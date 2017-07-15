<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/16
 * Time: 10:36
 */
function getTimeBeginAndEnd($time_flag)
{
    $data = array();
    if($time_flag == 'day'){
//        echo "11";
//        exit();
        $data['begin_time'] = mktime(0,0,0,date('m'),date('d')-1,date('Y'));//前一日开始时间
        $data['end_time'] = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;//前一日结束时间
    }else if($time_flag == 'month'){
//        $data['begin_time'] = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//前一月开始时间
        $data['begin_time'] = mktime(0,0,0,date('m')-1,1,date('Y'));//前一月开始时间
        $data['end_time']  = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//前一月结束时间
    }else{
        return false;
    }
//    echo strtotime(mktime(0,0,0,date('m'),date('d')-1,date('Y')));
//    print_r($data);
//    exit();
    return $data;
}