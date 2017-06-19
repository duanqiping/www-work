<?php

    //手动设置 Session 的生存期一天
    $lifeTime = 24 * 3600 * 7;
    session_set_cookie_params($lifeTime);
    // 开启session
    session_start();

	// 初始化当前的绝对路径
    // 换成正斜线是因为 win/linux都支持正斜线,而linux不支持反斜线
    header("Access-Control-Allow-Origin: *");//允许所有域名发起跨域请求，h5需要
    header('Access-Control-Allow-Headers: version, accept, xhr, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");
    header("Content-type: text/html; charset=utf-8");
//    header("Content-type: application/json; charset=utf-8");
    header("Access-Control-Request-Headers: *");
    date_default_timezone_set('PRC');
    ini_set("display_errors", "On");//显示所有错误信息  Off为屏蔽所有错误信息

    define('ROOT',str_replace('\\','/',dirname(dirname(__FILE__))) . '/');
    define('MROOT',dirname(ROOT).'/../');

	//开启调试模式
    define('APP_DEBUG', true);
    define('CONF_PATH','./Conf/');
    //加载框架入口文件
    require './ThinkPHP/ThinkPHP.php';
    //require './Runtime/~runtime.php';

