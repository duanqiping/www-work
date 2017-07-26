<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/25
 * Time: 14:48
 */

namespace Admin\Controller;


use Admin\Model\ContestOrder;
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

    //录入成绩(平时训练 单圈单圈录入)
    public function add()
    {
        $data = $_POST;
        $data['begin_time'] = intval($data['begin_time']);
        $data['end_time'] = intval($data['end_time']);
        $data['time'] = intval($data['time']);

        $customer = new CustomerModel();
        $rankInfo = $customer->where(array('customer_id'=>$data['customer_id']))
            ->field('score_table,rank_y_table,rank_m_table,rank_w_table,length')
            ->find();
        unset($data['customer_id']);

        $score = new ScoreModel();
        $b = $score->insert($data,$rankInfo);
        if($b){
            sendSuccess('success');
        }else{
            sendError('fail');
        }
    }

    //返回用户名
    public function getUserInfo()
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

    //获取考试名单
    public function getContest()
    {
        $condition = array();
        $contest_sn = $_GET['contest_sn'];
        $customer_id = $_GET['customer_id'];

        $condition['contest_sn'] = $_GET['contest_sn'];
        $condition['customer_id'] = $_GET['customer_id'];

        $contestOrder = new ContestOrder();
        $res = $contestOrder->getContestOrder($contest_sn,$customer_id);

        sendSuccess($res);

    }
} 