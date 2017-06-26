<?php
namespace Admin\Controller;

use Admin\Model\ConsumerHandleModel;
use Think\Controller;
class UserController extends Controller {

    //登录
    public function login($flag='',$account='',$passwd='')
    {

        if(IS_POST) {
            $use = ConsumerHandleModel::getInstance($flag);
            if($use == false)
            {
//                $this->assign('error_info','非法操作');
//                $this->display('public/login');
                exit('false');
            }
            else if(! $res = $use->login($account,$passwd,$flag))
            {
//                $this->assign('error_info','账号或密码有误');
//                $this->display('public/login');
                exit('账号或密码有误');
            }
            else
            {
//                $this->assign('name',$res['name']);
//                $this->display('index/index');
                exit('success');
            }
        }else{
//            $this->display('public/login');
            exit('去登陆');
        }
    }
    
    /**
     * 用户退出
    */
    public function logout(){

//        echo "nimei";
//        exit();
        if(IsLogin()){
            $use = ConsumerHandleModel::getInstance(1);
            $use->logout();

            session('[destroy]');
            exit('success');
//            $this->success('退出成功！', U('index/index'));
//            $this->display('public/login');
        } else {
            exit('fail');
//            $this->display('public/login');
        }
    }
}