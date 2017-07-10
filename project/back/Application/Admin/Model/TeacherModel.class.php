<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/20
 * Time: 9:31
 */

namespace Admin\Model;


class TeacherModel extends ConsumerHandleModel
{
    protected $tableName = 'teacher';

    protected $custom_fields = 'teacher_id id,name,passwd,account,grade';

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', 'time', self::MODEL_INSERT,'function'),//只能是当前模型的方法
    );

    //完善数据
    public function makeData($data)
    {
        //生成自己的code
        $b = true;

        if(!$b){
            $this->error = '服务器错误';
            return false;
        }else{
            return $data;
        }
    }
} 