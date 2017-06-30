<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 13:40
 */

namespace Admin\Controller;


use Admin\Model\ScoreModel;

class CustomerController extends BaseController
{

    //录入成绩
    public function add()
    {
        $score = new ScoreModel();
        $b = $score->insert($_POST);
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