<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 10:42
 */

namespace Home\Model;

use Think\Model\MongoModel;
class RankMongoModel extends MongoModel{

    protected $marathon = 42195;//全程马拉松

    protected $dbName='score';//（要连接的数据库名称）

    protected $trueTableName = '';

    protected $connection = array(
        'db_type' => 'mongo',
        'db_user' => '',//用户名(没有留空)
        'db_pwd' => '',//密码（没有留空）
        'db_host' => '127.0.0.1',//数据库地址
        'db_port' => '27017',//数据库端口 默认27017
    );
    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

    //获取排行
    public function getRank($customer_id,$cycles,$flag,$page=1,$pageSize=20)
    {
        if(($page<1)||($pageSize<1)){
            $page = 1;
            $pageSize = 20;
        }
        $offset = ($page-1)*$pageSize;

        if($flag == 'year'){
//            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time))";
            $condition['time_q'] = date('Y',NOW_TIME);
            $field = 'rank_y_table';
        }
        else if($flag == 'month'){
//            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(CURDATE()) = MONTH(FROM_UNIXTIME(add_time))";
            $condition['time_q'] = date('Y-m',NOW_TIME);
            $field = 'rank_m_table';
        }
        else{
//            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time)) AND WEEK(CURDATE()) = WEEK(FROM_UNIXTIME(add_time))";
            $condition['time_q'] = date('Y-W',NOW_TIME);
            $field = 'rank_w_table';
        }

        $customer = new CustomerModel();
        $res = $customer->where(array('customer_id'=>$customer_id))->field($field)->find();

        $rank_table = $res[$field];

//        $sql = "select * from $rank_table WHERE cycles='$cycles' AND ".$time_con. " order by time limit $offset,$pageSize";
//        $rankInfo = $this->query($sql);



        $condition['cycles'] = intval($cycles);
        $rankInfo = $this->table($rank_table)
            ->where($condition)
            ->field('user_id,customer_id,score_id,cycles,time,add_time,length')
            ->order('time')
            ->limit($offset,$pageSize)
            ->select();

        if(!$rankInfo) return array();
        $rankInfo = array_values($rankInfo);

//        echo $this->_sql();
//        print_r($res);
//        exit();

        $user = new UserModel();
        $rankInfo = $user->getUserInfoFromRank($rankInfo);
        return $rankInfo;
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
            ->field('user_id,customer_id,score_id,cycles,time,add_time,length')
            ->order('time')
            ->limit($offset,$pageSize)
            ->select();

        if(!$res) return array();

//        echo $this->_sql();
//        print_r($res);
//        exit();

        $res = array_values($res);

        $user = new UserModel();
        $res = $user->getUserInfoFromRank($res);
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
        $res = $this->table('rank_single')
            ->where($condition)
            ->field('user_id,customer_id,score_id,time,add_time,length')
            ->order('time')
            ->limit($offset,$pageSize)
            ->select();

        if(!$res) return array();
        $res = array_values($res);

        $user = new UserModel();
        $res = $user->getUserInfoFromRank($res);

        return $res;
    }

} 