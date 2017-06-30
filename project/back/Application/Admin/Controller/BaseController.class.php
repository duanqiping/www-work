<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 13:48
 */

namespace Admin\Controller;


use Think\Controller;
use Admin\Model\ConsumerHandleModel;

class BaseController extends Controller
{
    protected $error_info;
    protected $flag;

    //获取用户model
    public static function  getInstance($flag)
    {
        return  ConsumerHandleModel::getInstance($flag);
    }

    //获取用户标志
    public function getFlag()
    {
        if($_SESSION['user']['table'] == 'admin') $this->flag = 1;
        else if($_SESSION['user']['table'] == 'agent') $this->flag = 2;
        else if($_SESSION['user']['table'] == 'customer') $this->flag = 3;
        else if($_SESSION['user']['table'] == 'teacher') $this->flag = 4;
        else $this->flag = null;
        return $this->flag;
    }

    //获取错误信息
    public function getErrorInfo()
    {
        return $this->error_info;
    }

    /**
     * 是否有操作权限
     */
    public function getPower()
    {
//        var_dump( $_SESSION['user']['table']);
//        exit();
        switch($_SESSION['user']['table'])
        {
            case 'admin'://超级管理员
                if($_SESSION['user']['level']==1)
                {
                    return true;
                }
                else
                {
                    $this->error_info = '该操作只能超级管理员';
                    return false;
                }
                break;
            case 'agent'://超级和普通管理员
                if($_SESSION['user']['level']>0)
                {
                    return true;
                }
                else
                {
                    $this->error_info = '该操作只能管理员';
                    return false;
                }
                break;
            case 'customer'://超级和普通管理员
                if($_SESSION['user']['level']>0)
                {
                    return true;
                }
                else
                {
                    $this->error_info = '该操作只能管理员';
                    return false;
                }
                break;
            case 'teacher'://超级、普通管理员和学校
                if($_SESSION['user']['level']>0 || $_SESSION['user']['grade'] == 3)
                {
                    return true;
                }
                else
                {
                    $this->error_info = '该操作只能管理员';
                    return false;
                }
                break;
            default:
                $this->error_info = '没有权限';;
                return false;
                break;
        }
    }
} 