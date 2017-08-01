<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 10:02
 */

namespace Admin\Model;


use Think\Model;

class ContestModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
        array ('is_audit', '1', self::MODEL_INSERT),
    );

    //赛事列表
    public function _list($type)
    {
        $condition['is_show'] = 1;

        if(!$type){
            $condition['customer_id'] = $_SESSION['user']['id'];
        }else{
            $condition['customer_id'] = $_SESSION['user']['id'];
            if($type == 'unfinished'){
                $condition['begin_time'] = array('gt',NOW_TIME);
            }else if($type == 'finished'){
                $condition['is_use'] = 1;
            }else{

            }
        }
        $res = $this->where($condition)
            ->field('contest_id,customer_id,contest_sn,title,desc,add_time,begin_time,end_time,length,from_name')
            ->order('add_time desc')
            ->select();

        return $res;
    }

    //生成赛事编码
    public function createContestSn()
    {
        $sn = random(8,0);
        $flag = true;
        while($flag){
            $count = $this->where(array('contest_sn'=>$sn))->count();
            if($count>0){
                $this->createContestSn();
            }else{
                $flag = false;
            }
        }
        return $sn;
    }
    //填充数据
    public function fillData($data)
    {
//        print_r($data);
//        exit();

        $data['customer_id'] = $_SESSION['user']['id'];
        $data['contest_sn'] = $this->createContestSn();

        $s = explode('-',$data['reservation-time']);
        unset($data['reservation-time']);

//        print_r($s);
//        exit();

//        $data['end_time'] = strtotime($data['end_time']);
//        $data['begin_time'] = strtotime($data['begin_time']);

        $data['begin_time'] = strtotime($s[0]);
        $data['end_time'] = strtotime($s[1]);


        $data['add_time'] = NOW_TIME;

        if($_SESSION['user']['grade'] == 3){
            $data['from_id'] = $_SESSION['user']['id'];
            $data['from_name'] = '学校管理员';
        }
        else{
            $data['from_id'] = $_SESSION['user']['id'];
            $data['from_name'] = $_SESSION['user']['id'];
        }

//        print_r($data);
//        exit();

        return $data;
    }

} 