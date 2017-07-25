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
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
//        file_put_contents('log.txt',"111\n",FILE_APPEND );
        $list = $s->field('dept,user_id')->where($condition)->group('dept')->select();
        echo json_encode($list);
    }

    public function getCatid(){

        $dept=$_GET['dept'];
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
        $condition['dept'] = $dept;
//        file_put_contents('log.txt',$dept."111222\n",FILE_APPEND );
        $data=$s->field('user_id,class')->where($condition)->group('class')->select();
        echo json_encode($data);
    }

    //工单状态
    protected function status()
    {
        $deviceorder = new DeviceOrderModel();
        $status_info = $deviceorder->searchOrderSn();
        return $status_info;
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
        $condition = array();
        if($_POST && $_POST['dept'] != '--系别--'){
            $condition = $_POST;
            if($condition['class'] == '--班级--'){
                unset($condition['class']);
            }
        }

        $condition['customer_id'] = $_SESSION['user']['id'];

        $user = new UserModel();
        $res = $user->_list($condition);

        $this->assign('_list',$res);

        $this->display();
    }

    //排行表
    public function rank()
    {
        $page = 1;
        $pageSize = 10;
        $flag = 'single';
        $cycles = '';
        if($_GET){
            $flag = $_GET['flag'];
            $cycles = $_GET['cycles'];
        }

        $customer_id = $_SESSION['user']['id'];

        $rank = new RankMongoModel();
        $data = $rank->getScoreRank($customer_id,$flag,$cycles,$page,$pageSize);


        if($flag == 'single'){
            $rankName = '单圈最佳成绩';
        }else if($flag == 'week'){
            $rankName = '当周'.$cycles.'圈成绩';
        }else if($flag == 'month'){
            $rankName = '当月'.$cycles.'圈成绩';
        }else if($flag == 'year'){
            $rankName = '当年'.$cycles.'圈成绩';
        }else if($flag == 'marathon'){
            if($cycles == 26){$rankName = '四分之一程马拉松成绩';}
            else if($cycles == 52){$rankName = '半程马拉松成绩';}
            else{$rankName = '全程马拉松成绩';}
        }else{
            $rankName = '单圈最佳成绩';
         }

        $this->assign('_list',$data);
        $this->assign('rankName',$rankName);
        $this->display();
    }

    //考试、比赛
    public function contest()
    {
        $this->display();
    }

    public function score()
    {
        $condition = array();
        if($_POST && $_POST['dept'] != '--系别--'){
            $condition = $_POST;
            if($condition['class'] == '--班级--'){
                unset($condition['class']);
            }
        }
//        echo "<pre>";
//        print_r($condition);
//        print_r($_POST);
//        echo "</pre>";
//        exit();
//        $condition['customer_id'] = $_SESSION['user']['id'];

        $score = new ScoreModel();
        $res = $score->_list($condition,$condition);

//        echo "<pre>";
//        print_r($res);
//        echo "</pre>";
//        exit();

        $this->assign('_list',$res);
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