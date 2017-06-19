<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2015/12/22
 * Time: 16:22
 */
class BankAction extends Action
{
    //快捷银行卡列表
    public function show()
    {
        $tempbankcard = new TempBankcardModel();
        $tempbankcard->is_login();

        $data = $tempbankcard -> getBankcardInfos();

        $response = array("success"=>"true","data"=>$data);
        $response = ch_json_encode($response);
        exit($response);
    }

    //添加银行卡快捷支付
    public function add()
    {
        $tempbankcard = new TempBankcardModel();
        $tempbankcard->is_login();

        $bank_no = $_POST['bank_no'];

        load("@.bankList");
        $bankList = bankList();

        $str = getBankInfos($bank_no,$bankList);//[0] => 622918  [1] => 中信银行信用卡中心(63020000)-中信银联IC卡金卡-贷记卡
        if($str == '该卡号信息暂未录入')
        {
            $response = array("success"=>"false","error"=>array("msg"=>'该银行卡暂不支持','code'=>4145));
            $response = ch_json_encode($response);
            exit($response);
        }
        $tempbankcard -> bankNumLimit();//是否超过限制  最多添加5张银行卡
        $tempbankcard -> bankNoIsExist($bank_no);//判断银行卡是否重复添加

        $arr = explode("-",$str[1]);//[0] => 中信银行信用卡中心(63020000)  [1] => 中信银联IC卡金卡  [2] => 贷记卡

        $data['bank_name'] = substr($arr[0],0,stripos($arr[0],'银行')+6);

        //判断是否支持该银行卡
        //通过bank_name取出银行机构代码和银行图标 第三方支持的银行 -->借记卡(储蓄卡)
        $data = $tempbankcard->getCodeAndIf($data['bank_name'],$arr[2]);

        $data['bank_no'] = $_POST['bank_no'];
        $data['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
        $data['card_type'] = $arr[2];

        $response = array("success"=>"true","data"=>$data);
        $response = ch_json_encode($response);
        exit($response);
    }

    //填写用户账号信息 姓名 身份证 手机号
    public function info()
    {
        //接收 银行卡号 姓名 身份证 手机号
        $account = $_POST;
        if(!$account['user_name'] || !$account['user_mobile'] || !$account['user_card'] || !$account['bank_no'])
        {
            $response = array("success"=>"false","error"=>array("msg"=>'参数不能有空','code'=>4145));
            $response = ch_json_encode($response);
            exit($response);
        }
        is_mobile_legal($account['user_mobile']);//判断手机号码是否规范
        is_card_legal($account['user_card']);//判断身份证是否规范
        is_name_legal($account['user_name']);//判断用户名是否过长

        $tempbankcard = new TempBankcardModel();
        $tempbankcard->is_login();

        //判断银行卡是否重复添加
        $tempbankcard -> bankNoIsExist($account['bank_no']);

        load("@.bankList");
        $bankList = bankList();

        $str = getBankInfos($account['bank_no'],$bankList);//[0] => 622918  [1] => 中信银行信用卡中心(63020000)-中信银联IC卡金卡-贷记卡

        if($str == '该卡号信息暂未录入')
        {
            $response = array("success"=>"false","error"=>array("msg"=>'该银行卡暂不支持','code'=>4145));
            $response = ch_json_encode($response);
            exit($response);
        }

        $arr = explode("-",$str[1]);//[0] => 中信银行信用卡中心(63020000)  [1] => 中信银联IC卡金卡  [2] => 贷记卡

        $data['bank_name'] = substr($arr[0],0,stripos($arr[0],'银行')+6);

        //通过bank_name取出银行机构代码和银行图标 第三方支持的银行 -->借记卡(储蓄卡)
        $data = $tempbankcard->getCodeAndIf($data['bank_name'],$arr[2]);

        $data['bank_no'] = $_POST['bank_no'];
        $data['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
        $data['card_type'] = $arr[2];
        $data['bind_mobile'] = $account['user_mobile'];
        $data['user_name'] = $account['user_name'];
        $data['user_card_no'] = $account['user_card'];
        $data['time'] = time();
        if(!$tempbankcard -> add($data))
        {
            $response = array("success"=>"false","error"=>array('msg'=>'开通失败','code'=>4910));
            $response = ch_json_encode($response);
            exit($response);
        }
        $response = array("success"=>"true","data"=>'开通成功');
        $response = ch_json_encode($response);
        exit($response);


    }

    //删除绑定的银行卡
    public function delete()
    {
        $tempbankcard = new TempBankcardModel();
        $tempbankcard->is_login();

        $condition['temp_bankcard_id'] = $_POST['temp_bankcard_id'];
        $bankinfo = $tempbankcard -> where($condition) ->field('bank_no,bind_mobile,bank_sign')->find();//取出用户银行卡信息

        if($bankinfo['bank_sign'])//查看是否有签约号,有签约号则表示已经绑定
        {
            load("@.bankPost");
            $b = curlDeleteBankPost($bankinfo);//去解绑接口
            if(!$b) exit('{"success":"false","error":{"msg":"解绑失败","code":"4911"}}');
        }
        $b2 = $tempbankcard -> where($condition) ->delete();
        if(!$b2) exit('{"success":"false","error":{"msg":"解绑失败","code":"4912"}}');

        $response = array("success"=>"true","data"=> '解绑成功');
        $response = ch_json_encode($response);
        exit($response);
    }

    //生成支付订单-->信用卡
    public function create()
    {
        $tempbankcard = new TempBankcardModel();
        $tempbankcard -> is_login();

        //安全码  有效期   订单号  temp_bankcard_id
        $save_code = isset($_POST['save_code'])?trim($_POST['save_code']):'';//安全码
        $valid_time = isset($_POST['valid_time'])?trim($_POST['valid_time']):'';//有效期
        $order_sn = $arr['order_sn'] = $order_sn = isset($_POST['order_sn'])?trim($_POST['order_sn']):'';  //订单号
        $arr['temp_bankcard_id'] = $temp_bankcard_id = isset($_POST['temp_bankcard_id'])?trim($_POST['temp_bankcard_id']):'';//银行列表id号

        is_empty($arr);//必须的参数是否有为空
        load("@.bankPost");//引入自定义函数
        //如果传了有效时间 , 判断是否过期
        is_time_valid($valid_time);

        $bankcardinfo = $tempbankcard->getInfoById($_POST['temp_bankcard_id']); //通过银行卡 id 获取所需要的信息
        $bankCardType = ($bankcardinfo['bank_type']==0)?'DR':'CR';//信用卡 or 储蓄卡

        if(!$_POST['order_sn']){
            $msg = '订单号必须存在';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
        }
        $c = 'C';
        $pos = strpos($_POST['order_sn'],$c);

        if($pos!==false){//充值订单
            $cashorderinfo = new TempCashOrderModel();
            $total_fee = $cashorderinfo->getMoney($order_sn);
        }else{
            $purchase = new TempPurchaseModel();
            $total_fee = $purchase->getMoney($order_sn);
            $order_sn = $order_sn.'-1';
        }

        $requestTime = requestTime();//获取请求的时间
        $_SESSION['requestTime'] = $requestTime;
        $agreementNo = $bankcardinfo['bank_sign'];//银行卡绑定签约号

        //curl 模拟post请求
        $output1 = curlBankPost($requestTime,$total_fee,$bankcardinfo,$bankCardType,$save_code,$order_sn,$agreementNo);

        $token2 = passport_encrypt($_SESSION['payOrderId'].'@'.$_SESSION['bank_no'].'@'.$_SESSION['requestNo'].'@'.$_SESSION['requestTime'],'qiping');//h5 去支付的时候需要这个参数
        date_default_timezone_set("Asia/Shanghai");
        $time = date('Y-m-d H:i:s');
        if($output1->returnCode == 'SUCCESS')//$output1->returnCode == 'BUSINESS_EXCEPTION'
        {
            file_put_contents('create.log.txt',$output1->returnMessage.'--'.$output1->payOrderId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);//把json数据放入到create.log.txt中
            $response = array("success"=>"true","data"=>true,'cache'=>$token2);
            $response = ch_json_encode($response);
            exit($response);
        }
        file_put_contents('create.log.txt',$output1->returnMessage.'--'.$_SESSION['payOrderId'].'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);//把json数据放入到create.log.txt中  $_SESSION['payOrderId']支付订单号
        $msg = (strlen($output1->returnMessage)>90||$output1->returnMessage=='CVV2不正确')?'有效期或安全码有误':$output1->returnMessage;//测试了很久,只有一个错误提示,长度大于90,
        $response = array("success"=>"false","error"=>array('msg'=>$msg,'code'=>4911));//$output1->returnMessage
        $response = ch_json_encode($response);
        exit($response);
    }

    //快捷银行 确认支付接口
    public function confirm()
    {
        //验证码
        $code = $_POST['code'];

        if (isset($_POST['cache']))//h5 需要传这个参数
        {
            $str = passport_decrypt($_POST['token2'], 'qiping');
            $res = explode('@', $str);
            $_SESSION['payOrderId'] = $res[0];
            $_SESSION['bank_no'] = $res[1];
            $_SESSION['requestNo'] = $res[2];
            $_SESSION['requestTime'] = $res[3];
        }

        load("@.bankPost");//引入自定义函数
        $output = curlBankConfirmPost($code);//curl 确认支付 post请求

        if($output->returnCode == 'SUCCESS')
        {
            $model = M('TempBankcard');
            $condition['bank_no'] = $_SESSION['bank_no'];
            $model->where($condition)->setField('bank_sign',$output->agreementNo);//把签约号保存到数据库中
            unset($_SESSION['bank_no']);
            unset($_SESSION['requestTime']);
            unset($_SESSION['requestNo']);
            unset($_SESSION['payOrderId']);

            $response = array("success"=>"true","data"=>'支付成功');
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            date_default_timezone_set("Asia/Shanghai");
            $time = date('Y-m-d H:i:s');

            file_put_contents('create2.log.txt',$output->returnMessage.'--'.$_SESSION['payOrderId'].'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);//把json数据放入到create.log.txt中  $_SESSION['payOrderId']支付订单号
            $output->returnMessage = ($output->returnMessage=='手机验证码有误[输入的验证码有误]')?'手机验证码有误':$output->returnMessage;
            $code = $output->returnMessage=='余额不足'?4913:4911;
            $response = array("success"=>"false","error"=>array('msg'=>$output->returnMessage,'code'=>$code));
            $response = ch_json_encode($response);
            exit($response);
        }
    }

    //快捷支付 回调接口
    public function notify()
    {
        import('ORG.Rest.RestUtils');
        $res = RestUtils::processRequest();

        $data = $res -> getData();//接收传输的数据

        $time = date('Y-m-d H:i:s');//日志 时间
        $payId = $data['payOrderId'];//网麦支付订单号

        if($data['returnCode'] == 'SUCCESS')
        {
            $out_trade_no = $data['orderId'];
            $total_fee = $_POST['orderAmount']/10000;//麦网返回的单位是毫
            $buyer_email =  'hbz@pcw268.com';

            $temppurchase = new TempPurchaseModel();

            $c = 'C';
            $pos = strpos($out_trade_no,$c);
            if($pos !== false) {//是充值订单
                // 查订单信息
                $sql = "select ecs_temp_cash_order.order_status,ecs_temp_cash_order.order_id,ecs_temp_cash_order.order_amount,ecs_temp_cash_order.bonus_money,ecs_temp_cash_order.user_id,ecs_temp_buyers.temp_buyers_mobile from ecs_temp_cash_order left join ecs_temp_buyers on ecs_temp_buyers.temp_buyers_id = ecs_temp_cash_order.user_id where ecs_temp_cash_order.order_sn = '$out_trade_no'";
                $c_res = $temppurchase->query($sql);
                $c_res = $c_res[0];
                if($c_res['order_status'] != 0 ){//0待支付
                    file_put_contents('log.txt','订单不是待支付--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
                    echo "success";
                    return false;
                }
                //判断卖家有没有账户
                $sql2 = 'select temp_account_id from ecs_temp_account where temp_buyers_id ='.$c_res['user_id'];
                $c_res2 = $temppurchase -> query($sql2);

                if(!$c_res2 ){//没有账户
                    $sqlaccount = "INSERT INTO ecs_temp_account (temp_buyers_id,total,withdraw) VALUES('{$c_res['user_id']}',0.00,0.00)";
                    $b = $temppurchase -> execute($sqlaccount);//成功返回 1
                    if(!$b){
                        file_put_contents('log.txt','卖家没有账户--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
                        echo "success";
                        return false;
                    }
                }

                //查此订单有没有在payment数据库插入过数据
                $sql3 = "select temp_payment_id from ecs_temp_payment where type = 0 and temp_purchase_sn ='$out_trade_no'";
                $c_res3 = $temppurchase -> query($sql3);

                if($c_res3){
                    file_put_contents('log.txt','没有payment数据库插入数据--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
                    echo "success";
                    return false;
                }

                //修改订单状态为支付成功1
                $sql4 = "update ecs_temp_cash_order set pay_method = 7,order_status = 1 where order_sn = '$out_trade_no'";
                $b4 = $temppurchase->execute($sql4);
                if(!$b4)
                {
                    file_put_contents('log.txt','订单状态修改失败--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
                    echo "success";
                    return false;
                }
                //开始事务
                $temppurchase->startTrans();
                //payment 加 一条type=0的数据
                $sql5 = "insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values ('$out_trade_no',".time().",'{$c_res['temp_buyers_mobile']}','品材网支付','hbz@pcw268.com','hbz@pcw268.com',0,0,'{$c_res['user_id']}','$total_fee',1)";
                if($c_res['bonus_money'] > 0){//有红包
                    $sql6 = "insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values ('$out_trade_no',".time().",'{$c_res['temp_buyers_mobile']}','品材网支付','hbz@pcw268.com','hbz@pcw268.com',0,10,'{$c_res['user_id']}','{$c_res['bonus_money']}',1)";
                    //给充值人加上订单钱和红包
                    $sql7 = "update ecs_temp_account set total = total + '.$total_fee.'+'{$c_res['bonus_money']}',bonus_money = bonus_money+'{$c_res['bonus_money']}' where temp_buyers_id ='{$c_res['user_id']}'";
                    //给用户在红包表增加一条记录
                    $sql8 = "insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,state,cash_time,purchase_id,cash_money,order_id) values (1,".date('ymdHis').str_pad($c_res['user_id'],6,"0",STR_PAD_LEFT).substr(microtime(),2,4).",'{$c_res['user_id']}',0,".time().",0,'{$c_res['bonus_money']}','{$c_res['order_id']}')";

                    $b5 = $temppurchase->execute($sql5);
                    $b6 = $temppurchase->execute($sql6);
                    $b7 = $temppurchase->execute($sql7);
                    $b8 = $temppurchase->execute($sql8);

                    if($b5 && $b6 && $b7 && $b8){
                        $temppurchase->commit();
                    }else{
                        $temppurchase->rollback();
                    }
                }else{//无红包
                    //给充值人加上订单钱
                    $sql1 = "update ecs_temp_account set total = total + '$total_fee' where temp_buyers_id ='{$c_res['user_id']}'";
                    $b = $temppurchase->execute($sql1);
                    if($b){
                        $temppurchase->commit();
                    }else{
                        $temppurchase->rollback();
                    }
                }

            }
            else
            {
                //支付订单
                $out_trade_nos = explode("-", $out_trade_no);
                $out_trade_no = $out_trade_nos[0];

                $sql = "select ecs_temp_purchase.temp_purchase_id,ecs_temp_purchase.state,ecs_temp_purchase.account_money,ecs_temp_purchase.money,ecs_temp_purchase.suppliers_id,ecs_temp_purchase.buyers_id,ecs_temp_buyers.temp_buyers_mobile from ecs_temp_purchase left join ecs_temp_buyers on ecs_temp_buyers.temp_buyers_id = ecs_temp_purchase.suppliers_id where ecs_temp_purchase.temp_purchase_sn = '$out_trade_no'";
                $res = $temppurchase->query($sql);
                $res = $res[0];

                if($res['state'] != 1){
                    file_put_contents('pay_exception.log.txt',$_SESSION['temp_buyers_id'].'--'.$out_trade_no.'--订单状态不是1--'.$time."\n",FILE_APPEND);
                    //发短信通知卖家发货
                    $message = "订单号:".$out_trade_no."付款人:".$_SESSION['temp_buyers_id']."金额:".$total_fee."支付发生异常,请及时处理";
                    $mobile = '18621715257';//'15189345238';//沈鹏
                    sendmessage($mobile,$message);
                    echo "success";
                    return false;
                }

                //判断卖家有没有账户
                $sql2 = 'select temp_account_id from ecs_temp_account where temp_buyers_id ='.$res['suppliers_id'];
                $res2 = $temppurchase -> query($sql2);

                if(!$res2 ){//没有账户
                    $sqlaccount = "INSERT INTO ecs_temp_account (temp_buyers_id,total,withdraw) VALUES('{$res['suppliers_id']}',0.00,0.00)";
                    $b = $temppurchase -> execute($sqlaccount);//成功返回 1

                    if(!$b){
                        file_put_contents('log.txt','买家没有账户--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
                        echo "success";
                        return false;
                    }
                }
                //判断支付宝支付钱+余额支付的钱是否与订单钱相等
                if(($total_fee+$res['account_money']) < $res['money']){
                    //把支付宝支付的钱加在account_money里
                    $sql3 = "update ecs_temp_purchase set account_money = account_money + '$total_fee' where temp_purchase_sn ='$out_trade_no'";
                    if(!$b3 = $temppurchase->execute($sql3)){
                        file_put_contents('log.txt','支付宝的钱加在account_money里失败--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
                        echo "success";
                        return false;
                    }
                    echo "success";
                    return false;
                }
                //修改订单状态为支付成功2  快捷支付 method=7
                if($_SESSION['temp_buyers_id'] == $res['buyers_id'])
                {
                    $sql4 = "update ecs_temp_purchase set method = 7,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=".time().",payer_id='-1' where temp_purchase_sn = '$out_trade_no'";
                }
                else
                {
                    $sql4 = "update ecs_temp_purchase set method = 7,state = 2,actually_money = actually_money + '$total_fee',difference_money=difference_money - '$total_fee',pay_time=".time()." where temp_purchase_sn = '$out_trade_no'";
                }
                 $b4 = $temppurchase -> execute($sql4);
                if(!$b4)
                {
                    file_put_contents('log.txt','更新订单状态2失败--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
                    echo "success";
                    return false;
                }
                //订单支付完成,判断是否给下单返现红包
                $sql_order = "select area_id from ecs_temp_purchase_goods WHERE temp_purchase_id='{$res['temp_purchase_id']}'";
                $res_cash = $temppurchase->query($sql_order);
                $area_id = $res_cash[0]['area_id'];

                date_default_timezone_set('prc');
                $time = time();
                $sqlbonus="select cash_back,bonus_id from ecs_temp_bonus where bonus_status=0 AND goods_area_id='$area_id' and send_type=3 AND min_money<='{$res['money']}' and use_start_date<='$time' and use_end_date>='$time'";
                $result = $temppurchase->query($sqlbonus);

                if($result = $result[0])
                {
                    $cash_money = $res['money']*$result['cash_back'];//红包金额

                    $user_id = $res['buyers_id'];
                    $current_date = date('ymdHis',$time);
                    $cash_sn=$current_date.substr(microtime(),2,4).rand(100000,999999);
                    $sqlinscash="insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,cash_time,cash_money) values ('{$result['bonus_id']}','$cash_sn','$user_id','$time','$cash_money')";
                    $sqlaccount = "update ecs_temp_account set total=total+'$cash_money' WHERE temp_buyers_id='$user_id'";
                    $temppurchase->startTrans();
                    $b1 = $temppurchase->execute($sqlinscash);
                    $b2 = $temppurchase->execute($sqlaccount);

                    if(!$b1 || !$b2)
                    {
                        $temppurchase->rollback();
                    }else{
                        $temppurchase->commit();
                    }
                }

                //在payment加上此收入，同时在count里加入缓存 在acount插入一条数据
                $temppurchase->startTrans();
                $sql5 = "insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,from_account,to_account,method,type,user_id,money,client_from) values ('$out_trade_no',".time().",'{$res['temp_buyers_mobile']}','品材网支付111','$buyer_email','hbz@pcw268.com',0,0,'{$res['suppliers_id']}','$total_fee',1)";
                $sql6 = "update ecs_temp_account set withdraw = withdraw + '$total_fee'+'{$res['account_money']}' where temp_buyers_id ='{$res['suppliers_id']}'";

                $b5 = $temppurchase->execute($sql5);
                $b6 = $temppurchase->execute($sql6);

                if($b5 && $b6 ){
                    $temppurchase -> commit();
                }else{
                    $temppurchase -> rollback();
                }

                $message = "买家支付成功订单（".$out_trade_no."），请尽快发货给买家。";
                $mobile = $res['temp_buyers_mobile'];
                sendmessage($mobile,$message);

            }
        }
        else
        {
            file_put_contents('log.txt','returnCode不是SUCCESS--'.$payId.'--'.$_SESSION['temp_buyers_id'].'--'.$time."\n",FILE_APPEND);
            echo "success";
            return false;
        }

    }

    //支持的银行卡列表
    public function supportList()
    {
        load("@.bankList");
        $banklist = getMaiWangBankList('CR'); //信用卡
        $banklist2 = getMaiWangBankList('DR');//储蓄卡

        $data['储蓄卡'] = array();
        for($i=0,$len=count($banklist2);$i<$len;$i++)
        {
            $data['储蓄卡'][$i]['bank_name'] = $banklist2[$i]->bankName;
            $data['储蓄卡'][$i]['bank_code'] = $banklist2[$i]->bankCode;
            $data['储蓄卡'][$i]['bank_icon'] = getDrCodeAndImg2($data['储蓄卡'][$i]['bank_name']);
        }
        $data['信用卡'] = array();
        for($i=0,$len=count($banklist);$i<$len;$i++)
        {
            $data['信用卡'][$i]['bank_name'] = $banklist[$i]->bankName;
            $data['信用卡'][$i]['bank_code'] = $banklist[$i]->bankCode;
            $data['信用卡'][$i]['bank_icon'] = getCrCodeAndImg2($data['信用卡'][$i]['bank_name']);
        }
        $response = array("success"=>"true","data"=>$data);
        $response = ch_json_encode($response);
        exit($response);
    }

}