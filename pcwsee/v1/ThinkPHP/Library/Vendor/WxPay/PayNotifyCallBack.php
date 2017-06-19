<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/4/12
 * Time: 10:43
 */
class PayNotifyCallBack extends WxPayNotify
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

        $charge = new \Index\Model\ChargeModel();
        $res = $charge->where(array('ordersn'=>$out_trade_no))
            ->field('charge_id,user_id,ordersn,money,paytype,statu,name,product_flag_id,price_id,insert_time')
            ->find();

        //判断此订单状态是否为1；
        if ($res['statu'] != 0)
        {
            wx_log($out_trade_no,'支付异常');
            $message = "订单号:" . $out_trade_no."金额:" . $total_fee . ' 时间' . date("Y-m-d H:i:s", $time) . "支付发生异常,请及时处理";
            $mobile = '15189345238';//'15189345238';//沈鹏
            sendmessage($mobile, $message);

            $this->SetReturn_code("SUCCESS");
            $this->SetReturn_msg("OK");
            return;
        }

        //修改订单状态为支付成功2
        $charge->startTrans();
        $b1  = $charge->where(array('ordersn'=>$out_trade_no))->save(array('statu'=>1));
        if(!$b1)
        {
            wx_log($out_trade_no,'订单状态更新失败');
            $this->SetReturn_code("SUCCESS");
            $this->SetReturn_msg("OK");
            return;
        }
        //给用户创建 该服务的vip账号
        $vipModel = new \Index\Model\VipModel();
        //首先查看他原先是否办过该业务
        $b2 = $vipModel->CreateVipAccount($res['user_id'],$res['product_flag_id'],$res['price_id']);
        if($b1 && $b2)
        {
            $charge->commit();
        }
        else
        {
            $charge->rollback();
            wx_log($out_trade_no,'服务器错误');
            $this->SetReturn_code("SUCCESS");
            $this->SetReturn_msg("OK");
            return;
        }

        wx_log($out_trade_no,'支付成功');
        //结束
        return true;
    }
}