<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/17
 * Time: 22:50
 */
$email = "pksanwei@163a.com";

$pattern = "/^([0-9A-Za-z\\-_\\.]+)@ ([a-z0-9]+\\.[a-z]{2,3} (\\.[a-z]{2}) ?) $/i";//验证邮箱
//$pattern = "/^([0-9a-zA-Z]{6,8})$/i";//验证密码

if(preg_match($pattern,$email))
{
    echo "邮箱正确";
}
else{
    echo "错误";
}