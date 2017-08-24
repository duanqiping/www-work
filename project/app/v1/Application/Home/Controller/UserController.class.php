<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/20
 * Time: 13:48
 */

namespace Home\Controller;

use Home\Model\UserModel;
use Home\Model\CodeModel;
use Org\Tool\UpHeadTool;
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
        //注册检测 账号
        $this->C_regCheck($mobile,$type);

        if(session('mobile')){
            if($mobile!=session('mobile')) sendError('手机号未获取验证码');
            if(trim($checkcode)!=session('checkcode')) sendError('验证码错误');

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
                $user_info  = $user->getUserInfo($user_id);
                sendSuccess($user_info);
            }
            else{
                sendError('用户注册失败');
            }
        }else{
            sendError('非法操作');
        }


    }

    //登陆
    public function login()
    {
        $mobile = I('post.mobile');
        $passwd = I('post.passwd');

        is_mobile_legal($mobile);

        if(empty($passwd)) sendError('密码不能为空');

        $user = new UserModel();
        $res = $user->login($mobile,$passwd);
        if(!$res){
            sendError($user->getError());
        }
        setcookie('remuser',$mobile,time()+14*24*3600);

        sendSuccess($res);
    }

    //退出
    public function logout()
    {
        session_destroy();//清空session
        sendSuccess('退出成功');
    }

    //上传头像
    public function uploadImg()
    {
        is_login();
        $uptool = new UpHeadTool();
        $ori_img = $uptool->up('img', $_SESSION['account']);

        if (!$ori_img) {
            $error = $uptool->getErr();
            if ($error != 0) {
                sendError($error);
            }
            else{
                sendError('请选择要上传的头像');
            }
        }
        else {
            $user = new UserModel();
            $user->where(array('user_id'=>session('user_id')))->save(array('img'=>$ori_img));
            $ori_img = NROOT.$ori_img;
            sendSuccess($ori_img);
        }

    }

    //修改信息
    public function modifyInfo()
    {
        is_login();

        if(IS_POST)
        {
            $data = I("post.");
            $user = new UserModel();
            if ($user->where(array('user_id'=>session('user_id')))->save($data)) //更新用户信息
            {
                $condition['user_id'] = session('user_id');
                $info = $user->where($condition)->field($user->user_field)->find();

                $info['img'] = NROOT.$info['img'];

                sendSuccess($info);
            } else {
                sendError('修改个人资料失败');
            }
        }
        else
        {
            sendError('参数传输方式有无');
        }


    }

    //test
    public function test()
    {
//        $str1 = AesModel::encode('11345');
//
//        $str2 = AesModel::decode($str1);
//
//        print_r($str1);
//        print_r($str2);
        print_r($_SERVER);
    }
} 