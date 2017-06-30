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

    protected $cycles = array(1,2,3,4,5);
    //获取客户信息
    protected function customerInfo()
    {
        $customer = M('customer');
        $map['is_show'] = 1;
        $map['longitude_y'] = array('GT',0);
        $map['latitude_x'] = array('GT',0);
        $res = $customer->where($map)->field('customer_id,name,length,longitude_y,latitude_x')->select();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            if($res[$i]['length'] == 200) $this->cycles = array(2,4,6,8,10);
            else $this->cycles = array(1,2,3,4,5);
            $res[$i]['cycles'] = $this->cycles;
        }

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
        $type = trim($_GET['type'])?trim($_GET['type']):1;

        $rank = new RankModel();
        $data = $rank->getRank($customer_id,$cycles,$flag,$type,$page,$pageSize);

        sendSuccess($data);
    }

} 