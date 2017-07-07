<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 16:58
 */

namespace Admin\Model;


use Think\Model\MongoModel;

class RanKMongoModel extends MongoModel{

    protected $marathon = 42195;//全程马拉松

    protected $dbName='score';//（要连接的数据库名称）

    protected $trueTableName = '';

//    protected $connection = 'DB_CONFIG1';

    protected $connection = array(
        'db_type' => 'mongo',
        'db_user' => '',//用户名(没有留空)
        'db_pwd' => '',//密码（没有留空）
        'db_host' => '127.0.0.1',//数据库地址
        'db_port' => '27017',//数据库端口 默认27017
    );
    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

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
            $res = $this->table($tableName)->where($condition)->field('time')->find();

            if(!$res) {
                $b1 = $this->table($tableName)->add($add_info);//插入
                if(!$b1) {
                    return false;
                }
            }else if($res && $res['time'] > $all_time){//更新
                $updata = array(
                    'score_id' =>$data['score_id'],
                    'time'=>$all_time,
                    'length'=>$all_length,
                    'add_time'=>NOW_TIME
                );
                $b2 = $this->table($tableName)
                    ->where(array('_id'=>$res['_id']))
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
//            if($k == 'rank_y_table') $condition['__string']  = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time))";
//            else if($k == 'rank_m_table') $condition['__string']  = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time)) AND MONTH(FROM_UNIXTIME($time)) = MONTH(FROM_UNIXTIME(add_time))";
//            //同一周中可能月份不同
//            else $condition['__string']  = "YEAR(FROM_UNIXTIME($time)) = YEAR(FROM_UNIXTIME(add_time))  AND WEEK(FROM_UNIXTIME($time)) = WEEK(FROM_UNIXTIME(add_time))";

            $condition['user_id'] = $data['user_id'];
            $condition['cycles'] = $cycles;

            $res =$this->table($v)->where($condition)->field('time,add_time')->select();

            //查询是否有当年当月当周记录
            $info = array();
            foreach($res as $k1=>$v1){
                if($k == 'rank_y_table'){
                    if(date('Y',$res[$k1]['add_time'])==date('Y',$time)){$info = $res[$k1];}//当年
                }else if($k == 'rank_m_table'){
                    if(date('Y-m',$res[$k1]['add_time'])==date('Y-m',$time)){$info = $res[$k1];}//当年、当月
                }else{
                    if(date('Y-W',$res[$k1]['add_time'])==date('Y-W',$time)){$info = $res[$k1];}//当年、当周
                }
                if($info) break;
            }

//            //rank_y_table排行表插入条件：1没有该用户记录 2圈数不一样 3不在同年或同月或同周范围内
//            $sql_query1 =   "select time from $v WHERE user_id='{$data['user_id']}' AND cycles='$cycles' AND ".$time_con;
//            $res1 = $this->query($sql_query1);
//            $res1 = $res1[0];

            if(!$info) {
                if($k == 'rank_y_table'){
                    $add_info['time_q'] = date('Y',NOW_TIME);
                }else if($k == 'rank_m_table'){
                    $add_info['time_q'] = date('Y-m',NOW_TIME);
                }else{
                    $add_info['time_q'] = date('Y-W',NOW_TIME);
                }
                $b1 = $this->table($v)->add($add_info);//插入

                if(!$b1) {
                    return false;
                }//打印日志1
            }else if($info['time'] > $all_time){
                //更新
                $updata_info = array(
                    'score_id' => $data['score_id'],
                    'time' => $all_time,
                    'length' => $all_length,
                    'add_time' => NOW_TIME,
                );
                $b2 = $this->table($v)->where(array('_id'=>$info['_id']))->save($updata_info);
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

        $tableName = 'rank_single';
        $condition['user_id'] = $data['user_id'];
        $condition['customer_id'] = $data['customer_id'];
        $res = $this->table($tableName)->where($condition)->field('time')->find();
//        $res = $this->table($tableName)->where($condition)->field('rank_id,time')->select();

//        print_r($res);
//        exit();

        if(!$res){
            //插入
            if(!$this->table($tableName)->add($single_info)){
                return false;
            }
        }else{
            if($data['time']<$res['time']){
                $b = $this->table($tableName)
                    ->where(array('_id'=>$res['_id']))
                    ->save(array('time'=>$data['time'],'score_id'=>$data['score_id'],'add_time'=>NOW_TIME));
                if(!$b){
                    return false;
                }
            }
        }
//        $res = $this->table($tableName)->where($condition)->field('time')->find();
//        print_r($res);
//        exit();
        return true;
    }
} 