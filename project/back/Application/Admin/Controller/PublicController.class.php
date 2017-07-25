<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 18:01
 */

namespace Admin\Controller;


use Think\Model;
use Admin\Model\ConsumerHandleModel;
use Admin\Model\CustomerModel;

class PublicController extends \Think\Controller{

    //获取用户model
    public static function  getInstance($flag)
    {
        return  ConsumerHandleModel::getInstance($flag);
    }
    //首页
    public function index()
    {
        $customer = new CustomerModel();
        $data = $customer->homeInfo();

        $this->assign('data',$data);

        $this->display();
    }

    //登录
    public function login($flag='',$account='',$passwd='')
    {
        $flag = 3;

        if(IS_POST) {

            $consumer = $this->getInstance($flag);

            if(! $res = $consumer->login($account,$passwd,$flag))
            {
                $this->error($consumer->getError());
            }
            else
            {
                if($flag ==1){
                    $this->success('登录成功！', U('Admin/index'));
                }else if($flag ==2){
                    $this->display('agent/index');
                }else if($flag ==3){
//                    $this->success('登录成功！', U('Customer/index'));
                    $this->success('登录成功！', U('index'));
                }else{
                    $this->display('teacher/index');
                }
            }
        }else{
            $this->display('public/login');
        }
    }

    //退出
    public function logout()
    {
        if(IsLogin()){
            session ( 'user', null );
            session('[destroy]');

//            $this->redirect('login');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }
} 