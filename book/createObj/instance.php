<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/25
 * Time: 16:22
 */
class Preferences{
    private $props = array();
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new Preferences();
        }
        return self::$instance;
    }
    public function setProperty($key,$val)
    {
        $this->props[$key] = $val;
    }
    public function getProperty($key)
    {
        return $this->props[$key];
    }
}

$pref = Preferences::getInstance();
$pref->setProperty('name','Tom');

unset($pref);

$pref2 = Preferences::getInstance();

print $pref2->getProperty('name');