<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/14
 * Time: 17:37
 */

namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
    protected $tableName = 'USER';

    public  $user_field = 'user_id,is_check,account,nick,img,email,sex';

    //获取用户信息
    public function getUserInfo($user_id)
    {
        $condition['user_id'] = $user_id;
        $row = $this->where($condition)->field($this->user_field)->find();
        return $row;
    }

    //注册检测 账号
    public function regCheck($mobile,$type)
    {
        //要获取注册验证码
        if (1 == $type) {
            if ($this->checkAccount($mobile)) return '用户已注册';
        }
        //要获取忘记密码验证码
        else{
            if (!$this->checkAccount($mobile)) return '用户不存在';
        }
        return null;
    }

    //检查用户账号
    public function checkAccount($account)
    {
        $condition['account'] =  $account;
        $count = $this->table($this->tableName)->where($condition)->count();

        if($count>0) return true;//已经注册
        else return false;//未注册
    }

    //用户登录
    public function login($account,$passwd)
    {
        $condition['account'] = $account;
        $res = $this->table($this->tableName)->where($condition)->field($this->user_field.',passwd')->find();
        if(!$res)
        {
            $this->error = '账号不存在';
            return false;
        }
        if(!$res['is_check']){
            $this->error = '用户已经被屏蔽';
            return false;
        }
        if($res['passwd'] == md5($passwd)){
            unset($res['passwd']);
            $res['img'] = NROOT.$res['img'];
            $this->autoLogin($res);
            return $res;
        }
        else{
            $this->error = '账号或密码有误';
            return false;
        }
    }

    //退出
    public function logout()
    {
        session ( 'user', null );
    }
    //注册
    public function reg($data)
    {
        if($this->table($this->tableName)->where(array('account'=>$data['account']))->count()){
            return false;
        }

        $data['passwd'] = md5($data['passwd']);
        $data['nick'] = $data['account'];
        $data['is_check'] = 1;
        $data['sex'] = 1;
        $data['register_time'] = NOW_TIME;

        $b = $this->add($data);
        if(!$b)
        {
            return false;
        }else {
            return $b;
        }
    }

    //排行表中获取用户信息
    public function getUserInfoFromRank($res)
    {
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $condition_user['user_id'] = $res[$i]['user_id'];
            $userInfo = $this->where($condition_user)->field('nick,img')->find();
            if($userInfo['img']) $res[$i]['img'] = NROOT.$userInfo['img'];
            else $res[$i]['img'] = null;

            $res[$i]['nick'] = $userInfo['nick'];
        }
        return $res;
    }

    //保存用户信息
    private  function autoLogin($info) {

        /* 更新登录信息 */
        /* 记录登录SESSION和COOKIES */

        /* 更新登录信息 */
        $data = array (
            'login_count' => array (
                'exp',
                '`login_count`+1'
            ),
            'last_login_time' => NOW_TIME,
            'last_login_ip' => get_client_ip ( 0 )//0字串 1整数
        );
        $this->where(array('account'=>$info ['account']))->save ( $data );

        $_SESSION = $info;
    }
}