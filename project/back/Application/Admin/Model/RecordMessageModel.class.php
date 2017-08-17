<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 14:33
 */

namespace Admin\Model;


use Admin\Logic\Time;
use Think\Model;

class RecordMessageModel extends Model{

    //获取破记录的 前5条消息
    public function getRecordMessage($customer_id)
    {
        $condition['customer_id'] = $customer_id;
        $res = $this->where($condition)->field('length,time,user_id,name,add_time')->order('add_time desc')->limit(5)->select();

        $time = new Time();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $res[$i]['time_ago'] = $time->updateTime($res[$i]['add_time']);
        }
        return $res;
    }
} 