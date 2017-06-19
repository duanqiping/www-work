<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2015/12/24
 * Time: 16:47
 */
define('NROOT','http://'.$_SERVER['HTTP_HOST'].'/ecshop2');//正式服务器
define('PROOT','http://'.$_SERVER['HTTP_HOST'].'/pcshop/pcServ/Uploads/');//品材宝 供应商品图片的路径

if($_SERVER['SCRIPT_FILENAME'] == 'C:/wamp/www/v4.1/myecshop2/index.php')
{
    define('CROOT','http://'.$_SERVER['HTTP_HOST'].'/ecshop2/MobileAPI2/');//主要处理public文件下图片路径问题
    define('DROOT',NROOT.'/MobileAPI2/v4.1/myecshop2');//微信回调接口 和 支付宝回调接口
    define('PCROOT',NROOT.'/MobileAPI2/pcw');//品材宝 支付宝回调接口处理
}
//服务器中的测试环境
else if($_SERVER['SCRIPT_FILENAME'] == '/home/server/apache2/htdocs/ecshop/ecshop2/MobileAPI2/v4.1/myecshop2/index.php')
{
    define('CROOT','http://'.$_SERVER['HTTP_HOST'].'/ecshop2/MobileAPI2/');//主要处理public文件下图片路径问题
    define('DROOT',NROOT.'/MobileAPI2/v4.1/myecshop2');//微信回调接口 和 支付宝回调接口
    define('PCROOT',NROOT.'/MobileAPI2/pcw');//品材宝 支付宝回调接口处理
}
//正式环境
else
{
    define('CROOT','http://'.$_SERVER['HTTP_HOST'].'/ecshop2/MobileAPI/');//主要处理public文件下图片路径问题
    define('DROOT',NROOT.'/MobileAPI/v4.1/myecshop2');//微信回调接口 和 支付宝回调接口
    define('PCROOT',NROOT.'/MobileAPI/pcw');//品材宝 支付宝回调接口处理
}



////创建支付订单接口地址
//define('C_URL','http://120.55.194.72:10000/jstong-openapi/api/collectOrder');
//
////支付订单接口地址
//define('P_URL','http://120.55.194.72:10000/jstong-openapi/api/readyPayment');
//
////异步回调地址
//define('N_URL','http://121.40.239.22/pcwstore/myecshop2/home/bank/notify');
//
//
////快捷支付 确认支付地址
//define('CF_URL','http://120.55.194.72:10000/jstong-openapi/api/pay');
//
////银行卡解约地址
//define('D_URL','http://120.55.194.72:10000/jstong-openapi/api/agement');
//
////快捷支付  商户号
//define('MerchantCode','TMT201511180000000001');//TMT201511180000000004
//
//define('KEY','123456789');
//
////商户请求地址
//define('S_URL','http://www.pc985.com/');
//
////银行卡列表地址
//define('SH_URL','http://120.55.194.72:10000/jstong-openapi/api/bankList');


