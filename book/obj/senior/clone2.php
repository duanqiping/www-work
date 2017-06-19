<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/24
 * Time: 23:17
 */
class account
{
    public $balance;
    function __construct($banlance)
    {
        $this->balance = $banlance;
    }
}
class Person
{
    private $name;
    private $age;
    private $id;

    public $account;

    function __construct($name,$age,Account $account)
    {
        $this->name = $name;
        $this->age = $age;
        $this->account = $account;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function __clone()
    {
        $this->id = 0;

        $this->account = clone $this->account;
    }

}

$person = new Person("Bob",44,new Account(200));
$person->setId(345);

$person2 = clone $person;

$person->account->balance += 10;//account 210

print $person2->account->balance;//account 200