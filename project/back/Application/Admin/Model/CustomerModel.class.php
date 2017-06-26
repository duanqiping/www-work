<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:05
 */

namespace Admin\Model;


class CustomerModel extends ConsumerHandleModel
{
    protected $tableName = 'customer';

//    public function login($account,$passwd)
//    {
//        $condition['account'] = $account;
//        $res = $this->table($this->tableName)->where($condition)->field('name,passwd')->find();
//
//        if($res['passwd'] == md5($passwd)) return $res;
//        else return false;
//    }
}