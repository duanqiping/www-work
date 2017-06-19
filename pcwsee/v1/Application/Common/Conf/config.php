<?php
return array(
	//'配置项'=>'配置值'
    'MODULE_DENY_LIST'   => array('Common'),//禁止外部直接访问的模块

    'DEFAULT_MODULE'     => 'Index', //默认模块
    'URL_MODEL'          => '2', //URL模式

    'URL_CASE_INSENSITIVE'  =>  true,//设置为true的时候表示URL地址不区分大小写
    'LOAD_EXT_CONFIG' => 'db,alipay',// 加载扩展配置文件

    /* Cookie设置 */
    'COOKIE_EXPIRE'         =>  24 * 3600 * 7,    // Cookie有效期

    /* SESSION设置 */
    'SESSION_AUTO_START' => true, //是否开启session

//    'LOAD_EXT_FILE' => 'is_legal',//没有生效
//    'DEFAULT_M_LAYER'       =>  'Logic', // 更改默认的模型层名称为Logic


    /* cloud应用配置 */
    'app_id' => 'LKobAEumiJV2asAtokNNB197-gzGzoHsz',
    'app_key' => 'q0KUI9KixqVTfaY60YdWNR64',
    'app_master' => 'lrm60zGsfSDPf8qkrOdDv7i9',
);