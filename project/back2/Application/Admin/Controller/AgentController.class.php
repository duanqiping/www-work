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

   //工单列表
    protected  function hand($type)
    {
        $agent = new DeviceOrderModel();
        $res = $agent->_list($type);

        return $res;

    }

    //未处理工单
    public function outHand()
    {
//        print_r($_GET);
//        exit();
        $res = $this->hand($_GET['type']);

        $this->assign('_list',$res);
        $this->display('outHand');
    }

    //未处理工单
    public function inHand()
    {
        $res = $this->hand($_GET['type']);

        $this->assign('_list',$res);
        $this->display('inHand');
    }

    public function deal()
    {
        if($_GET){
            $data = $_GET;
//            var_dump($data);
//            exit();
            $this->assign('data',$data);
            $this->display();
        }else if($_POST){
            $data = $_POST;
//            var_dump($data);
//            exit();
            $deviceorder = new DeviceOrderModel();
            $result = $deviceorder->updateData($data);
            if($result){
                $res = $this->hand($type=2);
                $this->assign('_list',$res);
                $this->display('inHand');
            }else{
                $res = $this->hand($type=1);
                $this->assign('_list',$res);
                $this->display('outHand');
            }
        }
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