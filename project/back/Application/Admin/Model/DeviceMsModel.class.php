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

    //查询设备的条件
    public function condition($getData)
    {
        $conditon = array();

        //从侧栏中点击进入
        if(!$getData)
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
        }
        else{
            //获取代理商id
            if($getData['city']){
                $agent = new AgentModel();
                $agent_res = $agent->where(array('city'=>$getData['city']))->field('agent_id')->find();
                $conditon['agent_id'] = $agent_res['agent_id'];
            }
            //获取类型
            if($type = $getData['type']){
                if($type == '学校') $conditon['type'] = 1;
                else $conditon['type'] = 2;
            }
            //获取客户id
            if($getData['name']){
                $customer = new CustomerModel();
                $customer_res = $customer->where(array('name'=>$getData['name']))->field('customer_id')->find();
                $conditon['customer_id'] = $customer_res['customer_id'];
            }
        }

        return $conditon;
    }

    //获取客户id
    public function getCustomerId($customer_name)
    {
        if($_SESSION['user']['grade'] == 3){
            return $_SESSION['user']['id'];
        }else{
            $customer = new CustomerModel();
            $customer_res = $customer->where(array('name'=>$customer_name))->field('customer_id')->find();
            if(!$customer_res) return '';
            else return $customer_res['customer_id'];
        }
    }


    //添加设备
    public function addDeviceMs($data)
    {

    }

    //设备注册
    public function EaseRegister($account,$passwd)
    {
        $is_condition['ms_code'] = $account;
        $res = $this->where($is_condition)->field('next_ms_code,last_ms_code,last_expire_time,stay,customer_id,isPoint,is_register')->find();
        if(!$res){
            $this->error = '系统未录入该设备编码';
            return false;
        }
        if($res['is_register']==1){
            //测试阶段 先注释掉这段代码
//            $this->error = '该编码已经被注册';
//            return false;
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

        //获取起点 编码
        $start_condition['customer_id'] = $res['customer_id'];
        $start_condition['isPoint'] = 1;
        $res_start = $this->where($start_condition)->field('ms_code')->find();

        $res['start_ms_code'] = $res_start['ms_code'];
        unset($res['is_register']);
        return $res;
    }

    //设备列表
    public function _list($condition)
    {
        $res = $this->where($condition)
            ->field('device_ms_id,ms_code,next_ms_code,last_expire_time,customer_id,customer_name,add_time,is_register,isPoint,status')
            ->select();

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