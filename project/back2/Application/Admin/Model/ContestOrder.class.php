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
    public function _list()
    {
        $res = $this->field('*')->select();
        return $res;
    }

    //添加赛事学生名单
    public function addUser($ids){

        $user= new UserModel();
        $map['user_id'] = array('in',$ids);
        $addinfo = $user->where($map)->field("customer_id,user_id,name,studentId,sex,dept,grade,class,{$_SESSION['contest_sn']} as contest_sn")->select();

//        print_r($addinfo);
        foreach($addinfo as $k=>$v){
            $result = $this->add($v);
            if(!$result){
                $this->error = '添加失败';
                return false;
            }
        }
        return true;
//        $result  = $this->addAll($addinfo);
//        echo $this->_sql();
//        exit();
//        if($result){
//            return true;
//        }else{
//            return false;
//        }
    }
} 