<?php
namespace Index\Controller;

use Common\Controller\BaseController;
use Common\Model\Aes\AesModel;
use Common\Model\BaseModel;
use Index\Model\EasemobModel;
use Index\Model\UserModel;
use Think\Controller;

class IndexController extends BaseController
{

    /** 获取验证码
     * phone    手机号码
    */
    public function getCheckCode()
    {
        $data = $_POST;
        $phone = trim($data['phone']);
        $type = $data['type']+0;

        $b = is_mobile_legal($phone);
        if(!$b) sendError('手机号码有误',400);
        checkPostData(($type==1 || $type==2),'type值有误',400);

        $user = new UserModel();

        //要获取注册验证码
        if (1 == $type) {
            if ($user->getSingleInfo(array('phone'=>$phone),'phone')) sendError('用户已注册',401);
        }
        //要获取忘记密码验证码
        else{
            if (!$user->getSingleInfo(array('phone'=>$phone),'phone')) sendError('用户不存在',401);
        }

        $now = NOW_TIME;
        $condition['phone'] = $phone;
        $condition['instm'] = array('GT',$now-30*60);//10分钟
        $appcode = M('Appcode');
        $row = $appcode->where($condition)->field('id,phone,idcode,instm')->order('id desc')->limit(1)->find();

        $flag = false;
        $checkcode = '';//验证码
        //说明验证码已经发送，还在有效期内
        if ($row)
        {
            if ( ($now - $row['instm']) < 60) sendError('时间间隔太小，请1分钟后再申请',401);
            else
            {
                $checkcode = $row['idcode'];//1<time<10
                $b = $appcode->where(array('id'=>$row['id']))->save(array('instm'=>$now));
                if(!$b) file_put_contents('./Application/Runtime/Logs/log.txt','验证码时间更新失败' . '--' . $now . "\n", FILE_APPEND);
            }
        }
        else
        {
            $checkcode = random(6, 1);
            $flag = true;
        }
        //ok,发送验证码
        if (sendmessage($phone, URLEncode('您的验证码为：' . $checkcode . '。如需帮助请联系客服。')))
        {
            if($flag == true)
            {
                $model = new BaseModel();
                $time = NOW_TIME;
                $sql = "INSERT INTO vipapps.va_appcode (phone, idcode, instm) VALUES ('$phone', '$checkcode', '$time')";
                $model->execute($sql);
                if(!$b)file_put_contents('./Application/Runtime/Logs/log.txt','验证码入库失败' . '--' . $now . "\n", FILE_APPEND);
            }
            //把手机号和验证码存到SESSION里
            $_SESSION['phone'] = $phone;
            $_SESSION['checkcode'] = $checkcode;

            sendSuccess(array('msg'=>'验证码发送成功','code'=>0));
        }
        else {
            sendError('验证码发送失败',401);
        }
    }

    /**校验验证码
     * phone    手机号码
     * checkcode    验证码
     * type     注册or忘记密码
    */
    public function checkCode()
    {
        $phone = trim($_POST['phone']);
        $type = $_POST['type'];
        $checkcode = trim($_POST['checkcode']);
        is_mobile_legal($phone);
        checkPostData(($type==1 || $type==2),'type值有误',400);
        checkPostData((strlen($checkcode) == 6),'验证码有误',400);

        $user = new UserModel();

        //要获取注册验证码
        if (1 == $type) {
            if ($user->getSingleInfo(array('phone'=>$phone),'phone')) sendError('用户已注册',401);
        }
        //要获取忘记密码验证码
        else {
            if (!$user->getSingleInfo(array('phone' => $phone), 'phone')) sendError('用户不存在', 401);
        }

        if(isset($_SESSION['phone']))
        {
            if($phone!==$_SESSION['phone']) sendError('手机号未获取验证码',401);
            if($checkcode!==$_SESSION['checkcode']) sendError('验证码错误',401);

            $_SESSION['is_checkcode'] = true;
            sendSuccess(array('msg'=>'验证码校验通过','code'=>0));
        }
        else{
            sendError('手机号未获取验证码',401);
        }
    }

    /**用户注册
     * phone    手机号码
     * checkcode    验证码
     * password     用户密码
     */
    public function reg()
    {
        $phone = $data['phone'] = trim($_POST['phone']);
        $checkcode = trim($_POST['checkcode']);
        $password = $data['password'] = $_POST['password'];
        unset($_POST['checkcode']);

        is_mobile_legal($phone);
        checkPostData((strlen($checkcode) == 6),'验证码有误',400);
        checkPostData((strlen($password) >= 6),'密码长度不能少于6位',400);
        checkPostData($checkcode == $_SESSION['checkcode'],'验证码错误',400);

        $user = new UserModel();

        //检查用户是否注册
        if($user->reg($data))
        {
            //把验证短息清空
            $appcode = M('Appcode');
            $appcode->where(array('phone'=>$phone))->delete();

            $data_info = $user->getSingleInfo(array('phone'=>$phone),'user_id,user_name,phone,mail');
            $data_info['checkcode'] = $_SESSION['checkcode'];//暂时添加

            $_SESSION = $data_info;//把用户信息保存到session中

            setcookie('remuser',$data['phone'],time()+14*24*3600);

            //把用户注册到环信
            $e = new EasemobModel();
            $useinfo=array();
            $useinfo['username'] = $data_info['phone'];
            $useinfo['password'] = $data_info['password'];
            $e->openRegister($useinfo);

            //注册成功 返回一些用户信息
            sendSuccess($data_info);

        }
        else{
            sendError('用户注册失败',401);
        }
    }

    /** 登录 （家装造价）
     * user_name  手机号或昵称
     * password  用户密码
     */
    public function login()
    {
        $phone = $data['phone'] = trim($_POST['name']);
        $password = $_POST['password'];

        checkPostData(is_mobile_legal($phone),'手机号码不规范',400);
        checkPostData((strlen($password) >= 6),'密码长度不能少于6位',400);

        $user = new UserModel();

        $res = $user->getSingleInfo(array('phone'=>$phone),'user_id,user_name,password,phone,mail');
        if(!$res) sendError('用户不存在',401);
        if($res['password'] != md5($password)) sendError('用户名密码不匹配',401);
        unset($res['password']);

        //判断是否是vip用户
        $res = $user->vipInfo($res);

        $_SESSION = array('user_id'=>$res['user_id'],'phone'=>$res['phone']);
        setcookie('remuser',$phone,time()+14*24*3600);

        sendSuccess($res);
    }

    /** 退出*/
    public function logout()
    {
        session_destroy();//清空session
        sendSuccess(array('msg'=>'退出成功','code'=>0));
    }

    /** 忘记密码*/
    public function forgetPassword()
    {
        $phone = $data['phone'] = trim($_POST['phone']);
        $password = $data['password'] = $_POST['password'];
        $confirm_password = $data['confirm_password'] = $_POST['confirm_password'];

        is_mobile_legal($phone);
        checkPostData(($password == $confirm_password),'两次密码不一致',400);
        checkPostData((strlen($password) >= 6),'密码长度不能少于6位',400);

        $user = new UserModel();

        $res = $user->getSingleInfo(array('phone'=>$phone),'user_id,user_name,password,phone,mail');
        if($res['password'] == md5($password))sendSuccess(array('msg'=>'密码修改成功','code'=>0));

        //不一致
        if($user->where(array('phone'=>$phone))->save(array('password'=>md5($password))))
        {
            $response = ch_json_encode(array('msg'=>'密码修改成功','code'=>0));
            echo($response);

            $e = new EasemobModel();
            $options = array();
            $options['username'] = $_SESSION['temp_buyers_mobile'];//用户名
            $options['password'] = $res['temp_buyers_password']; //密码
            $options['newpassword'] = $data['temp_buyers_password']; //新密码
            $e->editPassword($options);
        }
        else
        {
            sendError('密码修改失败',4001);
        }
    }

    /** 修改密码 新密码 和 旧密码*/
    public function modify()
    {
        $this->IsLogin();

        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $uid = $_SESSION['user_id'];

        checkPostData((strlen($old_password) >= 6),'密码长度不能少于6位',400);
        checkPostData((strlen($new_password) >= 6),'新密码长度不能少于6位',400);

        $user = new UserModel();
        $res = $user->getSingleInfo(array('user_id'=>$uid),'user_id,user_name,password,phone,mail');
        if($res['password'] != md5($old_password)) sendError('原密码错误',401);
        if($old_password == $new_password) sendSuccess(array('msg'=>'密码修改成功','code'=>0));

        //更新密码
        $conditon['user_id'] = $uid;
        $b = $user->where($conditon)->save(array('password'=>md5($_POST['new_password'])));
        if(!$b) sendServerError('更新失败',5001);

        //修改密码 环信
        $e = new EasemobModel();
        $options = array();
        $options['username'] = $res['phone'];//用户名
        $options['password'] = $new_password; //密码
        $options['newpassword'] =$new_password; //新密码
        $e->editPassword($options);

        sendSuccess(array('msg'=>'密码修改成功','code'=>0));
    }

    /** 修改昵称 nick */
    public function modifyInfo()
    {
        $this->IsLogin();

        $uid = $_SESSION['user_id'];
        $user_name = $_POST['user_name'];
        checkPostData(strlen($user_name)<20,'昵称不能太长',400);

        $user = new UserModel();
        $res = $user->getSingleInfo(array('user_id'=>$uid),'user_id,user_name,phone,mail');
        if($user_name == $res['user_name'])
        {
            $res = $user->vipInfo($res);
            sendSuccess($res);
        }
        else
        {
            if ($user->where(array('user_id'=>$uid))->save(array('user_name'=>$user_name))) //更新用户信息
            {
                $info = $user->getSingleInfo(array('user_id'=>$uid),'user_id,user_name,phone,mail');
                //判断是否是vip用户
                $info = $user->vipInfo($info);
                sendSuccess($info);
            }
            else {
                sendError('修改失败','401');
            }
        }
    }

    /** 用户留言反馈*/
    public function feedback()
    {
        $msg = $_POST['msg'];
        checkPostData(strlen($msg)<1000,'留言不能太长',400);

        $this->IsLogin();
        $feedback = M('feedback');
        $data = array(
            'product_flag_id'=>'HOMECOST',
            'ver'=>$_SERVER['HTTP_VERSION']?$_SERVER['HTTP_VERSION']:'aaa',
            'name'=>$_SESSION['phone'],
            'user_id'=>$_SESSION['user_id'],
            'msg'=>$msg,
            'insert_time'=>date('Y-m-d H:m:s'),
        );
        $b = $feedback->add($data);
        if(!$b) sendError('服务器错误',500);
        else sendSuccess('反馈成功');
    }

}