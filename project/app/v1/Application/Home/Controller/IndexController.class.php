<?php
namespace Home\Controller;
use Home\Model\Map;
use Think\Controller;
use Think\Model;

class IndexController extends Controller {

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

    public function test()
    {
        $data = array(
            '0' => array(
                'expireAt'=>100,
                'next'=>2,
            ),
            '1' => array(
                'expireAt'=>100,
                'next'=>0,
            ),
            '2' => array(
                'expireAt'=>100,
                'next'=>1,
            ),
        );
        $res = json_encode($data);

        var_dump($res) ;

        $res2 = json_decode($res);
        var_dump($res2) ;

    }
}