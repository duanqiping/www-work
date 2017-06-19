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

    function __clone()
    {
        $this->id = 0;
    }

}

$person = new Person("Bob",44);
$person->setId(345);

$person2 = clone $person;

var_dump($person2);
