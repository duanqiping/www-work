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

    //获取客户的填写信息
    public function getCustomerFillData()
    {
        $condition['customer_id'] = $_SESSION['user']['id'];
        $condition['status'] = array('in',array(2,3,4));
        $res = $this->where(array())->field('ms_code,desc,contact_name,contact_mobile,type')->find();
        if(!$res) return array();
        else return $res;
    }

    //生成工单
    public function insertData($data)
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

            'desc' => $data['desc'],
            'ms_code' => $data['ms_code'],
            'contact_name' => $data['contact_name'],
            'contact_mobile' => $data['mobile'],
            'type' => $data['type'],
        );
//        print_r($add_data);
//        $this->add($add_data);
//        echo $this->_sql();
//        exit();

        if($this->create($add_data)){
            $id = $this->add();
            return $id;
        }else{
            return false;
        }

    }

    //更新工单为处理中
    public function updateData($data)
    {
        $agent = new AgentModel();
        $condition['agent_id'] = $_SESSION['user']['id'];
        $agent_data = $agent->where($condition)->field('agent_id,name,agent_mobile')->find();
//        echo $agent->_sql();
//
//        print_r($agent_data);
//        print_r($_SESSION);
        $update_data = array(
            'agent_id'=>$agent_data['agent_id'],
            'agent_name'=>$agent_data['name'],
            'agent_mobile'=>$agent_data['agent_mobile'],
            'accept_time'=>NOW_TIME,
            'agent_desc'=>$data['desc'],
            'status'=>2,
        );

        $condition_device['device_order_id']=$data['id'];
        $b = $this->where($condition_device)->save($update_data);
//        echo $this->_sql();
//        exit();
        if(!$b){
            return false;
        }else{
            return true;
        }

        exit();
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

    //工单列表 $type=1 待处理 2处理中 3处理完成 4客户确认完成
    public function _list($type)
    {
        if($type == 1){
            $condition['status'] = 1;
            $field = 'device_order_id id,order_sn,status,customer_name,customer_mobile,customer_addr,customer_desc,add_time';
            $order = 'add_time desc';
        }else if($type == 2){
            $condition['status'] = 2;
            $field = 'device_order_id id,order_sn,status,customer_name,customer_mobile,customer_addr,customer_desc,add_time,'.
                'agent_name,agent_mobile,accept_time,agent_desc';
            $order = 'accept_time desc';
        }else if($type == 3){
            $field = '';
            $order = '';
        }else{
            $field = '';
            $order = '';
        }
        $condition['status'] = $type;
        $res = $this->where($condition)
            ->field($field)
            ->order($order)
            ->select();
//        echo $this->_sql();
//        print_r($res);
//        exit();
        return $res;
    }
} 