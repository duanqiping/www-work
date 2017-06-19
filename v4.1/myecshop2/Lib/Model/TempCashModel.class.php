<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/18
 * Time: 13:04
 */
class TempCashModel extends BaseModel
{
    protected static $total_money = 0;
    protected static $num = 0;

    //获取红包列表
    public function getUserId($user_id, $limit, $page)
    {
        $offset = ($page - 1) * $limit;

        $sql = "select ca.cash_id id,ca.cash_sn sn,ca.cash_time time,IF(ca.cash_money>0,concat('+',ca.cash_money),ca.cash_money) money,bo.bonus_name name from ecs_temp_cash ca LEFT JOIN ecs_temp_bonus bo on ca.cash_bonus_id=bo.bonus_id WHERE ca.user_id='$user_id' AND ca.state=0 AND ca.cash_bonus_id<>8 ORDER BY ca.cash_time DESC limit $offset,$limit";
        $res= $this->query($sql);

        $condition['user_id'] = $user_id;
        $condition['state'] = 0;
        $condition['cash_bonus_id'] = array('neq',8);
        $this->total_money = $this->where($condition)->sum('cash_money');//计算总价
        $this->num = $this->where($condition)->count();

        if (!$res) {
            $arr['num'] = 0;
            $arr['total_money'] = 0;
            $arr['list'] = array();
            $response = array("success" => "true", "data" => $arr);
            $response = ch_json_encode($response);
            exit($response);
        }
        return $res;
    }

    //查询有无退换货
    public function getGoodsAdd($order_id)
    {
        $sql = "select count(*) as count_num,temp_purchase_id from ecs_temp_purchase_goods_add where temp_purchase_new_id=" . $order_id;
        $res = $this->query($sql);
        return $res[0];
    }
}