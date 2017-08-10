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
    public $title;//赛事标题
    public $onAchieve = 0;//合格人数
    public $outAchieve = 0;//不合格人数

    public $totalNum=0;//总记录条数
    public $pageSize=15;//每页的条数
    public $current = 1;//当前页

    public function _list($condition,$field)
    {
        $res = $this->where($condition)->field($field)->select();
        return $res;
    }
    //检查签到人员是否在考试名单列表中
    public function checkSignContest($user_ids,$contest_sn)
    {
        $condition = array();
        $condition['contest_sn'] = $contest_sn;

        for($i=0,$len=count($user_ids);$i<$len;$i++){
            $condition['user_id'] = $user_ids[$i];
            $count = $this->where($condition)->count();
            if($count<1){
                $this->error = "user_id为".$user_ids[$i]['user_id']."学生未在该考试名单中";
                return false;
            }
        }
        return true;
    }


    //更新用户成绩
    public function updateContest($data)
    {
        //先判断 是否已经存在这个成绩
        $condition = array();

        $condition['user_id'] = $data['user_id'];
        $condition['customer_id'] = $data['customer_id'];
        $condition['contest_sn'] = $data['contest_sn'];
        $count = $this->where($condition)->count();

        if($count<1){
            $this->error = '赛事名单中不存在该学生';
            return false;
        }

        $user = new UserModel();
        $sql = "update user set length=length+'{$data['length']}' WHERE user_id='{$data['user_id']}'";
        $user->execute($sql);

        $data['update'] = NOW_TIME;

        unset($data['customer_id']);
        unset($data['contest_sn']);
        unset($data['user_id']);



        $b = $this->where($condition)->save($data);

        if(!$b){
            $this->error = '服务器错误';
            return false;
        }else{
            return true;
        }
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
    public function contestList($condition,$page)
    {
        if($page<1)$page=1;
        $this->current = $page;

        $offset = ($page-1)*$this->pageSize;
        $res = $this->where($condition)->field('*')->limit($offset,$this->pageSize)->select();
        $this->totalNum = $this->where($condition)->count();

        $contest = new ContestModel();
        $res_contest = $contest->where(array('contest_sn'=>$_SESSION['contest_sn']))
            ->field('title,pass_score_male,pass_score_female')
            ->find();

        for($i=0,$len=count($res);$i<$len;$i++)
        {
            if($res[$i]['sex'] == 1){
                $res[$i]['pass_score'] = $res_contest['pass_score_male'];
            }else{
                $res[$i]['pass_score'] = $res_contest['pass_score_female'];
            }
            if($res[$i]['sign'] != 1)
            {
                $res[$i]['achieve'] = '未签到';
                $this->outAchieve += 1;
            }else{
                if($res[$i]['time'] <= $res[$i]['pass_score'] && $res[$i]['time']>0){
                    $res[$i]['achieve'] = '合格';
                    $this->onAchieve += 1;
                }else{
                    $res[$i]['achieve'] = '不合格';
                    $this->outAchieve += 1;
                }
            }
        }
        $this->title = $res_contest['title'];

        return $res;
    }

    //赛事名单列表
    public function contestList2($condition)
    {
        $condition['time'] = array('gt',0);
        $res = $this->where($condition)->field('*')->select();
        return $res;
    }

    //添加赛事学生名单
    public function addUser($ids,$contest_sn,$res_length)
    {
        $user= new UserModel();

        $map['user_id'] = array('in',$ids);
        $addinfo = $user->where($map)
            ->field("customer_id,user_id,name,studentId,sex,dept,grade,class")
            ->select();

        //开启事物
        $this->startTrans();

        foreach($addinfo as $k=>$v){

            //先查询是否已经添加 customer_id contest_sn user_id
            $condition_s['customer_id'] = $v['customer_id'];
            $condition_s['contest_sn'] = $contest_sn;
            $condition_s['user_id'] = $v['user_id'];

            $count = $this->where($condition_s)->count();

            if($count<1){
                $v['length'] = ($v['sex']==1)?$res_length['length_male']:$res_length['length_female'];
                $v['contest_sn'] = $contest_sn;

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

    //添加补考学生
    public function makeUpStudent($ids,$contest_sn,$reservationtime)
    {
        $contest = new ContestModel();

        $res = $contest->where(array('contest_sn'=>$contest_sn))
            ->field('contest_id parent_id,customer_id,contest_sn,title,content,length_male,length_female,length,pass_score_male,pass_score_female')
            ->find();

        $s = explode('-',$reservationtime);
        $res['begin_time'] = strtotime($s[0]);
        $res['end_time'] = strtotime($s[1]);
        $res['add_time'] = NOW_TIME;
        if($_SESSION['user']['grade'] == 3){
            $res['from_id'] = $_SESSION['user']['id'];
            $res['from_name'] = '学校管理员';
        }
        else{
            $res['from_id'] = $_SESSION['user']['id'];
            $res['from_name'] = $_SESSION['user']['id'];
        }
        if(!$contest->add($res)){
            $this->error = '补考赛事生成失败';
            return false;
        }

        $map['contest_order_id'] = array('in',$ids);
        $map['contest_sn'] = $contest_sn;
        $b = $this->where($map)->setInc('makeup');
        if(!$b) return false;
        else return true;
    }

    //获取赛事名单  圈数、终点endMachine放到List中
    public function getContestOrder($contest_sn,$customer_id)
    {
        $data = array();

        //获取考试名单人详细信息
        $sql = "select co.class classRoom,co.name,co.user_id,co.studentId,co.length,co.sex,d.code label from contest_order co LEFT JOIN device d ON co.user_id=d.user_id WHERE ".
            "co.contest_sn=%s and co.customer_id=%d";

        //获取赛事标题和内容
        $sql2 = "select title,content from contest WHERE contest_sn=%s";

        $res = $this->query($sql,$contest_sn,$customer_id);
        $res2 = $this->query($sql2,$contest_sn);

        if(!$res){
            return array();
        }
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            if($res[$i]['sex'] == 1){
                $res[$i]['endMachine'] = '0000113';
                $res[$i]['circle'] = '3';
            }else{
                $res[$i]['endMachine'] = '0000112';
                $res[$i]['circle'] = '2';
            }
            unset($res[$i]['length_male']);
            unset($res[$i]['length_female']);
        }
        $data['list'] = $res;
        $data['customer_id'] = $customer_id;

        $data['title'] = $res2[0]['title'];
        $data['content'] = $res2[0]['content'];
        $data['is_again'] = 0;//是否为重考
        return $data;
    }

    //获取系、年级、班级
    public function getStudentInfo($condition,$contest_sn)
    {
        $studentInfo = array();
        $studentInfo['dept'] = $this->where(array('contest_sn'=>$contest_sn))
            ->field('dept')
            ->group('dept')
            ->select();
        $studentInfo['grade'] = $this->where(array('contest_sn'=>$contest_sn,'dept'=>$condition['dept']))
            ->field('grade')
            ->group('grade')
            ->select();
        $studentInfo['class'] = $this->where(array('contest_sn'=>$contest_sn,'dept'=>$condition['dept'],'grade'=>$condition['grade']))
            ->field('class')
            ->group('class')
            ->select();
        return $studentInfo;
    }

    public function getDept($contest_sn)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn))->field('dept')->group('dept')->select();
        return $res;
    }
    public function getGrade($contest_sn,$dept)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn,'dept'=>$dept))->field('grade')->group('grade')->select();
        return $res;
    }
    public function getClass($contest_sn,$dept,$grade)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn,'dept'=>$dept,'grade'=>$grade))->field('class')->group('class')->select();
        return $res;
    }
} 