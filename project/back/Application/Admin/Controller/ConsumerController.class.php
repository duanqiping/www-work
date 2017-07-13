<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 18:28
 */

namespace Admin\Controller;

use Think\Controller;

class ConsumerController extends BaseController
{
    //登录...你好呀
    public function login($flag='',$account='',$passwd='')
    {
        if(IS_POST) {
            $consumer = $this->getInstance($flag);
            if($consumer == false)
            {
                exit('flag值只能是1-4整数');
            }
            else if(! $res = $consumer->login($account,$passwd,$flag))
            {
                $this->assign('error_info','账号或密码有误');
                $this->display('public/login');
//                exit('账号或密码有误');
            }
            else
            {
//                print_r($res);
//                print_r($_SESSION);
                $this->assign('name',$res['name']);
                if($flag ==1){
                    $this->display('admin/index');
                }else if($flag ==2){
                    $this->display('agent/index');
                }else if($flag ==3){
                    $this->display('customer/index');
                }else{
                    $this->display('teacher/index');
                }

//                exit('success');
            }
        }else{
            $this->display('public/login');
//            exit('去登陆');
        }
    }

    //退出
    public function logout()
    {
        if(IsLogin()){
            session ( 'user', null );

            session('[destroy]');
//            exit('success');
//            $this->success('退出成功！', U('index/index'));
            $this->display('public/login');
        } else {
//            exit('fail');
            $this->display('public/login');
        }
    }


    //test
    public function test()
    {
        $date = date_create('2000-01-01');
        print_r($date);
        echo date_format($date, 'Y-m-d H:i:s');
        echo DATE_FORMAT($date, 'Y-m-d H:i:s');
        exit();
    }

} 