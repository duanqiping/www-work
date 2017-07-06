<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 13:40
 */

namespace Admin\Controller;


use Admin\Model\CustomerModel;
use Admin\Model\ScoreModel;

class CustomerController extends BaseController
{
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