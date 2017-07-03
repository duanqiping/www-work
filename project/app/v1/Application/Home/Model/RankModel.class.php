<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 14:44
 */

namespace Home\Model;


use Think\Model;

class RankModel extends Model{

    protected $marathon = 42195;//全程马拉松

    //获取排行
    public function getRank($customer_id,$cycles,$flag,$page=1,$pageSize=20)
    {
        if(($page<1)||($pageSize<1)){
            $page = 1;
            $pageSize = 20;
        }
        $offset = ($page-1)*$pageSize;

        if($flag == 'year'){
            $field = 'rank_y_table';
            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time))";
        }
        else if($flag == 'month'){
            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(CURDATE()) = MONTH(FROM_UNIXTIME(add_time))";
            $field = 'rank_m_table';
        }
        else{
//            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(CURDATE()) = MONTH(FROM_UNIXTIME(add_time)) AND WEEK(CURDATE()) = WEEK(FROM_UNIXTIME(add_time))";
            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time)) AND WEEK(CURDATE()) = WEEK(FROM_UNIXTIME(add_time))";
            $field = 'rank_w_table';
        }

        $customer = new CustomerModel();
        $res = $customer->where(array('customer_id'=>$customer_id))->field($field)->find();

        $rank_table = $res[$field];

        $sql = "select * from $rank_table WHERE cycles='$cycles' AND ".$time_con. " order by time limit $offset,$pageSize";
        $rankInfo = $this->query($sql);


        return $rankInfo;
//        print_r($rankInfo);
//        exit();
    }

    //马拉松排行
    public function getMarathonRank($customer_id,$flag,$page,$pageSize){
        if(($page<1)||($pageSize<1)){
            $page = 1;
            $pageSize = 20;
        }
        $offset = ($page-1)*$pageSize;

        $customer = new CustomerModel();
        $res = $customer->where(array('customer_id'=>$customer_id))->field('length')->find();
        $length = $res['length'];
        if($flag == 1){
            $cycles = round($this->marathon/($length*4) );
        }else if($flag == 2){
            $cycles = round($this->marathon/($length*2) );
        }else{
            $cycles = round($this->marathon/$length);
        }


        $condition['customer_id'] = $customer_id;
        $condition['cycles'] = $cycles;
        $res = $this->table('rank_marathon')
            ->where($condition)
            ->field('rank_id,user_id,customer_id,score_id,cycles,time,add_time,length')
            ->order('time')
            ->limit($offset,$pageSize)
            ->select();

//        echo $this->_sql();
//        exit();
//        print_r($res);
//        exit();

        return $res;
    }

    //获取单圈最佳成绩排行
    public function getSingleRank($customer_id,$page,$pageSize)
    {
        if(($page<1)||($pageSize<1)){
            $page = 1;
            $pageSize = 20;
        }
        $offset = ($page-1)*$pageSize;

        $condition['customer_id'] = $customer_id;
        $res = $this->where($condition)->field('*')->order('time')->limit($offset,$pageSize)->select();

        return $res;
    }
} 