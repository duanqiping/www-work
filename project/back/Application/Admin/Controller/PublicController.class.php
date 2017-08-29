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

class PublicController extends BaseController{

    //获取用户model
    public static function  getInstance($flag)
    {
        return  ConsumerHandleModel::getInstance($flag);
    }
    //首页 概览
    public function index()
    {
        $customer = new CustomerModel();
        $data = $customer->homeInfo($this->uid,$this->grade);

        $this->assign('data',$data);
        $this->assign('single_res',$data['best_single']);//单圈前5名记录
        $this->assign('record_message',$data['record_message']);//破记录的最近5条信息

//        my_print($data['record_message']);

        $this->display();
    }

    //登录
    public function login($flag='',$account='',$passwd='')
    {
        if(IS_POST) {

            $consumer = $this->getInstance($flag);
            if(!$consumer) $this->error('flag参数有误');

            if(!$consumer->login($account,$passwd))
            {
//                $this->error($consumer->getError());
                $this->display('public/login');
            }
            else
            {
                $this->redirect('index');
//                $this->success('登录成功！', U('index'));
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

            $this->redirect('login');
        } else {
            $this->redirect('login');
        }
    }
} 