<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/12
 * Time: 13:45
 */

namespace Admin\Model;


use Think\Model;

class DeviceOrderModel extends Model{

    protected $tableName = 'device_order';

    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
        array ('status', 1, self::MODEL_INSERT),//只能是当前模型的方法
    );

    //生成工单
    public function insertData($desc)
    {
        //查询客户信息
        $customer=  new CustomerModel();
        $condition_customer['customer_id'] = $_SESSION['user']['id'];
        $res_customer = $customer->where($condition_customer)->field('customer_id,name,customer_addr,customer_mobile')->find();

        $add_data = array(
            'order_sn' => get_order_sn($res_customer['customer_id']),
            'customer_id' => $res_customer['customer_id'],
            'customer_name' => $res_customer['name'],
            'customer_mobile' => $res_customer['customer_mobile'],
            'customer_addr' => $res_customer['customer_addr'],
            'customer_desc' => $desc,
        );

        if($this->create($add_data)){
            $id = $this->add();
            return $id;
        }else{
            return false;
        }

    }

    //查看是否有待处理或处理中的工单
    public function searchOrderSn()
    {
        $condition['customer_id'] = $_SESSION['user']['id'];
        $condition['status'] = array('in',array('1','2'));

        $res = $this->where($condition)->field('status,device_order_id')->order('add_time desc')->limit(1)->select();
        $res = $res[0];
        if(!$res){
            return $res = array('info'=>'设备运行正常');
        }else{
            if($res['status'] == 1){
               $res['info'] = '设备故障待处理';
            }
            else if($res['status'] == 2){
                $res['info'] = '设备故障正在处理';
            }
            else{
                $res = array('info'=>'设备运行正常');
            }
            return $res;
        }
    }

    //工单列表 $type=1 待处理 2处理中 3处理完成
    public function _list($type)
    {
        $condition['status'] = $type;
        $res = $this->where($condition)
            ->field('device_order_id id,order_sn,status,customer_name,customer_mobile,customer_addr,customer_desc,add_time')
            ->order('add_time desc')
            ->select();
//        echo $this->_sql();
//        print_r($res);
//        exit();
        return $res;
    }
} 