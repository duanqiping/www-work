<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/11/9
 * Time: 10:44
 */

namespace Index\Model;
use Common\Model\Aes\AesModel;
use Common\Model\BaseModel;

/** 用户表model*/
class UserModel extends BaseModel
{
    public function getSingleInfo($condition,$fields)
    {
        return $this->where($condition)->field($fields)->find();
    }

    //用户注册
    public function reg($data)
    {
        if($this->getSingleInfo(array('phone'=>$data['phone']),'user_id'))  {
            return false;
        }
        $data['insert_time'] = date('Y-m-d H:i:s',NOW_TIME);
        $data['user_name'] = $data['phone'];
        $data['usertype'] = 9;
        $data['password'] = md5($data['password']);

        $b = $this->add($data);

        if(!$b)  return false;
        else return true;
    }

    //判断是否是vip用户
    public function vipInfo($data)
    {
        $now_time = NOW_TIME;
        $sql = "select vip_id,end_time from va_vip WHERE user_id='{$data['user_id']}' AND product_flag_id='HOMECOST' AND end_time>'$now_time'";
        $res_vip = $this->query($sql);
        if($res_vip)
        {
            $data['vip'] = true; //是 家装预算的vip
            $data['end_time']=$res_vip[0]['end_time'];
        }
        else
        {
            $data['vip'] = false;//否 家装预算的vip
            $data['end_time']='0';
        }
        $data['token'] = AesModel::encode(array('user_id'=>$data['user_id'],'time'=>NOW_TIME));
        return $data;
    }
}