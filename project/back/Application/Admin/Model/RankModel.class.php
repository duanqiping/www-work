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

    //$table_info排行表信息 $data录入的数据  $length学校的赛道的长度  $scoreInfo成绩表中的长度和时间
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

        //是否 启用事物， 感觉不合适

        //单圈最佳成绩
        $b = $this->singleSolve($data,$length);
        if(!$b){
            $this->error = '单圈成绩导入失败';
            return false;
        }

        //马拉松成绩录入
        $b1  = $this->marathonSolve($cycles,$all_time,$all_length,$length,$data,$add_info);
        if(!$b1) {
            $this->error = '马拉松成绩导入失败';
            return false;
        }

        //周月年成绩录入
        $b2 = $this->dateSolve($cycles,$all_time,$all_length,$table_info,$data,$add_info);
        if(!$b2){
            $this->error = '周月年成绩导入失败';
            return false;
        }

        return true;
    }

    //马拉松成绩处理
    private function marathonSolve($cycles,$all_time,$all_length,$length,$data,$add_info)
    {
        $tableName = 'rank_marathon';

        //全程 半程 四分之一程
        $array_marathon = array(floor($this->marathon/$length),floor($this->marathon/(2*$length)),floor($this->marathon/(4*$length)) );

        if(in_array($cycles,$array_marathon))
        {
            $condition['user_id'] = $data['user_id'];
            $condition['cycles'] = $cycles;
            $res = $this->table($tableName)->where($condition)->field('rank_id,time')->find();

            if(!$res) {
                $b1 = $this->table($tableName)->add($add_info);//插入
                if(!$b1) {
                    return false;
                }
            }else if($res && $res['time'] > $all_time){//更新
                $updata = array(
                    'score_id' =>$data['score_id'],
                    'time'=>$all_time,
                    'length'=>$all_length
                );
                $b2 = $this->table($tableName)
                    ->where(array('rank_id'=>$res['rank_id']))
                    ->save($updata);
                if(!$b2) {
                    return false;
                }
            }else{
               return true;
            }
        }
        return true;
    }

    //周月年成绩录入
    private function dateSolve($cycles,$all_time,$all_length,$table_info,$data,$add_info)
    {
        $time = NOW_TIME;
        foreach($table_info as $k=>$v)
        {
            if($k == 'rank_y_table') $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time))";
            else if($k == 'rank_m_table') $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(FROM_UNIXTIME($time)) = MONTH(FROM_UNIXTIME(add_time))";
                //同一周中可能月份不同
            else $time_con = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time))  AND WEEK(FROM_UNIXTIME($time)) = WEEK(FROM_UNIXTIME(add_time))";

            //rank_y_table排行表插入条件：1没有该用户记录 2圈数不一样 3不在同年或同月或同周范围内
            $sql_query1 =   "select rank_id,time from $v WHERE user_id='{$data['user_id']}' AND cycles='$cycles' AND ".$time_con;
            $res1 = $this->query($sql_query1);
            $res1 = $res1[0];

            if(!$res1) {
                $b1 = $this->table($v)->add($add_info);//插入

                if(!$b1) {
                    return false;
                }//打印日志1
            }else if($res1['time'] > $all_time){
                //更新
                $updata_info = array(
                    'score_id' => $data['score_id'],
                    'time' => $all_time,
                    'length' => $all_length,
                );
                $b2 = $this->table($v)->where(array('rank_id'=>$res1['rank_id']))->save($updata_info);
                if(!$b2) {
                    return false;
                }
            }
        }

        return true;
    }

    //单圈最佳成绩更新判断
    private function singleSolve($data,$length)
    {
        $single_info = array(
            'user_id' => $data['user_id'],
            'customer_id' => $data['customer_id'],
            'score_id' => $data['score_id'],
            'time' => $data['time'],
            'add_time' => NOW_TIME,
            'length' => $length,
        );

        $tableName = 'rank_singe';
        $condition['user_id'] = $data['user_id'];
        $condition['customer_id'] = $data['customer_id'];
        $res = $this->table($tableName)->where($condition)->field('rank_id,time')->find();
        if(!$res){
            //插入
            if(!$this->table($tableName)->add($single_info)){
                return false;
            }
        }else{
            if($data['time']<$res['time']){
                $b = $this->table($tableName)
                    ->where(array('rank_id'=>$res['rank_id']))
                    ->save(array('time'=>$data['time'],'score_id'=>$data['score_id']));
                if(!$b){
                    return false;
                }
            }
        }
        return true;
    }
}