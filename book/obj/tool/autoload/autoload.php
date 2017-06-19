<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/11
 * Time: 21:35
 */
function __autoload($classname)
{
    $path = str_replace('_',DIRECTORY_SEPARATOR,$classname);
    require_once "$path.php";
}

//$y = new business_ShopProduct();//false