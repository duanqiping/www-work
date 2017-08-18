<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:04
 */

namespace Admin\Model;


class AdminModel extends ConsumerHandleModel
{
    protected $tableName = 'admin';

    protected $power = '';//权限
    protected $level = 1;//管理员级别 1超级管理员 2普通管理员

    protected $custom_fields = 'admin_id id,name,passwd,account,level,grade';

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
        array ('is_audit', '1', self::MODEL_INSERT),
    );

    //权限控制 只能是超级管理员才能对普通管理员进行操作
    public function powerControl()
    {
        $this->level = $_SESSION['user']['level'];

        if($this->level == 1)
        {
            return true;//添加管理员
        }
        else{
            $this->error = '该操作只能由超级管理员进行';
            return false;
        }
    }
    
    public function getList()
    {
        $condition['is_audit'] = 1;
        $info = $this->where($condition)
            ->field('admin_id,account,name,last_login_time,last_login_ip,level')
            ->order('admin_id desc')
            ->select();
        return $info;
    }

    //添加用户 管理员 代理商 客户
    public function addConsumer(ConsumerHandleModel $consumerHandleModel,$data)
    {
        /* 添加用户 */
        if ($consumerHandleModel->create ( $data )) {
            $uid = $consumerHandleModel->table($consumerHandleModel->tableName)->add ();
            return $uid ? $uid : 0; // 0-未知错误，大于0-注册成功
        } else {
            return $this->getError (); // 错误详情见自动验证注释
        }
    }
}