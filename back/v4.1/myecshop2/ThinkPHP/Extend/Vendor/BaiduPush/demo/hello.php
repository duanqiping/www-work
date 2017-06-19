<?php
/**
 * *************************************************************************
 *
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 *
 * ************************************************************************
 */
/**
 *
 * @file hello.php
 * @encoding UTF-8
 * 
 * 
 *         @date 2015年3月10日
 *        
 */
require_once '../sdk.php';

$conn =  mysql_connect('localhost', 'root','aecsqlyou');
if(!$conn){
    $msg = "数据库连接失败";
    file_put_contents('log.txt',$msg.'--'.$time."\n",FILE_APPEND);
    return false;
}
$sql = 'set names utf8';
mysql_query($sql);
$sql = 'use ecshop';
mysql_query($sql);

//获取安卓 推送信息
$sql = "select * from ecs_push_message where (device=0 OR device=1) and is_delete=0";
$rs = mysql_query($sql);

$data = mysql_fetch_assoc($rs);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit();


//更新表,置期无效
$sql_update = "update ecs_push_message set is_delete=1 where message_id=".$data['message_id'];

$b = mysql_query($sql_update);

// 创建SDK对象.
$sdk = new PushSDK('N7okVPmX3GGEWUzMe5veYpHQ','qtsawbPU4GLr2Uo2zBDqdTP20VHfLny4');

$sdk->setDeviceType(3);

// message content.
$message = array();
$message['title'] = $data['title'];
$message['description'] = $data['content'];
$message['customContentString'] = 1;


// 设置消息类型为 通知类型.
$opts = array (
    'msg_type' => 1,
);

// 向目标设备发送一条消息
//$rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
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

    $data = json_encode($rs);
    exit($data);
}

 