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
    public function getRank($customer_id,$cycles,$flag,$type,$page=1,$pageSize=20)
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
            $time_con = "YEAR(CURDATE()) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(CURDATE()) = MONTH(FROM_UNIXTIME(add_time)) AND WEEK(CURDATE()) = WEEK(FROM_UNIXTIME(add_time))";
            $field = 'rank_w_table';
        }


        $field = $field.',length';

        $customer = new CustomerModel();
        $res = $customer->where(array('customer_id'=>$customer_id))->field($field)->find();

        $rank_table = 'rank_w_table';$length=400;//默认值
        foreach($res as $k=>$v)
        {
            if($k != 'length') $rank_table=$v;
            else $length = $v;
        }

        if($type == 2){
            if($cycles == 1){
                $this->marathon = ceil($this->marathon/4);//四分之一
            }
            else if($cycles == 2){
                $this->marathon = ceil($this->marathon/2);//二分之一
            }
            $cycles = ceil($this->marathon/$length);
            $time_con = "cycles>'$cycles' AND ".$time_con;
        }else{
            $time_con = "cycles='$cycles' AND ".$time_con;
        }

        $sql = "select * from $rank_table WHERE ".$time_con. " order by time limit $offset,$pageSize";
        $rankInfo = $this->query($sql);

//        echo $this->_sql();
//        exit();
        return $rankInfo;
//        print_r($rankInfo);
//        exit();
    }
} 