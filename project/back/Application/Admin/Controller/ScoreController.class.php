<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 12:20
 */

namespace Admin\Controller;


use Admin\Model\ContestOrderModel;
use Admin\Model\CustomerModel;
use Admin\Model\ScoreModel;
use Think\Controller;

//成绩管理控制器
class ScoreController extends BaseController{

    public function index()
    {
        $customer_id = $this->customer_id;

        $condition = I('get.');//筛选条件

        $type = I('get.type')?I('get.type'):'平时成绩';
        unset($condition['type']);

        $studentInfo = array();
        if($type == '平时成绩'){
            $score=  new ScoreModel();
            $customer = new CustomerModel();

            $socre_table = $customer->where(array('customer_id'=>$customer_id))->getField('score_table');//获取对应的成绩表

            $studentInfo['dept'] = $score->getDept($socre_table);//获取系别
            $studentInfo['grade'] = $score->getGrade($socre_table,$condition['dept']);//获取年级
            $studentInfo['class'] = $score->getClass($socre_table,$condition['dept'],$condition['grade']);//获取班级

            $res = $score->_list(makeCondition($condition,$this->uid,$contest_sn = 0),$current=$_GET['current'],$socre_table);

            $totalNum = $score->totalNum;$pageSize=$score->pageSize;$current=$score->current;
        }else{

            $contestorder = new ContestOrderModel();
            $studentInfo = $contestorder->getStudentInfo($condition,$customer_id);//获取系、年级、班级

            $res = $contestorder->contestList(makeCondition($condition,$customer_id,$contest_sn = 0),$current=$_GET['current']);

            $totalNum = $contestorder->totalNum;$pageSize=$contestorder->pageSize;$current=$contestorder->current;
        }

        $condition['type'] = $type;

        $this->assign('_list',$res);
        $this->assign('condition', $condition);

        $this->assignSchoolInfo($studentInfo['dept'],$studentInfo['grade'],$studentInfo['class']);
        $this->assignPageInfo($totalNum,$pageSize,$current);

        $this->display();
    }
} 