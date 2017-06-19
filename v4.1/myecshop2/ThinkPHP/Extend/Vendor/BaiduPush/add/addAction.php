<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2016/3/9
 * Time: 17:37
 */
$conn =  mysql_connect('localhost', 'root','aecsqlyou');
if(!$conn){
    $msg = "数据库连接失败";
    file_put_contents('log.txt',$msg.'--'.$time."\n",FILE_APPEND);
    return false;
}
$sql = 'set names utf8';
mysql_query($sql);
$sql = 'use ecshop';
mysql_query($sql);

$res = $_POST;
$time = time();
$sql = "insert into ecs_push_message (title,content,time,device) VALUES ('{$res['title']}','{$res['content']}','$time','{$res['device']}')";

$b = mysql_query($sql);
if($b)
{
    echo "成功";
    header("Refresh: 1; message.php");
    exit();
}else
{
    echo "失败";
    header("Refresh: 1; message.php");
    exit();
}
