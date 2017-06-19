<?php

/**
    B2B 微信支付回调接口
 */

ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

require_once 'config/config.php';

//初始化日志
$logHandler = new CLogFileHandler("../logs/" . date('Y-m-d') . '.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS"
        ) {
            return $result;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            file_put_contents('wxlog.txt', $msg . '--' . time() . "\n", FILE_APPEND);
            return false;
        }
        //查询订单，判断订单真实性
        $result = $this->Queryorder($data["transaction_id"]);
        if (!$result) {
            $msg = "订单查询失败";
            file_put_contents('wxlog.txt', $msg . '--' . time() . "\n", FILE_APPEND);
            return false;
        }
        //写代码
        Log::DEBUG("########:" . json_encode($result));

        $time = date('Y-m-d H:i:s');//日志 时间

        $sn = $result['out_trade_no'];//$out_trade_no = $result['out_trade_no'];
        $out_trade_nos = explode("-", $sn);
        $out_trade_no = $out_trade_nos[0]; //商户订单号

        //微信交易号
        $trade_no = $result['transaction_id'];

        //买家交易银行
        $buyer_email = $result['bank_type'];

        //交易总金额
        $total_fee = $result['cash_fee'] / 100;

        //付款人的user_id
        $open_id = $result['attach'];

        $conn =  mysql_connect('localhost', DB_USER,DB_PWD);
        if (!$conn) {
            $msg = "数据库连接失败";
            file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
            $this->SetReturn_code("SUCCESS");
            $this->SetReturn_msg("OK");
            $this->ReplyNotify(false);
            return;
        }
        $sql = 'set names utf8';
        mysql_query($sql);
        $sql = 'use pcwb2bs';
        mysql_query($sql);
        $c = 'C';
        $pos = strpos($out_trade_no, $c);
        //是充值订单
        if ($pos !== false) {
            // 查订单信息
            $sql = 'select ecs_temp_cash_order.order_status,ecs_temp_cash_order.order_id,ecs_temp_cash_order.order_amount,ecs_temp_cash_order.bonus_money,ecs_temp_cash_order.user_id,ecs_temp_buyers.temp_buyers_mobile from ecs_temp_cash_order left join ecs_temp_buyers on ecs_temp_buyers.temp_buyers_id = ecs_temp_cash_order.user_id where ecs_temp_cash_order.order_sn = \'' . $out_trade_no . '\'';
            $rs = mysql_query($sql);
            if (!$rs) {
                $msg = "没有查询到该订单信息";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $firstRow = mysql_fetch_assoc($rs);
            if ($firstRow['order_status'] != 0) {//0待支付
                $msg = "该订单信息不是待支付";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }

            //判断买家有没有账户
            $sql = 'select count(*) from b2b_pcy_account where temp_buyers_id =' . $firstRow['user_id'];
            $rs = mysql_query($sql);
            if (!$rs) {
                $msg = "买家没有账户";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $account_row = mysql_fetch_row($rs);
            if ($account_row[0] <= 0) {//没有账户
                $sqlaccount = 'INSERT INTO b2b_pcy_account (temp_buyers_id,total,withdraw) VALUES(' . $firstRow['user_id'] . ',0.00,0.00)';
                $res = mysql_query($sqlaccount);
                if (!$res) {
                    $msg = "买家创建账户失败";
                    file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }
                if (mysql_insert_id() <= 0) {
                    $msg = "买家创建账户失败1";
                    file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }

            }
            //查此订单有没有在payment数据库插入过数据
            $sql = 'select count(*) from b2b_pcy_payment where type = 0 and temp_purchase_sn =\'' . $out_trade_no . '\'';
            $rs = mysql_query($sql);
            if (!$rs) {
                $msg = "没有网payment表插入过数据";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $paymentrow = mysql_fetch_row($rs);
            if ($paymentrow[0] > 0) {
                $msg = "没有网payment表插入过数据1";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }

            function get_cash_sn()
            {
                $sn = date('ymdHis') . str_pad($firstRow['user_id'], 6, "0", STR_PAD_LEFT) . substr(microtime(), 2, 4);
                return $sn;
            }

            //修改订单状态为支付成功1
            $sql = 'update ecs_temp_cash_order set pay_method = 6,order_status = 1 where order_sn = \'' . $out_trade_no . '\'';

            if (!mysql_query($sql)) {
                $msg = "订单状态和支付方式更新失败";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }

            if (mysql_affected_rows() <= 0) {
                $msg = "影响的行数小于1";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . time() . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            //开始事务
            mysql_query("START TRANSACTION");
            //payment 加 一条type=0的数据
            $sql = 'insert into b2b_pcy_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\'' . $out_trade_no . '\',\'' . time() . '\',\'' . $firstRow['temp_buyers_mobile'] . '\',\'品材网支付\',\'' . $buyer_email . '\',\'hbz@pcw268.com\',0,0,\'' . $firstRow['user_id'] . '\',\'' . $total_fee . '\',1)';

            if ($firstRow['bonus_money'] > 0) {//有红包

                //红包亏损
                $sql1 = 'insert into b2b_pcy_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\'' . $out_trade_no . '\',\'' . time() . '\',\'' . $firstRow['temp_buyers_mobile'] . '\',\'品材网支付\',\'' . $buyer_email . '\',\'hbz@pcw268.com\',0,10,\'' . $firstRow['user_id'] . '\',\'' . $firstRow['bonus_money'] . '\',1)';
                //给充值人加上订单钱和红包
                $sql2 = 'update b2b_pcy_account set total = total + ' . $total_fee . '+' . $firstRow['bonus_money'] . ',bonus_money = bonus_money+' . $firstRow['bonus_money'] . ' where temp_buyers_id =' . $firstRow['user_id'];
                //给用户在红包表增加一条记录
                $sql3 = 'insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,state,cash_time,purchase_id,cash_money,order_id) values (1,\'' . get_cash_sn() . '\',' . $firstRow['user_id'] . ',0,' . time() . ',0,' . $firstRow['bonus_money'] . ',' . $firstRow['order_id'] . ')';
                $res = mysql_query($sql);
                $rc = mysql_insert_id();

                $res1 = mysql_query($sql1);
                $rc1 = mysql_affected_rows();

                $res2 = mysql_query($sql2);
                $rc2 = mysql_affected_rows();

                $res3 = mysql_query($sql3);
                $rc3 = mysql_affected_rows();
                if ($rc && $rc1 && $rc2 && $rc3) {
                    mysql_query("COMMIT");
                } else {
                    mysql_query("ROLLBACK");
                }
            } else {//无红包
                //给充值人加上订单钱
                $sql1 = 'update b2b_pcy_account set total = total + ' . $total_fee . ' where temp_buyers_id =' . $firstRow['user_id'];
                $res = mysql_query($sql);
                $rc = mysql_insert_id();


                $res1 = mysql_query($sql1);
                $rc1 = mysql_affected_rows();

                if ($rc && $rc1) {
                    mysql_query("COMMIT");

                } else {
                    mysql_query("ROLLBACK");

                }

            }


            mysql_query("END");


        }
        else {
            //判断此订单状态是否为1；
            $sql = 'select state from b2b_pcy_purchase where temp_purchase_sn = \'' . $out_trade_no . '\'';
            $rs = mysql_query($sql);
            if (!$rs) {
                $msg = "没有查询到该订单信息";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $row = mysql_fetch_row($rs);
            if ($row[0] != 1) {
                $msg = "订单状态不是1";
                file_put_contents('pay_exception.log.txt', '--' . $buyer_email . '--' . $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                $message = "订单号:" . $out_trade_no . "付款人:" . "微信银行账号:" . $buyer_email . "金额:" . $total_fee . "支付发生异常,请及时处理";
                $mobile = '15189345238';//'15189345238';//沈鹏
                sendmessage($mobile, $message);

                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }

            //查订单信息  不在同一个数据库，不能用join查询
            $sql = 'select b2b_pcy_purchase.temp_purchase_id,b2b_pcy_purchase.account_money,b2b_pcy_purchase.money,b2b_pcy_purchase.suppliers_id,b2b_pcy_purchase.buyers_id from b2b_pcy_purchase  where b2b_pcy_purchase.temp_purchase_sn = \'' . $out_trade_no . '\'';
            $rs = mysql_query($sql, $conn);
            if (!$rs) {
                $msg = "没有查询到该订单信息3";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $firstRow = mysql_fetch_assoc($rs);
            $sql_mobile = 'select temp_buyers_mobile from ecshop.ecs_temp_buyers where temp_buyers_id='.$firstRow['buyers_id'];
            $res = mysql_fetch_assoc(mysql_query($sql_mobile,$conn));

            $firstRow['temp_buyers_mobile'] = $res['temp_buyers_mobile'];//取出买家的mobile

            if (!$firstRow) {
                $msg = "没有查询到该订单信息4";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            //判断卖家有没有账户
            $sql = 'select count(*) from b2b_pcy_account where suppliers_id =' . $firstRow['suppliers_id'];
            $rs = mysql_query($sql);
            if (!$rs) {
                $msg = "卖家没有账户3";
                file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $row = mysql_fetch_row($rs);
            if ($row[0] <= 0) {//没有账户
                $sqlaccount = 'INSERT INTO b2b_pcy_account (suppliers_id,total,withdraw) VALUES(' . $firstRow['suppliers_id'] . ',0.00,0.00)';
                $res = mysql_query($sqlaccount);
                if (!$res) {
                    $msg = "卖家没有账户4";
                    file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }
                if (mysql_insert_id() <= 0) {
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }

            }
            //测试环境注释掉，上线环境还原
            //判断支付宝支付钱+余额支付的钱是否与订单钱相等
            if (($total_fee + $firstRow['account_money']) < $firstRow['money']) {
                //把支付宝支付的钱加在account_money里
                $sql = 'update b2b_pcy_purchase set account_money = account_money + ' . $total_fee . ' where temp_purchase_sn =\'' . $out_trade_no . '\'';
                if (!mysql_query($sql)) {
                    $msg = "把支付宝支付的钱加在account_money里失败";
                    file_put_contents('wxlog.txt', $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            //查看红包比例
            $time = time();
            $sql = "select cash_back from b2b_pcy_temp_bonus WHERE bonus_id=1 AND send_type=0 AND use_end_date>'$time'";
            $rs_cash = mysql_query($sql);
            $res_cash = mysql_fetch_assoc($rs_cash);

            //修改订单状态为支付成功2
            $sql = "update b2b_pcy_purchase set money='$total_fee',weixinid='$open_id',share_is_gen=1,payer_id='-2', method = 6,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=" . time() . " where temp_purchase_sn = '$out_trade_no'";

            //同时更新订单商品表的price
            $b = true;
            if($res_cash)
            {
                $sql_u = "update b2b_pcy_purchase_goods set price=price*(1+'{$res_cash['cash_back']}') WHERE temp_purchase_id='{$firstRow['temp_purchase_id']}'";
                $b = mysql_query($sql_u);
            }


            if (!mysql_query($sql) && !$b ) {
                $msg = "订单状态更新失败3";
                file_put_contents('wxlog.txt', $msg . "\n", FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }

            if (mysql_affected_rows() <= 0) {
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }

            //在payment加上此收入，同时在count里加入缓存 在acount插入一条数据
            mysql_query("START TRANSACTION");
            $sql = "insert into b2b_pcy_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,suppliers_id,money,client_from) values ('$out_trade_no',". time() .", '{$firstRow['temp_buyers_mobile']}' ,'品材网支付', '$buyer_email','hbz@pcw268.com',0,0,'{$firstRow['buyers_id']}', '{$firstRow['suppliers_id']}', '$total_fee',1)";
            $sql2 = 'update b2b_pcy_account set withdraw = withdraw + ' . $total_fee . '+' . $firstRow['account_money'] . ' where suppliers_id =' . $firstRow['suppliers_id'];

            $res = mysql_query($sql);
            $rc = mysql_insert_id();

            $res1 = mysql_query($sql2);
            $rc1 = mysql_affected_rows();
            if ($rc && $rc1) {
                mysql_query("COMMIT");
            } else {
                mysql_query("ROLLBACK");
            }
            mysql_query("END");
            //发短信通知卖家发货

            $msg = "支付成功";
            file_put_contents('wxlog.txt', $payer_id . '--' . $trade_no . '--' . $out_trade_no . '--' . $msg . '--' . $time . "\n", FILE_APPEND);

            include('../../include/lib_base.php');
            $message = "买家支付成功订单（" . $out_trade_no . "），请尽快发货给买家。";
            $mobile = $firstRow['temp_buyers_mobile'];
            sendmessage($mobile, $message);
        }

        //结束
        return true;
    }
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);


