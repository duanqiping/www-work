<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 10:02
 */

namespace Admin\Controller;


use Admin\Model\UserHandleModel;
use Think\Controller;

class AdminController extends Controller {

    //添加管理员
    public function add()
    {
//        print_r($_SERVER);
//        exit();
        //超级管理员登陆
        if((IsLogin())  && ($_SESSION['user']['level'] == 1))
        {
            $admin = UserHandleModel::getInstance($type = 1);
            $uid = $admin->register($_POST);
            if (0 < $uid) { // 注册成功
                exit('用户添加成功');
//                $this->success ( '用户添加成功！', U ( 'index' ) );
            } else { // 注册失败，显示错误信息
//                $this->error ( '用户添加失败！' );
                exit($admin->getError());
                exit('用户添加失败');
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
        $admin = UserHandleModel::getInstance($type = 1);
        $info = $admin->getList();
        print_r($info);
        exit();
    }
} 