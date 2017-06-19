<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/11/22
 * Time: 17:09
 */

namespace Index\Controller;


use Common\Controller\BaseController;
use Index\Model\ChargeModel;
use Index\Model\VipModel;

class PayController extends BaseController
{
    /** 预支付订单 返回签名*/
    public function alisign()
    {
        vendor('AliPay.Corefunction');
        vendor('AliPay.Notify');
        vendor('AliPay.Rsafunction');

        $order_sn = $_POST['ordersn'];
        checkPostData($order_sn, '订单号有误', '400');

        $charge = new ChargeModel();
        $charge->is_login();
        $res = $charge->where(array('ordersn'=>$order_sn))->field('charge_id,user_id,money,ordersn,paytype,statu,name,product_flag_id,price_id,insert_time')->find();
        if($res['statu'] != 0) sendError('订单不是待支付的订单',401);

        $total_fee = $res['money'];
        $total_fee = round($total_fee,2);

        $buyers_id = $res['user_id'];
        $order_sn = $res['ordersn'];
        $subject = '支付宝支付';

        $notify_url = DROOT.'/index/pay/ali';//回掉接口

        $tempKey = "myKey=\"aec188\"&";
        $data = array(
            'partner' => '2088911549097841',//
            'seller_id' => 'hbz@pcw268.com',//支付宝账号
            'out_trade_no' => $order_sn,//商户网站唯一订单号
            'subject' => $subject,//商品名称
            'body' => $buyers_id,//商品详情
            'total_fee' => $total_fee,//总金额
            'notify_url' => $notify_url,//回调地址
            'service' => 'mobile.securitypay.pay',
            'payment_type' => 1,//支付类型
            '_input_charset' => 'utf-8',
            'it_b_pay' => "30m",
            'show_url' => "m.alipay.com",
        );

//        $data = argSort($data);
        $str = createLinkstringWhiteQuote($data);//拼接

        $alipay_config = C('alipay_config');

        $sign = rsaSign($tempKey.$str,$alipay_config['private_key_path']);

        //对签名进行urlencode转码
        $sign = urlencode($sign);

        $orderInfor = $str."&sign=\"".$sign."\"&sign_type=\"RSA\"";

        $response = json_encode($orderInfor);
        exit($response);
    }

    /** 支付宝回调接口*/
    public function ali()
    {
        ali_log('11111111','test1');

        //支付宝
        vendor('AliPay.Corefunction');
        vendor('AliPay.Notify');
        vendor('AliPay.Rsafunction');

        //计算得出通知验证结果:
        $alipay_config = C('alipay_config');
        $alipayNotify = new \AlipayNotify($alipay_config);

        $verify_result = $alipayNotify->verifyNotify();//验证消息是否是支付宝发出的合法消息

        //验证成功
        if ($verify_result) {

            $time = date('Y-m-d H:i:s');//日志 时间
            $out_trade_no = $_POST['out_trade_no'];//商户订单号
            $trade_no = $_POST['trade_no']; //支付宝交易号
            $trade_status = $_POST['trade_status'];//交易状态
            $buyer_email = $_POST['buyer_email']; //买家支付宝账号
            $total_fee = $_POST['total_fee'];//交易总金额

            $payer_id = $_POST['body'];//付款人的user_id

            if ($_POST['trade_status'] == 'TRADE_FINISHED')
            {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //该种交易状态只在两种情况下出现
                //1、开通了普通即时到账，买家付款成功后。
                //2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。

                ali_log('11111111','test2');

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
                $charge = new ChargeModel();
                $res = $charge->where(array('ordersn'=>$out_trade_no))
                    ->field('charge_id,user_id,ordersn,money,paytype,statu,name,product_flag_id,price_id,insert_time')
                    ->find();

                //判断此订单状态是否为1；
                if ($res['statu'] != 0)
                {
                    ali_log($out_trade_no,'支付异常');
                    //发短信通知卖家发货
                    $message = "订单号:" . $out_trade_no . "金额:" . $total_fee . ' 时间' . date("Y-m-d H:i:s", $time) . "支付发生异常,请及时处理";
                    $mobile = '15189345238';//'15189345238';//沈鹏
                    sendmessage($mobile, $message);
                    echo "success";
                    return false;
                }

                //修改订单状态为支付成功2
                $charge->startTrans();
                $b1  = $charge->where(array('ordersn'=>$out_trade_no))->save(array('statu'=>1));
                if(!$b1)
                {
                    ali_log($out_trade_no,'订单状态更新失败');
                    echo "success";
                    return false;
                }
                //给用户创建 该服务的vip账号
                $vipModel = new VipModel();
                //首先查看他原先是否办过该业务
                $b2 = $vipModel->CreateVipAccount($res['user_id'],$res['product_flag_id'],$res['price_id']);
                if($b1 && $b2)
                {
                    $charge->commit();
                }
                else
                {
                    $charge->rollback();
                    ali_log($out_trade_no,'服务器错误');
                    echo "success";
                    return false;
                }

                ali_log($out_trade_no,'支付成功');

                //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                echo "success";        //请不要修改或删除
            }
            else {
                    ali_log($out_trade_no,'支付失败');
                    //验证失败
                    echo "fail";
                    //调试用，写文本函数记录程序运行情况是否正常
                    logResult('fail');
                }
            }
        }

    /** 微信生成支付订单接口*/
    public function doOrder()
    {
        vendor('WxPay.WxPayApi');//注意微信和支付宝不一样，引入的类文件名需得和类名一样
        vendor('WxPay.WxPayConfig');
        vendor('WxPay.WxPayException');
        vendor('WxPay.WxPayDataBase');
        vendor('WxPay.WxPayNotify');

        $order_sn = $_POST['ordersn'];
        checkPostData($order_sn, '订单号有误', '400');

        $charge = new ChargeModel();
        $charge->is_login();
        $res = $charge->where(array('ordersn'=>$order_sn))
            ->field('charge_id,user_id,money,ordersn,paytype,statu,name,product_flag_id,price_id,insert_time')
            ->find();
        if($res['statu'] != 0) sendError('订单不是待支付的订单',401);

        $total_fee = ($res['money']) * 100;
        $out_trade_no = $res['ordersn'];

        $body = '品材商品';
        $input = new \WxPayUnifiedOrder();

        //设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
        $input->SetOut_trade_no($out_trade_no);
        //设置商品或支付单简要描述
        $input->SetBody($body);
        //设置订单总金额，只能为整数，详见支付金额
        $total_fee = round($total_fee);//四舍五入
        $total_fee = intval($total_fee);//转成整形

        //交易有效时间
        $time_start = date('YmdHis',NOW_TIME);//交易开始时间（30分钟）
        $time_expire = date('YmdHis',NOW_TIME+30);//交易结束时间（30分钟）

        $input->SetTime_start($time_start);//交易开始时间
        $input->SetTime_expire($time_expire);//交易结束时间

        $input->SetAttach($_SESSION['user_id']);//付款人的user_id (待付款需要这个参数)

        $input->SetTotal_fee($total_fee);
        //设置取值如下：JSAPI，NATIVE，APP，详细说明见参数规定
        $input->SetTrade_type("APP");
        //设置接收微信支付异步通知回调地址
        $input->SetNotify_url(DROOT.'/index/pay/wx');

        $result = \WxPayApi::unifiedOrder($input);

        if (!array_key_exists("trade_type", $result) || !array_key_exists("prepay_id", $result))
        {
            if ($result['err_code_des']) {
                $msg = $result['err_code_des'];
            } else {
                $msg = '下单失败';
            }
            sendError($msg,401);
        }
        else
        {
            //返回数据给APP:trade_type,prepay_id
            $response = json_encode($result);
            exit($response);
        }
    }

    /** 微信支付回调接口  找材猫*/
    public function wx()
    {
        vendor('WxPay.WxPayApi');//注意微信和支付宝不一样，引入的类文件名需得和类名一样
        vendor('WxPay.WxPayConfig');
        vendor('WxPay.WxPayException');
        vendor('WxPay.WxPayDataBase');
        vendor('WxPay.WxPayNotify');

        vendor('WxPay.PayNotifyCallBack');

        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
    }


}