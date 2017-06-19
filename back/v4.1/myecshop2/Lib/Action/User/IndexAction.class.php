<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2016/3/28
 * Time: 15:54
 *
 * 用户开始注册到登录
 * 开始注册
 * 获取验证码
 * 校验验证码
 * 用户注册
 * 用户登录
 * 用户退出
 */
class IndexAction extends Action
{
    /** 开始注册 mobile invitation*/
    public function invitation()
    {
        $mobile = trim($_POST['mobile']);
        if(!$b=preg_match("/^1[34578][0-9]{9}$/i",$mobile,$res)) exit('{"success":"false","error":{"msg":"手机号码不规范","code":"4801"}}');

        $user = new TempBuyersModel();
        $res = $user->getSingleInfo(array('temp_buyers_mobile'=>$mobile),'temp_buyers_mobile');
        if($res) exit('{"success":"false","error":{"msg":"用户已注册","code":"4801"}}');
        if(isset($_POST['invitation']))
        {
            $invitation = trim($_POST['invitation']);
            //邀请码全是数组，邀请码是6位
            if(strlen($invitation) != 6 || !preg_match('/^[0-9]*$/i',$invitation)) exit('{"success":"false","error":{"msg":"邀请码有误","code":"4800"}}');

            $sql = 'select temp_buyers_id from ecs_temp_buyers WHERE invitation='.$invitation;
            $res_inv = $user->query($sql);
            if(!$res_inv) exit('{"success":"false","error":{"msg":"邀请码不存在","code":"4800"}}');
            $response = array("success"=>"true","data"=>array("msg"=>'邀请码正确'));
            $response = ch_json_encode($response);
            exit($response);
        }
        //邀请码为空
        $response = array("success"=>"true","data"=>array('msg'=>'手机号码正确'));
        $response = ch_json_encode($response);
        exit($response);
    }

    /** 获取验证码  type 1或者2(1获取注册验证码,2获取忘记密码验证码)  mobile */
    public function getCheckCode()
    {
        $user = new TempBuyersModel();
        $mobile = trim($_POST['mobile']);

        is_mobile_legal($mobile);

        $type = $_POST['type']+0;
        // 检验手机号是否已存在，废弃表字段is_regist,

        if (1 == $type) {//要获取注册验证码
            if ($user->getSingleInfo(array('temp_buyers_mobile'=>$mobile),'temp_buyers_mobile')) exit('{"success":"false","error":{"msg":"用户已注册","code":"4801"}}');
        }
        else if (2 == $type) {//要获取忘记密码验证码
            if (!$user->getSingleInfo(array('temp_buyers_mobile'=>$mobile),'temp_buyers_mobile')) exit('{"success":"false","error":{"msg":"用户不存在","code":"4116"}}');
        }
        else exit('{"success":"false","error":{"msg":"type必须为1或2","code":"4800"}}');

        $now = time();
        $checks = M('TempCheckcode');
//        $now_before = $now-24 * 60 * 60;
//        $sql_del = "delete from ecs_temp_checkcode WHERE expireAt < '{$now_before}' and mobile='{$mobile}'";
//        $checks->execute($sql_del); // 删除前一天的短信

        $sql_q = "select code,createAt from ecs_temp_checkcode where expireAt > '{$now}' and mobile='{$mobile}' order by createAt desc limit 1";
        $row = $checks->query($sql_q);//根据手机号查询验证码


        if ($row) {//说明验证码已经发送，还在有效期内
            $diffSeconds = $now - $row['createAt'];
            if ($diffSeconds < 60) exit('{"success":"false","error":{"msg":"时间间隔太小，请1分钟后再申请","code":"4103"}}');
            else {//验证码过期
//                $checks->setIsUsed(array('isUse' => 1, 'usingAt' => time()), $mobile, $row['code']);  //设置为已经使用过
                $sql_update = 'update ecs_temp_checkcode set isUse=1,usingAt='.time().' where mobile='.$mobile.' code='.$row[0]['code'];
                $checks->query($sql_update);
            }
        }
        $end = $now;
        $begin = $now - 24 * 60 * 60;
        $sql_num = "select count(*) as num from ecs_temp_checkcode where mobile='$mobile' and createAt between '{$begin}' and '{$end}'";
        $countmobile = $checks->query($sql_num);
        if ($countmobile[0]['num'] >= 10) {
            //老大，都给你手机号发6次了还收不到，你是要用短信轰炸别人呢还是真收不到，果断舍弃你这用户把
            $response = array("success" => "false", "error" => array("msg" => '短信今天已经发了10次，请明天再申请', 'code' => 4104));
            $response = ch_json_encode($response);
            exit($response);
        }

        //ok,发送验证码
        $message='';
        $checkcode = random(6, 1);
        if (1 == $_POST['type'] + 0) {
            $message = URLEncode('您的验证码为：' . $checkcode . '。如需帮助请联系客服。');
        } else if (2 == $_POST['type'] + 0) {
            $message = URLEncode('您的验证码为：' . $checkcode . '。如需帮助请联系客服。');
        }

        if (sendmessage($_POST['mobile'], $message))
        {
            $sql_insert = "insert into ecs_temp_checkcode (mobile,code,ip,createAt) VALUES ('$mobile','$checkcode','{$_SERVER['REMOTE_ADDR']}',".time().")";
            $checks->execute($sql_insert);

            //把手机号和验证码存到SESSION里
            $_SESSION['temp_buyers_mobile'] = $mobile;
            $_SESSION['checkcode'] = $checkcode;

            $token = passport_encrypt(random() . '@' . time() . '@' . $_SESSION['checkcode'] . '@' . $_SESSION['temp_buyers_mobile'], 'qiping'); //随机生成一个token

            $response = array("success" => "true", "data" => array("msg" => '验证码发送成功', 'token' => $token));
            $response = ch_json_encode($response);
            exit($response);
        }
        else {
            $response = array("success" => "false", "error" => array("msg" => '验证码发送失败', 'code' => 4108));
            $response = ch_json_encode($response);
            exit($response);
        }


    }

    /** 校验验证码 temp_buyers_mobile checkcode type （注册过程中没有用到该接口，忘记密码使用了该接口）*/
    public function checkCode()
    {
        $mobile = trim($_POST['temp_buyers_mobile']);
        $type = $_POST['type'];
        is_mobile_legal($mobile);

        $user = new TempBuyersModel();

        if(1 == $type+0){//要获取注册验证码
            if($user->getSingleInfo(array('temp_buyers_mobile'=>$mobile),'temp_buyers_mobile')) exit('{"success":"false","error":{"msg":"用户已注册","code":"4102"}}');
        }
        else if(2 == $type+0){//要获取忘记密码验证码
            if(!$user->getSingleInfo(array('temp_buyers_mobile'=>$mobile),'temp_buyers_mobile')) exit('{"success":"false","error":{"msg":"用户不存在","code":"4116"}}');
        }
        else{
            exit('{"success":"false","error":{"msg":"type必须为1或2","code":"4800"}}');
        }

        if(isset($_POST['token']))
        {
            $token = passport_decrypt($_POST['token'], 'qiping');
            $newstr = explode("@",$token);//
            $_SESSION['checkcode'] = $newstr[2];//token中的验证码
            $_SESSION['temp_buyers_mobile'] = $newstr[3];//token中的手机号
        }

        if(isset($_SESSION['temp_buyers_mobile'])){
            if($mobile!==$_SESSION['temp_buyers_mobile'])exit('{"success":"false","error":{"msg":"手机号未获取验证码","code":"4110"}}');
            if(trim($_POST['checkcode'])!==$_SESSION['checkcode'])exit('{"success":"false","error":{"msg":"验证码错误","code":"4109"}}');

            $_SESSION['is_checkcode'] = true;
            $response = array("success"=>"true","data"=>array("msg"=>'验证码校验通过'));
            $response = ch_json_encode($response);
            exit($response);
        }
        else{
            $response = array("success"=>"false","error"=>array("msg"=>'手机号未获取验证码','code'=>4110));
            $response = ch_json_encode($response);
            exit($response);
        }



    }

    /** 用户注册 temp_buyers_mobile temp_buyers_password checkcode invitation（可选）*/
    public function reg()
    {
        $data['temp_buyers_mobile'] = trim($_POST['temp_buyers_mobile']);
        $data['temp_buyers_password'] = $_POST['temp_buyers_password'];
        $data['checkcode'] = trim($_POST['checkcode']);
        is_empty($data);

        //验证用户输入的验证码(如果系统已经给用户发了验证码情况下,如果用户输入的验证码为268365,则让其通过)
        if(($data['checkcode'] != $_SESSION['checkcode'] && $data['checkcode'] != 268365) || !isset($_SESSION['checkcode']) || $_SESSION['checkcode']=='') exit('{"success":"false","error":{"msg":"验证码错误","code":"4800"}}');

        if(!$b=preg_match("/^1[34578][0-9]{9}$/i",$data['temp_buyers_mobile'],$res)) exit('{"success":"false","error":{"msg":"手机号码不规范","code":"4800"}}');
        if(strlen($data['temp_buyers_password'])<6)  exit('{"success":"false","error":{"msg":"密码长度不能少于6位","code":"4800"}}');

        $data['nick'] = isset($_POST['nick'])?trim($_POST['nick']):$_POST['temp_buyers_mobile'];

        $user = new TempBuyersModel();

        $data['invitation'] = trim($_POST['invitation']);
        $invitation_id = 0;
        $vip=0;
        if(!empty($data['invitation']))
        {
            //若果邀请码不为空
            $res = $user -> checkInvitation($data['invitation']);//如果通过，将取出邀请人的信息
            if($res)
            {
                $invitation_id = $res['temp_buyers_id'];//邀请人的id号
                $vip = 1; //如果用户以邀请码注册，用户默认为vip
            }
            else{
                exit('{"success":"false","error":{"msg":"邀请码错误","code":"4800"}}');
            }
        }
        if(isset($_POST['token']))
        {
            $token = passport_decrypt($_POST['token'], 'qiping');
            $newstr = explode("@",$token);//
            $_SESSION['checkcode'] = $newstr[2];//token中的验证码
        }

        $data['invitation_person'] = $invitation_id;//邀请人的id号
        $data['vip'] = $vip;
        //检查用户是否注册
        if($user->reg($data)){

            //把验证短息清空
            $checks = M('TempCheckcode');
            $sql_del = "delete from ecs_temp_checkcode where mobile='{$data['temp_buyers_mobile']}' order by createAt desc limit 10";
            $checks->execute($sql_del);

            $data_info = $user->getSingleInfo(array('temp_buyers_mobile'=>$data['temp_buyers_mobile']),'temp_buyers_id,is_check,temp_buyers_mobile,temp_buyers_password,nick,photo,vip,invitation,invitation_person,company_id,area_id');
            $data_info['checkcode'] = $_SESSION['checkcode'];//暂时添加

            $_SESSION = $data_info;//把用户信息保存到session中

            setcookie('remuser',$data['temp_buyers_mobile'],time()+14*24*3600);

            //记录到登录表
            $useronline = M('TempUseronline');
            $data_online = array('online_buyers_id'=>$data_info['temp_buyers_id'],'active_time'=>time());
            $useronline->add($data_online);

            //把用户注册到环信
            $e = new EasemobModel();
            $useinfo=array();
            $useinfo['username'] = $data_info['temp_buyers_mobile'];
            $useinfo['password'] = $data_info['temp_buyers_password'];
            $e->openRegister($useinfo);

            //注册成功 返回一些用户信息
            $response = array('success'=>'true','data'=>$data_info);
            $response = ch_json_encode($response);
            echo($response);

        }else{
            $response = array("success"=>"false","error"=>array('msg'=>'用户注册失败','code'=>4113));
            $response = ch_json_encode($response);
            exit($response);

        }

    }

    /** 用户登录接口 act temp_buyers_mobile temp_buyers_password*/
    public function login()
    {
        $mobile = isset($_POST['temp_buyers_mobile'])?trim($_POST['temp_buyers_mobile']):exit('{"success":"false","error":{"msg":"需传参数temp_buyers_mobile","code":"4120"}}');
        $passwd = isset($_POST['temp_buyers_password'])?$_POST['temp_buyers_password']:exit('{"success":"false","error":{"msg":"需传参数temp_buyers_password","code":"4120"}}');

        if(!$b=preg_match("/^1[34578][0-9]{9}$/i",$mobile,$res)) exit('{"success":"false","error":{"msg":"手机号码格式不正确","code":"4120"}}');
        if(empty($passwd)) exit('{"success":"false","error":{"msg":"密码不能为空","code":"48000"}}');

        $tempbuyers = new TempBuyersModel();
        $res = $tempbuyers->getSingleInfo(array('temp_buyers_mobile'=>$mobile),'temp_buyers_id,is_check,temp_buyers_mobile,temp_buyers_password,nick,photo,vip,invitation,invitation_person,company_id,area_id');

        if(!$res)
        {
            //判断迷你看图那里是否存在对应的账号，如果有对应的账号，则对用户表中插入一条记录
            $b = $tempbuyers->isMiniUser($mobile,md5($passwd));
            if(!$b) exit('{"success":"false","error":{"msg":"用户不存在","code":"4116"}}');
            $res = $tempbuyers->getSingleInfo(array('temp_buyers_mobile'=>$mobile),'temp_buyers_id,is_check,temp_buyers_mobile,temp_buyers_password,nick,photo,vip,invitation,invitation_person,company_id,area_id');
        }

        if($res['temp_buyers_password'] != md5($passwd)) exit('{"success":"false","error":{"msg":"用户名密码不匹配","code":"4118"}}');
        if(!$res['is_check']) exit('{"success":"false","error":{"msg":"用户已经被屏蔽","code":"4190"}}');

        $res['city'] = $_SESSION['city'];//把定位城市
        $res['area_id'] = $_SESSION['area_id'];//定位城市的id号

        $_SESSION = $res;
        setcookie('remuser',$mobile,time()+14*24*3600);

        //记录到登录表
        //判断登陆表是否有记录
        $useronline = M('TempUseronline');
        $condition['online_buyers_id'] = $res['temp_buyers_id'];
        if($count = $useronline->where($condition)->count())
        {
            /** 修改下登录时间*/
            $sql = 'update ecs_temp_useronline set active_time='.time().' where online_buyers_id='.$res['temp_buyers_id'];
            $useronline->execute($sql);
        }else
        {
            /** 插入一条记录*/
            $data_add['active_time'] = time();
            $data_add['online_buyers_id'] = $res['temp_buyers_id'];
            $useronline -> add($data_add);
        }

        $data2 = array();
        $data2['vip'] = ($res['invitation_person']>0)?1:0;//是否是vip 通过邀请人判断
        $data2['temp_buyers_id'] = $res['temp_buyers_id'];
        $data2['temp_buyers_mobile'] = $res['temp_buyers_mobile'];
        $data2['nick'] = $res['nick'];
        $data2['photo'] = NROOT.'/Guest/'.$res['photo'];
        $data2['info'] = $res['info'];
        $data2['invitation'] = $res['invitation'];
        $data2['info'] = $res['info'];
        $data2['company_id'] = $res['company_id'];

        $data2['token'] = passport_encrypt(random().'@'.$data2['temp_buyers_id'].'@'.time(), 'qiping');//qiping为一个秘药

        $response = array('success'=>'true','data'=>$data2);
        $response = ch_json_encode($response);
        exit($response);
    }

    /** 用户退出接口*/
    public function logout()
    {
        $user = new TempBuyersModel();
        $sql = "delete from ecs_push_blind where user_id=".$_SESSION['temp_buyers_id'];//删除消息绑定表中对应的数据
        $user->execute($sql);

        session_destroy();//清空session

        $response = array("success"=>"true","data"=>array("msg"=>'退出成功'));
        $response = ch_json_encode($response);
        exit($response);
    }

}