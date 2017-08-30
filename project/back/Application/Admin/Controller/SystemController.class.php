<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 16:46
 */

namespace Admin\Controller;


use Think\Controller;
use Admin\Model\ConsumerHandleModel;

//系统管理控制器
class SystemController extends BaseController{

    //创建账号
    public function index()
    {
        $this->assign('grade',$this->grade);

        $this->display();
    }

    //信息管理
    public function info()
    {
        $customer = D('customer');
        $res = $customer->where(array('customer_id'=>$this->customer_id))->field('name,province,city,type,school_type')->find();

        $this->assign('customerInfo',$res);

        $this->display();
    }

    //添加账号
    public function add()
    {
        $data = I('post.');

        $flag = $data['flag'];
        unset($data['flag']);

        $consumer = ConsumerHandleModel::getInstance($flag);

        $data = $consumer->makeData($data);

        if($consumer->create($data))
        {
            $uid = $consumer->add();

            if (0 < $uid) { // 注册成功
                $this->redirect('index');
            } else { // 注册失败，显示错误信息
                $this->redirect('index');
            }
        }else{
            echo $consumer->getError();
        }
    }

    //添加系别
    public function addDept()
    {
        $dept = I('get.dept');
        $school_type = I('get.school_type');

        $customer_id = $this->customer_id;

        $schoolInfo = D('schoolInfo');
        if($schoolInfo->create(array('customer_id'=>$customer_id,'dept_name'=>$dept,'school_type'=>$school_type))){
            $b = $schoolInfo->add();
            if($b) $msg = "添加成功";
            else $msg = "服务器错误";
        }else{
            $msg = $schoolInfo->getError();
        }
//        $dept_res = $schoolInfo->where(array('customer_id'=>$customer_id))->field('dept_name')->select();
//        file_put_contents('log.txt',json_encode($dept_res)."11111"."\n",FILE_APPEND );

        echo json_encode(array('msg'=>$msg));
    }

    //获取系别
    public function getDept()
    {
        $customer_id = $this->customer_id;

        $schoolInfo = D('schoolInfo');
        $dept_res = $schoolInfo->where(array('customer_id'=>$customer_id))->field('dept_name')->select();

//        file_put_contents('log.txt',json_encode($dept_res)."2222"."\n",FILE_APPEND );

        echo json_encode($dept_res);
    }

    //添加年级
    public function addGrade()
    {
        $grade = I('get.grade');
        $dept = I('get.dept');
        $school_type = I('get.school_type');

        $customer_id = $this->customer_id;

        $condition = array();
        $condition['customer_id'] = $customer_id;
        if($dept) $condition['dept_name'] = $dept;

        $schoolInfo = D('schoolInfo');
        $grade_num = $schoolInfo->where($condition)->getField('grade_num');

        //中小学
        if($grade_num == null){
            if($schoolInfo->create(array('customer_id'=>$customer_id,'grade_num'=>$grade,'school_type'=>$school_type))){
                $b = $schoolInfo->add();
                if($b) $msg="添加成功";
                else $msg="服务器错误";
            }else{
                $msg = $schoolInfo->getError();
            }
        }
        else if($grade_num>0){
            $msg = '年级已经添加,无需再次添加';
        }
        //大学
        else{
            if($schoolInfo->create(array('grade_num'=>$grade))){
                $b = $schoolInfo->where($condition)->save();
                if($b) $msg="添加成功";
                else $msg="服务器错误";
            }else{
                $msg = $schoolInfo->getError();
            }
        }
        echo json_encode(array('msg'=>$msg));
    }

    //获取年级
    public function getGrade()
    {
        $dept = I('get.dept');
        $customer_id = $this->customer_id;

        $schoolInfo = D('schoolInfo');
        $grade_num = $schoolInfo->where(array('customer_id'=>$customer_id,'dept_name'=>$dept))->getField('grade_num');

        echo json_encode(array('grade'=>$grade_num));
    }

    //添加班级
    public function addClass()
    {
        $class = I('get.class');
        $dept = I('get.dept');
        $customer_id = $this->customer_id;

        $schoolInfo = D('schoolInfo');
        $condition = array();
        $condition['customer_id'] = $customer_id;
        if($dept) $condition['dept_name'] = $dept;

        $class_list = $schoolInfo->where(array('customer_id'=>$customer_id,'dept_name'=>$dept))->getField('class_list');

//        file_put_contents('log.txt',$class.'--'.$dept.$class_list."\n",FILE_APPEND );
//        file_put_contents('log.txt',$class_list."0000"."\n",FILE_APPEND );

        //首次添加班级
        if(!$class_list){
            $array = array($class);
        }else{
            //往json后面添加班级
            $array = json_decode($class_list);
            $flag = false;
            for($i=0,$len=count($array);$i<$len;$i++)
            {
                if($array[$i] == $class){$flag = true;break;}
            }
            if($flag){
                echo json_encode(array('msg'=>'该班级已经存在，无需再次添加'));
                exit();
            }

            array_push($array,$class);
        }
        $array = json_encode($array);
//        file_put_contents('log.txt',$class_list."1111".$class."\n",FILE_APPEND );
        if($schoolInfo->create(array('class_list'=>$array)))
        {
            $b = $schoolInfo->where(array('customer_id'=>$customer_id,'dept_name'=>$dept))->save();
            if($b){
                $msg = '添加成功';
            }else{
                $msg = '服务器错误';
            }
        }else
        {
            $msg = $schoolInfo->getError();
        }
        echo json_encode(array('msg'=>$msg));
    }

    //获取班级
    public function getClass()
    {
        $dept = I('get.dept');
        $customer_id = $this->customer_id;

        $schoolInfo = D('schoolInfo');
        $condition = array();
        $condition['customer_id'] = $customer_id;
        if($dept) $condition['dept_name'] = $dept;

        $class_list = $schoolInfo->where($condition)->getField('class_list');

//        file_put_contents('log.txt',$class_list."2222"."\n",FILE_APPEND );

        echo $class_list;
    }
} 