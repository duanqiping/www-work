<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

header("Content-type: application/json; charset=utf-8");
header("Access-Control-Request-Headers: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

ini_set("display_errors", "On");//显示所有错误信息  Off为屏蔽所有错误信息

define('ROOT',str_replace('\\','/',dirname(dirname(__FILE__))) . '/');
define('MROOT',dirname(ROOT).'/../');

define('NROOT','http://'.$_SERVER['HTTP_HOST'].'/');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);

// 定义应用目录
define('APP_PATH','./Application/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单