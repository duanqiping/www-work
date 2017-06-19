<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/11/30
 * Time: 9:49
 */

namespace Index\Model;


use Common\Model\BaseModel;

class VipModel extends BaseModel
{
    //创建vip账号
    public function CreateVipAccount($user_id,$product_flag_id,$price_id)
    {
        $res_vip = $this->where(array('user_id'=>$user_id,'product_flag_id'=>$product_flag_id))->field('vip_id,end_time')->find();

        //查出延续多少天
        $sql_price = "select time from va_price WHERE price_id='$price_id'";
        $res_price = $this->query($sql_price);
        if($res_vip)
        {
            //end_time > now_time (会员还没过期, 属于延续会员)
            if($res_vip['end_time']>NOW_TIME)
            {
                $time = $res_vip['end_time']+$res_price[0]['time']*24*3600;
            }
            else
            {
                $time = NOW_TIME+$res_price[0]['time']*24*3600;
            }
            $sql = "UPDATE va_vip SET end_time='$time',isvip=isvip+1 WHERE vip_id = '{$res_vip['vip_id']}'";
            $b1 = $this->execute($sql);
            if($b1) return true;
            else return false;
        }
        else
        {
            $time = NOW_TIME+$res_price[0]['time']*24*3600;
            $data = array(
                'user_id'=>$user_id,
                'product_flag_id'=>$product_flag_id,
                'isvip'=>0,
                'end_time'=>$time,
                'insert_time'=>date('Y-m-d H:m:s',NOW_TIME),
            );
            $b2 = $this->add($data);
            if($b2) return true;
            else return false;
        }
    }
}