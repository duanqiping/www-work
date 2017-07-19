<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 22:54
 */

namespace Admin\Model;

use Think\Model;

//用户handle类
abstract class ConsumerHandleModel extends Model
{
    protected $custom_fields='';

    const ADMIN = 1;
    const AGENT = 2;
    const CUSTOMER = 3;
    const TEACHER = 4;

    static public function  getInstance($type)
    {
        switch ($type){
            case self::ADMIN:
                return new AdminModel();//系统用户
            case self::AGENT:
                return new AgentModel();//代理商
            case self::CUSTOMER:
                return new CustomerModel();//客户
            case self::TEACHER:
                return new TeacherModel();//老师
            default:
                return new TeacherModel();//老师 权限最低
        }
    }

    //用户登录
    public function login($account,$passwd,$flag)
    {
        if(!in_array($flag,array(1,2,3,4)))
        {
            $this->error = 'flag有误';
            return false;
        }

        $condition['account'] = $account;
        $res = $this->table($this->tableName)->where($condition)->field($this->custom_fields)->find();

        if($res['passwd'] == md5($passwd)){
            $this->autoLogin($res);//保存用户信息到session
            return $res;
        }
        else{
            $this->error = '账号或密码有误';
            return false;
        }
    }

    //检查用户账号
//    public function checkAccount($account,$from)
//    {
//        if($from == 'home')
//        {
//            $condition['account'] =  $account;
//            $count = $this->table($this->tableName)->where($condition)->count();
//
//            if($count>0) return true;//已经注册
//            else return false;//未注册
//        }
//        else{
//            return 'admin';
//        }
//    }


    //保存用户信息
    protected  function autoLogin($user) {
        /* 更新登录信息 */
        $data = array (
            'login_count' => array (
                'exp',
                '`login_count`+1'
            ),
            'last_login_time' => NOW_TIME,
            'last_login_ip' => get_client_ip ( 0 )//0字串 1整数
        );
        $this->where(array('account'=>$user ['account']))->save ( $data );

        /* 记录登录SESSION和COOKIES */
        $info = array (
            'id' => $user ['id'],
            'name' => $user ['name'],
            'account' => $user ['account'],
            'level' => $user['level']?$user['level']:0,//管理员等级
            'grade' => $user['grade'],//用户等级
            'table' => $this->tableName,
        );
        $_SESSION['user'] = $info;//用户 分系统用户 供应商等
    }
    public function makeData($data)
    {
        return $data;
    }

//    //自定义 自动添加函数
//    function getTime()
//    {
//        return timeChange(NOW_TIME);
//    }
//    //获取ip
//    function getIp()
//    {
//        return $_SERVER['SERVER_ADDR'];
//    }
}