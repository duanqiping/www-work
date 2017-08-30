<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 13:48
 */

namespace Admin\Controller;

use Admin\Model\ConsumerHandleModel;
use Admin\Model\TeacherModel;
use Admin\Model\UserModel;

class BaseController extends \Think\Controller
{
    protected $uid;//管理员id 或 代理商id 或 学校管理员id 或 老师id
    protected $grade;//上述身份的grade权限级别
    protected $customer_id;//客户id

    protected $error_info;
    protected $flag;

    /* TP初始化方法*/
    function _initialize(){
        $this->uid = $_SESSION['user']['id'];
        $this->grade = $_SESSION['user']['grade'];

        //客户
        if($this->grade == 3){
            $this->customer_id = $this->uid;
        }
        //老师
        else if($this->grade == 4){
            $teacher = D('teacher');
            $this->customer_id = $teacher->where(array('teacher_id'=>$this->uid))->getField('customer_id');
        }
    }

    //获取用户model
    public static function  getInstance($flag)
    {
        return  ConsumerHandleModel::getInstance($flag);
    }

    //获取学校 系、年级、班级筛选条件
    public function selectCondition(&$model,$condition,$uid,$content_sn='')
    {

        $studentInfo = array();
        if($model instanceof UserModel){
            $studentInfo['deptInfo'] = $model->getDept($uid);//获取系别
//            $res2 = $model->getDept($uid);//获取系别  打印东西为空

            my_print($studentInfo);
            $studentInfo['gradeInfo'] = $model->getGrade($uid,$condition['dept']);//获取年级
            $studentInfo['classInfo'] = $model->getClass($uid,$condition['dept'],$condition['grade']);//获取班级
        }

        return $studentInfo;
    }

    //是否为管理员登陆
    protected  function isAdminLogin()
    {
        if($_SESSION['user']['level']>0){
            return true;
        }else{
            return false;
        }
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