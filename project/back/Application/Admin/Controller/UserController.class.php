<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 13:13
 */

namespace Admin\Controller;

use Think\Controller;

//用户管理控制器
class UserController extends BaseController
{
    //用户管理首页
    public function index()
    {
        $uid = $this->uid;
        $condition = $_GET?$_GET:array();

        $user = D('user');

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

    //手环绑定
    public function bind()
    {
        $customer = D('customer');
        $school_res = $customer->where(array('customer_id'=>$this->uid))
            ->field('name,province,city,type,school_type')
            ->find();

        $this->assign('customerInfo',$school_res);


        $this->display();
    }

    //添加用户 编码与用户一一对应关系
    public function add()
    {
        $user = D('user');
        $device = D('device');

        $data = I('post.');
        $data['sex'] = $data['sex']=='男'?1:2;
        $code = $data['code'];//手环编码
        unset($data['code']);

        $device_id = $device->checkDeviceCode($code);//检查手环编码
        if(!$device_id){
            exit($device->getError());
        }

        //检查用户是否存在
        $condition['studentId'] = $data['studentId'];
        $condition['customer_id'] = $this->uid;
        $user_res = $user->where($condition)->field('user_id')->find();
        if($user_res){
            //存在 更新用户信息和关联手环编码
            $user->where($condition)->save($data);
            //检查是否存已经绑定手环
            $count = $device->where(array('user_id'=>$user_res['user_id']))->count();
            if($count>0){
                exit('该学生已经绑定了手环，无需再次绑定');
            }else{
                $device->where(array('device_id'=>$device_id))->setField('user_id',$user_res['user_id']);
            }

        }else{
            //不存在 创建账号和关联手环编码
            $data['add_time'] = NOW_TIME;
            $data['school'] = $_SESSION['user']['name'];
            $data['customer_id'] = $this->uid;

            $user_id = $user->add($data);
            $device->where(array('device_id'=>$device_id))->setField('user_id',$user_id);
        }

        $this->redirect('bind');
    }

    //获取系别
    public function getDept()
    {
        $schoolInfo = D('schoolInfo');
        $dept_res = $schoolInfo->where(array('customer_id'=>$this->uid))->field('dept_name')->select();

        echo json_encode($dept_res);
    }

    //获取年级
    public function getGrade()
    {
        $dept = I('get.dept');

        $schoolInfo = D('schoolInfo');
        $grade_num = $schoolInfo->where(array('customer_id'=>$this->uid,'dept_name'=>$dept))->getField('grade_num');

//        file_put_contents('log.txt',$grade_num."0000"."\n",FILE_APPEND );

        echo json_encode(array('grade'=>$grade_num));
    }

    //获取班级
    public function getClass()
    {
        $dept = I('get.dept');

        $schoolInfo = D('schoolInfo');
        $condition = array();
        $condition['customer_id'] = $this->uid;
        if($dept) $condition['dept_name'] = $dept;

        $class_list = $schoolInfo->where($condition)->getField('class_list');

//        file_put_contents('log.txt',$schoolInfo->_sql()."\n",FILE_APPEND );

        echo $class_list;
    }
} 