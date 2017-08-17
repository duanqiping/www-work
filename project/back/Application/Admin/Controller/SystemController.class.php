<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 16:46
 */

namespace Admin\Controller;


use Think\Controller;

//系统管理控制器
class SystemController extends Controller{

    public function index()
    {
        $this->display();
    }
} 