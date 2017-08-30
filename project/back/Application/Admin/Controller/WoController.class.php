<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27
 * Time: 10:43
 */

namespace Admin\Controller;

//工单控制器
use Admin\Model\DeviceOrderModel;
use Think\Controller;

class WoController extends BaseController
{

    //工单首页
    public function index()
    {
        $deviceOrder = D('deviceOrder');

        if($id = I('get.id'))
        {
            $selectInfo = $deviceOrder->where(array('device_order_id'=>$id))
                ->field('device_order_id id,order_sn,status')
                ->find();
            $this->assign('selectInfo',$selectInfo);
        }

        $list = $deviceOrder->_list($status = 0,$this->customer_id,$this->grade);//工单列表
        $fillInfo = $deviceOrder->getCustomerFillData($this->grade);//获取客户的填写数据（适用于客户查看）
        $selectCondition = $deviceOrder->selectCondition($this->customer_id,$this->grade);//区域筛选数组，用于填充页面

        $this->assign('_list',$list);
        $this->assign('fillData',$fillInfo);
        $this->assign('selectCondition',$selectCondition);

        $this->assign('grade',$this->grade);

        $this->display();
    }

    //新增一条工单
    public function add()
    {
        $data = I('post.');
        if($data){
            $deviceOrder=  D('deviceOrder');
            $result = $deviceOrder->insertData($data,$this->customer_id);
            if(!$result){
                exit('跳转到错误页面');
            }else{
                $this->redirect('index');
            }
        }else{
            $this->redirect('index');
        }
    }

    //查询工单
    public function inHand()
    {
        $status = $_GET['status'];
        $agent = new DeviceOrderModel();
        $res = $agent->_list($status,$this->customer_id,$this->grade);

        $this->assign('_list',$res);
        $this->display('inHand');
    }

    //工单处理
    public function deal()
    {
        if($_GET){
            $data = $_GET;
            $this->assign('data',$data);

            $this->display();
        }else if($_POST){
            $data = $_POST;

            $deviceorder = new DeviceOrderModel();
            $result = $deviceorder->updateData($data);
            if($result){
                $res = $this->hand($type=2);
                $this->assign('_list',$res);
                $this->display('inHand');
            }else{
                $res = $this->hand($type=1);
                $this->assign('_list',$res);
                $this->display('outHand');
            }
        }
    }

    //设备报修
    public function report()
    {
        $desc = trim($_POST['desc']);
        $status_info = $this->status();

        $this->assign('status_info',$status_info['info']);


        if(!$desc){
            $this->assign('info','请描述一下故障');
            $this->display('device');
            exit();
        }

        if($status_info['status'] == 1 || $status_info['status'] == 2){
            $this->assign('info','设备已申请报修');
            $this->display('device');
            exit();
        }

        $deviceorder = new DeviceOrderModel();
        if(!$deviceorder->insertData($desc,$this->customer_id)){
            $this->assign('info',$deviceorder->getError());
            $this->display('device');
        }else{
            $this->assign('status_info','设备故障待处理');
            $this->display('device');
        }

    }

} 