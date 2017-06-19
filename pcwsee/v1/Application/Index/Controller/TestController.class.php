<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/11/30
 * Time: 12:00
 */

namespace Index\Controller;


use Index\Model\ChargeModel;
use Think\Controller;

class TestController extends Controller{
    public function test()
    {
        $charge = new ChargeModel();
        $res = $charge->where(array('ordersn'=>'va11160520179059343309'))
            ->field('charge_id,user_id,ordersn,money,paytype,statu,name,product_flag_id,price_id,insert_time')
            ->find();
        print_r($res);
        exit();
    }

}