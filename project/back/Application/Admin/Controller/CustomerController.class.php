<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 13:40
 */

namespace Admin\Controller;


use Admin\Model\CustomerModel;
use Admin\Model\DeviceOrderModel;
use Admin\Model\RanKMongoModel;
use Admin\Model\ScoreModel;
use Admin\Model\TeacherModel;

class CustomerController extends BaseController
{
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
    public function summary()
    {
        $customer = new CustomerModel();
        $data = $customer->mainInfo();//用户量 活跃量 累计最长距离

        $rank = new RanKMongoModel();
        $best = $rank->bestScore();
//        print_r($data);
//        print_r($best);
//        exit();
        $this->assign('user',$data);
        $this->assign('best',$best);
        $this->display();
    }

    //用户信息列表
    public function info()
    {

        $teacher = new TeacherModel();
        $res = $teacher->_list();

        $this->assign('_list',$res);

        $this->display();
    }

    //排行表
    public function rank()
    {
//        print_r($_SESSION);
//        exit();
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
        $this->display();
    }

    //添加老师
    public function add2()
    {
        if(!$_POST){
            $this->display();
        }else{
            if($_POST['passwd'] != $_POST['repasswd'])
            {
                $this->assign('error_info','两次密码不一致');
                $this->display();

            }
//            echo "<pre>";
//            print_r($_POST);
//            echo "</pre>";
//            exit();
//            echo "add2";
            $teacher = new TeacherModel();
            $uid = $teacher->addTeacher($_POST);
            if($uid){
                $teacher = new TeacherModel();
                $res = $teacher->_list();

                $this->assign('_list',$res);
                $this->display('info');
            }else{
                $this->assign('error_info',$teacher->getError());
                $this->display();
            }

            exit();
        }

    }

    //设备管理主页
    public function device()
    {
        $agent = new DeviceOrderModel();
        $res = $agent->_list($type = 1);

        $status_info = $this->status();
        $this->assign('status_info',$status_info['info']);
        $this->assign('_list',$res);

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