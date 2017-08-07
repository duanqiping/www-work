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

        $contestorder = new ContestOrderModel();
        $score=  new ScoreModel();

        $uid = $_SESSION['user']['id'];

        $condition = $_GET;//筛选条件
//

//
        $deptInfo = $contestorder->getDept($_SESSION['contest_sn']);//获取系别
        $gradeInfo = $contestorder->getGrade($_SESSION['contest_sn'],$condition['dept']);//获取年级
        $classInfo = $contestorder->getClass($_SESSION['contest_sn'],$condition['dept'],$condition['grade']);//获取班级
//
//        $score = new ScoreModel();
//        $res = $score->_list(makeCondition($condition,$uid,$contest_sn = 0));

//        echo "<pre>";
//        print_r($res);
//        echo "</pre>";
//        exit();

//        $this->assign('_list',$res);
        $this->assign('condition', $condition);
        $this->assign('deptInfo', $deptInfo);
        $this->assign('gradeInfo', $gradeInfo);
        $this->assign('classInfo', $classInfo);


        $this->display();
    }
} 