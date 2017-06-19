<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/1
 * Time: 22:57
 */

//var_dump(get_include_path());
//exit;

set_include_path(get_include_path().";C:/wamp/www/");

require_once "useful/Outputter1.php";

class Outputter{

}

$conf = new conf('my');

//\com\getinstance\util\Debugs::helloWorld();

