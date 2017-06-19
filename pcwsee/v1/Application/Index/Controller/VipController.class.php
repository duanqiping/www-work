<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/11/22
 * Time: 16:23
 */

namespace Index\Controller;


use Common\Controller\BaseController;
use Index\Model\ChargeModel;
use Index\Model\VipModel;

class VipController extends BaseController
{
    /** vip选项*/
    public function info()
    {
        $priceModel = M('price');

        $res = $priceModel->where('price_id=9 or price_id=11')->field('price_id')->select();

        $data = array(
            '0'=>array(
                'type'=>1,
                'money'=>98,
                'Orig_money'=>198,
                'desc'=>'按季度收费',
                'tag'=>'',
                'price_id'=>$res[0]['price_id']
            ),
            '1'=>array(
                'type'=>2,
                'money'=>198,
                'Orig_money'=>698,
                'desc'=>'按年收费',
                'tag'=>'限时特价',
                'price_id'=>$res[1]['price_id']
            ),
        );
        sendSuccess($data);
    }

    /** vip订单*/
    public function confirm()
    {
        $price_id = $_POST['price_id'];
        $money = $_POST['money'];//订单金额
        $user_id = $_SESSION['user_id'];

        checkPostData($price_id,'price_id不能为空',400);
        checkPostData($money>0,'金额不能低于0',400);

        $charge = new ChargeModel();
        $charge->is_login();

        $priceModel = M('price');
        $res_price = $priceModel->where(array('price_id'=>$price_id))->field('name,product_flag_id')->find();

        $orderInfo = array();
        $orderInfo['user_id'] = $user_id;
        $orderInfo['ordersn'] = get_cash_sn($user_id);
        $orderInfo['money'] = $money;
        $orderInfo['paytype'] = 15;
        $orderInfo['statu'] = 0;
        $orderInfo['name'] = $res_price['name'];
        $orderInfo['product_flag_id'] = $res_price['product_flag_id'];
        $orderInfo['price_id'] = $price_id;
        $orderInfo['insert_time'] = date('Y-m-d H:i:s', NOW_TIME);

        $charge_id = $charge->add($orderInfo);
        if(!$charge_id)
        {
            sendServerError('服务器错误',500);
        }
        else
        {
            $res = $charge->where(array('charge_id'=>$charge_id))->field('charge_id,user_id,ordersn,money,paytype,statu,name,product_flag_id,price_id,insert_time')->find();
            sendSuccess($res);
        }
    }

    public function test()
    {
        $vipModel = new VipModel();
        //首先查看他原先是否办过该业务
        $res = $vipModel->CreateVipAccount(440784,'HOMECOST',10);
        var_dump($res);
    }
}