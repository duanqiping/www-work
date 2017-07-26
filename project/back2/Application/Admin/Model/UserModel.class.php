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

    //筛选条件
    public function makeCondition($data)
    {
        $condition = array();

        //系别 和 班级 是ajax 联动 (筛选条件)
        if($data['dept'] && $data['dept'] != '--系别--'){$condition['dept'] = $data['dept'];}
        if($data['class'] && $data['class'] != '--班级--'){$condition['class'] = $data['class'];}
        if($data['sex'] && $data['sex'] != '--性别--'){$condition['sex'] = $data['sex'];}

        $condition['customer_id'] = $_SESSION['user']['id'];

//        print_r($condition);
//        exit();

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