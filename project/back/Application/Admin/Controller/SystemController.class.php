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
class SystemController extends Controller{

    public function index()
    {
        $this->display();
    }

    //添加账号
    public function add()
    {
        $data = I('post.');

        my_print($data);

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

    //添加系
    public function addDept()
    {
        $dept = I('get.dept');
        $customer_id = $_SESSION['user']['id'];

        file_put_contents('log.txt',$dept."\n",FILE_APPEND );

        $collectdept = M('collegeDept');
        $count = $collectdept->where(array('customer_id'=>$customer_id,'dept_name'=>$dept))->count();
        if($count>0){
            echo json_encode(array('msg'=>'该系别已经存在,无需再次添加'));
        }else{
            $collectdept->add(array('customer_id'=>$customer_id,'dept_name'=>$dept,'add_time'=>NOW_TIME));
            echo json_encode(array('msg'=>'添加成功'));
        }
    }

    //获取系别
    public function getDept()
    {
        $customer_id = $_SESSION['user']['id'];

        $collectdept = M('collegeDept');
        $dept_res = $collectdept->where(array('customer_id'=>$customer_id))->field('dept_name')->select();
//        my_print($dept_res);
        echo json_encode($dept_res);
    }

    //添加年级
    public function addGrade()
    {
        $grade = I('get.grade');
        $dept = I('get.dept');
        $customer_id = $_SESSION['user']['id'];

        $collectdept = M('collegeDept');
        $grade_num = $collectdept->where(array('customer_id'=>$customer_id,'dept_name'=>$dept))->getField('grade_num');

        file_put_contents('log.txt',$grade.'--'.$dept.$grade_num."\n",FILE_APPEND );

        if($grade_num>0){
            echo json_encode(array('msg'=>'年级已经添加,无需再次添加'));
        }else{
            $collectdept->where(array('customer_id'=>$customer_id,'dept_name'=>$dept))->save(array('grade_num'=>$grade));
            echo json_encode(array('msg'=>'添加成功'));
        }
    }

    //获取年级
    public function getGrade()
    {
        $dept = I('get.dept');
        $customer_id = $_SESSION['user']['id'];

        $collectdept = M('collegeDept');
        $grade_num = $collectdept->where(array('customer_id'=>$customer_id,'dept_name'=>$dept))->getField('grade_num');
        file_put_contents('log.txt',$dept.'-1111-'.$grade_num."\n",FILE_APPEND );

        echo json_encode(array('grade'=>$grade_num));
    }
} 