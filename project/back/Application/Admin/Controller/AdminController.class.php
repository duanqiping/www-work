<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 10:02
 */

namespace Admin\Controller;


use Admin\Model\ConsumerHandleModel;
//use Think\Controller;

class AdminController extends ConsumerConroller {

    //添加管理员
    public function add()
    {
        if($this->getPower($_SESSION['user']['level']==1))
        {
            $flag = 1;
            $data = $_POST;
            $result = $this->register($flag,$data);
            if($result === true) {
                exit('用户添加成功');
            }
            else{
                exit($result);
            }
        }
        else
        {
            exit('该操作只能超级管理员');
        }
    }

    //获取管理员列表
    public function getList()
    {
        if($this->getPower($_SESSION['user']['level']==1))
        {
            $info = $this->consumerList($flag = 1);
            print_r($info);
            exit();
        }
        else
        {
            exit('该操作只能管理员');
        }
    }

    //删除管理员信息
    public function delete($id)
    {
        if((IsLogin())  && ($_SESSION['user']['level'] > 0))
        {
            $admin = ConsumerHandleModel::getInstance($type = 1);
            $info = $admin->where(array('admin_id'=>$id))->field('level')->find();
            if($info['level'] == 1) exit('不准对超级管理员执行该操作');
            $b = $admin->where(array('admin_id'=>$id))->delete();
            if($b) exit('删除成功');
            else exit('删除失败');
        }
        else
        {
            exit('该操作只能超级管理员');
        }
    }

} 