<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 19:23
 */

namespace Admin\Model;


use Think\Model;

class ContestOrder extends Model{

    public function _list($condition,$field)
    {
        $res = $this->where($condition)->field($field)->select();
        return $res;
    }

    //获取赛事名单
    public function getContestOrder($contest_sn,$customer_id)
    {
        $data = array();

        $sql = "select co.class classRoom,co.name,co.studentId,d.code label from contest_order co LEFT JOIN device d ON co.user_id=d.user_id WHERE ".
            "co.contest_sn='$contest_sn' and co.customer_id='$customer_id'";

        $res = $this->query($sql);
        if(!$res){
            return array();
        }
        $data['list'] = $res;
        $data['customer_id'] = $customer_id;
        $data['title'] = '上海交通大学夏季运动会';
        $data['endMachine'] = '0000113';
        $data['circle'] = '4';
        $data['type'] = 2;
        return $data;
    }
} 