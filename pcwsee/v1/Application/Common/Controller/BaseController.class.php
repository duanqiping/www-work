<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/11/18
 * Time: 10:22
 */

namespace Common\Controller;
use Common\Model\Aes\AesModel;
use Think\Controller;
use Common\Model\Rest\RestUtils;

class BaseController extends Controller {
    public function __construct() {
        parent::__construct();
        RestUtils::processRequest();
    }
    //登录权限
    public static function IsLogin()
    {
        if(isset($_SESSION['user_id']) && $_SESSION['user_id']>0)
        {
            return true;
        }
        else
        {
            $flag = true;
            $headers = getallheaders();
            $token = $headers['Authorization'];
            if($token)
            {
                $userObj = AesModel::decode($token);
                $old_time = $userObj->time;
                if($old_time+7*24*3600>NOW_TIME){
                    $_SESSION['user_id'] = $userObj->user_id;
                }
                else
                {
                    $flag = false;
                }
            }
            else
            {
                $flag = false;
            }
            if(!$flag) sendError('你还没有登录',400);
            else return true;
        }
    }



}