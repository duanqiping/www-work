<?php

/**
    找人代付 支付回调接口
 */

ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';
require_once 'config/config.php';

file_put_contents('../log.txt','-是否调用了回调接口-'.time()."\n",FILE_APPEND);

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
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
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
            file_put_contents('wxlog.txt',$msg.'--'.time()."\n",FILE_APPEND);
			return false;
		}
		//查询订单，判断订单真实性
		$result = $this->Queryorder($data["transaction_id"]);
		if(!$result){
			$msg = "订单查询失败";
            file_put_contents('wxlog.txt',$msg.'--'.time()."\n",FILE_APPEND);
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
        $total_fee = $result['cash_fee']/100;

        //付款人的user_id
        $payer_id = $result['attach'];

        $conn =  mysql_connect('localhost', DB_USER,DB_PWD);
        if(!$conn){
          $msg = "数据库连接失败";
          file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
          $this->SetReturn_code("SUCCESS");
          $this->SetReturn_msg("OK");
          $this->ReplyNotify(false);
          return;
        }
        $sql = 'set names utf8';
        mysql_query($sql);
        $db_name = DB_NAME_ECSHOP;
        $sql = "use $db_name";
        mysql_query($sql);
        $c = 'C';
        $pos = strpos($out_trade_no,$c);
        //是充值订单
        if($pos !== false)
        {
              // 查订单信息
              $sql = 'select ecs_temp_cash_order.order_status,ecs_temp_cash_order.order_id,ecs_temp_cash_order.order_amount,ecs_temp_cash_order.bonus_money,ecs_temp_cash_order.user_id,ecs_temp_buyers.temp_buyers_mobile from ecs_temp_cash_order left join ecs_temp_buyers on ecs_temp_buyers.temp_buyers_id = ecs_temp_cash_order.user_id where ecs_temp_cash_order.order_sn = \''.$out_trade_no.'\'';
              $rs = mysql_query($sql);
              if(!$rs)
              {
                   $msg = "没有查询到该订单信息";
                   file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                   $this->SetReturn_code("SUCCESS");
                   $this->SetReturn_msg("OK");
                   $this->ReplyNotify(false);
                   return;
              }
              $firstRow = mysql_fetch_assoc($rs);
              if($firstRow['order_status'] != 0 ){//0待支付
                    $msg = "该订单信息不是待支付";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }

              //判断买家有没有账户
              $sql = 'select count(*) from ecs_temp_account where temp_buyers_id ='.$firstRow['user_id'];
              $rs = mysql_query($sql);
              if(!$rs){
                    $msg = "买家没有账户";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
              }
              $account_row = mysql_fetch_row($rs);
              if($account_row[0] <= 0 ){//没有账户
                 $sqlaccount = 'INSERT INTO ecs_temp_account (temp_buyers_id,total,withdraw) VALUES('.$firstRow['user_id'].',0.00,0.00)';
                 $res = mysql_query($sqlaccount);
                 if(!$res){
                    $msg = "买家创建账户失败";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                 }
                 if(mysql_insert_id() <= 0){
                        $msg = "买家创建账户失败1";
                        file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                        $this->SetReturn_code("SUCCESS");
                        $this->SetReturn_msg("OK");
                        $this->ReplyNotify(false);
                        return;
                    }

              }
              //查此订单有没有在payment数据库插入过数据
              $sql = 'select count(*) from ecs_temp_payment where type = 0 and temp_purchase_sn =\''.$out_trade_no.'\'';
              $rs = mysql_query($sql);
              if(!$rs)
              {
                    $msg = "没有网payment表插入过数据";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
              }
              $paymentrow = mysql_fetch_row($rs);
              if($paymentrow[0] >0 ){
                    $msg = "没有网payment表插入过数据1";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
              }

              function get_cash_sn(){
                  $sn = date('ymdHis').str_pad($firstRow['user_id'],6,"0",STR_PAD_LEFT).substr(microtime(),2,4);
                  return $sn;
              }
              //修改订单状态为支付成功1
              $sql = 'update ecs_temp_cash_order set pay_method = 6,order_status = 1 where order_sn = \''.$out_trade_no.'\'';

              if(!mysql_query($sql)){
                    $msg = "订单状态和支付方式更新失败";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
              }

              if(mysql_affected_rows()<=0)
              {
                    $msg = "影响的行数小于1";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.time()."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
              }
              //开始事务
              mysql_query("START TRANSACTION");
              //payment 加 一条type=0的数据
              $sql = 'insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\''.$out_trade_no.'\',\''.time().'\',\''.$firstRow['temp_buyers_mobile'].'\',\'品材网支付\',\''.$buyer_email.'\',\'hbz@pcw268.com\',0,0,\''.$firstRow['user_id'].'\',\''.$total_fee.'\',1)';

              if($firstRow['bonus_money'] > 0){//有红包

                  //红包亏损
                  $sql1 = 'insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\''.$out_trade_no.'\',\''.time().'\',\''.$firstRow['temp_buyers_mobile'].'\',\'品材网支付\',\''.$buyer_email.'\',\'hbz@pcw268.com\',0,10,\''.$firstRow['user_id'].'\',\''.$firstRow['bonus_money'].'\',1)';
                  //给充值人加上订单钱和红包
                  $sql2 = 'update ecs_temp_account set total = total + '.$total_fee.'+'.$firstRow['bonus_money'].',bonus_money = bonus_money+'.$firstRow['bonus_money'].' where temp_buyers_id ='.$firstRow['user_id'];
                  //给用户在红包表增加一条记录
                  $sql3 = 'insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,state,cash_time,purchase_id,cash_money,order_id) values (1,\''.get_cash_sn().'\','.$firstRow['user_id'].',0,'.time().',0,'.$firstRow['bonus_money'].','.$firstRow['order_id'].')';
                  $res = mysql_query($sql);
                  $rc = mysql_insert_id();

                  $res1 = mysql_query($sql1);
                  $rc1 = mysql_affected_rows();

                  $res2 = mysql_query($sql2);
                  $rc2 = mysql_affected_rows();

                  $res3 = mysql_query($sql3);
                  $rc3 = mysql_affected_rows();
                  if($rc && $rc1 && $rc2 && $rc3){
                    mysql_query("COMMIT");
                  }else{
                     mysql_query("ROLLBACK");
                  }
            }
            else{//无红包
                //给充值人加上订单钱
                $sql1 = 'update ecs_temp_account set total = total + '.$total_fee.' where temp_buyers_id ='.$firstRow['user_id'];
                 $res = mysql_query($sql);
                 $rc = mysql_insert_id();


                 $res1 = mysql_query($sql1);
                 $rc1 = mysql_affected_rows();

                 if($rc && $rc1 ){
                    mysql_query("COMMIT");

                 }else{
                     mysql_query("ROLLBACK");

                 }

            }



            mysql_query("END");


          }
        else
        {
            //判断此订单状态是否为1；
            $sql = 'select state from ecs_temp_purchase where temp_purchase_sn = \''.$out_trade_no.'\'';
            $rs = mysql_query($sql);
            if(!$rs){
                    $msg = "没有查询到该订单信息";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
            }
            $row = mysql_fetch_row($rs);
            if($row[0] != 1 ){
                $msg = "订单状态不是1";
                file_put_contents('pay_exception.log.txt',$payer_id.'--'.$buyer_email.'--'.$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
                //发短信通知卖家发货
//                include('../../include/lib_base.php');
                $message = "订单号:".$out_trade_no."付款人:".$payer_id."微信银行账号:".$buyer_email."金额:".$total_fee."支付发生异常,请及时处理";
                $mobile = '15189345238';//'15189345238';//沈鹏
                sendmessage($mobile,$message);

                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }

            //查订单信息
            $sql = 'select ecs_temp_purchase.temp_purchase_id,ecs_temp_purchase.account_money,ecs_temp_purchase.money,ecs_temp_purchase.suppliers_id,ecs_temp_purchase.buyers_id,ecs_temp_buyers.temp_buyers_mobile from ecs_temp_purchase left join ecs_temp_buyers on ecs_temp_buyers.temp_buyers_id = ecs_temp_purchase.suppliers_id where ecs_temp_purchase.temp_purchase_sn = \''.$out_trade_no.'\'';
            $rs = mysql_query($sql,$conn);
            if(!$rs){
                $msg = "没有查询到该订单信息3";
                file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $firstRow = mysql_fetch_assoc($rs);
            if(!$firstRow){
                 $msg = "没有查询到该订单信息4";
                 file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
             }
            //判断卖家有没有账户
            $sql = 'select count(*) from ecs_temp_account where temp_buyers_id ='.$firstRow['suppliers_id'];
            $rs = mysql_query($sql);
            if(!$rs){
                $msg = "卖家没有账户3";
                file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            $row = mysql_fetch_row($rs);
            if($row[0] <= 0 ){//没有账户
                $sqlaccount = 'INSERT INTO ecs_temp_account (temp_buyers_id,total,withdraw) VALUES('.$firstRow['suppliers_id'].',0.00,0.00)';
                $res = mysql_query($sqlaccount);
                if(!$res){
                    $msg = "卖家没有账户4";
                    file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }
                if(mysql_insert_id() <= 0){
                    $this->SetReturn_code("SUCCESS");
                    $this->SetReturn_msg("OK");
                    $this->ReplyNotify(false);
                    return;
                }

            }
            //测试环境注释掉，上线环境还原
            //判断支付宝支付钱+余额支付的钱是否与订单钱相等
            if(($total_fee+$firstRow['account_money']) < $firstRow['money']){
                //把支付宝支付的钱加在account_money里
                $sql = 'update ecs_temp_purchase set account_money = account_money + '.$total_fee.' where temp_purchase_sn =\''.$out_trade_no.'\'';
                if(!mysql_query($sql)){
                      $msg = "把支付宝支付的钱加在account_money里失败";
                      file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
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

            //修改订单状态为支付成功2
            if($firstRow['buyers_id'] == $payer_id) /** 自己付的款(非代付), 把payer_id置为1*/
            {
                $sql = "update ecs_temp_purchase set method = 6,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=".time().",payer_id='-1' where temp_purchase_sn = '$out_trade_no'";
            }else
            {
                $sql = "update ecs_temp_purchase set method = 6,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=".time()." where temp_purchase_sn = '$out_trade_no'";
            }

            if(!mysql_query($sql)){
              $msg = "订单状态更新失败3";
              file_put_contents('wxlog.txt',$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);
              $this->SetReturn_code("SUCCESS");
              $this->SetReturn_msg("OK");
              $this->ReplyNotify(false);
              return;
            }

            if(mysql_affected_rows()<=0){
                $this->SetReturn_code("SUCCESS");
                $this->SetReturn_msg("OK");
                $this->ReplyNotify(false);
                return;
            }
            //从3月15日到3月20日。(首单优惠政策)(7,8,218,4004)
            if($firstRow['suppliers_id'] == 1024)
            {
                $sql_invitation = "select invitation_person from ecs_temp_buyers where temp_buyers_id=".$firstRow['buyers_id'];
                $res_invitation = mysql_fetch_assoc(mysql_query($sql_invitation,$conn));
//                $sql2 = "select invitation_person from ecs_temp_buyers where temp_buyers_id=".$firstRow['buyers_id'];
                $sql2 = "select temp_buyers_permission_id from ecs_temp_buyers_permission  where permission_id=2 and area_id=1 and temp_buyers_id=".$res_invitation['invitation_person'];
                $res_permission = mysql_fetch_assoc(mysql_query($sql2,$conn));//判断是否是优惠的人

                $sql3 = "select count(*) as count from ecs_temp_purchase where state in(2,3,4,5,6,7) and buyers_id=".$firstRow['buyers_id'];
                $rs = mysql_query($sql3,$conn);
                $arr = mysql_fetch_assoc($rs);

                if($arr['count']<=1)
                {
                    $sqlpurchase = "update ecs_temp_purchase set is_first=1 where temp_purchase_id=".$firstRow['temp_purchase_id'];
                    mysql_query($sqlpurchase);//更新is_first字段

                    if(time()> strtotime(date('2016-05-02 00:00:00')) && time()< strtotime(date('2016-05-30 23:59:59')) && $res_permission )
                    {

                        $sql_goods = "select sum(pg.amount*pg.price) as money from ecs_temp_purchase_goods pg LEFT JOIN ecs_goods g on pg.goods_id = g.goods_id WHERE (g.hotbrand_id=328 or g.hotbrand_id=329) AND pg.temp_purchase_id=".$firstRow['temp_purchase_id'];
                        $rs_goods = mysql_query($sql_goods);
                        $res_goods = mysql_fetch_assoc($rs_goods);
                        $money = $res_goods['money'];

                        if($money > 0)
                        {
                            date_default_timezone_set('prc');
                            $time = time();
//                            $cash_money = $firstRow['money']*(0.1)<=500?$firstRow['money']*(0.1):500;//首次下单
                            $cash_money = $money*(0.1)<=500?$money*(0.1):500;//首次下单

                            $user_id = $firstRow['buyers_id'];
                            $current_date = date('ymdHis',$time);
                            $cash_sn=$current_date.substr(microtime(),2,4).rand(100000,999999);
                            $sqlinscash = "insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,cash_time,purchase_id,cash_money) values ('7','$cash_sn','$user_id','$time','{$firstRow['temp_purchase_id']}','$cash_money')";
                            $sqlaccount = "update ecs_temp_account set total=total+'$cash_money' WHERE temp_buyers_id='$user_id'";

                            mysql_query("START TRANSACTION");
                            $b1 = mysql_query($sqlinscash);
                            $b2 = mysql_query($sqlaccount);
                            if(!$b1 || !$b2)
                            {
                                file_put_contents('alilog.txt',$trade_no.'--'.$out_trade_no.'--首次下单红包返回失败--'.$time."\n",FILE_APPEND);
                                mysql_query("ROLLBACK");
                            }else{
                                mysql_query("COMMIT");
                            }
                            mysql_query("END");
                        }

                    }
                }
            }

            //订单支付完成,判断是否给下单返现红包
            $sql_order = "select area_id from ecs_temp_purchase_goods WHERE temp_purchase_id='{$firstRow['temp_purchase_id']}'";
            $rs = mysql_query($sql_order);
            $res = mysql_fetch_row($rs);
            $area_id = $res[0];
            date_default_timezone_set('prc');
            $time = time();
            $sqlbonus="select cash_back,bonus_id from ecs_temp_bonus where bonus_status=0 AND goods_area_id='$area_id' and send_type=3 AND min_money<='{$firstRow['money']}' and use_start_date<='$time' and use_end_date>='$time'";
            $rs = mysql_query($sqlbonus,$conn);
            if($result = mysql_fetch_assoc($rs))
            {
                $cash_money = $firstRow['money']*$result['cash_back'];//红包金额
                $user_id = $firstRow['buyers_id'];
                $current_date = date('ymdHis',$time);
                $cash_sn=$current_date.substr(microtime(),2,4).rand(100000,999999);

                $sqlinscash="insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,cash_time,purchase_id,cash_money) values ('{$result['bonus_id']}','$cash_sn','$user_id','$time','{$firstRow['temp_purchase_id']}','$cash_money')";
                $sqlaccount = "update ecs_temp_account set total=total+'$cash_money' WHERE temp_buyers_id='$user_id'";
                mysql_query("START TRANSACTION");
                $b1 = mysql_query($sqlinscash);
                $b2 = mysql_query($sqlaccount);
                if(!$b1 || !$b2)
                {
                    mysql_query("ROLLBACK");
                }else{
                    mysql_query("COMMIT");
                }
                mysql_query("END");
            }

            //在payment加上此收入，同时在count里加入缓存 在acount插入一条数据
            mysql_query("START TRANSACTION");
            $sql = 'insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values (\''.$out_trade_no.'\',\''.time().'\',\''.$firstRow['temp_buyers_mobile'].'\',\'品材网支付\',\''.$buyer_email.'\',\'hbz@pcw268.com\',0,0,\''.$firstRow['suppliers_id'].'\',\''.$total_fee.'\',1)';
            $sql2 = 'update ecs_temp_account set withdraw = withdraw + '.$total_fee.'+'.$firstRow['account_money'].' where temp_buyers_id ='.$firstRow['suppliers_id'];

            $res = mysql_query($sql);
            $rc = mysql_insert_id();

            $res1 = mysql_query($sql2);
            $rc1 = mysql_affected_rows();
            if($rc && $rc1 ){
                mysql_query("COMMIT");
            }else{
             mysql_query("ROLLBACK");
            }
            mysql_query("END");
            //发短信通知卖家发货

            $msg = "支付成功";
            file_put_contents('wxlog.txt',$payer_id.'--'.$trade_no.'--'.$out_trade_no.'--'.$msg.'--'.$time."\n",FILE_APPEND);

            include('../../include/lib_base.php');
            $message = "买家支付成功订单（".$out_trade_no."），请尽快发货给买家。";
            $mobile = $firstRow['temp_buyers_mobile'];
//            $mobile = '18621715257';
            sendmessage($mobile,$message);
        }

        //结束
		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);


