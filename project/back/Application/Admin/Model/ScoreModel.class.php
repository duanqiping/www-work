<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 17:27
 */

namespace Admin\Model;


use Think\Model;

//成绩表
class ScoreModel extends Model{

    protected $_auto = array (

        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
    );

    //录入成绩
    public function insert($data)
    {
        $customerModel = M('customer');
        $res = $customerModel
            ->where(array('customer_id'=>$data['customer_id']))
            ->field('score_table,rank_y_table,rank_m_table,rank_w_table')
            ->find();
        if($this->create()) {
            $b = $this->table($res['score_table'])->add($data);
            if(!$b) return false;
            //排行表插入条件：1没有该用户记录 2圈数不一样 3不在当年当周范围内
            unset($res['score_table']);
            $data['score_id'] = $b;
            $rankModel = new RankModel();
            $rankModel->dealWithSolve($res,$data);
            return true;
        }else{
            return false;
        }
    }
}

