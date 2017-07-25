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
    const Week = 'week';
    const Day = 'day';

    protected $dbName='score';//（要连接的数据库名称）
    protected $trueTableName = '';
    protected $connection = 'DB_CONFIG1';
    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

    protected $data_array = array();//统计一次成绩的数组

//    protected $_auto = array (
//
//        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
//    );

    //活跃用户量
    private function activeUserNum($score_table,$time_flag)
    {
        //活跃用户量
//        $dateInfo = getTimeBeginAndEnd($time_flag);
//        $begin_time = $dateInfo['begin_time'];
//        $end_time = $dateInfo['end_time'];
        $begin_time = getTimeBegin($time_flag);
        $end_time = NOW_TIME;

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

    //累计圈数
    private function sumCycles($score_table,$time_flag)
    {
        $begin_time = getTimeBegin($time_flag);
//        $end_time = NOW_TIME;

        $condition['add_time'] = array('gt',$begin_time);
        //$condition['add_time'] = array('lt',$end_time);

        $count = $this->table($score_table)->where($condition)->count();

        return $count;
    }

    //成绩列表
    public function _list($condition)
    {
//        $sql = 'db.z_score_34695.find( { "dept": { $exists: true } },{"add_time":true} )';
//        $res = $this->mongoCode($sql);
//
//        $condition = array();
//        $condition['dept'] = '美术系';
//        $condition['class'] = '信息一班';
//        $condition['user_id'] = '1';
        $res = $this->table('z_score_34695')->where($condition)->field('flag,user_id,name,studentId,sex,dept,grade,class,time,add_time')->select();

        //对成绩信息进行分组统计和排序
        $result = $this->scoreAccount($res);

        return $result;
    }

    //录入成绩
    public function insert($data,$rankInfo)
    {
        //更新用户表的累计长度
        $user = new UserModel();
        $sql = "update user set length=length+'{$data['length']}' WHERE user_id='{$data['user_id']}'";
        $user_res = $user->where(array('user_id'=>$data['user_id']))->field('sex,dept,grade,class,name,studentId')->find();
        $user->execute($sql);

        $data = array_merge($data,$user_res);

        $data['add_time'] = NOW_TIME;



//        var_dump($data);
//        exit();

        $b = $this->table($rankInfo['score_table'])->add($data);
        if(!$b){
            $this->error = '成绩导入失败';
            return false;
        }

        //累次查出一次成绩
        $condition['user_id'] = $data['user_id'];
        $condition['flag'] = $data['flag'];
        $scoreInfo = $this->table($rankInfo['score_table'])->where($condition)->field('time')->select();
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

        $count_week  = $this->activeUserNum($score_table,ScoreModel::Week);//当周活跃用户量

        $count_month  = $this->activeUserNum($score_table,ScoreModel::Month);//当月活跃用户量

        $count_week_cycles = $this->sumCycles($score_table,ScoreModel::Week);//

        $data['count_month'] = $count_month;
        $data['count_week'] = $count_week;
        $data['count_week_cycles'] = $count_week_cycles;

        return $data;
    }

    public function scoreAccount($res)
    {
        $result =   array();//先按user_id分组
        foreach($res as $k=>$v){
            $result[$v['user_id']][]    =   $v;
        }

        $data_group = array();//收集分组统计好的数据
        foreach($result as $k1=>$v1){
            $result2 =   array();//再按flag分组
            foreach($v1 as $k2=>$v2){
                $result2[$v2['flag']][]    =   $v2;
            }
            $data_group = array_merge($data_group,$result2);
        }

        $s = array();//把统计好的数据进行合并
        $sort = array();
        for($i=0,$len=count($data_group);$i<$len;$i++){
            $s[$i] = end($data_group[$i]);
            $s[$i]['cycles'] = count($data_group[$i]);
            $s[$i]['sum_time'] = 0;
            for($j=0,$lenj=count($data_group[$i]);$j<$lenj;$j++){
                $s[$i]['sum_time'] += $data_group[$i][$j]['time'];
            }
            $sort[$i] = $s[$i]['add_time'];
        }
        array_multisort($sort,SORT_DESC,$s);
        //        print_r($result);
//        echo "<pre>";
//        print_r($s);
//        echo "</pre>";
//        exit();

        return $s;

//        echo "<pre>";
//        print_r($result);
//        print_r($this->data_array);
//        print_r($s);
//        echo "</pre>";
//        exit();
//        return $res;
    }
}

