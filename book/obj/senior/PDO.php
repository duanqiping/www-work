<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/4/2
 * Time: 20:54
 */
require_once("shopProduct.php");
$pdo = new PDO("mysql:host=localhost;dbname=book",'root','');
$pdo->exec('set names utf8');
if(!$pdo->exec('insert into products(firstname,mainname) VALUES ("段","齐平")'))
{
    echo "数据库连接失败";
}
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$obj = ShopProduct::getInstance(4,$pdo);
var_dump($obj);