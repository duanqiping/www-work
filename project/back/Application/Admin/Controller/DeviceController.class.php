<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 10:46
 */

namespace Admin\Controller;

use Think\Controller;
use Admin\Model\CustomerModel;
use Admin\Model\DeviceMsModel;

class DeviceController extends Controller{

    //设备管理主页
    public function index()
    {
        if($_SESSION['user']['grade'] == 3 || $_SESSION['user']['grade']==4){
            $customer = new CustomerModel();
            $res = $customer->where(array('customer_id'=>$_SESSION['user']['id']))->field('province,city,name,grade')->find();
            $this->assign('info',$res);
        }
        $devicems = new DeviceMsModel();
        $data = $devicems->_list();

        $this->assign('_list',$data);

        $this->display();
    }
} 