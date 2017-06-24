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
abstract class UserHandleModel extends Model
{

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', 'getTime', self::MODEL_INSERT,'callback'),
        array ('is_audit', '1', self::MODEL_INSERT),

//        array ('last_login_time', 'getTime', self::MODEL_UPDATE,'callback'),
//        array ('last_login_ip', 'getIp', self::MODEL_UPDATE,'callback'),
    );

    static public function  getInstance($type)
    {
        if($type == 1) return new AdminModel();//系统用户
        else if($type == 2) return new AgentModel();//代理商
        else if($type == 3) return new CustomerModel();//客户
        else if($type == 4) return new TeacherModel();//老师
        else return false;//非法操作

    }
    public function register($data)
    {
//        print_r($data);
//        exit();
        /* 添加用户 */
        if ($this->create ( $data )) {
            $uid = $this->table($this->tableName)->add ();
            return $uid ? $uid : 0; // 0-未知错误，大于0-注册成功
        } else {
            return $this->getError (); // 错误详情见自动验证注释
        }

    }

    //用户登录
    public function login($account,$passwd,$flag)
    {
        $condition['account'] = $account;

        if($flag==1) $fields = 'name,passwd,account,level';
        else $fields = 'name,passwd,account';

        $res = $this->table($this->tableName)->where($condition)->field($fields)->find();

        if($res['passwd'] == md5($passwd)){
            $this->autoLogin($res,$flag);//保存用户信息到session
            return $res;
        }
        else return false;
    }

    //退出
    public function logout()
    {
        session ( 'user', null );
    }
    //检查用户账号
    public function checkAccount($account,$from)
    {
        if($from == 'home')
        {
            $condition['account'] =  $account;
            $count = $this->table($this->tableName)->where($condition)->count();

            if($count>0) return true;//已经注册
            else return false;//未注册
        }
        else{
            return 'admin';
        }
    }


    //保存用户信息
    protected  function autoLogin($user,$falg) {
        /* 更新登录信息 */
        $data = array (
            'login_count' => array (
                'exp',
                '`login_count`+1'
            ),
            'last_login_time' => timeChange(NOW_TIME),
            'last_login_ip' => get_client_ip ( 0 )//0字串 1整数
        );
        $this->where(array('account'=>$user ['account']))->save ( $data );

        /* 记录登录SESSION和COOKIES */
        $info = array (
            'flag' => $falg,
            'name' => $user ['name'],
            'account' => $user ['account'],
            'level' => $user['level']?$user['level']:0//管理等级
        );
        $_SESSION['user'] = $info;//用户 分系统用户 供应商等
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