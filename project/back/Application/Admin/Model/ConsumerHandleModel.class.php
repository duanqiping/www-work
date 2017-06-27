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
                return false;
        }
    }
    public function register($data)
    {
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
        if(! in_array($flag,array(self::ADMIN,self::AGENT,self::CUSTOMER,self::TEACHER))){
            $this->error = 'flag值只能是1-4整数';
            return false;
        }

        $condition['account'] = $account;

        if($flag==self::ADMIN) $fields = 'name,passwd,account,level,grade';
        else $fields = 'name,passwd,account,grade';

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
            'level' => $user['level']?$user['level']:0,//管理员等级
            'grade' => $user['grade'],//用户等级
        );
        $_SESSION['user'] = $info;//用户 分系统用户 供应商等
    }

//    //自定义 自动添加函数
    function getTime()
    {
        return timeChange(NOW_TIME);
    }
//    //获取ip
//    function getIp()
//    {
//        return $_SERVER['SERVER_ADDR'];
//    }
}