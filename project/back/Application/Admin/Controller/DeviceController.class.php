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

        $condition = $devicems->condition($_GET);

        $condition_string = '';
        if($_GET){
            foreach($_GET as $v){
                $condition_string .=' '.$v;
            }
        }

        $data = $devicems->_list($condition);//设备列表

        $this->assign('_list',$data);
        $this->assign('condition_string',$condition_string);
        $this->assign('city',$_GET['city']);//城市名
        $this->assign('name',$_GET['name']);//客户名
        $this->assign('type',$_GET['type']);//类别

//        var_dump($devicems->getCustomerId($_GET['name']));
//        exit();

        $this->assign('customer_id',$devicems->getCustomerId($_GET['name']));

        $this->display();
    }

    //ajax 添加设备
    public function addDevice()
    {
        $customer_id = $_GET['customer_id'];
        $DeviceNum = $_GET['DeviceNum'];
        file_put_contents('log.txt',$customer_id.'44'.$DeviceNum."\n",FILE_APPEND );

        echo json_encode(array());
    }

    //ajax 获取城市
    public function getCities(){

        $province = $_GET['province'];

        $s= new AgentModel();
//        $condition['parent_id'] = $_SESSION['user']['id'];
        $condition['province'] = $province;

        $list = $s->field('agent_id,city')->where($condition)->select();

//        file_put_contents('log.txt',$province.$s->_sql()."\n",FILE_APPEND );
        echo json_encode($list);
    }

    //ajax 获取客户
    public function getCustomer(){
        $type = $_GET['type'];

        $s= new CustomerModel();
        $condition['agent_id'] = $_SESSION['user']['id'];

        if($type == '学校') $condition['type'] = 1;
        else $condition['type'] = 2;
//        file_put_contents('log.txt',$type."--111\n",FILE_APPEND );

        $list = $s->field('customer_id,name')->where($condition)->select();
//        file_put_contents('log.txt',$s->_sql()."\n",FILE_APPEND );
        echo json_encode($list);
    }
} 