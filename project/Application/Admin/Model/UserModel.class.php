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
}