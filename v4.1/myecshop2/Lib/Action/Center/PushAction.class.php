<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2016/3/10
 * Time: 14:17
 */
class PushAction extends Action
{
    //在类初始化方法中，引入相关类库
    public function _initialize() {
        vendor('BaiduPush.sdk');
    }
    //消息列表(找材猫)
    public function show()
    {
        $pushmessage = new PushMessageModel();
//        $pushmessage->is_login();

        $data = $pushmessage->show();

        $response = array('success' => 'true', 'data' => $data);
        $response = ch_json_encode($response);
        exit($response);

    }

    //绑定用户信息入库(找材猫)
    public function add()
    {
        $push_id = $_POST['push_id'];
        $device = $_POST['device'];
        $uid = $_SESSION['temp_buyers_id'];

        $model = new BaseModel();
        $model->is_login();

        $sql = "select * from ecs_push_blind where push_id='$push_id' or user_id='$uid'";
        $res = $model->query($sql);
        $res =  $res[0];////查询是表中是否已经存在该push_id和user_id
        
        //保证push_id 和 user_id都唯一性
        if($res)
        {
            if($res['user_id'] == $uid && $res['push_id']==$push_id && $res['device'] == $device)
            {
                $response = array("success"=>"true","data"=>'消息入库成功');
                $response = ch_json_encode($response);
                exit($response);
            }
            else
            {
                $sql_update = "update ecs_push_blind set push_id='$push_id',user_id='$uid',device='$device' WHERE id='{$res['id']}'";
                $b = $model->execute($sql_update);

                if($b)
                {
                    $response = array("success"=>"true","data"=>'消息入库成功');
                    $response = ch_json_encode($response);
                    exit($response);
                }
                else
                {
                    $response = array("success"=>"false","data"=>array("msg"=>'手机信息更新失败'));
                    $response = ch_json_encode($response);
                    exit($response);
                }
            }

        }

        $sql = "insert into ecs_push_blind set push_id='$push_id',user_id='$uid',device=$device";
        $b2 = $model->execute($sql);

        if($b2)
        {
            $response = array("success"=>"true","data"=>'消息入库成功');
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            $response = array("success"=>"false","error"=>array("msg"=>'用户手机信息入库失败','code'=>4805));
            $response = ch_json_encode($response);
            exit($response);
        }
    }


    /** 指定 推送一些人(找材猫)
     * title 推送内容标题
        content 推送消息内容
     *  user_type 推送客户类型 1老用户 2新用户
     */
    public function some()
    {
        $pushmessage = new PushMessageModel();

        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        $data['user_type'] = $_POST['user_type'];

        $user_type = $_POST['user_type'];
        
        $pushmessage->checkPostData(!($_POST['title']&&$_POST['content']),'title和content不能为空',4800);
        $pushmessage->checkPostData(!($user_type == 1 || $user_type==2),'user_type的值只能为1或2',4801);

        $data['type'] = 1;
        $data['time'] = time();
        $data['extend'] = $_POST['content'];

        $res_android = array();
        $res_ios = array();
        $res_android = $pushmessage->pushSome($device = 1,$user_type);//安卓用户推送
        $res_ios  = $pushmessage->pushSome($device = 2,$user_type);//ios用户推送
        $res = array_merge($res_android,$res_ios);

        //对应消息入库
        $data_res= array();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $data_res[$i] = $data;
            $data_res[$i]['user_id'] = $res[$i]['user_id'];
        }

        $ids = $pushmessage->addAll($data_res);
        if(!$ids) $pushmessage->printError('用户消息入库失败','4800');

        if($user_type == 2) $msg='新用户推送成功';
        else $msg = '老用户推送成功';
        $pushmessage->printSuccess($msg);
    }

    //推送所有人（全部会员）(找材猫)
    public function push_all()
    {
        $pushmessage = new PushMessageModel();
//        $pushmessage->is_login();

        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        $data['type'] = 1;
        $data['time'] = time();
        $data['extend'] = $_POST['content'];

        $pushmessage->android_all();
        $pushmessage->ios_all();

        $b = $pushmessage->add($data);
        if(!$b) $pushmessage->printError('消息入库失败','4800');
        $pushmessage->printSuccess('推送成功');
    }

    /**
     * 推送到个人（找材猫）
     * title 推送内容标题
     *  content 推送消息内容
     * mobile 手机号码
    */
    public function one()
    {
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        $mobile = trim($_POST['mobile']);

        is_mobile_legal($mobile);

        $pushmessage = new PushMessageModel();
        $pushmessage->checkPostData(!($_POST['title']&&$_POST['content']),'title和content不能为空',4800);

        $pushmessage->pushOne($mobile,$data);

        $pushmessage->printSuccess('推送成功');




    }

    //推送到单台设备  安卓
    public function single()
    {
        $pushmessage = new PushMessageModel();
        $pushmessage->is_login();
        // 创建SDK对象.
        $sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ','qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');
        $sdk->setDeviceType(3);

        //获取安卓 推送信息
        $message = array();
        $message['title'] = $_POST['title'];
        $message['description'] = $_POST['content'];
        $message['custom_content'] = array('type'=>1,'time'=>time(),'title'=>$_POST['title'],'extend'=>'品材网又降价啦！黄沙，2.98元/包起；声达生态板，199元/张；西门了品宜五孔，7.38元/个...  包运费包上楼，更多低价点开“找材猫”吧!',);

        // 设置消息类型为 通知类型.
        $opts = array (
            'msg_type' => 1,
        );

//        $channelId = '3754056278303487806';//3512439608136708538
        $channelId = $_POST['push_id'];
        
        // 向目标设备发送一条消息
        $rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
//        $rs = $sdk -> pushMsgToAll($message,$opts);

        // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
        if($rs === false){
            print_r($sdk->getLastErrorCode());
            print_r($sdk->getLastErrorMsg());
        }else{
            // 将打印出消息的id,发送时间等相关信息.
            $rs['RequestId'] = $sdk->getRequestId();// 获得方法调用所生成的 RequestId
            $data = json_encode($rs);
            exit($data);
        }

    }

    //推送到单台设备  ios
    public function single_ios()
    {
        $pushmessage = new PushMessageModel();
        $pushmessage->is_login();
        // 创建SDK对象.
        $sdk = new PushSDK();

        $message = array (
            'aps' => array (
                // 消息内容
                'title' => $_POST['title'],
                'description'=>$_POST['content'],
                'badge'=>1
            ),
        );
        // 设置消息类型为 通知类型.
        $opts = array (
            'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
            'deploy_status' => 2,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
        );

        $channelId = $_POST['push_id'];
        // 向目标设备发送一条消息
        $rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
//        $rs = $sdk -> pushMsgToAll($message,$opts);


        // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
        if($rs === false){
            print_r($sdk->getLastErrorCode());
            print_r($sdk->getLastErrorMsg());
        }else{
            // 将打印出消息的id,发送时间等相关信息.
            $rs['RequestId'] = $sdk->getRequestId();// 获得方法调用所生成的 RequestId
            $data = json_encode($rs);
            exit($data);
        }

    }

    //推送到所有设备  安卓
    public function all()
    {
        $pushmessage = new PushMessageModel();
        $pushmessage->is_login();
        // 创建SDK对象.
        $sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ','qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');
        $sdk->setDeviceType(3);

        //获取安卓 推送信息
        $sql = "select * from ecs_push_message where (device=0 OR device=1) and is_delete=0";
        $data = $pushmessage->query($sql);
        $data=$data[0];

        $message = array();
        $message['title'] = $data['title'];
        $message['description'] = $data['content'];

//        $message['extend'] = array('type'=>'text','data'=>array('title'=>'欢迎新同事','content'=>'大家好才是真的好'));
        $message['extend'] = unserialize($data['extend']);
//        $message['customContentString'] = 1;

        // 设置消息类型为 通知类型.
        $opts = array (
            'msg_type' => 1,
        );

        // 向目标设备发送一条消息
//        $rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
        $rs = $sdk -> pushMsgToAll($message,$opts);


        // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
        if($rs === false){
            print_r($sdk->getLastErrorCode());
            print_r($sdk->getLastErrorMsg());
        }else{
            // 将打印出消息的id,发送时间等相关信息.
            $rs['RequestId'] = $sdk->getRequestId();// 获得方法调用所生成的 RequestId
            $rs['message_id'] = $data['message_id'];
            $rs['title'] = $data['title'];
            $rs['content'] = $data['content'];
            $rs['extend'] = $message['extend'];

            $data = json_encode($rs);
            exit($data);
        }
    }

    //推送到所有设备  ios
    public function all_ios()
    {
        $pushmessage = new PushMessageModel();
        $pushmessage->is_login();
        // 创建SDK对象.
        $sdk = new PushSDK();

        //获取安卓 推送信息
        $message = array (
            'aps' => array (
                // 消息内容
                'title' => $_POST['title'],
                'description'=>$_POST['content'],
                'badge'=>1
            ),
        );

        // 设置消息类型为 通知类型.
        $opts = array (
            'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
            'deploy_status' => 1,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
        );

        $rs = $sdk -> pushMsgToAll($message,$opts);

        // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
        if($rs === false){
            print_r($sdk->getLastErrorCode());
            print_r($sdk->getLastErrorMsg());
        }else {
            // 将打印出消息的id,发送时间等相关信息.
            $rs['RequestId'] = $sdk->getRequestId();// 获得方法调用所生成的 RequestId
            $data = json_encode($rs);
            exit($data);
        }
    }

}