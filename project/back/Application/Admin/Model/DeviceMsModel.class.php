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

    //
    public function _list()
    {
        $condition['customer_id'] = $_SESSION['user']['id'];
        $res = $this->where($condition)->field('device_ms_id,ms_code,next_ms_code,last_expire_time,customer_id,add_time,status')->select();
        foreach($res as $k=>$v){
//            $res[$k]['online'] =
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