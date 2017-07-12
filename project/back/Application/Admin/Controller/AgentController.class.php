<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/15
 * Time: 17:42
 */

namespace Admin\Controller;

use Admin\Model\AgentModel;
use Admin\Model\DeviceMsModel;
use Admin\Model\DeviceOrderModel;
use Think\Controller;
class AgentController extends BaseController
{
    //查询设备 所有设备 正常设备 损坏设备
    public function getDevice($flag,$agent_id)
    {
        $deviceMs = new DeviceMsModel();
        $res = $deviceMs->getDeviceInfo($flag,$agent_id);
        print_r($res);
    }

    //未处理工单
    public function outHand()
    {
        $agent = new DeviceOrderModel();
        $res = $agent->_list($type = 1);

        $this->assign('_list',$res);
        $this->display();
    }
    public function deal()
    {
        $id = trim($_GET['id']);
//        $info = $_GET;
        print_r($id);
        exit();
    }

    //test
    public function test()
    {
        $data = array(
            '1' => array(
                'expire_time' => 60,
                'target'=>2,
            ),
            '2' => array(
                'expire_time' => 80,
                'target'=>3,
            ),
            '3' => array(
                'expire_time' => 100,
                'target'=>1,
            ),
        );
        $res = json_encode($data);
        echo $res;
    }
}