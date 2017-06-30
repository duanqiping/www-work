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
    protected $marathon = 42195;//全程马拉松

    public function dealWithSolve($table_info,$data,$length,$scoreInfo)
    {
        $all_time = 0;
        $all_length = 0;
        $cycles = count($scoreInfo);
        foreach($scoreInfo as $k=>$v){
            $all_time += $scoreInfo[$k]['time'];
            $all_length += $scoreInfo[$k]['length'];
        }


        $add_info = array(
            'user_id'=>$data['user_id'],
            'customer_id'=>$data['customer_id'],
            'score_id'=>$data['score_id'],
            'cycles'=>$cycles,
            'time'=>$all_time,
            'add_time'=>NOW_TIME,
            'length' =>$all_length
        );
//        if($length*$data['cycles']>$this->marathon)//全程
//        if($length*$data['cycles']<$this->marathon && $length*$data['cycles']>ceil($this->marathon/2))//半程
//        if($length*$data['cycles']<ceil($this->marathon/2) && $length*$data['cycles']<ceil($this->marathon/4))//四分之一程0

        //是否 启用事物， 感觉不合适
        $time = NOW_TIME;
        foreach($table_info as $k=>$v)
        {
            if($k == 'rank_y_table') $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time))";
            else if($k == 'rank_m_table') $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(FROM_UNIXTIME($time)) = MONTH(FROM_UNIXTIME(add_time))";
            else $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(FROM_UNIXTIME($time)) = MONTH(FROM_UNIXTIME(add_time)) AND WEEK(FROM_UNIXTIME($time)) = WEEK(FROM_UNIXTIME(add_time))";

            //rank_y_table排行表插入条件：1没有该用户记录 2圈数不一样 3不在同年或同月或同周范围内
            $sql_query1 =   "select rank_id,time from $v WHERE user_id='{$data['user_id']}' AND cycles='$cycles' AND ".$time_con;
            $res1 = $this->query($sql_query1);
            $res1 = $res1[0];

            if(!$res1) {
                $b1 = $this->table($v)->add($add_info);//插入
                if(!$b1) {}//打印日志1
            }else if($res1 && $res1['time'] > $all_time){
                //更新
//                $b2 = $this->table($v)->where(array('rank_id'=>$res1['rank_id']))->setField('time',$all_time);
//                $b2 = $this->table($v)->where(array('rank_id'=>$res1['rank_id']))->save(array('time'=>$all_time,'cycles'=>$cycles));
                $b2 = $this->table($v)->where(array('rank_id'=>$res1['rank_id']))->save(array('time'=>$all_time,'length'=>$all_length));
                if(!$b2) { }//打印日志2
            }else{
                    //不做任何处理
            }
        }
        return true;
    }
}