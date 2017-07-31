<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/30
 * Time: 10:28
 */

namespace Admin\Controller;


use Admin\Model\UserModel;
use Think\Controller;

class OtherController extends BaseController{

    //彻底删除一个客户及想关联表
    public function deleteCustomer()
    {

        $customer_id = $_GET['customer_id'];

        $flag = $_POST['flag']=3;

        //权限判断
        if(!$this->isAdminLogin()){
            exit('该操作只能由管理员进行');
        }

        $consumer = $this->getInstance($flag);
        $b = $consumer->deleteCustomerInfo($customer_id);
        if(!$b){
            exit('fail');
        }else{
            echo "success";
        }
    }

    public function test()
    {
        $user = new UserModel();
        $condition = true;

        $count = $user->where($condition)->count();
        echo $user->_sql();
    }
} 