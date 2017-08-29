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
        $res = array();

        $type = $_GET['type']?$_GET['type']:'平时成绩';
        unset($_GET['type']);
        $condition = $_GET;//筛选条件

        $studentInfo = array();
        if($type == '平时成绩'){
            $score=  new ScoreModel();
            $customer = new CustomerModel();

            $socre_table = $customer->where(array('customer_id'=>$this->uid))->getField('score_table');//获取对应的成绩表


            $studentInfo['dept'] = $score->getDept($socre_table);//获取系别
            $studentInfo['grade'] = $score->getGrade($socre_table,$condition['dept']);//获取年级
            $studentInfo['class'] = $score->getClass($socre_table,$condition['dept'],$condition['grade']);//获取班级

            $res = $score->_list(makeCondition($condition,$this->uid,$contest_sn = 0),$current=$_GET['current'],$socre_table);

            $this->assign('totalNum',$score->totalNum);//总页数
            $this->assign('pageSize',$score->pageSize);//每页数
            $this->assign('current',$score->current);//第几页
        }else if($type == '考试\赛事成绩'){
            $contest_sn = $_SESSION['contest_sn'];
            $contestorder = new ContestOrderModel();

            $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

            $res = $contestorder->contestList(makeCondition($condition,$this->uid,$contest_sn = 0),$current=$_GET['current']);

            $this->assign('totalNum',$contestorder->totalNum);//总页数
            $this->assign('pageSize',$contestorder->pageSize);//每页数
            $this->assign('current',$contestorder->current);//第几页
        }

        $condition['type'] = $type;

        $this->assign('_list',$res);
        $this->assign('condition', $condition);

        $this->assign('deptInfo', $studentInfo['dept']);
        $this->assign('gradeInfo', $studentInfo['grade']);
        $this->assign('classInfo', $studentInfo['class']);

        $this->display();
    }
} 