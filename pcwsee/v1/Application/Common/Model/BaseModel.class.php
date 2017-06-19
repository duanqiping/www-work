<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/11/11
 * Time: 11:56
 */

namespace Common\Model;
use Think\Model;

class BaseModel  extends Model
{
    //判断登录状态   使用于一些必须要登录的接口
    public function is_login()
    {
        if( !(isset($_SESSION['user_id'])&&$_SESSION['user_id']>0) )
        {
            sendError('你还没有登录',401);
        }
    }
}