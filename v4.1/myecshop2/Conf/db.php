<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2015/7/22
 * Time: 15:26
 */

//本地
if($_SERVER['SCRIPT_FILENAME'] == 'C:/wamp/www/v4.1/myecshop2/index.php')
{
    $db_user = 'root';
    $db_pwd = '';
    $db_name = 'ecshop';
}
//服务器中的测试环境
else if($_SERVER['SCRIPT_FILENAME'] == '/home/server/apache2/htdocs/ecshop/ecshop2/MobileAPI2/v4.1/myecshop2/index.php')
{
    define('isTest',true);//ecshop_mobile_test

    $db_user = 'pcw';
    $db_pwd = 'k+b/lLv4K8D2ZUg1';
    $db_name = 'ecshop_mobile_test';
}
//正式环境
else
{
    define('isTest',false);//ecshop

    $db_user = 'pcw';
    $db_pwd = 'k+b/lLv4K8D2ZUg1';
    $db_name = 'ecshop';
}

return array(
    //数据库配置
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_USER'   => $db_user, // 用户名
    'DB_PWD'    => $db_pwd, // 密码
    'DB_NAME'   => $db_name, // 数据库名
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'ecs_', // 数据库表前缀
    'DB_CHARSET' => 'UTF8', //设置数据库的字符集

    'DB_CONFIG1' => array(
        'DB_TYPE'  => 'mysql',
        'DB_USER'  => $db_user,
        'DB_PWD'   => $db_pwd,
        'DB_HOST'  => 'localhost',
        'DB_PORT'  => '3306',
        'DB_NAME'  => 'pcwb2bs',
        'DB_CHARSET'=>    'utf8',
        'DB_PREFIX' => 'b2b_', // 数据库表前缀
    ),
);

