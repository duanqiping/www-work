<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:04
 */

namespace Admin\Model;


class AdminModel extends UserHandleModel
{
    protected $tableName = 'admin';

//    public function login($account,$passwd)
//    {
//        $condition['account'] = $account;
//        $res = $this->table($this->tableName)->where($condition)->field('name,passwd')->find();
//
//        if($res['passwd'] == md5($passwd)) return $res;
//        else return false;
//    }
}