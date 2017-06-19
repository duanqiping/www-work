<?php
/*APP统一下单接口*/
define('ACC',true);
require('../../include/init.php');
ini_set('date.timezone','Asia/Shanghai');
require_once "../lib/WxPay.Api.php";
require_once 'log.php';
//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
//接收订单号

$model = new Model();
$model->is_login();

$order_sn = isset($_POST['order_sn'])?trim($_POST['order_sn']):'';
if(!$order_sn){
        $msg = '订单号必须存在';
        $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
        $response = ch_json_encode($response);
        exit($response);
}
$c = 'C';
$pos = strpos($order_sn,$c);
if($pos!==false){//充值订单
    $cashorderinfo = new CashOrderModel;
    $orderinfo = $cashorderinfo->getinfobysn($order_sn);
   if(!$orderinfo){
           $msg = '无此订单信息';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
    }
    if($orderinfo['order_status']!=0){
           $msg = '订单状态应该为待支付';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
    }
    $total_fee = ($orderinfo['order_amount'])*100;//($orderinfo['order_amount'])*100;

    $out_trade_no = $order_sn;
}else{
    $purchase = new PurchaseModel();
    $orderinfo = $purchase->lookpurchase($order_sn);
    if(!$orderinfo){
           $msg = '无此订单信息';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
    }
    if($orderinfo['state']!=1){
        $msg = $orderinfo['state']==0?'该订单已经取消':'该订单已经付款';
           $msg = '订单状态应该为待支付';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
    }
    $total_fee = ($orderinfo['money']-$orderinfo['account_money'])*100;
    if($orderinfo['account_money']>0){
        $out_trade_no = $order_sn."-1";
    }else if($_SESSION['temp_buyers_id'] != $orderinfo['buyers_id']) {
        //为人代支付
        $out_trade_no = $order_sn.'-'.$_SESSION['temp_buyers_id'];
    }else{
        $out_trade_no = $order_sn;
    }

}

    $body = '品材商品';
   


$input = new WxPayUnifiedOrder();

//设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
$input->SetOut_trade_no($out_trade_no);
//设置商品或支付单简要描述
$input->SetBody($body);
//设置订单总金额，只能为整数，详见支付金额
$total_fee = round($total_fee);//四舍五入
$total_fee = intval($total_fee);//转成整形


$input->SetAttach($_SESSION['temp_buyers_id']);//付款人的user_id (待付款需要这个参数)

$input->SetTotal_fee($total_fee);
//设置取值如下：JSAPI，NATIVE，APP，详细说明见参数规定
$input->SetTrade_type("APP");
//设置接收微信支付异步通知回调地址
$input->SetNotify_url("http://115.182.53.111/ecshop2/MobileAPI/v3/AskPriceApi/Wxpay/app/notify.php");
//$input->SetNotify_url("http://121.40.239.22/pcwstore/AskPriceApi/Wxpay/app/notify.php");

$result = WxPayApi::unifiedOrder($input);
Log::DEBUG("unifiedorder:" . json_encode($result));
if(!array_key_exists("trade_type", $result)  || !array_key_exists("prepay_id", $result)){
            if($result['err_code_des']){
                $msg = $result['err_code_des'];
            }else{
                $msg = '下单失败';
            }
            
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);

}else{
    //返回数据给APP:trade_type,prepay_id

    $response = array('success'=>'true','data'=>$result);
    $response = ch_json_encode($response);
    exit($response);

}

?>