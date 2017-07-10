<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 13:40
 */

namespace Admin\Controller;


use Admin\Model\CustomerModel;
use Admin\Model\RanKMongoModel;
use Admin\Model\ScoreModel;

class CustomerController extends BaseController
{
    //概述主页 用户量 活跃用户量 单圈最佳 累计最长距离
    public function index()
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

    //添加老师
    public function addTeacher()
    {

    }

    //录入成绩
    public function add()
    {
        $customer = new CustomerModel();
        $rankInfo = $customer->test($_POST);

        $score = new ScoreModel();
        $b = $score->insert($_POST,$rankInfo);
        if($b){
            exit('success');
        }else{
            exit('fail');
        }
    }

    //查询成绩
    public function getScore($customer_id)
    {

    }
} 