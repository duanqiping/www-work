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
use Home\Model\RankMongoModel;
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

//        $rank = new RankModel();
        $rank = new RankMongoModel();
        $data = $rank->getRank($customer_id,$cycles,$flag,$page,$pageSize);

        sendSuccess($data);
    }

    //获取马拉松排行
    public function marathonRank()
    {

        $customer_id = trim($_GET['customer_id']);
        $flag = trim($_GET['flag'])?trim($_GET['flag']):1;
        $page = trim($_GET['page']);
        $pageSize = trim($_GET['pageSize']);

//        $rank = new RankModel();
//        $data = $rank->getMarathonRank($customer_id,$flag,$page,$pageSize);
        $rank = new RankMongoModel();
        $data = $rank->getMarathonRank($customer_id,$flag,$page,$pageSize);

        sendSuccess($data);
    }

    //个人最佳成绩排行
    public function singleRank()
    {
        $customer_id = trim($_GET['customer_id']);
        $page = trim($_GET['page']);
        $pageSize = trim($_GET['pageSize']);

//        $rank = new RankModel('rank_singe');
        $rank = new RankMongoModel();
        $data = $rank->getSingleRank($customer_id,$page,$pageSize);

        sendSuccess($data);
    }

} 