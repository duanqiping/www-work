<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27
 * Time: 10:43
 */

namespace Admin\Controller;

//工单控制器
use Think\Controller;

use Admin\Model\CustomerModel;

class WoController extends Controller{

    public function index()
    {
        if($_SESSION['user']['grade'] == 3 || $_SESSION['user']['grade']==4){
            $customer = new CustomerModel();
            $res = $customer->where(array('customer_id'=>$_SESSION['user']['id']))->field('province,city,name,grade')->find();
            $this->assign('info',$res);//客户信息
        }

        $this->display();
    }

} 