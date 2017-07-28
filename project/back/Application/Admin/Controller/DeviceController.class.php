<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 10:46
 */

namespace Admin\Controller;

use Admin\Model\AgentModel;
use Think\Controller;
use Admin\Model\CustomerModel;
use Admin\Model\DeviceMsModel;

class DeviceController extends Controller{

    //设备管理主页
    public function index()
    {
        $uid = $_SESSION['user']['id'];
        if($_SESSION['user']['grade'] == 3 || $_SESSION['user']['grade']==4){
            $customer = new CustomerModel();
            $res = $customer->where(array('customer_id'=>$uid))->field('province,city,name,grade')->find();
            $this->assign('info',$res);//客户信息
        }else if($_SESSION['user']['grade'] == 2){
            $agent = new AgentModel();
            $res = $agent->where(array('agent_id'=>$uid))->field('parent_id,province,city')->find();
            $this->assign('info',$res);//客户信息
        }

        $devicems = new DeviceMsModel();
        $data = $devicems->_list();//设备列表

        $this->assign('_list',$data);

        $this->display();
    }

    //ajax 获取城市
    public function getCities(){
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
//        file_put_contents('log.txt',"111\n",FILE_APPEND );
        $list = $s->field('dept,user_id')->where($condition)->group('dept')->select();
        echo json_encode($list);
    }

    //ajax 获取客户
    public function getCustomer(){
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
//        file_put_contents('log.txt',"111\n",FILE_APPEND );
        $list = $s->field('dept,user_id')->where($condition)->group('dept')->select();
        echo json_encode($list);
    }
} 