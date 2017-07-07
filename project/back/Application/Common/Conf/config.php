<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_MODULE'     => 'Home', //默认模块
//    'APP_GROUP_LIST' => 'Home,admin', //项目分组设定
    'URL_MODEL'          => '2', //URL模式
    'SESSION_AUTO_START' => true, //是否开启session

    'URL_PARAMS_BIND'       =>  true, // URL变量绑定到操作方法作为参数(默认开启)

    // 设置禁止访问的模块列表
    'MODULE_DENY_LIST'      =>  array('Common','Runtime','Api'),

    // 加载扩展配置文件
    'LOAD_EXT_CONFIG' => 'db,mongodb',
);