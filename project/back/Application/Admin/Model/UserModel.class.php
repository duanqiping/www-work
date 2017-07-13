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

} 