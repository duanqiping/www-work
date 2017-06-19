<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/27
 * Time: 10:43
 */
class TempPaymentModel extends BaseModel
{
    public $tableName = 'ecs_temp_payment';

    protected $fields = array('temp_payment_id','temp_purchase_sn','time','from_user','to_user','from_account','to_account','method','type','admin_id','user_id','money','pay_from','client_from','edit_time','_pk'=>'temp_payment_id','autoinc'=>true);

    public function __construct($database_type)
    {
        parent::__construct();
        if ($database_type == 2)
        {
            $this->db(1, 'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_payment';
        }
    }

    //获取单条信息
    public function getSingleInfo($condition,$field)
    {
        return $res=$this->table($this->tableName)->where($condition)->field($field)->find();
    }
    //获取多条信息
    public function getMultipleInfo($condition,$field)
    {
        return $res=$this->where($condition)->field($field)->select();
    }

    //收支明细
    public function paymentDetails($page, $limit, $type, $uid)
    {
        
        $offset = ($page - 1) * $limit;

        //钱包明细只显示：余额付款 和 部分余额退款
        if ($type == 1) {//收入...........................
            //注意：第一个退款是state=7的退款   第二个是取消订单的退款state=0  这里退款 type=11和12 （11对应的是state=7   12对应的是state=0）
            $sql = "SELECT name_id,id,time,sn,name,money FROM ( (SELECT '名字id' as name_id,order_id id,add_time time,order_sn sn,'充值' AS name,concat('+',order_amount) money FROM ecs_temp_cash_order WHERE user_id ='{$uid}' AND order_status=1 ) UNION ALL(SELECT ca.cash_bonus_id name_id, ca.cash_id id, ca.cash_time time, ca.cash_sn sn,bo.bonus_name name, concat('+',ca.cash_money) money FROM ecs_temp_cash ca JOIN ecs_temp_bonus bo on ca.cash_bonus_id=bo.bonus_id WHERE ca.user_id ='{$uid}' AND ca.state=0) UNION ALL (SELECT '名字id' as name_id, temp_purchase_id id, time time,temp_purchase_sn sn,'退款' AS name,concat('+',account_money) money FROM ecs_temp_purchase AS tp WHERE buyers_id = '{$uid}' AND tp.state=7 AND method IN (0,5,6) and is_delete=0 AND EXISTS (SELECT temp_purchase_sn  FROM ecs_temp_payment AS p WHERE p.temp_purchase_sn = tp.temp_purchase_sn AND type=11)) UNION ALL (SELECT '名字id' as name_id, temp_payment_id id, edit_time time,temp_purchase_sn sn,'退款' AS name,concat('+',money) money FROM ecs_temp_payment AS p WHERE  p.type=12 AND EXISTS (SELECT temp_purchase_sn  FROM ecs_temp_purchase AS tp WHERE tp.method IN (0,5,6) and buyers_id='{$uid}' AND p.temp_purchase_sn = tp.temp_purchase_sn AND tp.state=0 and is_delete=0) )) As tmp  ORDER BY time DESC limit " . $offset . "," . $limit;

        } else if ($type == 2) {//支出  两只情况 1.纯余额支付 2.部分余额支付   method=0支付宝  5余额支付   6微信支付

            $sql = "SELECT * FROM ( (SELECT '名字id' as name_id, temp_purchase_id id, time,temp_purchase_sn sn,'余额支付' AS name,concat('-',account_money) money FROM ecs_temp_purchase AS tp WHERE  tp.method=5 and buyers_id='$uid' and is_delete=0 AND account_money>0) UNION ALL (SELECT '名字id' as name_id, temp_payment_id id, time time,temp_purchase_sn sn,'余额支付' AS name,concat('-',money) money FROM ecs_temp_payment AS p WHERE  p.type IN (11,12) AND EXISTS (SELECT temp_purchase_sn  FROM ecs_temp_purchase AS tp WHERE tp.method IN (0,6) and is_delete=0  and buyers_id='$uid' AND p.temp_purchase_sn = tp.temp_purchase_sn ) ) ) As tmp  ORDER BY time DESC limit " . $offset . "," . $limit;

            //全部
        } else {
            $sql = "SELECT * FROM ( (SELECT '名字id' as name_id,order_id id,add_time time,order_sn sn,'充值' AS name,concat('+',order_amount) money FROM ecs_temp_cash_order WHERE user_id ='{$uid}' AND order_status=1 ) UNION ALL( SELECT ca.cash_bonus_id name_id, ca.cash_id id, ca.cash_time time, ca.cash_sn sn,bo.bonus_name name, concat('+',ca.cash_money) money FROM ecs_temp_cash ca JOIN ecs_temp_bonus bo on ca.cash_bonus_id=bo.bonus_id WHERE ca.user_id ='{$uid}' AND ca.state=0 ) UNION ALL (SELECT '名字id' as name_id, temp_purchase_id id, time time,temp_purchase_sn sn,'退款' AS name,concat('+',account_money) money FROM ecs_temp_purchase AS tp WHERE buyers_id = '{$uid}' AND tp.state=7 AND method IN (0,5,6) and is_delete=0 AND EXISTS (SELECT temp_purchase_sn  FROM ecs_temp_payment AS p WHERE p.temp_purchase_sn = tp.temp_purchase_sn AND type=11)) UNION ALL (SELECT '名字id' as name_id, temp_payment_id id, edit_time time,temp_purchase_sn sn,'退款' AS name,concat('+',money) money FROM ecs_temp_payment AS p WHERE  p.type=12 AND EXISTS (SELECT temp_purchase_sn  FROM ecs_temp_purchase AS tp WHERE tp.method IN (0,5,6) and is_delete=0 and buyers_id='{$uid}' AND p.temp_purchase_sn = tp.temp_purchase_sn AND tp.state=0) ) UNION ALL (SELECT '名字id' as name_id, temp_purchase_id id, time,temp_purchase_sn sn,'余额支付' AS name,concat('-',account_money) money FROM ecs_temp_purchase AS tp WHERE  tp.method=5 and is_delete=0 and buyers_id='$uid' AND account_money>0) UNION ALL (SELECT '名字id' as name_id, temp_payment_id id, time time,temp_purchase_sn sn,'余额支付' AS name,concat('-',money) money FROM ecs_temp_payment AS p WHERE  p.type IN (11,12) AND EXISTS (SELECT temp_purchase_sn  FROM ecs_temp_purchase AS tp WHERE tp.method IN (0,6) and is_delete=0  and buyers_id='$uid' AND p.temp_purchase_sn = tp.temp_purchase_sn ) )) As tmp  ORDER BY time DESC limit " . $offset . "," . $limit;
        }

        $arr = $this->query($sql);

        if(!$arr) return array();

        for ($i = 0,$len=count($arr); $i < $len; $i++)//这段逻辑判断红包类型 然后删除没用的字段name_id
        {
            if(!$arr[$i]['name'])  $arr[$i]['name']='红包';
            $arr[$i]['money'] = preg_replace('/\+\-/i','-',$arr[$i]['money']);//+ - 要进行转义
        }
        return $arr;

    }

    //买家确认收货，把账户缓存的钱转卖家账户余额里
    public function toSuppliersAccount($money, $uid, $account_money = 0)
    {
        $this->startTrans();
        $withdraw = $money - $account_money;

        $b1 = 1;//处理用纯余额支付问题
        if($withdraw>0)
        {
            $sql = "update ecs_temp_account set withdraw = withdraw - '{$withdraw}' where temp_buyers_id =" . $uid;
            $b1 = $this->execute($sql);
        }

//        $sql2 = "update ecs_temp_account set total = total + '{$money}' where temp_buyers_id =" . $uid;
//        $b2 = $this->execute($sql2);

        if ($b1) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }
    }

    //买家确认收货，把账户缓存的钱转卖家账户余额里
    public function toSuppliersAccount2($money, $uid, $withdraw_rate,$rate)
    {
        $this->startTrans();

        $money = round($money * $withdraw_rate/$rate,2);
        $sql = "update b2b_pcy_account set withdraw = withdraw - '{$money}' where suppliers_id =" . $uid;
        $sql2 = "update b2b_pcy_account set total = total + '{$money}' where suppliers_id =" . $uid;
        $b1 = $this->execute($sql);
        $b2 = $this->execute($sql2);

        if ($b1 && $b2) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }
    }

    //确认收货，给邀请人红包
    public function bonusforinvitation($order_id, $order_sn, $user_mobile, $user_id, $bonus_money, $bonus_id)
    {
        $this->startTrans();
        //在payment 给此订单，邀请人加上type=10红包亏损纪录
        $sql1 = 'insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,to_account,type,user_id,money,client_from) values (\'' . "{$order_sn}" . '\',\'' . time() . '\',\'' . "{$user_mobile}" . '\',\'品材网支付\',\'hbz@pcw268.com\',10,\'' . $user_id . '\',\'' . "{$bonus_money}" . '\',1)';
        //给邀请人在用户红包表加一条红包记录
        $sql2 = 'insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,state,cash_time,purchase_id,cash_money) values (' . $bonus_id . ',\'' . $this->get_bonus_sn() . '\',' . $user_id . ',0,' . time() . ',\'' . "{$order_id}" . '\',' . "{$bonus_money}" . ')';
        //在邀请人账户TOTAL加上红包，红包记录字段累加红包
        $sql3 = "update ecs_temp_account set total = total + '{$bonus_money}', bonus_money = bonus_money+'{$bonus_money}' where temp_buyers_id =" . $user_id;

        $b1 = $this->execute($sql1);
        $b2 = $this->execute($sql2);
        $b3 = $this->execute($sql3);

        if ($b1 && $b2 && $b3) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }

    }

    //在payment把原来的订单入账信息修改为一条退款信息，type=3，同时在卖家count里的缓存减去这笔钱，在买家的count账户的缓存加上这笔钱， 在acount插入一条数据,事务
    public function refund($suppliers_id, $buyers_id, $purchase_sn, $money,$database_type)
    {

        $this->startTrans();

        if($database_type == 1)
        {
            $sql = "update ecs_temp_payment set type = 3 where user_id ='{$suppliers_id}' and temp_purchase_sn ='{$purchase_sn}'";
            //从卖家账户减去这笔订单钱
            $sql2 = "update ecs_temp_account set withdraw = withdraw - '{$money}' where temp_buyers_id ='{$suppliers_id}'";
            //给买家加上这笔定单钱
            $sql3 = "update ecs_temp_account set withdraw = withdraw + '{$money}' where temp_buyers_id ='{$buyers_id}'";
        }
        else
        {
            $sql = "update b2b_pcy_payment set type = 3 where user_id ='{$suppliers_id}' and temp_purchase_sn ='{$purchase_sn}'";
            //从卖家账户减去这笔订单钱
            $sql2 = "update b2b_pcy_account set withdraw = withdraw - '{$money}' where temp_buyers_id ='{$suppliers_id}'";
            //给买家加上这笔定单钱
            $sql3 = "update b2b_pcy_account set withdraw = withdraw + '{$money}' where temp_buyers_id ='{$buyers_id}'";
        }

        $b1 = $this->execute($sql);
        $b2 = $this->execute($sql2);
        $b3 = $this->execute($sql3);

        if ($b1 && $b2 && $b3) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }

    }

    //微信分享 返红包
    public  function FenXiongHongBao($firstRow,$uid,$cash_back)
    {
        //判品材宝用户是否有账户在acount
        $sql_count = "select count(*) as count from pcwb2bs.b2b_pcy_account WHERE temp_buyers_id='$uid'";
        $res_count = $this->query($sql_count);

        if ($res_count[0]['count'] < 1)
        {
            //说明没有账户，就帮创建
            $sql_user = "select user_id,telephone from pcwb2bs.b2b_user WHERE temp_buyers_id='$uid'";
            $res_user = $this->query($sql_user);
            $suppliers_id = $res_user[0]['user_id'];
            $sql_insert = "insert into pcwb2bs.b2b_pcy_account (temp_buyers_id,suppliers_id,total,withdraw) VALUES ('$uid','$suppliers_id','0.00','0.00')";
            $b = $this->execute($sql_insert);
            if(!$b) return false;
        }

        //微信分享 给品材宝用户返红包
        if ($cash_back && $firstRow['share_is_gen'] == 1)
        {
            //有红包
            //查有没有给邀请人加过红包，在payment表查下订单
            $sql_payment = "select type from pcwb2bs.b2b_pcy_payment where temp_purchase_sn = '{$firstRow['temp_purchase_sn']}'";
            $paymentinfo = $this->query($sql_payment);

            for ($i = 0,$len=count($paymentinfo); $i < $len; $i++) {
                if ($paymentinfo[$i]['type'] == 10) {
                    return true;//已经发过红包
                }
            }

            $hongbao = round($cash_back*$firstRow['money'],2);
            if($hongbao > 0)
            {
                if (!$this->bonusforinvitationNew($firstRow['temp_purchase_id'], $firstRow['temp_purchase_sn'],$_SESSION['temp_buyers_mobile'], $uid,  $hongbao, 1,$firstRow['suppliers_id']))
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
            else
            {
                return true;
            }

        }

        return true;
    }

    //确认收货，给邀请人红包
    private  function bonusforinvitationNew($order_id, $order_sn, $user_mobile, $user_id, $bonus_money, $bonus_id,$suppliers_id)
    {
        $this->startTrans();
        //在payment 给此订单，邀请人加上type=10红包亏损纪录
        $sql1 = 'insert into pcwb2bs.b2b_pcy_payment (temp_purchase_sn,time,from_user,to_user,to_account,type,user_id,money,client_from) values (\'' . "{$order_sn}" . '\',\'' . time() . '\',\'' . "{$user_mobile}" . '\',\'品材网支付\',\'hbz@pcw268.com\',10,\'' . $user_id . '\',\'' . "{$bonus_money}" . '\',1)';
        //给邀请人在用户红包表加一条红包记录
        $sql2 = "insert into pcwb2bs.b2b_pcy_temp_cash (cash_bonus_id,cash_sn,user_id,state,cash_time,purchase_id,cash_money) values ('$bonus_id', ".get_cash_sn($user_id).",'$suppliers_id',1,".time().",'$order_id','$bonus_money')";
        //在邀请人账户TOTAL加上红包，红包记录字段累加红包
        $sql3 = "update pcwb2bs.b2b_pcy_account set total = total + '{$bonus_money}', bonus_money = bonus_money+'{$bonus_money}' where temp_buyers_id =" . $user_id;

        $rc1 = $this->execute($sql1);
        $rc2 = $this->execute($sql2);
        $rc3 = $this->execute($sql3);

        if ($rc1 && $rc2 && $rc3) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }

    }
}