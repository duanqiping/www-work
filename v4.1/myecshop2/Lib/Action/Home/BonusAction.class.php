<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/10
 * Time: 10:01
 * 余额接口、红包列表接口、充值订单详情、钱包明细、充值订单生成接口
 */
class BonusAction extends Action
{
    /** 余额接口*/
    public function recharge()
    {
        $uid = $_SESSION['temp_buyers_id'];

        $database_type = 1;//默认值1
        if($_POST['temp_purchase_id'])
        {
            $database_type = $_POST['database_type'];
            checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        }



        if($database_type == 1)
        {
            $tempaccount = new TempAccountModel(1);
            $tempaccount->is_login();

            $res = $tempaccount->getSingleInfo(array('temp_buyers_id'=>$uid),'temp_account_id,temp_buyers_id,total');

            if(!$res)
            {
                //创建一个账户
                $id = $tempaccount->addOne($uid);
                $res_account = $tempaccount->getSingleInfo(array('temp_account_id'=>$id),'temp_account_id,temp_buyers_id,total');
                $tempaccount->printSuccess($res_account);
            }


            //返回余额
            $res['switch']='true';
            $res['quick_pay'] = 'false';//快捷支付
            $res['cod_pay'] = 'false';//货到付款
            $res['other_pay'] = 'false';//货到付款

            $temppuchasegoods = new TempPurchaseGoodsModel(1);
            $b = $temppuchasegoods->huoDaoPay($_POST['temp_purchase_id']);//货到付款判断函数
            if($b) $res['cod_pay'] = 'true';

            if(isset($_POST['temp_purchase_id']))
            {
                $temp_purchase_id = $_POST['temp_purchase_id'];
                $sql = "select account_money,state,buyers_id,payer_id from ecs_temp_purchase WHERE temp_purchase_id=".$temp_purchase_id;
                $res_account_money = $tempaccount->query($sql);
                if($res_account_money[0]['state'] == 0) exit('{"success":"false","error":{"msg":"订单已经取消","code":"4158"}}');

                $b = ($res_account_money[0]['buyers_id'] != $uid) && ($res_account_money[0]['payer_id']!=$uid);//处理买家取消代付
                if($b) exit('{"success":"false","error":{"msg":"买家已经取消代付","code":"4162"}}');

                if($res_account_money[0]['account_money']>0) $res['cod_pay']='false';//支付用了余额, 就不能货到付款
            }
            $tempaccount->printSuccess($res);
        }
        else
        {
            $model = new Model();
            $sql_b2b = "select count(*) as count from pcwb2bs.b2b_user WHERE temp_buyers_id='$uid'";
            $res_b2b = $model->query($sql_b2b);
            if($res_b2b[0]['count'] == 1) $b2b_user = 'true';
            else $b2b_user = 'false';

            $data['total'] = 0;
            $data['quick_pay'] = false;
            $data['cod_pay'] = false;
            $data['other_pay'] = $b2b_user;//货到付款
            printSuccess($data);
        }
    }

    /** 红包列表接口*/
    public function show()
    {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['pageSize']) ? $_POST['pageSize'] : 10;

        $tempcashorder = new TempCashModel();
        $tempcashorder->is_login();

        $data_info = $tempcashorder->getUserId($_SESSION['temp_buyers_id'],$limit,$page);

        $data['num'] = $tempcashorder->num;//红包个数
        $data['total_money'] =$tempcashorder->total_money;//红包总金额
        $data['list'] = $data_info;

        $tempcashorder->printSuccess($data);
    }

    /** 充值订单详情 temp_purchase_sn(充值订单号)*/
    public function details()
    {
        $sn = $_POST['temp_purchase_sn'];
        $c = 'C';
        $pos = strpos($sn,$c);
        //是充值订单
        if($pos !== false) {
            $tempcasehorder = new TempCashOrderModel();
            $tempcasehorder->is_login();

            $data = $tempcasehorder -> getSingleInfo(array('temp_purchase_sn'=>$sn),'order_sn,order_amount money');
            if(!$data) $data=array();

            $tempcasehorder->printSuccess($data);
        }
        //非充值订单
        else
        {
            $temppurchase = new TempPurchaseModel(1);
            $temppurchase -> is_login();

            $data = $temppurchase -> getSingleInfo(array('temp_purchase_sn'=>$sn),'temp_purchase_sn,money t_money,account_money');
            if(!$data)
            {
                $temppurchase->printError('没有该订单',23333);
            }
            else
            {
                $data['money'] = $data['t_money'] - $data['account_money'];//money为要充值的金额
                unset($data['t_money']);
                unset($data['account_money']);
            }
            $temppurchase->printSuccess($data);
        }
    }

    /** 钱包明细 type 0全部   1收入   2支出*/
    public function acc()
    {
        $payment = new TempPaymentModel(1);
        $payment->is_login();

        $type = isset($_POST['type']) ? $_POST['type'] + 0 : 0;
        $uid = $_SESSION['temp_buyers_id'];

        //接收页码
        $page = !isset($_POST['page']) || empty($_POST['page']) ? 1 : $_POST['page'] + 0;
        //每页显示多少条
        $limit = empty($_POST['pageSize']) ? 5 : $_POST['pageSize'] + 0;
        $data = $payment->paymentDetails($page, $limit, $type, $uid);

        $payment->printSuccess($data);
    }

    /** 充值订单生成接口 order_amount充值金额 area_id区域id号*/
    public function do_order()
    {
        $order_amount = $_POST['order_amount'] + 0;//充值金额$order_amount
        $area_id = $_POST['area_id'];
        $uid = $_SESSION['temp_buyers_id'];

        $cash_order = new TempCashOrderModel();

        $data['order_sn'] = $cash_order->cash_orderSn();
        $data['order_amount'] = $order_amount;
        $data['user_id'] = $uid;
        $data['order_status'] = 0;//待支付
        $data['add_time'] = time();

        //充值人有没有资格获取红包，条件是第一次充值1000元以上可以获得红包
        $is_one = $cash_order->is_one($uid);
        //说明是第一次充值1000元以上,有红包
        if($is_one < 1)
        {
            //查应该给哪种红包
            $bonus = new TempBonusModel();
            if (!$area_id) exit('{"success":"false","error":{"msg":"必须传一个area_id","code":"4800"}}');

            $bonus_info = $bonus->look_bonus($area_id, 0);
            if($bonus_info)
            {
                //根据bonus_id查红包信息
                $data['bonus_id'] = $bonus_info['bonus_id'];
                $data['bonus_name'] = $bonus_info['bonus_name'];
                if ($bonus_info['bonus_status'] == 0)
                {
                    //有红包
                    if ($data['order_amount'] >= $bonus_info['min_amount']) $data['bonus_money'] = $bonus_info['bonus_money'] != 0 ? $bonus_info['bonus_money'] : $bonus_info['cash_back'] * $data['order_amount'];
                    else $data['bonus_money'] = 0;
                }
            }
        }

        $id  = $cash_order->add($data);//入库
        if (!$id) exit('{"success":"false","error":{"msg":"充值订单入库失败","code":"4800"}}');

        //返回订单详情给APP
        $condition['order_id'] = $id;
        $order_info = $cash_order->where($condition)->field('order_id temp_purchase_id,order_sn temp_purchase_sn,user_id,order_status,pay_method,order_amount money,bonus_id,bonus_name,bonus_money')->find();

        $cash_order->printSuccess($order_info);
    }

}