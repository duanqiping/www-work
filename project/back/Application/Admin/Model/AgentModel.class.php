<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:05
 */

namespace Admin\Model;


class AgentModel extends ConsumerHandleModel
{
    protected $tableName = 'agent';

    protected $custom_fields = 'agent_id id,name,passwd,account,grade';

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
//        array ('is_audit', '1', self::MODEL_INSERT),
    );

    public function getList()
    {
        $condition['is_show'] = 1;
        $info = $this->where($condition)
            ->field('agent_id,account,name,rank,parent_id,agent_address,agent_mobile,last_login_time,last_login_ip')
            ->order('agent_id desc')
            ->select();
        return  $info ;
    }
}