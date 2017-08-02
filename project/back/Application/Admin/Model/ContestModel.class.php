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

    //按钮操作 type:edit编辑 delete删除
    public function clickOperate($getInfo)
    {
        if(!$getInfo) return true;

        $type = $getInfo['type'];
        if($type == 'edit'){
            $contest_sn = $getInfo['contest_sn'];
            $res = $this->where(array('contest_sn'=>$contest_sn))
                ->field('contest_sn,title,length_male,length_female,pass_score_male,pass_score_female,desc,begin_time,end_time')
                ->find();
            if($res){
                $res['reservation-time'] = date('d-m-Y:H:i:s',$res['begin_time']).'-'.date('d-m-Y:H:i:s',$res['end_time']);
                unset($res['begin_time']);
                unset($res['end_time']);
                return $res;
            }else{
                $this->error = '未查到该赛事信息';
                return false;
            }
        }else if($type == 'delete'){
            $contest_sn = $getInfo['contest_sn'];
            $b = $this->where(array('contest_sn'=>$contest_sn))->delete();
            if($b){
                return true;
            }else{
                $this->error = '服务器错误';
                return false;
            }
        }
    }

    //正在进行 冲突中 即将开始的考试
    public function contestSelect()
    {

    }


    //获取赛事列表
    public function getContestInfo()
    {
        $condition['is_show'] = 1;
        $condition['customer_id'] = $_SESSION['user']['id'];

        $res = $this->where($condition)
            ->field('contest_sn,title,add_time')
            ->order('add_time desc')
            ->select();

        return $res;
    }


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
        $data['customer_id'] = $_SESSION['user']['id'];
        $data['contest_sn'] = $this->createContestSn();

        $s = explode('-',$data['reservation-time']);
        unset($data['reservation-time']);

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
        return $data;
    }

} 