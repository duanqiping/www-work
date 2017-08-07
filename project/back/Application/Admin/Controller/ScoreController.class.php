<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 12:20
 */

namespace Admin\Controller;


use Admin\Model\ContestOrderModel;
use Admin\Model\ScoreModel;
use Think\Controller;

class ScoreController extends Controller{

    public function index()
    {
        $deptInfo  = array();
        $gradeInfo  = array();
        $classInfo  = array();
        $res = array();

        $uid = $_SESSION['user']['id'];

        $type = $_GET['type']?$_GET['type']:'平时成绩';
        unset($_GET['type']);
        $condition = $_GET;//筛选条件

        if($type == '平时成绩'){
            $score=  new ScoreModel();

            $deptInfo = $score->getDept();//获取系别
            $gradeInfo = $score->getGrade($condition['dept']);//获取年级
            $classInfo = $score->getClass($condition['dept'],$condition['grade']);//获取班级
            $res = $score->_list(makeCondition($condition,$uid,$contest_sn = 0));
        }else if($type == '考试\赛事成绩'){
            $contestorder = new ContestOrderModel();
            $deptInfo = $contestorder->getDept($_SESSION['contest_sn']);//获取系别
            $gradeInfo = $contestorder->getGrade($_SESSION['contest_sn'],$condition['dept']);//获取年级
            $classInfo = $contestorder->getClass($_SESSION['contest_sn'],$condition['dept'],$condition['grade']);//获取班级

            $res = $contestorder->contestList2(makeCondition($condition,$uid,$contest_sn = 0));
        }

        $condition['type'] = $type;


        $this->assign('_list',$res);

        $this->assign('condition', $condition);
        $this->assign('deptInfo', $deptInfo);
        $this->assign('gradeInfo', $gradeInfo);
        $this->assign('classInfo', $classInfo);


        $this->display();
    }
} 