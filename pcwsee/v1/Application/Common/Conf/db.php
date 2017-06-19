<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/11/14
 * Time: 17:22
 */
//return array(
//    //数据库配置信息
//    'DB_TYPE'   => 'mysql',// // 数据库类型
//    'DB_HOST'   => 'localhost', // // 服务器地址
//    'DB_USER'   => 'cad',// // 用户名
//    'DB_PWD'    => 'ZLRgtnXj/aldPBqF3',// // 密码
//    'DB_PORT'   => 3306,// // 端口
//    'DB_NAME'   => 'vipapps',// // 数据库名
//    'DB_PREFIX' => 'va_',// // 数据库表前缀
//    'DB_CHARSET'=> 'utf8'
//);


if($_SERVER['SCRIPT_FILENAME'] == 'C:/wamp/www/pcwsee/v1/index.php')
{
    return array(
        //数据库配置信息
        'DB_TYPE'   => 'mysql',// // 数据库类型
        'DB_HOST'   => 'localhost', // // 服务器地址
        'DB_USER'   => 'root',// // 用户名
        'DB_PWD'    => 'aecsqlyou',// // 密码
        'DB_PORT'   => 3306,// // 端口
        'DB_NAME'   => 'vipapps',// // 数据库名
        'DB_PREFIX' => 'va_',// // 数据库表前缀
        'DB_CHARSET'=> 'utf8',// // 字符集
    );
}
else
{
    return array(
        //数据库配置信息
        'DB_TYPE'   => 'mysql',// // 数据库类型
        'DB_HOST'   => 'localhost', // // 服务器地址
        'DB_USER'   => 'cad',// // 用户名
        'DB_PWD'    => 'ZLRgtnXj/aldPBqF3',// // 密码
        'DB_PORT'   => 3306,// // 端口
        'DB_NAME'   => 'vipapps',// // 数据库名
        'DB_PREFIX' => 'va_',// // 数据库表前缀
        'DB_CHARSET'=> 'utf8'
    );
}