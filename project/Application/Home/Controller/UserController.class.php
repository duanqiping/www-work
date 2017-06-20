<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/20
 * Time: 13:48
 */

namespace Home\Controller;


use Admin\Model\UserHandleModel;
use Home\Model\CodeModel;
use Think\Controller;

class UserController extends Controller{

    //普通用户注册 获取验证吗
    public function getCheckCode($mobile,$type)
    {
        $mobile = is_mobile_legal($mobile);
        checkData( ($type==1 || $type == 2),'type值非法' );

        $user = UserHandleModel::getInstance($flag = null);

        //要获取注册验证码
        if (1 == $type) {
            if ($user->checkAccount($mobile,'home')) sendError('用户已注册',401);
        }
        //要获取忘记密码验证码
        else{
            if (!$user->checkAccount($mobile,'home')) sendError('用户不存在',401);
        }

        $codeModel = new CodeModel();
        $row = $codeModel->checkCode($mobile);

        //说明验证码已经发送，还在有效期内
        if ($row)
        {
            $diffSeconds = NOW_TIME - $row['createAt'];
            if ($diffSeconds < 60){
                sendError('时间间隔太小，请1分钟后再申请');
            }
            else
            {
                //验证码过期
                $codeModel->updateCode($row['id']);
            }
        }
        $msg = $codeModel->checkAction($mobile);//检测用户发短信行为
        if($msg) sendError($msg);

        //ok,发送验证码
        $message='';
        $checkcode = random(4, 1);
        $checkcode = '0000';
        if (1 == $_POST['type'] + 0) {
            $message = URLEncode('您的验证码为：' . $checkcode . '。如需帮助请联系客服。');
        } else if (2 == $_POST['type'] + 0) {
            $message = URLEncode('您的验证码为：' . $checkcode . '。如需帮助请联系客服。');
        }

        if (sendmessage($mobile, $message))
        {
            if(!$codeModel->addCode($mobile,$checkcode)) sendServerError('验证码入库失败',500);

            //把手机号和验证码存到SESSION里
            $_SESSION['mobile'] = $mobile;
            $_SESSION['checkcode'] = $checkcode;

            sendSuccess('验证码发送成功');

        }
        else {
            sendError('验证码发送失败');
        }
    }
} 