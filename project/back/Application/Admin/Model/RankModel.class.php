<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 18:10
 */

namespace Admin\Model;


use Think\Model;

class RankModel extends Model
{
    public function dealWithSolve($table_info,$data)
    {
        $time = NOW_TIME;

        $add_info = array(
            'user_id'=>$data['user_id'],
            'customer_id'=>$data['customer_id'],
            'score_id'=>$data['score_id'],
            'cycles'=>$data['cycles'],
            'time'=>$data['time'],
            'add_time'=>NOW_TIME,
        );
        //是否 启用事物， 感觉不合适
        foreach($table_info as $k=>$v)
        {
            if($k == 'rank_y_table') $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time))";
            else if($k == 'rank_m_table') $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(FROM_UNIXTIME($time)) = MONTH(FROM_UNIXTIME(add_time))";
            else $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(FROM_UNIXTIME($time)) = MONTH(FROM_UNIXTIME(add_time)) AND WEEK(FROM_UNIXTIME($time)) = WEEK(FROM_UNIXTIME(add_time))";

            //rank_y_table排行表插入条件：1没有该用户记录 2圈数不一样 3不在同年或同月或同周范围内
            $sql_query1 =   "select rank_id,time from $v WHERE user_id='{$data['user_id']}' AND cycles='{$data['cycles']}' AND ".$time_con;
            $res1 = $this->query($sql_query1);
            $res1 = $res1[0];

            if(!$res1) {
                $b1 = $this->table($v)->add($add_info);//插入
                if(!$b1) {}//打印日志1
            }else if($res1 && $res1['time'] > $data['time']){
                //更新
                $b2 = $this->table($v)->where(array('rank_id'=>$res1['rank_id']))->setField('time',$data['time']);
                if(!$b2) { }//打印日志2
            }else{
                    //不做任何处理
            }
        }
        return true;
    }
}