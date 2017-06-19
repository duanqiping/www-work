<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/24
 * Time: 22:55
 */
class Person
{
    private $name;
    private $age;
    private $id;

    function __construct($name,$age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    function setId($id)
    {
        $this->id = $id;
    }
    function __destruct()
    {
        if( ! empty($this->id))
        {
            print "saving person";
        }
    }
}

$person = new Person("Bob",44);
$person->setId(345);
unset($person);//unset之前会先调用__destruct()方法
