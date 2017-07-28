<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 9:20
 */

namespace Admin\Model;


use Think\Model;

class DeviceMsModel extends Model{

    protected $tableName = 'device_ms';

    //添加设备
    public function addDeviceMs($data)
    {

    }

    //设备注册
    public function EaseRegister($account,$passwd)
    {
        $is_condition['ms_code'] = $account;
        $res = $this->where($is_condition)->field('next_ms_code,last_ms_code,last_expire_time,stay,is_register')->find();
        if(!$res){
            $this->error = '系统未录入该设备编码';
            return false;
        }
        if($res['is_register']==1){
            $this->error = '该编码已经被注册';
            return false;
        }

        $e = new Easemob();
        $result = $e->createUser($account,$passwd);//授权注册

        //这种情况 是为了处理机器软件重装等偶发情况
        if($result['error'] != 'duplicate_unique_property_exists'){
            $this->error = '注册失败';
            return false;
        }else{
            $this->where($is_condition)->setField('is_register',1);
        }
        unset($res['is_register']);
        return $res;
    }

    //设备列表
    public function _list()
    {
        $uid = $_SESSION['user']['id'];
        $grade  = $_SESSION['user']['grade'];
        $condition = array();

        if($grade == 3 || $grade == 4){
            $condition['customer_id'] = $uid;
        }else if($grade == 2){
            //筛选出 所有学校
            $customer = new CustomerModel();
            $customer_infos = $customer->where(array('agent_id'=>$uid))->field('customer_id,name')->select();
            $customer_ids = array();
            for($i=0,$len=count($customer_infos);$i<$len;$i++){
                $customer_ids[] = $customer_infos[$i]['customer_id'];
            }
            $condition['customer_id'] = array('in',$customer_ids);
        }

        $res = $this->where($condition)->field('device_ms_id,ms_code,next_ms_code,last_expire_time,customer_id,customer_name,add_time,status')->select();

        foreach($res as $k=>$v){
            $res[$k]['online'] = round((NOW_TIME-$v['add_time'])/3600,2);
        }

        return $res;
    }

    //获取设备信息
    public function getDeviceInfo($flag,$agent_id)
    {

        $condition['agent_id'] = $agent_id;
        if($flag == 'all'){//所有设备

        }else if($flag == 'bad'){//损坏的设备
            $condition['status'] = 0;
        }else{//正常设备
            $condition['status'] = 1;
        }

        $res = $this->where($condition)->field('device_ms_id,ms_code,agent_id,customer_id,detail')->select();
        if(!$res) return array();
        return $res;
    }
} 