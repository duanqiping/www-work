<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/25
 * Time: 14:48
 */

namespace Admin\Controller;


use Admin\Model\ContestModel;
use Admin\Model\ContestOrderModel;
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
        $data = I('post.');
        $data['begin_time'] = intval($data['begin_time']);
        $data['end_time'] = intval($data['end_time']);
        $data['time'] = intval($data['time']);

        $customer = new CustomerModel();
        $rankInfo = $customer->where(array('customer_id'=>$data['customer_id']))
            ->field('score_table,rank_y_table,rank_m_table,rank_w_table,length')
            ->find();
        if(!$rankInfo) sendError('fail');

        $customer_id = $data['customer_id'];
        unset($data['customer_id']);

        $score = new ScoreModel();
        $b = $score->insert($data,$rankInfo,$customer_id);
        if($b){
            sendSuccess('success');
        }else{
            sendError('fail');
        }
    }

    //录入 比赛\赛事 成绩
    public function addContest()
    {
        $data = I('post.');

        $contest = new ContestModel();
        $result = $contest->getContestStandard($data['contest_sn'],$data['user_id'],$data['time']);//判断是否合格
        if($result) $data['up_standard'] = 1;//合格
        else $data['up_standard'] = 0;//不合格

        $contestOrder = new ContestOrderModel();
        $b = $contestOrder->updateContest($data);

        if($b){
            sendSuccess('success');
        }else{
            sendError($contestOrder->getError());
        }
    }

    //获取某次比赛成绩
    public function getContestScore()
    {
        $condition = array();
        $condition['customer_id'] = $customer = I('get.customer_id');
        $condition['contest_sn'] = $contest_sn = I('get.contest_sn');
        $condition['time'] = array('gt',0);

        $score = new ContestOrderModel();
        $res = $score->where($condition)
            ->field('user_id,time,sex,dept,grade,class classRoom,name,studentId')
            ->order('time')
            ->select();
        $res = $res?array_values($res):array();
        sendSuccess($res);
    }

    //签到学生信息 入库
    public function sign()
    {
        $contestOrder = new ContestOrderModel();
        $user_ids = $_POST['user_id'];
        $contest_sn = $_POST['contest_sn'];
        $result = $contestOrder->checkSignContest($user_ids,$contest_sn);
        if(!$result){
            sendError($contestOrder->getError());
        }
        $condition['user_id'] = array('in',$user_ids);
        $condition['contest_sn'] = $contest_sn;
        $contestOrder->where($condition)->setField('sign',1);

        sendSuccess('success');
    }

    //返回用户名
    public function getUserInfo()
    {
        $code = I('get.code');//手环编码

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

        $contest_sn = I('get.contest_sn');
        $customer_id = I('get.customer_id');

        $condition['contest_sn'] = $contest_sn;
        $condition['customer_id'] = $customer_id;

        $contestOrder = new ContestOrderModel();
        $res = $contestOrder->getContestOrder($contest_sn,$customer_id);

        sendSuccess($res);

    }

    //获取当前时间  精确到毫秒
    public function getTime()
    {
        list($s1, $s2) = explode(' ', microtime());
        $res =  (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); //411

//        list($usec, $sec) = explode(" ", microtime());
//        $res = ((float)$usec + (float)$sec);//这个会带小数点

        sendSuccess($res);
    }
} 