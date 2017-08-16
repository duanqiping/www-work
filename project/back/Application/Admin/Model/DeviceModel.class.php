<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 16:03
 */

namespace Admin\Model;


use Think\Model;

class DeviceModel extends Model{
    protected $tableName = 'device';

    //检查手环编码是否存在或被使用
    public function checkDeviceCode($code)
    {
        $res = $this->where(array('code'=>$code))->field('device_id,code,user_id')->find();
        if(!$res){
            $this->error = '编码不存在';
            return false;
        }else{
            if($res['user_id']>0){
                $this->error = '编码已经被使用';
                return false;
            }else{
                return $res['device_id'];
            }
        }
    }
} 