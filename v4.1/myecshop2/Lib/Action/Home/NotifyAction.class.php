<?php

/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/4/7
 * Time: 10:03
 * 支付宝回调接口、微信生成支付订单接口、微信支付回调接口
 */
class NotifyAction extends Action
{
    /** 预支付订单 返回签名*/
    public function alisign()
    {
        vendor('AliPay.Corefunction');
        vendor('AliPay.Notify');
        vendor('AliPay.Rsafunction');

        $order_sn = $_POST['temp_purchase_sn'];
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;//供应商的id号

        checkPostData(!$order_sn, '订单号有误', '12356');
        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);

        $c = 'C';
        $pos = strpos($order_sn, $c);
        if($pos !== false)
        {
            $cashorder = new TempCashOrderModel();
            $cashorder->is_login();
            $res = $cashorder->getSingleInfo(array('order_sn' => $order_sn), 'order_sn,user_id,order_amount');
            $total_fee = $res['order_amount'];
            $buyers_id = $res['user_id'];
            $order_sn = $res['order_sn'];
            $subject = '支付宝充值';
        }
        else
        {
            $puchase = new TempPurchaseModel($database_type);
            $puchase->is_login();
            $res = $puchase->getSingleInfo(array('temp_purchase_sn' => $order_sn), 'temp_purchase_sn,buyers_id,money,account_money,state');
            if($res['state'] != 1) $puchase->printError('订单不是待支付的订单','4890');

            $total_fee = round($res['money']-$res['account_money'],2);
            $buyers_id = $res['buyers_id'];
            $order_sn = $res['temp_purchase_sn'];
            $subject = '支付宝支付';
        }
        if($database_type == 1) $notify_url = DROOT.'/home/notify/ali';//找材猫
        else $notify_url = PCROOT.'/AskPriceApi/pay_mob/notify_url.php';//品材宝

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

        $response = array('success' => 'true', 'data' => $orderInfor);
        $response = json_encode($response);
        exit($response);
    }

    public function test()
    {
        vendor('AliPay.Corefunction');
        vendor('AliPay.Notify');
        vendor('AliPay.Rsafunction');

        $alipay_config = C('alipay_config');
//        var_dump($alipay_config);
//        $sign = 'pDLGAL/XeCUlFcZsIg04Ok5A/2ICFsIpUevmGQ6pRMjfixh8at2FyTiDtfte/s3oCYLE3DfNXJvJayMy1pU4tPXjWG4YvsMjRXDNw6nND5Z3hVltOC+z9aXVmApU0p1WVygkLIMVFA/xzNl2m6i36+E4/UrtrpCxC1QSB+xl/Js=';

        $data = 'sfjaspodjf';
//        $data1 = 'nuCMIUjKM4xwIlgO%2BaOQPEF0PNskoxNdCCRKUtZEUxuo1Oz43LJVOfyKYkJV2TPRZAzj4XmfKdD4bFPp7CD1S9cGbX8eCqZZK01a%2FfFy2n50Jzi90NoMzk0NXOJSIiMZtURQakDvMSRlJ2z2UvIb42z%2FuTpGDbF%2FkydegWT6WxA%3D';
        $sign = rsaSign($data,$alipay_config['private_key_path']);

        $res = rsaVerify($data, $alipay_config['ali_public_key_path2'],$sign);
        var_dump($res);
        exit();
    }

    /** 支付宝回调接口*/
    public function ali()
    {
        //支付宝
        vendor('AliPay.Corefunction');
        vendor('AliPay.Notify');
        vendor('AliPay.Rsafunction');

        //计算得出通知验证结果:
        $alipay_config = C('alipay_config');
        $alipayNotify = new AlipayNotify($alipay_config);//计算得出通知验证结果

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

            if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //该种交易状态只在两种情况下出现
                //1、开通了普通即时到账，买家付款成功后。
                //2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

                $c = 'C';
                $pos = strpos($out_trade_no, $c);

                //是充值订单
                if ($pos !== false) {

                    $tempcash = new TempCashOrderModel();

                    // 查订单信息
                    $firstRow = $tempcash->getSingleInfo(array('order_sn' => $out_trade_no), 'order_status,order_id,order_amount,bonus_money,user_id');

                    if ($firstRow['order_status'] != 0) {//0待支付
                        file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--充值订单不是待支付--' . $time . "\n", FILE_APPEND);
                        echo "success";
                        return false;
                    }

                    //判断买家有没有账户
                    $sql = 'select count(*) as num from ecs_temp_account where temp_buyers_id =' . $firstRow['user_id'];
                    $res_num = $tempcash->query($sql);

                    if ($res_num[0]['num'] <= 0) {//没有账户
                        $sqlaccount = 'INSERT INTO ecs_temp_account (temp_buyers_id,total,withdraw) VALUES(' . $firstRow['user_id'] . ',0.00,0.00)';
                        $res = $tempcash->execute($sqlaccount);
                        if (!$res) {
                            file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--买家家账户创建失败--' . $time . "\n", FILE_APPEND);
                            echo "success";
                            return false;
                        }
                    }
                    //查此订单有没有在payment数据库插入过数据
                    $sql = 'select count(*) as num from ecs_temp_payment where type = 0 and temp_purchase_sn =\'' . $out_trade_no . '\'';
                    $res_num = $tempcash->query($sql);
                    if ($res_num[0]['num'] > 0) {
                        file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--订单有没有在payment数据库插入过数据--' . $time . "\n", FILE_APPEND);
                        echo "success";
                        return false;
                    }

                    //修改订单状态为支付成功1
                    $sql = "update ecs_temp_cash_order set pay_method = 0,order_status = 1 where order_sn = '$out_trade_no'";
                    if (!$tempcash->execute($sql)) {
                        file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--充值订单状态更新失败--' . $time . "\n", FILE_APPEND);
                        echo "success";
                        return false;
                    }

                    //开始事务
                    $tempcash->startTrans();
                    //payment 加 一条type=0的数据
                    $sql = 'insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\'' . $out_trade_no . '\',\'' . time() . '\',\'' . $firstRow['temp_buyers_mobile'] . '\',\'品材网支付\',\'' . $buyer_email . '\',\'hbz@pcw268.com\',0,0,\'' . $firstRow['user_id'] . '\',\'' . $total_fee . '\',1)';

                    if ($firstRow['bonus_money'] > 0) {//有红包
                        //红包亏损
                        $sql1 = 'insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\'' . $out_trade_no . '\',\'' . time() . '\',\'' . $firstRow['temp_buyers_mobile'] . '\',\'品材网支付\',\'' . $buyer_email . '\',\'hbz@pcw268.com\',0,10,\'' . $firstRow['user_id'] . '\',\'' . $firstRow['bonus_money'] . '\',1)';
                        //给充值人加上订单钱和红包
                        $sql2 = 'update ecs_temp_account set total = total + ' . $total_fee . '+' . $firstRow['bonus_money'] . ',bonus_money = bonus_money+' . $firstRow['bonus_money'] . ' where temp_buyers_id =' . $firstRow['user_id'];
                        //给用户在红包表增加一条记录
                        $sql3 = 'insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,state,cash_time,purchase_id,cash_money,order_id) values (1,\'' . get_cash_sn($firstRow['user_id']) . '\',' . $firstRow['user_id'] . ',0,' . time() . ',0,' . $firstRow['bonus_money'] . ',' . $firstRow['order_id'] . ')';

                        $rc = $tempcash->execute($sql);
                        $rc1 = $tempcash->execute($sql1);
                        $rc2 = $tempcash->execute($sql2);
                        $rc3 = $tempcash->execute($sql3);

                        if ($rc && $rc1 && $rc2 && $rc3) {
                            $tempcash->commit();
                        } else {
                            $tempcash->rollback();
                        }

                    } else {//无红包
                        //给充值人加上订单钱
                        $sql1 = 'update ecs_temp_account set total = total + ' . $total_fee . ' where temp_buyers_id =' . $firstRow['user_id'];

                        $rc = $tempcash->execute($sql);
                        $rc1 = $tempcash->execute($sql1);

                        if ($rc && $rc1) {
                            $tempcash->commit();
                        } else {
                            $tempcash->rollback();
                        }
                    }
                }
                else
                {
                    $purchase = new TempPurchaseModel(1);
                    $firstRow = $purchase->getSingleInfo(array('temp_purchase_sn' => $out_trade_no), 'temp_purchase_id,buyers_id,money,account_money,suppliers_id,state');

                    //判断此订单状态是否为1；
                    if ($firstRow['state'] != 1)
                    {
                        file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--' . '支付异常' . '--' . $time . "\n", FILE_APPEND);
                        //发短信通知卖家发货
                        $message = "订单号:" . $out_trade_no . "付款人:" . $payer_id . "支付宝账号:" . $buyer_email . "金额:" . $total_fee .' 时间'.date("Y-m-d H:i:s", $time). "支付发生异常,请及时处理";
                        $mobile = '15189345238';//'15189345238';//沈鹏
                        sendmessage($mobile, $message);
                        echo "success";
                        return false;
                    }

                    //判断卖家有没有账户
                    $sql = 'select count(*) as num from ecs_temp_account where temp_buyers_id =' . $firstRow['suppliers_id'];
                    $res_num = $purchase->query($sql);

                    if ($res_num[0]['num'] <= 0) {//没有账户
                        $sqlaccount = 'INSERT INTO ecs_temp_account (temp_buyers_id,total,withdraw) VALUES(' . $firstRow['suppliers_id'] . ',0.00,0.00)';
                        $res = $purchase->execute($sqlaccount);
                        if (!$res) {
                            $msg = "卖家账户创建失败";
                            file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                            echo "success";
                            return false;
                        }
                    }
                    //判断支付宝支付钱+余额支付的钱是否与订单钱相等
                    if (round($total_fee + $firstRow['account_money'], 2) < round($firstRow['money'], 2)) {
                        //把支付宝支付的钱加在account_money里
                        $sql = 'update ecs_temp_purchase set account_money = account_money + ' . $total_fee . ' where temp_purchase_sn =' . $out_trade_no;
                        if (!$purchase->execute($sql)) {
                            file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--宝支付钱+余额支付的钱是否与订单钱不相等--' . $time . "\n", FILE_APPEND);
                            echo "success";
                            return false;
                        }
                        echo "success";
                        return false;
                    }

                    //修改订单状态为支付成功2
                    if ($firstRow['buyers_id'] == $payer_id) {
                        //自己付的款(非代付), 把payer_id置为-1
                        $sql = "update ecs_temp_purchase set method = 0,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=" . time() . ",payer_id='-1' where temp_purchase_sn = '$out_trade_no'";
                    } else {
                        $sql = "update ecs_temp_purchase set method = 0,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=" . time() . " where temp_purchase_sn = '$out_trade_no'";
                    }

                    if (!$purchase->execute($sql)) {
                        file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $out_trade_no . '--订单状态更新失败--' . $time . "\n", FILE_APPEND);
                        echo "success";
                        return false;
                    }
                    //如果该订单是一个补货的子订单，支付完成则把父订单的replenish_state置为0
                    $purchase->updateFatherSn($firstRow['temp_purchase_id']);

                    //从3月15日到3月20日。(首单优惠政策)(7,8,218,4004)
                    $purchase->startTrans();
                    if($firstRow['suppliers_id'] == 1024) $purchase->isFirstOrder($firstRow['buyers_id'],$firstRow['temp_purchase_id'],$firstRow['money']);

                    //订单支付完成,判断是否给下单返现红包
                    $purchase->returnCashOrder($firstRow['buyers_id'],$firstRow['temp_purchase_id'],$firstRow['money']);
                    $purchase->commit();

                    //在payment加上此收入，同时在count里加入缓存 在acount插入一条数据
                    $purchase->startTrans();
                    $sql = 'insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\'' . $out_trade_no . '\',\'' . time() . '\',\'' . $firstRow['temp_buyers_mobile'] . '\',\'品材网支付\',\'' . $buyer_email . '\',\'hbz@pcw268.com\',0,0,\'' . $firstRow['suppliers_id'] . '\',\'' . $total_fee . '\',1)';
                    $sql2 = 'update ecs_temp_account set withdraw = withdraw + ' . $total_fee . '+' . $firstRow['account_money'] . ' where temp_buyers_id =' . $firstRow['suppliers_id'];

                    $rc = $purchase->execute($sql);
                    $rc1 = $purchase->execute($sql2);
                    if ($rc && $rc1) {
                        $purchase->commit();
                    } else {
                        $purchase->rollback();
                    }

                    $msg = "支付成功";
                    file_put_contents('./Runtime/Logs/pay/alilog.txt', $trade_no . '--' . $payer_id . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);

                    //发短信通知卖家发货
//                    $message = "买家支付成功订单（" . $out_trade_no . "），请尽快发货给买家。";
//                    $mobile = $firstRow['temp_buyers_mobile'];
//                    sendmessage($mobile, $message);
                }

            }

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";        //请不要修改或删除

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $d = $out_trade_no . ',' . $trade_no . ',' . $trade_status . ',' . $buyer_email;
            logResult('success:' . $d);
        } else {
            file_put_contents('./Runtime/Logs/pay/alilog.txt', '支付失败' . "\n", FILE_APPEND);
            //验证失败
            echo "fail";
            //调试用，写文本函数记录程序运行情况是否正常
            logResult('fail');
        }
    }

    /** 微信统一下单 扫码支付*/
    public function native()
    {
        vendor('WxPay.WxPayApi');//注意微信和支付宝不一样，引入的类文件名需得和类名一样
        vendor('WxPay.WxPayDataBase');
        vendor('WxPay.WxPayConfig');
        vendor('WxPay.WxPayException');

        vendor('WxPay.WxPayNativePay');

        $order_sn = isset($_POST['order_sn']) ? trim($_POST['order_sn']) : '';
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;//供应商的id号

        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        checkPostData(!$order_sn,'订单号必须存在',4800);

        $c = 'C';
        $pos = strpos($order_sn, $c);
        //充值订单
        if ($pos !== false)
        {
            $cashorderinfo = new TempCashOrderModel();

            $orderinfo = $cashorderinfo->getSingleInfo(array('order_sn' => $order_sn), 'order_amount,order_status');
            if (!$orderinfo)
            {
                $cashorderinfo->printError('无此订单信息',4800);
            }
            if ($orderinfo['order_status'] != 0)
            {
                $cashorderinfo->printError('订单状态应该为待支付',4800);
            }
            $total_fee = ($orderinfo['order_amount']) * 100;//($orderinfo['order_amount'])*100;

            $out_trade_no = $order_sn;
        }
        else
        {
            $purchase = new TempPurchaseModel($database_type);
            $orderinfo = $purchase->getSingleInfo(array('temp_purchase_sn' => $order_sn), 'temp_purchase_id,state,buyers_id,money,account_money,time,replenish_state');

//            echo $purchase->getLastSql();
//            exit();

            if (!$orderinfo)
            {
                $purchase->printError('无此订单信息',4800);
            }
            if ($orderinfo['state'] != 1) {
                $msg = $orderinfo['state'] == 0 ? '该订单已经取消' : '该订单已经付款';
                $purchase->printError($msg,4800);
            }
            $total_fee = ($orderinfo['money'] - $orderinfo['account_money']) * 100;

            if ($orderinfo['account_money'] > 0) {
                $out_trade_no = $order_sn . "-1";
            } else if ($_SESSION['temp_buyers_id'] != $orderinfo['buyers_id']) {
                //为人代支付
                $out_trade_no = $order_sn . '-' . $_SESSION['temp_buyers_id'];
            } else {
                $out_trade_no = $order_sn;
            }


            //如果是补货子订单,得设置有效期
            if($database_type == 1)
            {
                $sql = "select replenish_state from ecs_temp_purchase WHERE temp_purchase_id =  (SELECT temp_purchase_id from ecs_temp_purchase_goods_add WHERE temp_purchase_new_id ='{$orderinfo['temp_purchase_id']}' limit 1)";
                $res_r = $purchase->query($sql);
                $replenish_state = $res_r[0]['replenish_state'];

                if($replenish_state == 1)
                {
                    date_default_timezone_set('PRC');
                    $time = time();
                    $is_time = buHuoTime();//当天15:30:00

                    //当日时间已经过了15:30:00
                    if ($time > $is_time) {
                        if($orderinfo['time'] < $is_time) $purchase->printError('补货订单已经失效',4565);
                    }
                    else
                    {
                        //当日时间没过15:30:00
                        //当日时间已经没过15:30:00
                        $back_time = $is_time - 1 * 24 * 3600;
                        if ($orderinfo['time'] < $back_time)$purchase->printError('补货订单已经失效',4565);//支付时间发生在昨天15：30之前
                    }
                }
            }
        }

        $notify = new NativePay();

        $input = new WxPayUnifiedOrder();
        $body = '品材商品';
        $input->SetBody($body);
        $input->SetAttach($_SESSION['temp_buyers_id']);
//        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($total_fee);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        if($database_type == 1) $input->SetNotify_url(DROOT.'/home/notify/wx');
        else $input->SetNotify_url(DROOT.'/home/notify/pcwWx');
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");
        $result = $notify->GetPayUrl($input);

        var_dump($result);
        $url2 = $result["code_url"];

        print_r(urlencode($url2));
    }

    /** 微信生成支付订单接口*/
    public function doOrder()
    {
        vendor('WxPay.WxPayApi');//注意微信和支付宝不一样，引入的类文件名需得和类名一样
        vendor('WxPay.WxPayConfig');
        vendor('WxPay.WxPayException');
        vendor('WxPay.WxPayDataBase');
        vendor('WxPay.WxPayNotify');

        $order_sn = isset($_POST['order_sn']) ? trim($_POST['order_sn']) : '';
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;//供应商的id号

        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        checkPostData(!$order_sn,'订单号必须存在',4800);

        $c = 'C';
        $pos = strpos($order_sn, $c);
        //充值订单
        if ($pos !== false)
        {
            $cashorderinfo = new TempCashOrderModel();

            $orderinfo = $cashorderinfo->getSingleInfo(array('order_sn' => $order_sn), 'order_amount,order_status');
            if (!$orderinfo)
            {
                $cashorderinfo->printError('无此订单信息',4800);
            }
            if ($orderinfo['order_status'] != 0)
            {
                $cashorderinfo->printError('订单状态应该为待支付',4800);
            }
            $total_fee = ($orderinfo['order_amount']) * 100;//($orderinfo['order_amount'])*100;

            $out_trade_no = $order_sn;
        }
        else
        {
            $purchase = new TempPurchaseModel($database_type);
            $orderinfo = $purchase->getSingleInfo(array('temp_purchase_sn' => $order_sn), 'temp_purchase_id,state,buyers_id,money,account_money,time,replenish_state');

            if (!$orderinfo)
            {
                $purchase->printError('无此订单信息',4800);
            }
            if ($orderinfo['state'] != 1) {
                $msg = $orderinfo['state'] == 0 ? '该订单已经取消' : '该订单已经付款';
                $purchase->printError($msg,4800);
            }
            $total_fee = ($orderinfo['money'] - $orderinfo['account_money']) * 100;

            if ($orderinfo['account_money'] > 0) {
                $out_trade_no = $order_sn . "-1";
            } else if ($_SESSION['temp_buyers_id'] != $orderinfo['buyers_id']) {
                //为人代支付
                $out_trade_no = $order_sn . '-' . $_SESSION['temp_buyers_id'];
            } else {
                $out_trade_no = $order_sn;
            }


            //如果是补货子订单,得设置有效期
            if($database_type == 1)
            {
                $sql = "select replenish_state from ecs_temp_purchase WHERE temp_purchase_id =  (SELECT temp_purchase_id from ecs_temp_purchase_goods_add WHERE temp_purchase_new_id ='{$orderinfo['temp_purchase_id']}' limit 1)";
                $res_r = $purchase->query($sql);
                $replenish_state = $res_r[0]['replenish_state'];

                if($replenish_state == 1)
                {
                    date_default_timezone_set('PRC');
                    $time = time();
                    $is_time = buHuoTime();//当天15:30:00

                    //当日时间已经过了15:30:00
                    if ($time > $is_time) {
                        if($orderinfo['time'] < $is_time) $purchase->printError('补货订单已经失效',4565);
                    }
                    else
                    {
                        //当日时间没过15:30:00
                        //当日时间已经没过15:30:00
                        $back_time = $is_time - 1 * 24 * 3600;
                        if ($orderinfo['time'] < $back_time)$purchase->printError('补货订单已经失效',4565);//支付时间发生在昨天15：30之前
                    }
                }
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

        //交易有效时间
        $time_start = date('YmdHis',NOW_TIME);//交易开始时间（30分钟）
        $time_expire = date('YmdHis',NOW_TIME+30);//交易结束时间（30分钟）

        $input->SetTime_start($time_start);//交易开始时间
        $input->SetTime_expire($time_expire);//交易结束时间

        $input->SetAttach($_SESSION['temp_buyers_id']);//付款人的user_id (待付款需要这个参数)

        $input->SetTotal_fee($total_fee);
        //设置取值如下：JSAPI，NATIVE，APP，详细说明见参数规定
        $input->SetTrade_type("APP");
        //设置接收微信支付异步通知回调地址
        if($database_type == 1) $input->SetNotify_url(DROOT.'/home/notify/wx');
        else $input->SetNotify_url(DROOT.'/home/notify/pcwWx');


        $result = WxPayApi::unifiedOrder($input);

        if (!array_key_exists("trade_type", $result) || !array_key_exists("prepay_id", $result))
        {
            if ($result['err_code_des']) {
                $msg = $result['err_code_des'];
            } else {
                $msg = '下单失败';
            }
            $response = array("success" => "false", "error" => array("msg" => $msg, 'code' => 4800));
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            //返回数据给APP:trade_type,prepay_id
            $response = array('success' => 'true', 'data' => $result);
            $response = ch_json_encode($response);
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

        $notify = new PayNotifyCallBack();
        $notify->Handle(false);
    }

    /** 微信支付回调接口  品材宝*/
    public function pcwWx()
    {
        vendor('WxPay.WxPayApi');//注意微信和支付宝不一样，引入的类文件名需得和类名一样
        vendor('WxPay.WxPayConfig');
        vendor('WxPay.WxPayException');
        vendor('WxPay.WxPayDataBase');
        vendor('WxPay.WxPayNotify');

        vendor('WxPay.PcwPayNotifyCallBack');//不同

        $notify = new PcwPayNotifyCallBack();//不同
        $notify->Handle(false);
    }
}