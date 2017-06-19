<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2016/3/10
 * Time: 14:32
 */
class PushMessageModel extends BaseModel
{
    protected $fields = array('message_id', 'user_id', 'title', 'type', 'content', 'extend', 'time', 'device', 'is_delete', '_pk' => 'message_id', '_autoinc' => true);

    //在类初始化方法中，引入相关类库
    public function _initialize()
    {
        vendor('BaiduPush.sdk');
    }
    //把消息保存到数据库中
    public function addMessage($user_id,$temp_purchase_id)
    {
        $data['user_id'] = $user_id;
        $data['extend'] = $temp_purchase_id;
        $data['type'] = 3;
        $data['title'] = '找材猫';
        $data['content'] = '亲,你有一笔代付订单,请查看';
        $data['time'] = time();

        $b = $this->add($data);
        if($b) return true;
        else{
            $time = date('Y-m-d H:i:s');
            $msg = $this->getLastSql();
            file_put_contents('message.log', $msg.'--' . $_SESSION['temp_buyers_id'] . '--' . $time . "\n", FILE_APPEND);
            exit('{"success":"false","error":{"msg":"消息入库失败","code":"4158"}}');
        }


    }

    //取出消息列表
    public function show()
    {
        $condition['is_delete'] = 0;

        if(!$_SESSION['temp_buyers_id'])  $condition['user_id'] = 0;// //没有登录,返回公共信息

        else $condition['_string'] = "(user_id=0 or user_id='{$_SESSION['temp_buyers_id']}')";   //已经登录,公共信息和自己对应的消息

        $res = $this->where($condition)->field('message_id,title,content,extend,time,type')->order('time desc')->select();
        if($res) return $res;
        else return array();
    }

    //单用户信息推送绑定入库
    public function UserMessageAdd($push_id, $device)
    {
        $sql = "insert into " . $this->table . " set push_id='$push_id',user_id='{$_SESSION['temp_buyers_id']}',device=$device";

        $b = $this->execute($sql);
        if ($b) return true;
        else  return false;
    }

    //查询是表中是否已经存在该push_id
    public function search($push_id)
    {
        $sql = "select * from " . $this->table . " where push_id=" . $push_id;
        $res = $this->query($sql);
        if ($res) return true;
        else return false;
    }

    //返回红包，推送一条信息 andorid
    public function CashSingle($user_id,$cash_sn)
    {
        $sql_channelId = "select push_id,device from ecs_push_blind where user_id=".$user_id;
        $res_channelId = $this->query($sql_channelId);

        $sql_bonus = "select ca.cash_money,b.bonus_name from ecs_temp_cash ca LEFT JOIN ecs_temp_bonus b on ca.cash_bonus_id = b.bonus_id WHERE ca.cash_sn='$cash_sn'";
        $res_bonus = $this->query($sql_bonus);

        if($res_channelId && $res_bonus)
        {
            $channelId = $res_channelId[0]['push_id'];//用户绑定的channelid
            $device = $res_channelId[0]['device'];//用户设备 android or ios

            $bonus_name = $res_bonus[0]['bonus_name'];//红包名字
            $bonus_money = $res_bonus[0]['cash_money'];//红包金额

            // 创建SDK对象.
            if($device == 1)
            {
                $sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ', 'qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');//android
                $sdk->setDeviceType(3);
                $opts = array(
                    'msg_type' => 1,
                );

                $message = array();
                $message['title'] = $bonus_name;
                $message['description'] = '亲,你收到一个'.$bonus_name.',请查看';
                $message['custom_content'] = array('type'=>1,'time'=>time(),'title'=>$message['title'],'extend'=>'你收到一个'.$bonus_money.'元的'.$bonus_name.',红包金额会自动存入你的余额,可以在下单中当作现金使用(可以在【我的红包】查看收到的红包)');

            }
            else
            {
                $sdk = new PushSDK();//ios
                // 设置消息类型为 通知类型.
                $opts = array(
                    'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
                    'deploy_status' => 2,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
                );
                $message = array (
                    'aps' => array (
                        // 消息内容
                        'alert' => $bonus_name,
                        'badge'=>1
                    ),
                );
                $message['title'] = $bonus_name;
                $message['description'] = '亲,你收到一个'.$bonus_name.',请查看';
                $message['custom_content'] = array('type'=>1,'time'=>time(),'title'=>$bonus_name,'extend'=>'你收到一个'.$bonus_money.'元的'.$bonus_name.',红包金额会自动存入你的余额,可以在下单中当作现金使用(可以在【我的红包】查看收到的红包)');
            }

            //获取安卓 推送信息
            $data = array();
            $data['title']= $bonus_name;
            $data['content'] = '亲,你收到一个'.$bonus_name.',请查看';
            $data['user_id'] = $user_id;
            $data['extend'] = '你收到一个'.$bonus_money.'元的'.$bonus_name.',红包金额会自动存入你的余额,可以在下单中当作现金使用(可以在【我的红包】查看收到的红包)';
            $data['time'] = time();
            $data['device'] = $device;
            $data['type'] = 1;

            if($this->add($data))
            {
                // 向目标设备发送一条消息
                $rs = $sdk->pushMsgToSingleDevice($channelId, $message, $opts);
                if ($rs === false) {
                    file_put_contents('./Runtime/Logs/other/log.txt', $sdk->getLastErrorCode() . '--' . $sdk->getLastErrorMsg() . '--' .'android红包消息推送失败'. $user_id . '--' . time() . "\n", FILE_APPEND);
                } else {
                    return true;
                }
            }
            return true;
        }
    }

    //好友代付 -- 安卓
    public function single($channelId,$device,$user_id,$temp_purchase_id)
    {
        // 创建SDK对象.
        $sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ', 'qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');
        $sdk->setDeviceType(3);

        //获取安卓 推送信息

        $message = array();
        $message['title'] = '找材猫';
        $message['description'] = '亲,你有一笔代付订单,请查看';
        $message['custom_content'] = array('type'=>3,'extend'=>$temp_purchase_id);

        // 设置消息类型为 通知类型.
        $opts = array(
            'msg_type' => 1,
        );

        // 向目标设备发送一条消息
        $rs = $sdk->pushMsgToSingleDevice($channelId, $message, $opts);

        $time = date('Y-m-d H:i:s');
        $data['user_id'] = $user_id;
        $data['type'] = 3;
        $data['title'] = $message['title'];
        $data['content'] =  $message['description'];
        $data['extend'] = $temp_purchase_id;
        $data['time'] = time();
        $data['device'] = $device;

        $b = $this->add($data);
        if(!$b)  file_put_contents('message.log', '插入失败--' . $_SESSION['temp_buyers_id'] . '--' . $time . "\n", FILE_APPEND);
        // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
        if ($rs === false) {
            file_put_contents('message.log', $sdk->getLastErrorCode() . '--' . $sdk->getLastErrorMsg() . '--' . $_SESSION['temp_buyers_id'] . '--' . $time . "\n", FILE_APPEND);
        } else {
            return true;
        }
    }

    //好友代付 -- ios
    public function single_ios($channelId,$device,$user_id,$temp_purchase_id)
    {
        $pushmessage = new PushMessageModel();
//        $pushmessage->is_login();
        // 创建SDK对象.
        $sdk = new PushSDK();

        $message = array (
            'aps' => array (
                // 消息内容
                'alert' => '好友的请求代付款',
                'badge'=>1
            ),
        );

//        $message = array();
        $message['title'] = '好友的请求代付款';
        $message['description'] = '亲,你有一笔代付订单,请查看';
        $message['custom_content'] = array('type'=>3,'extend'=>$temp_purchase_id);
        // 设置消息类型为 通知类型.
        $opts = array(
            'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
            'deploy_status' => 2,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
        );

        // 向目标设备发送一条消息
        $rs = $sdk->pushMsgToSingleDevice($channelId, $message, $opts);

        $time = date('Y-m-d H:i:s');
        $data['user_id'] = $user_id;
        $data['type'] = 3;
        $data['title'] = $message['title'];
        $data['content'] =  $message['description'];
        $data['extend'] = $temp_purchase_id;
        $data['time'] = time();
        $data['device'] = $device;

        $b = $this->add($data);

        if(!$b)  file_put_contents('message.log', '插入失败--' . $_SESSION['temp_buyers_id'] . '--' . $time . "\n", FILE_APPEND);

        // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.

        if ($rs === false) {
            file_put_contents('message.log', $sdk->getLastErrorCode() . '--' . $sdk->getLastErrorMsg() . '--' . $_SESSION['temp_buyers_id'] . '--' . $time . "\n", FILE_APPEND);
        } else {
            // 将打印出消息的id,发送时间等相关信息.
            // 然后将信息出入的消息表中
            return true;
        }
    }

    //推送到个人（找材猫）
    public function pushOne($mobile,$data)
    {
        $time = time();

        $message['title'] = $data['title'];
        $message['description'] = $data['content'];
        $message['custom_content'] = array('type'=>1,'title'=>$data['title'],'time'=>"$time",'extend'=>$data['content']);

        $sql = "select push_id,user_id,device FROM ecs_push_blind WHERE user_id = (select temp_buyers_id from ecs_temp_buyers WHERE temp_buyers_mobile='$mobile') limit 1";
        $res = $this->query($sql);
        if(!$res) $this->printError('用户没有绑定推送','4804');
        $res = $res[0];

        $channelId = $res['push_id'];

        //安卓
        if($res['device'] == 1)
        {
            $sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ', 'qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');
            $sdk->setDeviceType(3);

            // 设置消息类型为 通知类型.
            $opts = array (
                'msg_type' => 1,
            );
        }
        //ios
        else
        {
            //创建ios sdk对象
            $sdk = new PushSDK();

            $message = array (
                'aps' => array (
                    // 消息内容
                    'alert' => $_POST['title'],
                    'badge'=>1
                ),
            );
            $opts = array(
                'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
                'deploy_status' => 2,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
            );
        }

        $rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
        if($rs === false){
            $this->printError('推送失败','4805');
        }else{
            $data['time'] = $time;
            $data['type'] = 1;
            $data['extend'] = $data['content'];
            $data['user_id'] = $res['user_id'];

            $b = $this->add($data);
            if($b) return true;
            else $this->printError('推送信息入库失败','5001');
        }
    }

    //android 批量推送
    public function pushSome($device,$user_type)
    {
        $time = time();
        $message['title'] = $_POST['title'];
        $message['description'] = $_POST['content'];
        $message['custom_content'] = array('type'=>1,'title'=>$_POST['title'],'time'=>"$time",'extend'=>$_POST['content']);

        if($device == 1)
        {
            //创建andriod sdk对象
            $sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ', 'qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');
            $sdk->setDeviceType(3);

            // 设置消息类型为 通知类型.
            $opts = array (
                'msg_type' => 1,
            );
        }
        else if($device == 2)
        {
            //创建ios sdk对象
            $sdk = new PushSDK();

            $message = array (
                'aps' => array (
                    // 消息内容
                    'alert' => $_POST['title'],
                    'badge'=>1
                ),
            );
            $opts = array(
                'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
                'deploy_status' => 2,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
            );
        }
        else
        {
            exit('device 有误');
        }

        if($user_type == 1)
        {
            //老用户
            $sql = "select b.push_id,b.user_id from ecs_temp_purchase p left join  ecs_push_blind b on p.buyers_id=b.user_id WHERE b.user_id is not null AND b.device='$device' AND p.suppliers_id=1024 AND p.state BETWEEN 2 AND 7 GROUP by p.buyers_id";
        }
        else
        {
            //新用户（如果需求扩展时  只需多传一个参数判断是新用户 or 老用户就ok）
            $sql = "select b.push_id,b.user_id from ecs_push_blind b  WHERE b.user_id is not null AND b.device='$device' AND NOT EXISTS (select pu.temp_purchase_id from ecs_temp_purchase pu where pu.buyers_id=b.user_id AND pu.state BETWEEN 2 AND 7)";
        }
        
        $res = $this->query($sql);

        $idArr = array();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $idArr[] = $res[$i]['push_id'];//取出用户的push_id
        }


//        if($device == 1)
//        {
//            $res = array('0'=>array('user_id'=>6269));
//            $idArr = array('3754056278303487806');//齐平
//        }
//        else
//        {
//            $res = array('0'=>array('user_id'=>226),'1'=>array('user_id'=>3727));
//            $idArr = array('5586371042050149118','4761988529483011894');//刘俊杰
//
////            $res = array('0'=>array('user_id'=>1547),'1'=>array('user_id'=>5115),'2'=>array('user_id'=>5235));
////            $idArr = array('5005565471070422766','5178936511792051421','5140562087750859420');//刘振杰 王云 朱丹成
//        }


        $rs = $sdk -> pushBatchUniMsg($idArr,$message,$opts);
        if($rs === false){
            $this->printError('推送失败','4806');
        }
        return $res;
    }
    //ios 批量推送
    public function ios_some()
    {
        // 创建SDK对象.
        $sdk = new PushSDK();

        $message = array (
            'aps' => array (
                // 消息内容
                'alert' => $_POST['title'],
                'badge'=>1
            ),
        );
        
        $message['title'] = $_POST['title'];
        $message['description'] = $_POST['content'];
        $message['custom_content'] = array('type'=>1,'title'=>$_POST['title'],'time'=>time(),'extend'=>$_POST['content']);

        $opts_ios = array(
            'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
            'deploy_status' => 2,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
        );

        $sql = "select b.push_id,b.user_id from ecs_temp_purchase p left join  ecs_push_blind b on p.buyers_id=b.user_id WHERE b.user_id is not null AND b.device=2 AND p.suppliers_id=1024 AND p.state BETWEEN 2 AND 7 GROUP by p.buyers_id";
        $res = $this->query($sql);

        $idArr_ios = array();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $idArr_ios[] = $res[$i]['push_id'];//ios用户
        }

//        $idArr_ios = array('5140562087750859420','5005565471070422766');//朱丹成，刘振杰
//        $res = array('0'=>array('user_id'=>5235),'1'=>array('user_id'=>1547));

        $rs_ios = $sdk -> pushBatchUniMsg($idArr_ios,$message,$opts_ios);
//
        if($rs_ios === false){
            print_r($sdk->getLastErrorCode());
            print_r($sdk->getLastErrorMsg());
        }
//        echo " ios push ok";
        return $res;
    }

    //android 批量推送(全部会员)
    public function android_all()
    {
        // 创建SDK对象.
        $sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ', 'qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');
        $sdk->setDeviceType(3);

        $time = time();
        $message['title'] = $_POST['title'];
        $message['description'] = $_POST['content'];
        $message['custom_content'] = array('type'=>1,'title'=>$_POST['title'],'time'=>"$time",'extend'=>$_POST['content']);

        // 设置消息类型为 通知类型.
        $opts = array (
            'msg_type' => 1,
        );

//        $sql = "select b.push_id from ecs_temp_purchase p left join  ecs_push_blind b on p.buyers_id=b.user_id WHERE b.user_id is not null AND b.device=1 AND p.suppliers_id=1024 AND p.state BETWEEN 2 AND 7 GROUP by p.buyers_id";
        $sql = "select b.push_id from  ecs_push_blind b  WHERE b.user_id is not null AND b.device=1";
        $res = $this->query($sql);

        $idArr = array();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $idArr[] = $res[$i]['push_id'];//安卓用户
        }

//        $res = array('0'=>array('user_id'=>6269));
//        $idArr = array('4262196927315867566');//谭易

        $rs = $sdk -> pushBatchUniMsg($idArr,$message,$opts);
        if($rs === false){
            print_r($sdk->getLastErrorCode());
            print_r($sdk->getLastErrorMsg());
        }
    }

    //ios 批量推送(全部会员)
    public function ios_all()
    {
        // 创建SDK对象.
        $sdk = new PushSDK();

        $message = array (
            'aps' => array (
                // 消息内容
                'alert' => $_POST['title'],
                'badge'=>1
            ),
        );

        $message['title'] = $_POST['title'];
        $message['description'] = $_POST['content'];
        $message['custom_content'] = array('type'=>1,'title'=>$_POST['title'],'time'=>time(),'extend'=>$_POST['content']);

        $opts_ios = array(
            'msg_type' => 1,        // iOS不支持透传, 只能设置 msg_type:1, 即通知消息.
            'deploy_status' => 2,   // iOS应用的部署状态:  1：开发状态；2：生产状态； 若不指定，则默认设置为生产状态。
        );

        $sql = "select b.push_id from ecs_push_blind b WHERE b.user_id is not null AND b.device=2";
        $res = $this->query($sql);


        $idArr_ios = array();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $idArr_ios[] = $res[$i]['push_id'];//ios用户
        }

//        $idArr_ios = array('5586371042050149118','4761988529483011894');//刘俊杰

        $rs_ios = $sdk -> pushBatchUniMsg($idArr_ios,$message,$opts_ios);
//
        if($rs_ios === false){
            print_r($sdk->getLastErrorCode());
            print_r($sdk->getLastErrorMsg());
        }
    }

}