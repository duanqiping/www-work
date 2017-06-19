<?php
namespace Admin\Controller;

use Admin\Model\UserHandleModel;
use Admin\Model\UserModel;
use Think\Controller;
class IndexController extends Controller
{
    //后台首页
    public function index(){
        $this->display('public/login');
    }

    //登录
    public function login($flag='',$account='',$passwd='')
    {
        if(IS_POST) {

            $use = UserHandleModel::getInstance($flag);

            if(! $res = $use->login($account,$passwd))
            {
                $this->assign('error_info','账号或密码有误');
                $this->display('public/login');
            }
            else
            {
                $this->assign('name',$res['name']);
                $this->display('index');
            }
        }else{
            $this->display('public/login');
        }
    }

    //测试
    public function test()
    {
        $this->display('public/base');
    }

}