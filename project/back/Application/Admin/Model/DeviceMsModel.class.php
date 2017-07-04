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