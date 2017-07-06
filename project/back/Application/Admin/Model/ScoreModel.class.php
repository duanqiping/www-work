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

    protected $connection = array(
        'db_type' => 'mongo',
        'db_user' => '',//用户名(没有留空)
        'db_pwd' => '',//密码（没有留空）
        'db_host' => '127.0.0.1',//数据库地址
        'db_port' => '27017',//数据库端口 默认27017
    );
    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

//    protected $_auto = array (
//
//        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
//    );

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
}

