<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/14
 * Time: 17:37
 */

namespace Admin\Model;

use Think\Model;

class UserModel extends UserHandleModel
{
    protected $tableName = 'USER';

//    public function login($account,$passwd)
//    {
//        $condition['account'] = $account;
//        $res = $this->table($this->tableName)->where($condition)->field('name,passwd')->find();
//
//        if($res['passwd'] == md5($passwd)) return $res;
//        else return false;
//    }
//
}