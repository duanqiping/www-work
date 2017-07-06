<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/5
 * Time: 18:26
 */

namespace Admin\Model;


use Think\Model\MongoModel;

class MonModel extends MongoModel{

    protected $dbName='runoob';//（要连接的数据库名称）

    protected $trueTableName = 'col';//数据表名
//    protected $tableName = 'col';//数据表名

    protected $connection = array(
        'db_type' => 'mongo',
        'db_user' => '',//用户名(没有留空)
        'db_pwd' => '',//密码（没有留空）
        'db_host' => '127.0.0.1',//数据库地址
        'db_port' => '27017',//数据库端口 默认27017
        'DB_NAME'   => 'runoob', // 数据库名
    );
    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

    public function __construct($name)
    {
        parent::__construct($name);
        $this->trueTableName=$name;//要连接的那个集合（表）控制器里传过来
    }

    /* public function getall()
    {
    return $this->select();
    }*/
} 