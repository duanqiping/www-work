<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 14:28
 */

namespace Admin\Model;


use Think\Model;

class SchoolInfoModel extends Model{

    protected $tableName = 'school_info';

    protected $_validate = array(
        array ('dept_name', '1,30', '系别名不能太长', self::EXISTS_VALIDATE, 'length'),
        array ('dept_name', '', '该系别已经存在,无需再次添加', self::EXISTS_VALIDATE, 'unique'),
        array('grade_num','is_numeric','年级是一个数字',self::MODEL_UPDATE,'function'),

        array ('class_list', '1,500', '班级数量超过上限', self::EXISTS_VALIDATE, 'length'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
    );
} 