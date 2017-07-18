<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 13:40
 */

namespace Admin\Controller;


use Admin\Model\CustomerModel;
use Admin\Model\DeviceMsModel;
use Admin\Model\DeviceOrderModel;
use Admin\Model\RanKMongoModel;
use Admin\Model\ScoreModel;
use Admin\Model\UserModel;

class CustomerController extends BaseController
{
    public function getSection(){
        $s= M("user");
        $condition['customer_id'] = 31;
        file_put_contents('log.txt',"111\n",FILE_APPEND );
        $list = $s->field('dept,user_id')->where($condition)->select();
        echo json_encode($list);
    }

    public function getCatid(){
        $sid=$_GET['id'];
        $c= M("category");
        $data=$c->field('id,title')->where("sectionid=$sid")->select();
        echo json_encode($data);
    }

    //工单状态
    protected function status()
    {
        $deviceorder = new DeviceOrderModel();
        $status_info = $deviceorder->searchOrderSn();
        return $status_info;
    }

    //录入成绩
    public function add()
    {
        $customer = new CustomerModel();
        $rankInfo = $customer->where(array('customer_id'=>$_POST['customer_id']))
            ->field('score_table,rank_y_table,rank_m_table,rank_w_table,length')
            ->find();

        $score = new ScoreModel();
        $b = $score->insert($_POST,$rankInfo);
        if($b){
            exit('success');
        }else{
            exit('fail');
        }
    }

    //概述主页 用户量 活跃用户量 单圈最佳 累计最长距离
    public function index()
    {
        $customer = new CustomerModel();
        $data = $customer->homeInfo();

        $this->assign('data',$data);

        $this->display();
    }

    //用户信息列表
    public function info()
    {

        $user = new UserModel();
        $res = $user->_list();

        $this->assign('dept',array('0'=>'数学系','1'=>'物理系'));

        $this->assign('_list',$res);

        $this->display();
    }

    //排行表
    public function rank()
    {

        $page = 1;
        $pageSize = 10;
        $flag = 'single';
        $customer_id = $_SESSION['user']['id'];

        $rank = new RankMongoModel();
        $data = $rank->getSingleRank($customer_id,$page,$pageSize);

//        print_r($data);
//        exit();

        $this->assign('_list',$data);
        $this->display();
    }

    //考试、比赛
    public function contest()
    {
        $this->display();
    }

    public function score()
    {
        $score = new ScoreModel();

        $this->display();
    }

    //设备管理主页
    public function device()
    {
        $devicems = new DeviceMsModel();
        $data = $devicems->_list();

        $deviceorder = new DeviceOrderModel();
        $res = $deviceorder->_list($type = 1);

        $status_info = $this->status();
        $this->assign('status_info',$status_info['info']);
        $this->assign('_list',$res);
        $this->assign('device',$data);

        $this->display();
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
        if(!$deviceorder->insertData($desc)){
            $this->assign('info',$deviceorder->getError());
            $this->display('device');
        }else{
            $this->assign('status_info','设备故障待处理');
            $this->display('device');
        }

    }
} 