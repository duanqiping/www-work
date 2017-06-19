<?php

/**
    B2B 微信生成支付订单接口
 */

//接收参数 get 订单号

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "../app/WxPay.JsApiPay.php";
require_once '../app/log.php';

require_once 'config/config.php';

error_reporting(E_ALL & ~E_NOTICE);
//ini_set("display_errors", "On");//显示所有错误信息  Off为屏蔽所有错误信息


//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//$openId =  $_GET['openId'];


$order_sn = $_GET['order_sn'];
if(!$order_sn)
{
    echo "order_sn参数不能为空";
    exit();
}

$conn =  mysql_connect('localhost', DB_USER,DB_PWD);
if(!$conn){
    exit('数据库连接失败');
}
$sql = 'set names utf8';
mysql_query($sql);
$sql = 'use pcwb2bs';
mysql_query($sql);

//查询订单信息
$sql_order = "select temp_purchase_id,temp_purchase_sn,buyers_id,time,money,name,address,mobile,state,method,description,receive_time,finish_time,method,transportation,account_money,payer_id from b2b_pcy_purchase WHERE state=1 AND is_delete=0 AND temp_purchase_sn='$order_sn'";
$rs_order = mysql_query($sql_order);
$res_order = mysql_fetch_assoc($rs_order);

//查看红包比例
$time = time();
$sql = "select cash_back from b2b_pcy_temp_cash WHERE bonus_id=1 AND use_end_date>'$time'";
$rs_cash = mysql_query($sql);
$res_cash = mysql_fetch_assoc($rs_cash);

$cash_back = $res_cash['cash_back'];

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


//②、统一下单
$total_fee = intval(($res_order['money']*(1+$cash_back)) * 100);

$input = new WxPayUnifiedOrder();
$input->SetBody("品材商品");
$input->SetAttach("用户id");//需要传
//$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetOut_trade_no($res_order['temp_purchase_sn']);
$input->SetTotal_fee($total_fee);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url(PAYB2B_URL);
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);


$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */

?>

<!--</head>-->
<!--<body>-->
<!--<br/>-->
<!--<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>-->
<!--<div align="center">-->
<!--    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->
<!---->



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width initial-scale=1, maxinum-scale=1" name="viewport">
    <meta content="telephone=no" name="format-detection" />
    <title>微信支付</title>
    <style type="text/css">
        /**
            dark:	#424242
            orange 	#fc5e17
            blue 	#00acff
            gray 	#7b7b7b
        */

        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }


        .dark {
            color: #424242;
        }

        .orange {
            color: #fc5e17;
        }

        .gray {
            color: #7b7b7b;
        }

        .bg-white {
            background-color: white;
        }

        .line {
            background-color: #f4f4f4;
            width: 100%;
            height: 1px
        }

        .padding {
            padding: 10px;
        }

        .padding-right {
            padding-right: 10px
        }

        .big-font{
            font-size: 18px;
        }
        .nor-font {
            font-size: 16px;
        }



        .explanation {
            color: #424242;
            margin-top: -20px
        }

        .explanation > ul {
            list-style-type: none;;
            padding: 0.4rem 0.8rem;
            font-size: 16px;
        }

        .explanation > ul > li {
            padding: 0.4rem 0;
        }

        .order-list {
            margin-top: -10px;
            margin-bottom: -10px

        }

        .order-list >ul {
            list-style-type: none;
            padding: 0 0.8rem;
        }

        /*分享按钮*/
        .share-btn {
            padding: 10px 20px;
        }

        .share-btn > button {
            width: 100%;
            height: 43px;
            background-color: #fc5e17;
            color: white;
            font-size: 18px;
            border: 0;
            border-radius:4px;
        }

    </style>

    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg == "get_brand_wcpay_request:ok"){
                        //alert(res.err_code+res.err_desc+res.err_msg);
                        alert('支付成功');
//                        window.location.href="http://xxxxxx";
                    }else{
                        //返回跳转到订单详情页面
                        alert('支付失败');
//                        window.location.href="http://xxxxx/index.php?wxid={$openid}";

                    }
//                    alert(res.err_code+res.err_desc+res.err_msg);
//                    alert('支付失败');
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
    <script type="text/javascript">
        //获取共享地址
        function editAddress()
        {
            WeixinJSBridge.invoke(
                'editAddress',
                <?php echo $editAddress; ?>,
                function(res){
                    var value1 = res.proviceFirstStageName;
                    var value2 = res.addressCitySecondStageName;
                    var value3 = res.addressCountiesThirdStageName;
                    var value4 = res.addressDetailInfo;
                    var tel = res.telNumber;

                    alert(value1 + value2 + value3 + value4 + ":" + tel);
                }
            );
        }

                window.onload = function(){
                    callpay();
                };

    </script>
</head>


<body>

<div style="text-align:center;color:#387ef5;font-size:2rem">
    <p>跳转中...</p>
</div>

</body>
</html>