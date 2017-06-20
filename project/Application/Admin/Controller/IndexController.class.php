<?php
namespace Admin\Controller;


use Think\Controller;
class IndexController extends Controller
{
    //后台首页
    public function index(){
        $this->display('public/login');
    }

    //测试
    public function test()
    {
        $this->display('public/base');
    }

}