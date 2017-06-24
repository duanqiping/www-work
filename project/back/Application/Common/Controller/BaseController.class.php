<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 11:27
 */

namespace Common\Controller;


use Think\Controller;

class BaseController extends Controller{

    //用户是否已经登陆
    public function IsLogin()
    {
        if($_SESSION['user']) return true;
        else return false;
    }
} 