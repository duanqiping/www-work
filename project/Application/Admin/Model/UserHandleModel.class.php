<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 22:54
 */

namespace Admin\Model;


use Think\Model;

//用户handle类
abstract class UserHandleModel extends Model
{
//    protected $tableName;
//    protected $type=1;


    static public function  getInstance($type)
    {
        if($type == 1) return new AdminModel();//系统用户
        else if($type == 2) return new AgentModel();//代理商
        else if($type == 3) return new CustomerModel();//客户
        else return new UserModel();//普通用户

    }

    //用户登录
    public function login($account,$passwd)
    {
        $condition['account'] = $account;
        $res = $this->table($this->tableName)->where($condition)->field('name,passwd')->find();
//        $res = $this->where($condition)->field('name,passwd')->find();


        if($res['passwd'] == md5($passwd)) return $res;
        else return false;
    }
}