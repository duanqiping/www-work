<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 14:28
 */

namespace Admin\Model;


use Think\Model;

class CollegeDeptModel extends Model{

    protected $tableName = 'college_dept';

    protected $_validate = array(
        array ('dept_name', '1,30', '系别不能太长', self::EXISTS_VALIDATE, 'length'),
        array ('class_list', '1,500', '班级数量超过上限', self::EXISTS_VALIDATE, 'length'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
    );
} 