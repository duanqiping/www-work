<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/25
 * Time: 14:48
 */

namespace Admin\Controller;


use Admin\Model\UserModel;
use Think\Controller;
use Admin\Model\CustomerModel;
use Admin\Model\ScoreModel;
use Admin\Model\DeviceMsModel;

//主机 控制器
class MasterController extends Controller{

    //设备注册
    public function register()
    {
        $account = trim($_GET['account']);//设备编码
        $passwd = 123456;//设备设定默认密码

        $devicems = new DeviceMsModel();
        $res = $devicems->EaseRegister($account,$passwd);
        if(!$res){
            sendError($devicems->getError());
        }else{
            sendSuccess($res);
        }
    }

    //录入成绩
    public function add()
    {
        $customer = new CustomerModel();
        $rankInfo = $customer->where(array('customer_id'=>$_POST['customer_id']))
            ->field('score_table,rank_y_table,rank_m_table,rank_w_table,length')
            ->find();

        $score = new ScoreModel();
        $b = $score->insert($_POST,$rankInfo);
        if($b){
            sendSuccess('success');
        }else{
            sendError('fail');
        }
    }

    //返回用户名
    public function getName()
    {
        $code = $_GET['code'];

        $user = new UserModel();
        $res = $user->getUserName($code);
        if(!$res){
            sendError($user->getError());
        }else{
            sendSuccess($res);
        }
    }
} 