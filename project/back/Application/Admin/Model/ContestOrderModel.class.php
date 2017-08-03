<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 19:23
 */

namespace Admin\Model;


use Think\Model;

class ContestOrderModel extends Model{

    protected $tableName = 'contest_order';

    public function _list($condition,$field)
    {
        $res = $this->where($condition)->field($field)->select();
        return $res;
    }

    //筛选条件
    public function makeCondition($data,$uid)
    {
        $condition = array();

        $condition['customer_id'] = $uid;
        $condition['contest_sn'] = $_SESSION['contest_sn'];

        //系别 和 班级 是ajax 联动
        if($data['dept'] && $data['dept'] != '系别' && $data['dept'] != '不限'){$condition['dept'] = $data['dept'];}
        if($data['grade'] && $data['grade'] != '年级' && $data['grade'] != '不限'){$condition['grade'] = $data['grade'];}
        if($data['class'] && $data['class'] != '班级' && $data['class'] != '不限'){$condition['class'] = $data['class'];}
        if($data['sex'] && $data['sex'] != '性别' && $data['sex'] != '不限'){
            if($data['sex'] == '男')$condition['sex'] = 1;
            else $condition['sex'] = 2;
        }

        return $condition;
    }


    //获取赛事名单人数
    public function getContestNum($res)
    {
        for($i=0,$len=count($res);$i<$len;$i++){
            $count = $this->where(array('contest_sn'=>$res[$i]['contest_sn']))->count();
            $res[$i]['count'] = $count;
        }
        return $res;
    }

    //赛事名单列表
    public function contestList($condition)
    {
        $res = $this->where($condition)->field('*')->select();

//        echo $this->_sql();
//        exit();

        return $res;
    }

    //添加赛事学生名单
    public function addUser($ids){

        $user= new UserModel();
        $map['user_id'] = array('in',$ids);
        $addinfo = $user->where($map)->field("customer_id,user_id,name,studentId,sex,dept,grade,class,{$_SESSION['contest_sn']} as contest_sn")->select();

        //开启事物
        $this->startTrans();

        foreach($addinfo as $k=>$v){

            //先查询是否已经添加 customer_id contest_sn user_id
            $condition_s['customer_id'] = $v['customer_id'];
            $condition_s['contest_sn'] = $_SESSION['contest_sn'];
            $condition_s['user_id'] = $v['user_id'];


            $count = $this->where($condition_s)->count();

            if($count<1){
                $result = $this->add($v);
                if(!$result){
                    $this->rollback();
                    $this->error = '添加失败';
                    return false;
                }
            }
        }
        $this->commit();
        return true;
    }


    //获取赛事名单  圈数、终点endMachine放到List中
    public function getContestOrder($contest_sn,$customer_id)
    {
        $data = array();

        $sql = "select co.class classRoom,co.name,co.user_id,co.studentId,co.sex,d.code label from contest_order co LEFT JOIN device d ON co.user_id=d.user_id WHERE ".
            "co.contest_sn='$contest_sn' and co.customer_id='$customer_id'";

        $res = $this->query($sql);
        if(!$res){
            return array();
        }
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            if($res[$i]['sex'] == 1){
                $res[$i]['endMachine'] = '0000113';
                $res[$i]['circle'] = '4';
            }else{
                $res[$i]['endMachine'] = '0000112';
                $res[$i]['circle'] = '3';
            }
        }
        $data['list'] = $res;
        $data['customer_id'] = $customer_id;
        $data['title'] = '上海交通大学夏季运动会';
        $data['content'] = '运动与健康';
//        $data['endMachine'] = '0000113';
//        $data['circle'] = '4';
        $data['type'] = 2;
        return $data;
    }

    public function getDept($contest_sn)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn))->field('dept')->group('dept')->select();
        return $res;
    }
    public function getGrade($contest_sn)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn))->field('grade')->group('grade')->select();
        return $res;
    }
    public function getClass($contest_sn)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn))->field('class')->group('class')->select();
        return $res;
    }
} 