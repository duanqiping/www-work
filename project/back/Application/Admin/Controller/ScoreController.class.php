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
        $res = array();

        $uid = $_SESSION['user']['id'];

        $type = $_GET['type']?$_GET['type']:'平时成绩';
        unset($_GET['type']);
        $condition = $_GET;//筛选条件

        $studentInfo = array();
        if($type == '平时成绩'){
            $score=  new ScoreModel();
            $studentInfo['dept'] = $score->getDept();//获取系别
            $studentInfo['grade'] = $score->getGrade($condition['dept']);//获取年级
            $studentInfo['class'] = $score->getClass($condition['dept'],$condition['grade']);//获取班级

            $res = $score->_list(makeCondition($condition,$uid,$contest_sn = 0),$current=$_GET['current']);

            $this->assign('totalNum',$score->totalNum);//总页数
            $this->assign('pageSize',$score->pageSize);//每页数
            $this->assign('current',$score->current);//第几页
        }else if($type == '考试\赛事成绩'){
            $contest_sn = $_SESSION['contest_sn'];
            $contestorder = new ContestOrderModel();

            $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

//            $res = $contestorder->contestList2(makeCondition($condition,$uid,$contest_sn = 0));
            $res = $contestorder->contestList(makeCondition($condition,$uid,$contest_sn = 0),$current=$_GET['current']);

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