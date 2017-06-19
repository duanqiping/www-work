<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/6/6
 * Time: 14:41
 */

/**
    找人支付 (该接口 已经被弃用)
 */

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "../app/WxPay.JsApiPay.php";
require_once '../app/log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

$url = $_GET['uri']."&openId=".$openId;
Header("Location: $url");
exit();



