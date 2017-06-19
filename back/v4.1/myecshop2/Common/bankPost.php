<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2015/12/28
 * Time: 9:40
 */
//这个函数 仅快捷支付 创建支付订单需要
//快捷支付要post的参数
function curlBankPost($requestTime,$total_fee,$bankcardinfo,$bankCardType,$save_code,$order_sn,$agreementNo)
{
    $key = KEY;
    $merchantcode = MerchantCode;
    $url = S_URL;
    $signMsg = "charset=UTF-8&exts=&key=$key&merchantCode=$merchantcode&paymentCurrency=CNY&requestTime=$requestTime&signType=MD5&url=$url&version=1.0";
    $signMsg=strtoupper(md5($signMsg));

    $post_data['merchantCode'] = $merchantcode;
    $post_data['charset'] = 'UTF-8';
    $post_data['version'] = '1.0';
    $post_data['requestTime'] = $requestTime; //请求时间
    $post_data['exts'] = '';
    $post_data['signType'] = 'MD5';
    $post_data['signMsg'] = $signMsg;
    $post_data['paymentCurrency'] = 'CNY';
    $post_data['orderId'] = $order_sn;
    $post_data['notifyUrl'] = N_URL;//异步回调地址
    $post_data['goodsTotalAmount'] = $total_fee;
    $post_data['goodsDetails'] = "[{'goodsName':'品材商品','details':'主营辅材主材','price':$total_fee,'goodsNumber':'1','totalAmount':$total_fee,'supplierCode':'null'}]";

    $ch = curl_init ();
    $url = C_URL;   //创建支付订单接口地址
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT,5);   //超时设置(秒) 只需要设置一个秒的数量就可以
    // post数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // post的变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    $output = json_decode(curl_exec($ch));//转成对象

    $post_data1['merchantCode'] = $merchantcode;
    $post_data1['charset'] = 'UTF-8';
    $post_data1['version'] = '1.0';
    $post_data1['requestTime'] = $requestTime;//date('y-m-d h:i:s',time()); 这个时间要和上面的时间对应
    $post_data1['exts'] = '';
    $post_data1['signType'] = 'MD5';
    $post_data1['signMsg'] = $signMsg;
    $post_data1['paymentCurrency'] = 'CNY';
    $post_data1['outMemberRegistTime'] = '20110707112233';//用户注册时间  先写死
    $post_data1['agreementNo'] = $agreementNo; //
    $post_data1['payOrderId'] = $output->payOrderId;

    $_SESSION['payOrderId'] = $output->payOrderId; //payOrderId也要保存到session中

    if(!$agreementNo || ($bankCardType == 'DR' && $agreementNo))//没有签约号 和 有签约号但支付方式是储蓄卡  都传下面的参数
    {
        $post_data1['outMemberId'] = $_SESSION['temp_buyers_id'];

        $post_data1['bankCode'] = $bankcardinfo['bank_code'];
        $post_data1['bankCardType'] = $bankCardType;//DR 借记卡(信用卡)
        $post_data1['bankCardNo'] = $bankcardinfo['bank_no'];
        $_SESSION['bank_no'] = $bankcardinfo['bank_no'];//支付成功后,把签约号保存到数据库中--需要银行卡号

        $post_data1['realName'] = $bankcardinfo['user_name'];
        $post_data1['idNo'] = $bankcardinfo['user_card_no'];
        $post_data1['idType'] = 'IC';//身份证 先写死
        $post_data1['mobile'] = $bankcardinfo['bind_mobile'];
        $post_data1['cvv2'] = $save_code;//安全码
        $post_data1['validTerm'] = $_POST['valid_time']; //有效期
    }

    $url1 = P_URL;  //支付订单接口地址
    curl_setopt($ch, CURLOPT_URL, $url1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT,5);   //超时设置(秒) 只需要设置一个秒的数量就可以
    // post数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // post的变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data1);

    $output1= json_decode(curl_exec($ch));//转成对象

    $_SESSION['requestNo'] = $output1->requestNo;//把requestNo保存到session中

    return $output1;

}

// 判断银行卡是否过期
function is_time_valid($valid_time)
{
    if($valid_time)
    {
        $res1 = explode('/',$valid_time);
        $valid_time = $res1[1].$res1[0];//有效时间

        $res2 = explode('-',date('y-m-d',time()));
        $now_time = $res2[0].$res2[1];//当前时间 2015/12/24==>1512
        if($valid_time < $now_time)
        {
            $response = array("success"=>"false","error"=>array('msg'=>'该银行卡已过有效使用期','code'=>4149));
            $response = ch_json_encode($response);
            exit($response);
        }
    }
}

//curl 确认支付 post请求
function curlBankConfirmPost($code)
{
    $requestTime = $_SESSION['requestTime'];
    $requestNo = $_SESSION['requestNo'];
    $payOrderId = $_SESSION['payOrderId'];

    $key = KEY;
    $merchantcode = MerchantCode;
    $url = S_URL;
    $signMsg = "charset=UTF-8&exts=&key=$key&merchantCode=$merchantcode&paymentCurrency=CNY&requestTime=$requestTime&signType=MD5&url=$url&version=1.0";
    $signMsg = strtoupper(md5($signMsg));

    $post_data['merchantCode'] = $merchantcode;
    $post_data['charset'] = 'UTF-8';
    $post_data['version'] = '1.0';
    $post_data['requestTime'] = $requestTime;
    $post_data['exts'] = '';
    $post_data['signType'] = 'MD5';
    $post_data['signMsg'] = $signMsg;
    $post_data['paymentCurrency'] = 'CNY';
//        $post_data['payOrderId'] = 'TPO201512180000100002';
    $post_data['payOrderId'] = $payOrderId;
    $post_data['agreementNo'] = '';
    $post_data['requestNo'] = $requestNo;
    $post_data['outMemberId'] = $_SESSION['temp_buyers_id'];
    $post_data['code'] = $code;


    $ch = curl_init ();
    $url = CF_URL;   //确认支付
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // post数据
    curl_setopt($ch, CURLOPT_TIMEOUT,10);   //超时设置(秒) 只需要设置一个秒的数量就可以 余额不足的情况要响应好久
    curl_setopt($ch, CURLOPT_POST, 1);
    // post的变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    $output = json_decode(curl_exec($ch));//转成对象

    return $output;
}

//curl 解约绑定的银行卡
function curlDeleteBankPost($bankinfo)
{
    $key = KEY;
    $merchantcode = MerchantCode;
    $url = S_URL;
    $requestTime = requestTime();
    $signMsg = "charset=UTF-8&exts=&key=$key&merchantCode=$merchantcode&paymentCurrency=CNY&requestTime=$requestTime&signType=MD5&url=$url&version=1.0";
    $signMsg = strtoupper(md5($signMsg));

    $post_data['merchantCode'] = $merchantcode;//商户号
    $post_data['charset'] = 'UTF-8';
    $post_data['version'] = '1.0';
    $post_data['paymentCurrency'] = 'CNY';
    $post_data['requestTime'] = $requestTime;
    $post_data['exts'] = '';
    $post_data['signType'] = 'MD5';
    $post_data['signMsg'] = $signMsg;

    $post_data['outMemberId'] = $_SESSION['temp_buyers_id'];//用户编号
    $post_data['mobile'] = $bankinfo['bind_mobile'];
    $post_data['bankCardNo'] = $bankinfo['bank_no'];
    $post_data['agreementNo'] = $bankinfo['bank_sign'];

    $ch = curl_init ();
    $url = D_URL;   //
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // post数据
    curl_setopt($ch, CURLOPT_TIMEOUT,5);   //超时设置(秒) 只需要设置一个秒的数量就可以
    curl_setopt($ch, CURLOPT_POST, 1);
    // post的变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    $output = json_decode(curl_exec($ch));//转成对象

    if($output->returnCode == 'SUCCESS') return true;
    else return false;
}

//获取请求的时间
function requestTime()
{
    date_default_timezone_set("Asia/Shanghai");
    $requestTime = '20'.(date('y-m-d H:i:s',time()));
    $requestTime = preg_replace('/-| |:|/i', '',$requestTime);//过滤掉 - 空格 : 符号
    return $requestTime;
}