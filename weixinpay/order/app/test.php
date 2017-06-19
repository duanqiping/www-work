<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/12/9
 * Time: 15:58
 */
require_once 'config/config.php';

var_dump(DB_USER);
var_dump(DB_PWD);
var_dump(DB_NAME);

exit();
print_r($_SERVER['SCRIPT_FILENAME']);
$res = explode('/',$_SERVER['SCRIPT_FILENAME']);
print_r($res);
exit();