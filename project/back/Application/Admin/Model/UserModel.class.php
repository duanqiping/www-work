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

    //排行表中获取用户信息
    public function getUserInfoFromRank($res)
    {
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $condition_user['user_id'] = $res[$i]['user_id'];
            $userInfo = $this->where($condition_user)->field('nick,dept,class')->find();
//            if($userInfo['img']) $res[$i]['img'] = NROOT.$userInfo['img'];
//            else $res[$i]['img'] = null;

            $res[$i]['nick'] = $userInfo['nick'];
            $res[$i]['dept'] = $userInfo['dept'];
            $res[$i]['class'] = $userInfo['class'];
        }
        return $res;
    }
    //用户列表
    public function _list()
    {
        $res = $this->where(array('customer_id'=>$_SESSION['user']['id']))
            ->field('user_id id,name,studentId,dept,class,last_login_time,last_login_ip,login_count')
            ->order('add_time desc')
            ->select();
        
        $sql = "SELECT u.user_id,u.name,u.studentId,u.dept,u.class,u.last_login_time,u.last_login_ip,u.login_count,d.device_id ".
            "FROM user u left join device d on u.user_id=d.user_id WHERE u.customer_id = 31 ORDER BY u.add_time desc";
        $res = $this->query($sql);
//        print_r($res);
//        echo $this->_sql();
//        exit();

        return $res;
    }
} 