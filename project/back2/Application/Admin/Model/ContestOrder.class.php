<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 19:23
 */

namespace Admin\Model;


use Think\Model;

class ContestOrder extends Model{

    protected $tableName = 'contest_order';

    //赛事名单列表
    public function _list($condition)
    {
        $res = $this->where($condition)->field('*')->select();
        return $res;
    }

    //添加赛事学生名单
    public function addUser($ids){

        $user= new UserModel();
        $map['user_id'] = array('in',$ids);
        $addinfo = $user->where($map)->field("customer_id,user_id,name,studentId,sex,dept,grade,class,{$_SESSION['contest_sn']} as contest_sn")->select();

        //开启事物
        $this->startTrans();
        foreach($addinfo as $k=>$v){
            //先查询是否已经添加 customer_id contest_sn user_id
            $condition_s['customer_id'] = $v['customer_id'];
            $condition_s['contest_sn'] = $_SESSION['contest_sn'];
            $condition_s['user_id'] = $v['user_id'];
            $count = $this->where($condition_s)->count();
            if($count<1){
                $result = $this->add($v);
                if(!$result){
                    $this->rollback();
                    $this->error = '添加失败';
                    return false;
                }
            }
        }
        $this->commit();
        return true;
    }
} 