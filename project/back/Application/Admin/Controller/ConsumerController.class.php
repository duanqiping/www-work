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
//                $this->assign('error_info','账号或密码有误');
//                $this->display('public/login');
                exit('账号或密码有误');
            }
            else
            {
                print_r($res);
//                print_r($_SESSION);
//                $this->assign('name',$res['name']);
//                $this->display('index/index');
                exit('success');
            }
        }else{
//            $this->display('public/login');
            exit('去登陆');
        }
    }

    //退出
    public function logout()
    {
        if(IsLogin()){
            session ( 'user', null );

            session('[destroy]');
            exit('success');
//            $this->success('退出成功！', U('index/index'));
//            $this->display('public/login');
        } else {
            exit('fail');
//            $this->display('public/login');
        }
    }

    //添加用户
    public function add($flag)
    {
        if($this->getPower())
        {
            $consumer = $this->getInstance($flag);
            unset($_POST['flag']);

            $data = $consumer->makeData($_POST);

            $uid = $consumer->register($data);
            if (0 < $uid) { // 注册成功
                if($consumer->getTableName() == 'customer'){
                    if(!$consumer->createScoreAndRankTable($data))
                    {
                        $consumer->where(array('customer_id'=>$uid))->delete();
                        exit($consumer->getError());
                    }
                }
                exit('用户添加成功');
                return true;
            } else { // 注册失败，显示错误信息
                exit($consumer->getError());
            }
        }
        else
        {
            exit($this->getErrorInfo());
        }
    }

    //获取用户列表
    public function getList($flag)
    {
        if($this->getPower())
        {
            $consumer = $this->getInstance($flag);
            $info = $consumer->getList();

            print_r($info);
            exit();
        }
        else
        {
            exit($this->getErrorInfo());
        }
    }

    //删除用户
    public function delete($id,$flag)
    {

        if(($this->getPower()))
        {
            $consumer = $this->getInstance($flag);
            if($consumer->getTableName() == 'admin')
            {
                $info = $consumer->where(array('admin_id'=>$id))->field('level')->find();
                if($info['level'] == 1) exit('不准对超级管理员执行该操作');
            }
            $b = $consumer->delete($id);

            if($b) exit('删除成功');
            else exit('删除失败');
        }
        else
        {
            echo "1122";
            exit($this->getErrorInfo());
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