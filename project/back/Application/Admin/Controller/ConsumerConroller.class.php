<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 18:28
 */

namespace Admin\Controller;

use Admin\Model\ConsumerHandleModel;
use Think\Controller;

class ConsumerConroller extends Controller
{

    /**
     * flag 对应用户表
     * power 对应权限
     * data  输入的数据
    */
    protected  function register($flag,$data)
    {
        $admin = ConsumerHandleModel::getInstance($flag);
        $uid = $admin->register($data);
        if (0 < $uid) { // 注册成功
            return true;
        } else { // 注册失败，显示错误信息
            return ($admin->getError());
        }
    }

    /**获取用户列表
    */
    protected function consumerList($flag)
    {
        $admin = ConsumerHandleModel::getInstance($flag);
        $info = $admin->getList();
        return $info;
    }

    /**
     * 是否有操作权限
    */
    public function getPower($power)
    {
        return  (IsLogin() && $power)?true:false;
    }
} 