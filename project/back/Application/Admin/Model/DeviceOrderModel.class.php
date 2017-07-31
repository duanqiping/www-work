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
//        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
        array ('status', 1, self::MODEL_INSERT),//只能是当前模型的方法
    );

    //筛选条件 省份 城市 类型 客户
    public function selectCondition()
    {
        $selectConditon = array();

        $grade = $_SESSION['user']['grade'];
        $uid = $_SESSION['user']['id'];
        if($grade == 1){
            $selectConditon['province'] = '省份';
            $selectConditon['city'] = '城市';
            $selectConditon['type'] = '类型';
            $selectConditon['name'] = '跑道';
        }else if($grade == 2){
            $agent = new AgentModel();
            $agent_res = $agent->where(array('agent_id'=>$uid))->field('province')->find();

            $selectConditon['province'] = $agent_res['province'];
            $selectConditon['city'] = '城市';
            $selectConditon['type'] = '类型';
            $selectConditon['name'] = '跑道';
        }else{

            $customer = new CustomerModel();
            $customer_res = $customer->where(array('customer_id'=>$uid))->field('province,city,type,name')->find();

            $selectConditon['province'] = $customer_res['province'];
            $selectConditon['city'] = $customer_res['city'];
            $selectConditon['type'] = $customer_res['type']==1?'学校':'运动场';
            $selectConditon['name'] = $customer_res['name'];
        }

        return $selectConditon;
    }

    //系统后台 代理商 客户
    //工单列表 $status 1待处理 2处理中 3处理完成 4客户确认完成
    public function _list($status)
    {
        $grade = $_SESSION['user']['grade'];
        $uid = $_SESSION['user']['id'];

        $condition = array();

        if($grade == 3 || $grade == 4){
            $condition['customer_id'] = $uid;
        }else if($grade == 2){
            $condition['agent_id'] = $uid;
        }else{
        }

        if($status == 1){
            $condition['status'] = 1;
        }else if($status == 2){
            $condition['status'] = 2;
        }else if($status == 3){
            $condition['status'] = $status;
        }else{
        }
        $field = 'device_order_id id,order_sn,status,customer_name,customer_addr,desc,add_time,'.
            'ms_code,contact_name,contact_mobile,type,'.
            'agent_name,agent_mobile,accept_time,agent_desc';

        $order = 'add_time desc';

        $res = $this->where($condition)
            ->field($field)
            ->order($order)
            ->select();

//        echo $this->_sql();
//        exit();

        return $res;
    }

    //获取客户的填写信息
    public function getCustomerFillData()
    {
        $grade = $_SESSION['user']['grade'];

        if($grade == 3 || $grade == 4){
            $condition['customer_id'] = $_SESSION['user']['id'];
            $condition['status'] = array('in',array(1,2,3));
            $res = $this->where($condition)->field('ms_code,desc,contact_name,contact_mobile,type')->find();
            if(!$res) return array();
            else return $res;
        }else{
            return array();
        }
    }

    //生成工单
    public function insertData($data)
    {
        $uid = $_SESSION['user']['id'];

        //查询是否有处理中的工单 有则直接返回
        $map['customer_id'] = $uid;
        $map['status'] = array('in',array(1,2,3));
        $count = $this->where($map)->count();
        if($count > 0) return false;

        //查询客户信息
        $customer=  new CustomerModel();
        $condition_customer['customer_id'] = $uid;
        $res_customer = $customer->where($condition_customer)->field('customer_id,name,customer_addr')->find();

        $add_data = array(
            'order_sn' => get_order_sn($res_customer['customer_id']),
            'customer_id' => $res_customer['customer_id'],
            'customer_name' => $res_customer['name'],
            'customer_addr' => $res_customer['customer_addr'],

            'status' => 1,
            'add_time' => NOW_TIME,

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

        if($id = $this->add($add_data)){
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
} 