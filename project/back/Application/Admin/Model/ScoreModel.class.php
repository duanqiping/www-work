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
    const Month = 'month';
    const Day = 'day';

    protected $dbName='score';//（要连接的数据库名称）
    protected $trueTableName = '';
    protected $connection = 'DB_CONFIG1';
    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

//    protected $_auto = array (
//
//        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
//    );

    private function activeUserNum($score_table,$time_flag)
    {
        //活跃用户量
        $dateInfo = getTimeBeginAndEnd($time_flag);
        $begin_time = $dateInfo['begin_time'];
        $end_time = $dateInfo['end_time'];

        $sql = 'db.'."$score_table".'.group({
                    key:{user_id:true},//分组条件
                    initial:{num:0},
                    $reduce:function(doc,prev){
                    prev.num++
                    },
                    condition:{$where:function(){
                    return this.add_time>'."$begin_time".' && this.add_time<'."$end_time".';//查询条件
                    }
                    }
                    }); ';
        $res = $this->mongoCode($sql);
        return count($res);
    }

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

    //活跃用户量(暂定 往上推一个月 有跑步记录)
    //每天活跃量 (暂定 上一天有多少人跑步)
    //月跑步公里数 （上个月总公里数）
    //用户时间段统计 （上个月 上午8-10  晚上6-11点）
    //持续运动量（一个月 有20天都在跑，平均每天运动量400米）
    public function UserInfo()
    {
        $data = array();

        $customer = new CustomerModel();
        $res_customer = $customer->where(array('customer_id'=>$_SESSION['user']['id']))->field('score_table')->find();
        $score_table = $res_customer['score_table'];

        $count_month  = $this->activeUserNum($score_table,ScoreModel::Month);//上月活跃用户量
        $count_day  = $this->activeUserNum($score_table,ScoreModel::Day);//昨日活跃用户量
        $data['count_month'] = $count_month;
        $data['count_day'] = $count_day;

//        $count = $this->table($score_table)->where($condition)->group('user_id')->field('user_id')->select();
//        $sql  = 'db.'."$score_table".'.find({"add_time":{"$gt":'."$begin_time".'},"add_time":{"$lt":'."$end_time".'}},'.
//            '{"user_id":1,"add_time":1}).toArray()';

//        var_dump($count_month);
//        var_dump($count_day);
//        exit();

//        print_r($count);
//        exit();

        return $data;
    }
}

