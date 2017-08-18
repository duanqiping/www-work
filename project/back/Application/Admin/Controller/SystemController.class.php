<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 16:46
 */

namespace Admin\Controller;


use Think\Controller;
use Admin\Model\ConsumerHandleModel;

//系统管理控制器
class SystemController extends Controller{

    public function index()
    {
        $this->display();
    }

    //添加账号
    public function add()
    {
        $data = I('post.');

        $flag = $data['flag'];
        unset($data['flag']);

        $consumer = ConsumerHandleModel::getInstance($flag);

        $data = $consumer->makeData($data);

        if($consumer->create($data))
        {
            $uid = $consumer->add();

            if (0 < $uid) { // 注册成功
                $this->redirect('index');
            } else { // 注册失败，显示错误信息
                $this->redirect('index');
            }
        }else{
            echo $consumer->getError();
        }
    }
} 