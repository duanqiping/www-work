<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/10
 * Time: 17:05
 */

namespace Admin\Model;


use Think\Model;

class UserModel extends Model{

    //系别
    public function getDept($uid)
    {
        $res = $this->where(array('customer_id'=>$uid))->field('dept')->group('dept')->select();
        return $res?$res:array();
    }
    //获取年级
    public function getGrade($uid,$dept)
    {
        $res = $this->where(array('customer_id'=>$uid,'dept'=>$dept))->field('grade')->group('grade')->select();
        return $res?$res:array();
    }
    //获取班级
    public function getClass($uid,$dept,$grade)
    {
        $res = $this->where(array('customer_id'=>$uid,'dept'=>$dept,'grade'=>$grade))->field('class')->group('class')->select();
        return $res?$res:array();
    }

    //获取用户名
    public function getUserName($code)
    {
        $sql = "select u.name,u.user_id from device d LEFT JOIN user u ON d.user_id = u.user_id WHERE d.code='$code'";
        $res = $this->query($sql);
        if(!$res){
            $this->error = '该用户尚未注册或未绑定手环';
            return false;
        }else{
            return $res[0];
        }
    }

    //筛选条件
    public function makeCondition($data,$uid)
    {
        $condition = array();

        $condition['customer_id'] = $uid;

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

    //排行表中获取用户信息
    public function getUserInfoFromRank($res)
    {
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $condition_user['user_id'] = $res[$i]['user_id'];
            $userInfo = $this->where($condition_user)->field('name,dept,grade,studentId,class')->find();
//            if($userInfo['img']) $res[$i]['img'] = NROOT.$userInfo['img'];
//            else $res[$i]['img'] = null;

            $res[$i]['name'] = $userInfo['name'];
            $res[$i]['studentId'] = $userInfo['studentId'];
            $res[$i]['grade'] = $userInfo['grade'];
            $res[$i]['dept'] = $userInfo['dept'];
            $res[$i]['class'] = $userInfo['class'];
        }
        return $res;
    }
    //用户列表
    public function _list($condition)
    {
        $where = '';
        foreach($condition as $k=>$v){
            if(end($condition) == $v){
                $where .= "u.$k='$v'";
            }else{
                $where .= "u.$k='$v' AND ";
            }
        }
        
        $sql = "SELECT u.user_id,u.name,u.studentId,u.sex,u.grade,u.dept,u.class,u.last_login_time,u.last_login_ip,u.login_count,d.device_id ".
            "FROM user u left join device d on u.user_id=d.user_id WHERE $where ORDER BY u.add_time desc";
        $res = $this->query($sql);

        return $res;
    }
} 