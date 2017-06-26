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

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', 'getTime', self::MODEL_INSERT,'callback'),//只能是当前模型的方法
        array ('is_audit', '1', self::MODEL_INSERT),
    );
    
    public function getList()
    {
        $condition['is_audit'] = 1;
        $info = $this->where($condition)
            ->field('admin_id,account,name,last_login_time,last_login_ip,level')
            ->order('admin_id desc')
            ->select();
        return $info;
    }
}