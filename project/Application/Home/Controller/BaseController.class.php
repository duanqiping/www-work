<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/20
 * Time: 20:04
 */

namespace Home\Controller;


use Think\Controller;
use Admin\Model\UserHandleModel;

class BaseController extends Controller
{
    //检测 验证码
    public function C_regCheck($mobile,$type)
    {
        $mobile = is_mobile_legal($mobile);
        checkData( ($type==1 || $type == 2),'type值非法' );

        $user = UserHandleModel::getInstance($flag = null);
        $result = $user->regCheck($mobile,$type);
        if($result) sendError($result);
        return true;
    }

} 