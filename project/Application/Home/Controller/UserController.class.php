<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/20
 * Time: 13:48
 */

namespace Home\Controller;

use Admin\Model\UserModel;
use Home\Model\CodeModel;
use Think\Controller;

class UserController extends BaseController{

    //普通用户注册 获取验证吗....
    public function getCheckCode($mobile,$type)
    {
        $this->C_regCheck($mobile,$type);

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
                $codeModel->updateCode($row['id']);////验证码过期
            }
        }
        $msg = $codeModel->checkAction($mobile);//检测用户发短信行为
        if($msg) sendError($msg);

        //ok,发送验证码
        $message='';
        $checkcode = random(4, 1);
        $checkcode = '0000';

        $message = URLEncode('您的验证码为：' . $checkcode . '。如需帮助请联系客服。');

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

    //普通用户注册 校验验证码
    public function CheckCode($mobile,$type,$checkcode)
    {
        $this->C_regCheck($mobile,$type);

        if(session('mobile')){
            if($mobile!==session('mobile')) sendError('手机号未获取验证码');
            if(trim($checkcode)!==session('checkcode')) sendError('验证码错误');

            $_SESSION['is_checkcode'] = true;
            sendSuccess('验证码校验通过');
        }else{
            sendError('手机号未获取验证码');
        }
    }

    //注册
    public function reg()
    {
        if(IS_POST)
        {
            $mobile = $data['account'] = trim($_POST['mobile']);
            $passwd = $data['passwd'] = $_POST['passwd'];
            $sex = $data['sex'] = $_POST['sex'];

            is_mobile_legal($mobile);
            if(strlen($passwd)<6)  sendError('密码长度不能少于6位');
            if($sex !=1 && $sex !=2)  sendError('sex值非法');

            $user = new UserModel();

            //检查用户是否注册
            if($user_id = $user->reg($data)){

                setcookie('remuser',$data['mobile'],time()+14*24*3600);

                //记录到登录表
                $useronline = M('UserOnline');
                $data_online = array('user_id'=>$user_id,'addr'=>$_SERVER['SERVER_ADDR'],'active_time'=>time());
                $useronline->add($data_online);

                $user_info  = $user->getUserInfo($user_id);
                //注册成功 返回一些用户信息
                sendSuccess($user_info);
            }
            else{
                sendError('用户注册失败');
            }
        }else{
            sendError('非法操作');
        }


    }
} 