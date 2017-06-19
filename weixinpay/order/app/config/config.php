<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/12/9
 * Time: 16:00
 */
$falg = 0;//默认本地
$res = explode('/',$_SERVER['SCRIPT_FILENAME']);//地址路径
foreach($res as $var)
{
    if($var == 'MobileAPI2') $falg=1;
    else if($var == 'MobileAPI') $falg=2;
}
if($falg == 0)
{
    define('DB_USER','root');//默认本地
    define('DB_PWD','aecsqlyou');

    define('DB_NAME_ECSHOP','ecshop');

    define('PAYB2B_URL','http://localhost/weixinpay/order/app/notifyB2B.php');
    define('PAYOTHER_URL','http://localhost/weixinpay/order/app/notifyB2Bother.php');
}
else if($falg == 1)
{
    define('DB_USER','pcw');//正式服务器测试版
    define('DB_PWD','k+b/lLv4K8D2ZUg1');

    define('DB_NAME_ECSHOP','ecshop_mobile_test');

    define('PAYB2B_URL','http://www.pcw365.com/ecshop2/MobileAPI2/weixinpay/order/app/notifyB2B.php');
    define('PAYOTHER_URL','http://www.pcw365.com/ecshop2/MobileAPI2/weixinpay/order/app/notifyB2Bother.php');
}
else
{
    define('DB_USER','pcw');//正式服务器
    define('DB_PWD','k+b/lLv4K8D2ZUg1');

    define('DB_NAME_ECSHOP','ecshop');

    define('PAYB2B_URL','http://www.pcw365.com/ecshop2/MobileAPI/weixinpay/order/app/notifyB2B.php');
    define('PAYOTHER_URL','http://www.pcw365.com/ecshop2/MobileAPI/weixinpay/order/app/notifyB2Bother.php');
}


