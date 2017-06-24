<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/24
 * Time: 23:31
 */

namespace Admin\Logic;




use Admin\Model\UserHandleModel;
use Think\Model;

//用户策略  待发挥作用
class ConsumerStrategy extends Model
{
    public function selectConsumer(UserHandleModel $handleModel)
    {
        return $handleModel;
    }
}