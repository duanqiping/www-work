<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/4/5
 * Time: 14:05
 * 修改密码
 * 修改个人资料
 * 获取个人用户信息
 * 添加收获地址
 * 默认地址
 * 地址列表
 * 删除地址
 * 修改地址
 */
class InfoAction extends Action
{
    /** 忘记密码*/
    public function forgetPassword()
    {
        $data = $_POST;
        $user = new TempBuyersModel();

        if(isset($_POST['token']))
        {
            $token = passport_decrypt($_POST['token'], 'qiping');
            $newstr = explode("@",$token);//
            $_SESSION['temp_buyers_mobile'] = $newstr[3];//token中的手机号
        }
        $res = $user->getSingleInfo(array('temp_buyers_mobile'=>$_SESSION['temp_buyers_mobile']),'temp_buyers_id,temp_buyers_password');
        //密码和原来一致
        if($res['temp_buyers_password'] == md5($data['temp_buyers_password']))
        {
            $response = array("success" => "true", "data" => array("msg" => '密码修改成功'));
            $response = ch_json_encode($response);
            exit($response);
        }
        //不一致
        $condition['temp_buyers_id'] = $res['temp_buyers_id'];
        $data = array('temp_buyers_password' => md5($data['temp_buyers_password']));
        if($user->where($condition)->save($data))
        {
            $response = array("success" => "true", "data" => array("msg" => '密码修改成功'));
            $response = ch_json_encode($response);
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
            $response = array("success" => "false", "error" => array("msg" => '密码修改失败', 'code' => 4117));
            $response = ch_json_encode($response);
            exit($response);

        }
    }

    /** 修改密码 新密码 和 旧密码*/
    public function modify()
    {
        //接收 新密码 和 旧密码
        $data = $_POST;
        $uid = $_SESSION['temp_buyers_id'];

        if($data['new_password']=='') exit('{"success":"false","error":{"msg":"新密码不能为空","code":"4131"}}');
        if(strlen($data['new_password'])<6) exit('{"success":"false","error":{"msg":"新密码不能少于6位","code":"4132"}}');
        if($data['new_password'] == $data['old_password']) exit('{"success":"false","error":{"msg":"新密码不能与新密码相同","code":"4130"}}');

        $user = new TempBuyersModel();
        $user -> is_login();
        $res = $user -> getSingleInfo(array('temp_buyers_id'=>$uid),'temp_buyers_password');//取出用户原密码

        if($res['temp_buyers_password'] != md5($_POST['old_password'])) exit('{"success":"false","error":{"msg":"原密码错误","code":"4133"}}');

        //更新密码
        $data_info = array('temp_buyers_password'=>md5($_POST['new_password']));
        $conditon['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
        $b = $user->where($conditon)->save($data_info);

        if(!$b) exit('{"success":"false","error":{"msg":"密码修改失败","code":"4134"}}');

        $res_info = $user -> getSingleInfo(array('temp_buyers_id'=>$uid),'temp_buyers_id,temp_buyers_mobile,temp_buyers_password,photo,nick,info');//取出用户原密码

        //修改密码 环信
        $e = new EasemobModel();
        $options = array();
        $options['username'] = $res_info['temp_buyers_mobile'];//用户名
        $options['password'] = $res_info['temp_buyers_password']; //密码
        $options['newpassword'] =$res_info['temp_buyers_password']; //新密码
        $e->editPassword($options);

        $response = array("success"=>"true","data"=>array("msg"=>'密码修改成功'));
        $response = ch_json_encode($response);
        exit($response);
    }

    /** 修改个人资料 nick info ori_img */
    public function modifyInfo()
    {
        import('ORG.Tool.UpHeadTool');
        $data = $_POST;

        $uid = $_SESSION['temp_buyers_id'];

        $user = new TempBuyersModel();
        $user->is_login();

        //  上传头像
        $uptool = new UpHeadTool();
        $ori_img = $uptool->up('ori_img', $_SESSION['temp_buyers_mobile']);

        if (!$ori_img) {
            $error = $uptool->getErr();
            if ($error != 0) {
                $response = array("success" => "false", "error" => array("msg" => $error, 'code' => 4101));
                $response = ch_json_encode($response);
                exit($response);
            }

        }
        if ($ori_img) {
            $data['photo'] = str_replace('Guest/', '', $ori_img);
        }

        if ($user->updateInfo($data, $_SESSION['temp_buyers_id']) !== false) //更新用户信息
        {
            $info = $user->getSingleInfo(array('temp_buyers_id'=>$uid),'temp_buyers_id,temp_buyers_mobile,nick,photo,info,invitation_person,invitation');
            $info['photo'] = NROOT . '/Guest/' . $info['photo'];
            $info['vip'] = $info['invitation_person']>0?1:0;//是否是vip 通过invitation 判断

            $response = array('success' => 'true', 'data' => $info);
            $response = ch_json_encode($response);
            exit($response);

        } else {
            $msg = '修改个人资料失败';
            $response = array("success" => "false", "error" => array("msg" => $msg, 'code' => 4100));
            $response = ch_json_encode($response);
            exit($response);

        }
    }

    /** 获取个人用户信息*/
    public function getInfo()
    {
        $user = new TempBuyersModel();
        $user->is_login();
        $uid = $_SESSION['temp_buyers_id'];

        if($row = $user->getSingleInfo(array('temp_buyers_id'=>$uid),'temp_buyers_id,temp_buyers_mobile,temp_buyers_password,photo,nick,info')){
            if($row['photo']){
                $row['photo'] = NROOT.'/Guest/'.$row['photo'];

            }else{
                $row['photo'] = '';
            }
            if(!$row['info']) $row['info'] = '';

            unset($row['temp_buyers_password']);

            $row['token'] = $_POST['token'];//接口token 然后再返回给手机端
            $response = array('success'=>'true','data'=>$row);
            $response = ch_json_encode($response);
            exit($response);
        }else{
            $msg = '获取个人资料失败';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4105));
            $response = ch_json_encode($response);
            exit($response);

        }
    }

    /** 添加收货地址 name address mobile city district*/
    public function addAddress()
    {
        $mobile = $data['mobile'] = trim($_POST['mobile']);
        $name = $data['name'] = $_POST['name'];
        $province = $data['province'] = $_POST['province'];//省
        $city = $data['city'] = $_POST['city'];//市
        $district = $data['district'] = $_POST['district'];//县（区）

        $data['defaultaddress'] = $_POST['defaultaddress'];
        $data['region_id'] = $_POST['id'];//县（区）对应的region_id
        $data['short_address']=$_POST['address'];
        $data['address']=$province.' '.$city.' '.$district.' '.$_POST['address'];


        is_mobile_legal($mobile);
        is_address_legal($data['short_address']);
        is_name_legal($name);

        is_empty($data);

        $addadress = new BaseModel('TempBuyersAddress');
        $addadress->is_login();

        //对传过的city进行判断
        $uid = $_SESSION['temp_buyers_id']?$_SESSION['temp_buyers_id']:$_SESSION['admin']['temp_buyers_id'];//供应商也可以调用这边的接口

        $data['temp_buyers_id'] = $uid;

        $condition_count['temp_buyers_id'] = $data['temp_buyers_id'];
        $count = $addadress->where($condition_count)->count();
        if ($count == 0) $data['defaultaddress'] = 1;//说明第一次填地址，默认为defaultaddress为1
        if ($count > 0) {
            //如果新增的地址defaultaddress为1，则把其他的defaultaddress为0
            if ($data['defaultaddress'] == 1) {
                $condition_update['temp_buyers_id'] = $data['temp_buyers_id'];
                $b = $addadress->where($condition_update)->save(array('defaultaddress'=>0));
                if ($b === false) exit('{"success":"false","error":{"msg":"更改默认地址失败","code":"4900"}}');
            }
        }

        if ($data['temp_buyers_address_id'] = $addadress->add($data))
        {
            $response = array("success" => "true", "data" => $data);
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            exit('{"success":"false","error":{"msg":"添加地址失败","code":"4107"}}');
        }

    }

    /** 默认地址*/
    public function defaultAddress()
    {
        $addadress = new BaseModel('TempBuyersAddress');
        $addadress->is_login();
//        $uid = $_SESSION['temp_buyers_id'];
        $uid = $_SESSION['temp_buyers_id']?$_SESSION['temp_buyers_id']:$_SESSION['admin']['temp_buyers_id'];//供应商也可以调用这边的接口

        $sql = 'select temp_buyers_address_id,name,address,mobile,defaultaddress,city,district from ecs_temp_buyers_address where defaultaddress = 1 and temp_buyers_id =' . $uid;

        $data = $addadress->query($sql);

        if(empty($data)){
            $jobj=new stdclass();
            $response = json_encode(array('success'=>'true','data'=>$jobj));
            exit($response);
        }
        $response = array('success'=>'true','data'=>$data[0]);
        $response = ch_json_encode($response);
        exit($response);
    }

    /** 地址列表*/
    public function addressList()
    {
        $addadress = new BaseModel('TempBuyersAddress');
        $addadress->is_login();
        $uid = $_SESSION['temp_buyers_id']?$_SESSION['temp_buyers_id']:$_SESSION['admin']['temp_buyers_id'];//供应商也可以调用这边的接口

        $sql = "select temp_buyers_address_id,name,short_address,address,mobile,defaultaddress,province,city,district,region_id from ecs_temp_buyers_address where temp_buyers_id ='$uid' order by temp_buyers_address_id DESC ";
        $data = $addadress->query($sql);
        if(empty($data))
        {
            $response = json_encode(array('success'=>'true','data'=>array()));
            exit($response);
        }
        for($i=0,$len=count($data);$i<$len;$i++)
        {
            if($data[$i]['short_address'])
            {
                $data[$i]['address'] = $data[$i]['short_address'];//short_address不为空
                unset($data[$i]['short_address']);
            }
            else
            {
                unset($data[$i]['short_address']);//short_address为空,使用旧地址
            }
        }
        $response = array('success'=>'true','data'=>$data);
        $response = ch_json_encode($response);
        exit($response);
    }

    /** 删除地址*/
    public function delAddress()
    {
        $addadress = new BaseModel('TempBuyersAddress');
        $addadress->is_login();

//        $uid = $_SESSION['temp_buyers_id'];
        $uid = $_SESSION['temp_buyers_id']?$_SESSION['temp_buyers_id']:$_SESSION['admin']['temp_buyers_id'];//供应商也可以调用这边的接口

        $id = isset($_POST['temp_buyers_address_id'])?$_POST['temp_buyers_address_id']+0:0;
        if(!$id) exit('{"success":"false","error":{"msg":"地址ID不能为空","code":"4800"}}');

        //判断用户有没有此地址ID
        $condition_count['temp_buyers_id'] = $uid;
        $condition_count['temp_buyers_address_id']=$id;
        $count = $addadress->where($condition_count)->count();
        if($count<1) exit('{"success":"false","error":{"msg":"删除的地址信息不存在","code":"4143"}}');

        $condition_del['temp_buyers_address_id'] = $id;
        $condition_del['temp_buyers_id'] = $uid;

        if($addadress->where($condition_del)->delete()){
            $response = array("success"=>"true","data"=>array("msg"=>'删除地址成功'));
            $response = ch_json_encode($response);
            exit($response);
        }else{
            $response = array("success"=>"false","error"=>array("msg"=>'删除地址失败','code'=>4112));
            $response = ch_json_encode($response);
            exit($response);
        }
    }

    /** 修改地址 address_id name address mobile defaultaddress*/
    public function updateAddress()
    {
        $data['temp_buyers_address_id'] = $_POST['address_id'];
        $mobile = $data['mobile'] = trim($_POST['mobile']);
//        $address = $data['address'] = $_POST['address'];
        $address = $data['short_address'] = $_POST['address'];
        $name = $data['name'] = $_POST['name'];

        $data['province'] = $_POST['province'];//省
        $data['city'] = $_POST['city'];//市
        $data['district'] = $_POST['district'];//县（区）
        $data['region_id'] = $_POST['id'];//县（区）对应的region_id

        $data['address']=$data['province'].' '.$data['city'].' '.$data['district'].' '.$_POST['address'];
        
        is_mobile_legal($mobile);
        is_address_legal($address);
        is_name_legal($name);

        is_empty($data);

        $data['defaultaddress'] = $_POST['defaultaddress'];
        
        $addadress = new BaseModel('TempBuyersAddress');
        $addadress->is_login();

//        $data['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
        $data['temp_buyers_id'] = $_SESSION['temp_buyers_id']?$_SESSION['temp_buyers_id']:$_SESSION['admin']['temp_buyers_id'];//供应商也可以调用这边的接口

        $condition_update['temp_buyers_address_id'] = $_POST['address_id'];

        if($addadress->where($condition_update)->save($data))
        {
            $data['address'] = $data['short_address'];
            unset($data['short_address']);
            $response = array('success'=>'true','data'=>$data);
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            $response = array("success"=>"false","error"=>array("msg"=>'修改地址失败','code'=>4111));
            $response = ch_json_encode($response);
            exit($response);
        }
    }

    //添加邀请码
    public function addInvitation()
    {
        $user = new  TempBuyersModel();
        $user->is_login();

        $uid = $_SESSION['temp_buyers_id'];

        if(isset($_POST['invitation']))
        {
            $res2 = $user->getSingleInfo(array('temp_buyers_id'=>$uid),'invitation');

            //判断输入的是否是自己的邀请码
            if($res2['invitation'] == $_POST['invitation'])
            {
                $response = array("success"=>"false","error"=>array("msg"=>'你不能输入自己的邀请码','code'=>4804));
                $response = ch_json_encode($response);
                exit($response);
            }

            $res = $user -> checkInvitation($_POST['invitation']);//如果通过，将取出邀请人的信息
            if(!$res)
            {
                $response = array("success"=>"false","error"=>array("msg"=>'邀请码错误','code'=>4802));
                $response = ch_json_encode($response);
                exit($response);
            }
            $invitation_id = $res['temp_buyers_id'];//邀请人的id号
            $data = array('invitation_person'=>$invitation_id,'vip'=>'1');
            $condition['temp_buyers_id'] = $uid;
            $b = $user->where($condition)->save($data);
            if(!$b)
            {
                $response = array("success"=>"false","error"=>array("msg"=>'更新邀请人失败','code'=>4908));
                $response = ch_json_encode($response);
                exit($response);
            }
            $response = array('success'=>'true','data'=>array('msg'=>'添加邀请人成功'));
            $response = ch_json_encode($response);
            exit($response);

        }else
        {
            //没有邀请码
            $response = array("success"=>"false","error"=>array("msg"=>'请输入邀请码','code'=>4803));
            $response = ch_json_encode($response);
            exit($response);
        }
    }

    //问题反馈
    public function question()
    {
        $content = $_POST['content'];

        if(strlen($content) < 15)
        {
            $response = array("success"=>"false","error"=>array("msg"=>'不少于15字符','code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
        }

        $comment = new BaseModel();
        $comment->is_login();
        $mobile = $_SESSION['temp_buyers_mobile'];

        if(!$mobile){
            $msg = 'session过期';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4120));
            $response = ch_json_encode($response);
            exit($response);
        }

        $time = time();

        $sql_into = "insert into ecs_temp_comment (mobile,content,add_time) VALUES ('$mobile','$content','$time')";
        $b = $comment->execute($sql_into);

        if($b)
        {
            $response = array("success"=>"true","data"=>array("msg"=>'反馈问题成功'));
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            $response = array("success"=>"false","error"=>array('msg'=>'反馈问题失败','code'=>4115));
            $response = ch_json_encode($response);
            exit($response);
        }
    }
}