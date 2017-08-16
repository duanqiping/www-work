<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 13:13
 */

namespace Admin\Controller;


use Admin\Model\UserModel;
use Think\Controller;

//用户管理控制器
class UserController extends Controller{
    public function index()
    {
        $uid = $_SESSION['user']['id'];
        $condition = $_GET?$_GET:array();

        $user = new UserModel();

        $res = $user->_list(makeCondition($condition,$uid,$contest_sn=0),$current=$_GET['current']);

        $deptInfo = $user->getDept($uid);//获取系别
        $gradeInfo = $user->getGrade($uid,$condition['dept']);//获取年级
        $classInfo = $user->getClass($uid,$condition['dept'],$condition['grade']);//获取班级

        $this->assign('_list', $res);
        $this->assign('condition', $condition);
        $this->assign('deptInfo', $deptInfo);
        $this->assign('gradeInfo', $gradeInfo);
        $this->assign('classInfo', $classInfo);

        $this->assign('totalNum',$user->totalNum);//总页数
        $this->assign('pageSize',$user->pageSize);//每页数
        $this->assign('current',$user->current);//第几页

        $this->display();
    }
} 