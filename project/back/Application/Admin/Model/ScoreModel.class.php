<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 17:27
 */

namespace Admin\Model;


use Think\Model\MongoModel;

//成绩表
class ScoreModel extends MongoModel{

    protected $dbName='score';//（要连接的数据库名称）

    protected $trueTableName = '';

    protected $connection = 'DB_CONFIG1';

    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

//    protected $_auto = array (
//
//        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
//    );
//    public function getTableName()
//    {
//
//    }

    //录入成绩
    public function insert($data,$rankInfo)
    {
//        $customerModel = M('customer');
//        $res = $customerModel
//            ->where(array('customer_id'=>$data['customer_id']))
//            ->field('score_table,rank_y_table,rank_m_table,rank_w_table,length')
//            ->find();
//
        $data['add_time'] = NOW_TIME;
        $b = $this->table($rankInfo['score_table'])->add($data);
        if(!$b){
            $this->error = '成绩导入失败';
            return false;
        }
//
//        //更新用户表的累计长度
//        $sql = "update user set length=length+'{$data['length']}' WHERE user_id='{$data['user_id']}'";
//        $this->execute($sql);

        //累次查出一次成绩
        $condition['user_id'] = $data['user_id'];
        $condition['flag'] = $data['flag'];
        $scoreInfo = $this->table($rankInfo['score_table'])->where($condition)->field('time,length')->select();
        //排行表插入条件：1没有该用户记录 2圈数不一样 3不在当年当周范围内
        $length = $rankInfo['length'];
        unset($rankInfo['score_table']);
        unset($rankInfo['length']);
        $data['score_id'] = $b;
//        $rankModel = new RankModel();
        $rankModel = new RanKMongoModel();
        $rankModel->dealWithSolve($rankInfo,$data,$length,$scoreInfo);
        return true;

    }

    //活跃用户量(暂定 往上推一个月 平均每天跑了100米)
    //每天活跃量 (暂定 上一天有多少人跑步)
    //月跑步公里数 （上个月总公里数）
    //用户时间段统计 （上个月 上午8-10  晚上6-11点）
    //持续运动量（一个月 有20天都在跑，平均每天运动量400米）
    public function UserInfo()
    {
        $customer = new CustomerModel();
        $res_customer = $customer->where(array('customer_id'=>$_SESSION['user']['id']))->field('score_table')->find();
        $score_table = $res_customer['score_table'];


        //活跃用户量
        $begin_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));
        $end_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));

        $condition['add_time'] = array('gt',$begin_time);
        $condition['add_time'] = array('lt',$end_time);
//        $count = $this->table($score_table)->where($condition)->group('user_id')->count();
//        $count = $this->table($score_table)->where($condition)->group('user_id')->field('user_id')->select();

//        $sql  = "db.{$score_table}.find({'user_id':'16'},{'user_id':1,'add_time':1}).toArray()";
        $sql  = 'db.'."$score_table".'.find({"add_time":{"$gt":'."$begin_time".'},"add_time":{"$lt":'."$end_time".'}},'.
            '{"user_id":1,"add_time":1}).toArray()';
//        echo $sql;
//        exit();
        $res = $this->mongoCode($sql);
//        $res = $this->table($score_table)->where(array('user_id'=>'16'))->field('user_id,add_time')->select();

        echo $this->_sql();
        var_dump($res);
        exit();

        print_r($count);
        exit();

    }
}

