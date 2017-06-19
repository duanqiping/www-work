<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/4/6
 * Time: 17:34
 */
class TempBonusModel extends Model
{
    protected $fields = array('bonus_id','bonus_name','bonus_money','send_type','cash_back','min_amount','max_amount','send_start_date','send_end_date','use_start_date','use_end_date','comment','bonus_status','add_time','min_goods_amount');

    public function look_bonus($id,$type){
        // $sql='select * from ecs_temp_bonus where send_type = '.$type.' and goods_area_id ='.$id;
        $sql='select * from ecs_temp_bonus where send_type = '.$type.' and bonus_status = 0 and use_start_date<\''.time().'\' and use_end_date>\''.time().'\' and goods_area_id ='.$id;
        $res = $this->query($sql);
        return $res[0];
    }

    //订单支付完成,判断是否给下单返现红包
    public function return_cash($money,$order_id)
    {
        $sql_order = "select area_id from ecs_temp_purchase_goods WHERE temp_purchase_id='$order_id'";
        $res = $this->query($sql_order);
        $area_id = $res[0]['area_id'];

        date_default_timezone_set('prc');
        $time = time();
        $sqlbonus="select cash_back,bonus_id from ecs_temp_bonus where bonus_status=0 AND goods_area_id='$area_id' and send_type=3 AND min_money<='$money' and use_start_date<='$time' and use_end_date>='$time'";

        if($result = $this->query($sqlbonus))
        {
            $cash_money = $money*$result[0]['cash_back'];

            $user_id = $_SESSION['temp_buyers_id'];
            $current_date = date('ymdHis',$time);
            $cash_sn=$current_date.substr(microtime(),2,4).rand(100000,999999);
            $sqlinscash="insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,cash_time,cash_money) values ('{$result[0]['bonus_id']}','$cash_sn','$user_id','$time','$cash_money')";
            $sqlaccount = "update ecs_temp_account set total=total+'$cash_money' WHERE temp_buyers_id='$user_id'";
            $b1 = $this->execute($sqlinscash);
            $b2 = $this->execute($sqlaccount);
            if(!$b1 || !$b2)
            {
                $this->rollback();
                exit('{"success":"false","error":{"msg":"返现失败","code":"4917"}}');
            }
            $this->commit();
            return true;
        }
        return true;

    }
}