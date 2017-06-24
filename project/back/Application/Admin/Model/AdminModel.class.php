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

    //用户登录
    public function login($account, $passwd, $flag)
    {
        $condition['account'] = $account;
        //新增字段管理等级
        $res = $this->table($this->tableName)->where($condition)->field('name,passwd,account,level')->find();

        if ($res['passwd'] == md5($passwd)) {
            $this->autoLogin($res, $flag);//保存用户信息到session
            return $res;
        } else return false;


    }
}