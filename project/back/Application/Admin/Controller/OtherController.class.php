<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/30
 * Time: 10:28
 */

namespace Admin\Controller;


use Think\Controller;

class OtherController extends Controller{

    //彻底删除一个客户及想关联表
    public function deleteCustomer()
    {
        $customer_id = $_GET['customer_id'];
    }
} 