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
    static public function  getInstance($type)
    {
        if($type == 1) return new AdminModel();//系统用户
        else if($type == 2) return new AgentModel();//代理商
        else if($type == 3) return new CustomerModel();//客户
        else if($type == 4) return new TeacherModel();//客户
        else return new UserModel();//普通用户

    }

    //用户登录
    public function login($account,$passwd,$flag)
    {
        $condition['account'] = $account;
        $res = $this->table($this->tableName)->where($condition)->field('name,passwd,account')->find();

//        echo $this->_sql();
//        exit();


        if($res['passwd'] == md5($passwd)){
            $this->autoLogin($res,$flag);
            return $res;
        }
        else return false;
    }

    //退出
    public function logout()
    {
        session ( 'user', null );
    }
    //检查用户账号
    public function checkAccount($account,$from)
    {
        if($from == 'home')
        {
            $condition['account'] =  $account;
            $count = $this->table($this->tableName)->where($condition)->count();
//            echo $this->_sql();
//            var_dump($count);
//            exit();
            if($count>0) return false;//已经注册
            else return true;//未注册
        }
        else{
            return 'admin';
        }
    }

    //保存用户信息
    private  function autoLogin($user,$falg) {

        /* 更新登录信息 */
        /* 记录登录SESSION和COOKIES */
        $user = array (
            'flag' => $falg,
            'name' => $user ['name'],
            'account' => $user ['account'],
        );
        session ( 'user', $user);//用户 分系统用户 供应商等
    }
}