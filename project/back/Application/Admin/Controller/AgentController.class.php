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