<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 14:21
 */

namespace Home\Controller;


use Home\Model\Map;
use Home\Model\RankModel;
use Think\Controller;


class RankController extends Controller{

    //获取客户信息
    protected function customerInfo()
    {
        $customer = M('customer');
        $map['longitude_y'] = array('GT',0);
        $map['latitude_x'] = array('GT',0);
        $res = $customer->where($map)->field('customer_id,name,longitude_y,latitude_x')->select();
        return $res;
    }

    //所有客户的地址信息
    public function location()
    {
        $res = $this->customerInfo();
        sendSuccess($res);
    }

    //最近的一个客户
    public function nearby()
    {
        $latitude_x = trim($_GET['latitude_x']);
        $latitude_y = trim($_GET['longitude_y']);
        $res = $this->customerInfo();

        $map = new Map();
        $data = $map->getCustomerInfo($latitude_x,$latitude_y,$res);

        sendSuccess($data);
    }

    //获取周排行 customer_id cycles flag page pageSize
    public function rank()
    {
        $customer_id = trim($_GET['customer_id']);
        $cycles = trim($_GET['cycles']);
        $page = trim($_GET['page']);
        $pageSize = trim($_GET['pageSize']);
        $flag = trim($_GET['flag']);

        $rank = new RankModel();
        $data = $rank->getRank($customer_id,$cycles,$flag,$page,$pageSize);

        sendSuccess($data);
    }

} 