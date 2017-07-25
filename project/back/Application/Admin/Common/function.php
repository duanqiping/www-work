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