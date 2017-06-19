<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/4/12
 * Time: 10:43
 */
class PcwPayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);

        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return $result;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        if(!array_key_exists("transaction_id", $data)){
            file_put_contents('./Runtime/Logs/pay/wxlog.txt','输入参数不正确 '.time()."\n",FILE_APPEND);
            return false;
        }
        //查询订单，判断订单真实性
        $result = $this->Queryorder($data["transaction_id"]);
        if(!$result){
            file_put_contents('./Runtime/Logs/pay/wxlog.txt','订单查询失败--'.time()."\n",FILE_APPEND);
            return false;
        }
        //写代码

        $time = date('Y-m-d H:i:s');//日志 时间

        $sn = $result['out_trade_no'];//$out_trade_no = $result['out_trade_no'];
        $out_trade_nos = explode("-", $sn);
        $out_trade_no = $out_trade_nos[0]; //商户订单号

        $trade_no = $result['transaction_id']; //微信交易号

        $buyer_email = $result['bank_type'];//买家交易银行

        $total_fee = $result['cash_fee']/100; //交易总金额

        $payer_id = $result['attach'];//付款人的user_id

        $open_id = $result['openid'];

        $c = 'C';
        $pos = strpos($out_trade_no,$c);
        //是充值订单
        if($pos !== false)
        {
            file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'充值订单'.$msg.'--'.time()."\n",FILE_APPEND);

            $tempcash = new TempCashOrderModel();

            // 查订单信息
            $firstRow = $tempcash->getSingleInfo(array('order_sn' => $out_trade_no), 'order_status,order_id,order_amount,bonus_money,user_id');

            if($firstRow['order_status'] != 0 ){//0待支付
                $msg = "该订单信息不是待支付";
                file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                return;
            }

            //判断买家有没有账户
            $sql = 'select count(*) as num from ecs_temp_account where temp_buyers_id =' . $firstRow['user_id'];
            $res_num = $tempcash->query($sql);

            if ($res_num[0]['num'] <= 0) {//没有账户
                $sqlaccount = 'INSERT INTO ecs_temp_account (temp_buyers_id,total,withdraw) VALUES(' . $firstRow['user_id'] . ',0.00,0.00)';
                $res = $tempcash->execute($sqlaccount);
                if(!$res){
                    file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'-买家创建账户失败-'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    return;
                }
            }
            //查此订单有没有在payment数据库插入过数据
            $sql = 'select count(*) as num from ecs_temp_payment where type = 0 and temp_purchase_sn =\'' . $out_trade_no . '\'';
            $res_num = $tempcash->query($sql);
            if ($res_num[0]['num'] > 0) {
                file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'-没有网payment表插入过数据1-'.time()."\n",FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                return;
            }

            //修改订单状态为支付成功1
            $sql = 'update ecs_temp_cash_order set pay_method = 6,order_status = 1 where order_sn = \'' . $out_trade_no . '\'';
            if (!$tempcash->execute($sql)) {
                file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'--订单状态和支付方式更新失败--'.time()."\n",FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                return;
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
            $purchase = new TempPurchaseModel(2);
            $firstRow = $purchase->getSingleInfo(array('temp_purchase_sn' => $out_trade_no), 'temp_purchase_id,buyers_id,money,account_money,suppliers_id,state');

            if($firstRow['state'] != 1 ){
                file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'-支付异常-'.$time."\n",FILE_APPEND);
                //发短信通知卖家发货
                $message = "订单号:".$out_trade_no."付款人:".$payer_id."微信银行账号:".$buyer_email."金额:".$total_fee."支付发生异常,请及时处理";
                $mobile = '15189345238';//'15189345238';//沈鹏
                sendmessage($mobile,$message);

                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                return;
            }

            //判断卖家有没有账户
            $sql = 'select count(*) as num from pcwb2bs.b2b_pcy_account where temp_buyers_id =' . $firstRow['suppliers_id'];
            $res_num = $purchase->query($sql);

            if($res_num[0]['num'] <= 0 ){//没有账户
                $sqlaccount = 'INSERT INTO pcwb2bs.b2b_pcy_account (temp_buyers_id,total,withdraw) VALUES(' . $firstRow['suppliers_id'] . ',0.00,0.00)';
                $res = $purchase->execute($sqlaccount);
                if(!$res){
                    file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'-卖家没有账户-'.$time."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    return;
                }
            }

            //获取供应商的手机号码
            $sql_telephone = "select telephone from pcwb2bs.b2b_user WHERE user_id='{$firstRow['suppliers_id']}'";
            $res_telephone = $purchase->query($sql_telephone);

            //测试环境注释掉，上线环境还原
            //判断支付宝支付钱+余额支付的钱是否与订单钱相等
            if (round($total_fee + $firstRow['account_money'], 2) < round($firstRow['money'], 2)) {
                //把支付宝支付的钱加在account_money里
                $sql = 'update pcwb2bs.b2b_pcy_purchase set account_money = account_money + ' . $total_fee . ' where temp_purchase_sn =\'' . $out_trade_no . '\'';
                if (!$purchase->execute($sql)) {
                    file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'-把微信支付的钱加在account_money里失败-'.$time."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    return;
                }
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                return;
            }

            //修改订单状态为支付成功2
            if($firstRow['buyers_id'] == $payer_id) /** 自己付的款(非代付), 把payer_id置为1*/
            {
                $sql = "update pcwb2bs.b2b_pcy_purchase set method = 6,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=".time().",payer_id='-1' where temp_purchase_sn = '$out_trade_no'";
            }else
            {
                $sql = "update pcwb2bs.b2b_pcy_purchase set method = 6,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=".time()." where temp_purchase_sn = '$out_trade_no'";
            }

            if (!$purchase->execute($sql)) {
                file_put_contents('./Runtime/Logs/pay/wxlog.txt',$trade_no.'--'.$out_trade_no.'-订单状态更新失败-'.$time."\n",FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                return;
            }
            //如果该订单是一个补货的子订单，支付完成则把父订单的replenish_state置为0
//            $purchase->updateFatherSn($firstRow['temp_purchase_id']);

            //对操作进行事务处理红包
//            $purchase->startTrans();
//            //从3月15日到3月20日。(首单优惠政策)(7,8,218,4004)
//            if($firstRow['suppliers_id'] == 1024) $purchase->isFirstOrder($firstRow['buyers_id'],$firstRow['temp_purchase_id'],$firstRow['money']);
//
//            //订单支付完成,判断是否给下单返现红包
//            $purchase->returnCashOrder($firstRow['buyers_id'],$firstRow['temp_purchase_id'],$firstRow['money']);
//            $purchase->commit();

            //在payment加上此收入，同时在count里加入缓存 在acount插入一条数据
            $purchase->startTrans();
            $sql = 'insert into pcwb2bs.b2b_pcy_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\'' . $out_trade_no . '\',\'' . time() . '\',\'' . $firstRow['temp_buyers_mobile'] . '\',\'品材网支付\',\'' . $open_id . '\',\'hbz@pcw268.com\',0,0,\'' . $firstRow['suppliers_id'] . '\',\'' . $total_fee . '\',1)';
            $sql2 = 'update pcwb2bs.b2b_pcy_account set withdraw = withdraw + ' . $total_fee . '+' . $firstRow['account_money'] . ' where temp_buyers_id =' . $firstRow['suppliers_id'];

            $rc = $purchase->execute($sql);
            $rc1 = $purchase->execute($sql2);
            if ($rc && $rc1) {
                $purchase->commit();
            } else {
                $purchase->rollback();
            }

            file_put_contents('./Runtime/Logs/pay/wxlog.txt', $trade_no . '--' . $payer_id . '--' . $out_trade_no . '-支付成功-' . $time . "\n", FILE_APPEND);

            //发短信通知卖家发货
            $message = "买家支付成功订单（" . $out_trade_no . "），请尽快发货给买家。";
            $mobile = $res_telephone[0]['telephone'];
            if(APP_DEBUG == false) sendmessage($mobile, $message);
        }
        //结束
        return true;
    }
}