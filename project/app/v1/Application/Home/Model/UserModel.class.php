<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/14
 * Time: 17:37
 */

namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
    protected $tableName = 'USER';

    protected $user_field = 'user_id,account,nick,img,email,sex';

    //获取用户信息
    public function getUserInfo($user_id)
    {
        $condition['user_id'] = $user_id;
        $row = $this->where($condition)->field($this->user_field)->find();
        return $row;
    }

    //注册检测 账号
    public function regCheck($mobile,$type)
    {
        //要获取注册验证码
        if (1 == $type) {
            if ($this->checkAccount($mobile,'home')) return '用户已注册';
        }
        //要获取忘记密码验证码
        else{
            if (!$this->checkAccount($mobile,'home')) return '用户不存在';
        }
        return null;
    }

    //用户登录
    public function login($account,$passwd,$flag)
    {
        $condition['account'] = $account;
        $res = $this->table($this->tableName)->where($condition)->field('name,passwd,account')->find();

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

            if($count>0) return true;//已经注册
            else return false;//未注册
        }
        else{
            return 'admin';
        }
    }

    public function reg($data)
    {
//        if($this->getSingleInfo(array('temp_buyers_mobile'=>$data['temp_buyers_mobile']),'temp_buyers_id')){
        if($this->table($this->tableName)->where(array('account'=>$data['account']))->count()){
            return false;
        }

        $data['passwd'] = md5($data['passwd']);
        $data['nick'] = $data['account'];
        $data['is_check'] = 1;
        $data['sex'] = 1;
        $data['register_time'] = timeChange(NOW_TIME);

        $b = $this->add($data);
        if(!$b)
        {
            return false;
        }else {
            return $b;
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