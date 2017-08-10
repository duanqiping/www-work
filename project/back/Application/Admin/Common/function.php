<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/16
 * Time: 10:36
 */

//获取前一日和前一个的起始时间
function getTimeBeginAndEnd($time_flag)
{
    $data = array();
    if($time_flag == 'day'){
        $data['begin_time'] = mktime(0,0,0,date('m'),date('d')-1,date('Y'));//前一日开始时间
        $data['end_time'] = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;//前一日结束时间
    }else if($time_flag == 'month'){
//        $data['begin_time'] = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//前一月开始时间
        $data['begin_time'] = mktime(0,0,0,date('m')-1,1,date('Y'));//前一月开始时间
        $data['end_time']  = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//前一月结束时间
    }else{
        return false;
    }
    return $data;
}

//获取当日 当月的起始时间
function getTimeBegin($time_flag)
{
    if($time_flag == 'week'){
        $begin_time = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y')); //当周起始时间
    }else if($time_flag == 'month'){
        $begin_time = mktime(0,0,0,date('m'),1,date('Y')); //当月起始时间
    }else if($time_flag == 'year'){
        $begin_time =  mktime(0,0,0,1,1,date('Y'));//当年起始时间
    }else{
        return false;
    }
    return $begin_time;
}

//筛选条件
function makeCondition($data,$uid,$contest_sn)
{
    $condition = array();

    $condition['customer_id'] = $uid;
    if($contest_sn) $condition['contest_sn'] = $contest_sn;//已选的名单

    //系别 和 班级 是ajax 联动
    if($data['dept'] && $data['dept'] != '系别' && $data['dept'] != '不限'){$condition['dept'] = $data['dept'];}
    if($data['grade'] && $data['grade'] != '年级' && $data['grade'] != '不限'){$condition['grade'] = $data['grade'];}
    if($data['class'] && $data['class'] != '班级' && $data['class'] != '不限'){$condition['class'] = $data['class'];}
    if($data['sex'] && $data['sex'] != '性别' && $data['sex'] != '不限'){
        if($data['sex'] == '男')$condition['sex'] = '1';
        else $condition['sex'] = '2';
    }
    if($data['sign'] && $data['sign'] != '签到' && $data['sign'] != '不限'){
        if($data['sign'] == '未签到')$condition['sign'] = 0;
        else $condition['sign'] = 1;
    }
    //不合格的学生
    if($data['confirm'] === 0){
        $condition['confirm'] = $data['confirm'];
    }
    return $condition;
}

//打印数据
function my_print($res)
{
    echo "<pre>";
    print_r($res);
    echo "</pre>";
    exit();
}

//分割时间
function ScoreTimeExplode($time)
{
    $s = explode('-',$time);
    $time = $s[0]*60+$s[1];
    return $time;
}

//判断赛事状态 $res为赛事列表 或单场赛事
function ContestState($res)
{
    //一维
    if (count($res) == count($res, 1))
    {
        $res = buttonProperty($res);
    }
    //二维
    else
    {
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $res[$i] = buttonProperty($res[$i]);
        }
    }
    return $res;
}

//通过赛事状态 设置按钮属性
function buttonProperty($res)
{
    if($res['parent_id'] != 0) $res['title'] = $res['title'].'(补考)';

    if($res['end_time']<NOW_TIME)
    {
        $res['flag'] = ($res['status'] == 4)?'已结束':'已过期';
        $res['button'] = '开始';
        $res['click'] = 0;//不可点击
        $res['valid'] = 0;
    }
    else if($res['status'] == 4)
    {
        $res['flag'] = '已结束';
        $res['button'] = '进入';
        $res['click'] = 1;//可点击
        $res['valid'] = 1;
    }
    else if($res['status'] == 3)
    {
        $res['flag'] = '进行中';
        $res['button'] = '进入';
        $res['click'] = 1;//可点击
        $res['valid'] = 1;
    }
    else if($res['status'] == 2)
    {
        $res['flag'] = '准备中';
        $res['button'] = '进入';
        $res['click'] = 1;//可点击
        $res['valid'] = 1;
    }
    else if($res['status'] == 1)
    {
        $res['flag'] = '未开始';
        $res['button'] = '开始';
        $res['click'] = 1;//可点击
        $res['valid'] = 1;
    }
    return $res;
}