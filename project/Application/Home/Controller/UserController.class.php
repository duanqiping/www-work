<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/20
 * Time: 13:48
 */

namespace Home\Controller;


use Admin\Model\UserHandleModel;
use Think\Controller;

class UserController extends Controller{

    //普通用户注册 检查账号
    public function checkAccount($mobile)
    {
        $mobile = is_mobile_legal($mobile);
//        $use = UserHandleModel::getInstance($flag = null);
        $use = UserHandleModel::getInstance($flag = null);
        if ($use->checkAccount($mobile,'home')) {
            sendSuccess($mobile);
        }else{
            sendError('该手机号已经被注册');
        }
    }
} 