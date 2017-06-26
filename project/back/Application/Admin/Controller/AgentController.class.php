<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/15
 * Time: 17:42
 */

namespace Admin\Controller;

use Admin\Model\ConsumerHandleModel;
use Think\Controller;

class AgentController extends ConsumerConroller
{

    //添加代理商
    public function add()
    {
        if($this->getPower($_SESSION['user']['level']>0))
        {
            $flag = 2;
            $data = $_POST;
            $result = $this->register($flag,$data);
            if($result === true) {
                exit('用户添加成功');
            }
            else{
                exit($result);
            }
        }
        else
        {
            exit('该操作只能超级管理员');
        }
    }

    //代理商列表
    public function getList()
    {
        if($this->getPower($_SESSION['user']['level']>0))
        {
            $info = $this->consumerList($flag = 2);
            print_r($info);
            exit();
        }
        else
        {
            exit('该操作只能管理员');
        }
    }

    //删除管理员信息
    public function delete($id)
    {
        if((IsLogin())  && ($_SESSION['user']['level'] > 0))
        {
            $agent = ConsumerHandleModel::getInstance($type = 2);
            $info = $agent->where(array('admin_id'=>$id))->field('level')->find();
            if($info['level'] == 1) exit('不准对超级管理员执行该操作');
            $b = $agent->where(array('admin_id'=>$id))->delete();
            if($b) exit('删除成功');
            else exit('删除失败');
        }
        else
        {
            exit('该操作只能超级管理员');
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