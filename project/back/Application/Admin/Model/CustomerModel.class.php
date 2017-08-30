<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:05
 */

namespace Admin\Model;


class CustomerModel extends ConsumerHandleModel
{
    protected $tableName = 'customer';

    protected $custom_fields = 'customer_id id,name,passwd,account,grade';

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
    );

    //首页信息
    //$grade 1系统 2代理商 3客户 4老师
    public  function homeInfo($uid,$customer_id,$grade)
    {
        $data = array();

        $data_user = $this->mainInfo($uid,$customer_id,$grade);//用户量 累计最长距离

        $score = new ScoreModel();
        $data_score = $score->UserInfo($uid,$customer_id,$grade);//当周活跃量 当月活跃量

        $rank = new RanKMongoModel();
        $best_res = $rank->bestScore($uid,$customer_id,$grade);//单圈最佳成绩(前5名)

        $recordMessage = new RecordMessageModel();
        $record_message = $recordMessage->getRecordMessage($customer_id);////获取破记录的 前5条消息

        $data = array_merge($data,$data_user,$data_score);
        $data['best_single'] = $best_res;
        $data['record_message'] = $record_message;

        return $data;
    }

    //获取客户信息
    public function getList()
    {
        $condition['is_show'] = 1;
        $info = $this->where($condition)
            ->field('customer_id,account,name,agent_id,customer_addr,score_table,description,last_login_time,last_login_ip')
            ->order('agent_id desc')
            ->select();
        return  $info ;
    }

    //完善数据
    public function makeData($data)
    {
        //生成自己的code
        $flag = 0;
        $code = "";
        while ($flag == 0) {
            $code = random(5, 0);
            $count = $this->where(array('code'=>$code))->count();
            if ($count == 0)//生成的编码没有被使用
            {
                $flag = 1;
            }
        }
        $data['code'] = $code;
        $data['score_table'] =  $score_table= 'z_score_'.$code;
        $data['rank_y_table'] =  $rank_y_table= 'z_rank_y_'.$code;
        $data['rank_m_table'] =  $rank_m_table= 'z_rank_m_'.$code;
        $data['rank_w_table'] =  $rank_w_table= 'z_rank_w_'.$code;
        return $data;
    }

    //客户概述信息
    public function mainInfo($uid,$customer_id,$grade)
    {
        $data = array();

        $condition = array();

        $user = new UserModel();

        $sql_device = '';//手环sql
        $sql_device_ms = '';//主机数量sql

        //客户、老师
        if($grade == 3 || $grade == 4){
            $condition['customer_id'] = $customer_id;
        }else if($grade == 2){
            //筛选出 所有学校
            $customer_infos = $this->where(array('agent_id'=>$uid))->field('customer_id')->select();
            $customer_ids = array();
            for($i=0,$len=count($customer_infos);$i<$len;$i++){
                $customer_ids[] = $customer_infos[$i]['customer_id'];
            }
            $condition['customer_id'] = array('in',$customer_ids);

            $sql_device = "select count(*) as count from device WHERE agent_id='$uid'";
            $sql_device_ms = "select count(*) as count from device_ms WHERE agent_id='$uid'";
        }else if($grade == 1){
            $condition['customer_id'] = true;

            $sql_device = "select count(*) as count from device";
            $sql_device_ms = "select count(*) as count from device_ms";
        }

        //用户量
        $count = $user->where($condition)->count();

        //所有用户总公里数
        $sum_length = $user->where($condition)->sum('length');

        $data['user_count'] = $count;
        $data['sum_length'] = round($sum_length/1000,2);

        if($sql_device){
            $res_device = $this->query($sql_device);
            $res_device_ms = $this->query($sql_device_ms);
            $count_device = $res_device[0]['count'];//手环数量
            $count_device_ms = $res_device_ms[0]['count'];//主机数量

            $data['count_device'] = $count_device;
            $data['count_device_ms'] = $count_device_ms;
        }


        return $data;
    }

    //删除一个客户及其关联表
    public function deleteCustomerInfo($customer_id)
    {
        $condition['customer_id'] = $customer_id;


        $res = $this->where($condition)->field('score_table,rank_y_table,rank_m_table,rank_w_table')->find();

        foreach($res as $v){
            $sql = "DROP TABLE IF EXISTS $v";
            $b = $this->execute($sql);
        }

//        $b = $this->where('customer_id=25')->delete();
        $sql = "delete from customer WHERE customer_id='$customer_id'";
        $b = $this->execute($sql);
        if(!$b){
            exit('服务器错误1');
        }
//        echo $this->_sql();
//        print_r($res);
        return true;
    }
}