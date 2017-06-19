<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/15
 * Time: 10:31
 */
class TempCashOrderModel extends BaseModel
{
    protected $fields = array('order_id','order_sn','user_id','order_status','pay_method','order_amount','add_time','bonus_id','bonus_name','bonus_money','_pk'=>'order_id','_autoinc'=>true);

    public function getSingleInfo($condition,$field)
    {
        return $this->where($condition)->field($field)->find();
    }

    //快捷支付 获取充值的金额
    public function getMoney($order_sn)
    {
        $condition['temp_purchase_sn'] = $order_sn;
        $orderinfo = $this -> where($condition) -> field('order_amount,order_status') -> find();

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
        return $orderinfo['order_amount'];
    }

    //生成订单号
    public function cash_orderSn()
    {
        return $sn = 'C' . date('ymdHis') . str_pad($_SESSION['temp_buyers_id'], 6, "0", STR_PAD_LEFT) . substr(microtime(), 2, 4);
    }

    //是否是第一次充值1000元以上.可以获得红包
    public function is_one($uid)
    {
        $condition['order_status'] = 1;
        $condition['user_id'] = $uid;
        $condition['_string'] = 'order_amount >= 1000';

        return $b =  $this->where($condition)->count();
    }
}