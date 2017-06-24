<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:04
 */

namespace Admin\Model;


class AdminModel extends UserHandleModel
{
    protected $tableName = 'admin';


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