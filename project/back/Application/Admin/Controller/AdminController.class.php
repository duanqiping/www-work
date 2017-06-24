<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 10:02
 */

namespace Admin\Controller;


use Admin\Model\UserHandleModel;
use Common\Controller\BaseController;
use Think\Controller;

class AdminController extends BaseController {

    //添加管理员
    public function add($account,$name,$passwd,$level)
    {
        //超级管理员登陆
        if(($b = $this->IsLogin() ) && ($_SESSION['user']['level'] == 1))
        {
            $admin = UserHandleModel::getInstance($type = 1);
            $admin->add($_POST);
            exit();
        }
        else
        {
            exit('权限不够');
        }
    }
} 