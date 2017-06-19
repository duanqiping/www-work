<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/14
 * Time: 15:26
 */
class TempAccountModel extends BaseModel
{
    public $tableName = 'ecs_temp_account';

    protected $fields = array('temp_account_id','temp_buyers_id','total','withdraw','cashout','bonus_money','_pk'=>'temp_account_id','_autoinc'=>'true');

    public function __construct($database_type)
    {
        parent::__construct();
        if ($database_type == 2)
        {
            $this->db(1, 'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_account';
        }
    }

    //获取单条信息
    public function getSingleInfo($condition,$field)
    {
        return $res=$this->table($this->tableName)->where($condition)->field($field)->find();
    }

    //创建一个用户账号
    public function addOne($user_id)
    {
        $accountdata = array(
            'temp_buyers_id' => $user_id,
            'total' => 0.00,
            'withdraw' => 0.00
        );
        $id = $this->table($this->tableName)->data($accountdata)->add();

        if(!$id)
        {
            $response = array("success"=>"false","error"=>array("msg"=>'创建账号失败','code'=>4907));
            $response = ch_json_encode($response);
            exit($response);
        }
        return $id;
    }

    /*
    if (余额>=订单的总金额){
        修改订单状态为已支付，支付方式为余额支付
        买家账户扣掉余额钱
        payment表插入一条数据type = 11支付方式为余额支付
        给卖家账户的缓冲区加上余额支付的钱
        返回支付成功
    }else{
      修改订单的字段扣的钱填上
      买家账户扣掉余额钱
      payment表插入一条数据 type = 11
      返回余额支付了多少钱，还需要支付多少钱完成订单
    }
    */
    //确认下单使用了余额支付
    public function payUseAccount($total_money)
    {
        $condition_account['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
        $res_account = $this->table($this->tableName)->where($condition_account)->field('total')->find();

        $data_account = array();//减去要准备去支付钱

        if($res_account['total'] >= $total_money)
        {
            $arr['state'] = 2;//余额够支付
            $arr['account_money'] = $total_money;
            $arr['difference_money'] = 0;//买家扣除余额实际要去支付的钱

            $data_account['total'] =$res_account['total']-$total_money;
        }else{
            $arr['state'] = 1;//余额不够支付
            $arr['account_money'] = $res_account['total'];
            $arr['difference_money'] = $total_money-$res_account['total'];//买家扣除余额实际要去支付的钱

            $data_account['total'] = '0.00';
        }
        $this->startTrans();//启动事务
        $b = $this->table($this->tableName)->where($condition_account)->save($data_account);


        
        if(!$b)
        {
            $this -> rollback();//失败 回滚
            $this->error_info = '扣除余额失败';
            $this->error_code = 4917;
            return false;
        }
        else
        {
            $time = time();
            $arr['finish_time'] = $time;
            $arr['pay_time'] = $time;
            $arr['method'] = 5;
            return $arr;
        }
    }
}
