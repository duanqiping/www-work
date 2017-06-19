<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/4/2
 * Time: 20:34
 */
class StaticExample{
    static public $aNum = 0;
    static public function sayHello(){
        self::$aNum++;
        print 'hello'.self::$aNum;
    }
}
print StaticExample::$aNum;
StaticExample::sayHello();