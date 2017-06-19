<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/29
 * Time: 21:21
 */
//class StringThing{}
//
//$st = new StringThing();
//
//print $st;//Catchable fatal error: Object of class StringThing could not be converted to string

class Person
{
    function GetName(){ return "Bob";}
    function GetAge(){ return 44;}
    //常用于错误日志报告
    function __ToString()
    {
        $desc = $this->getName();
        $desc .= ' age '.$this->GetAge();

        return $desc;
    }
}

$person = new Person();
print $person;