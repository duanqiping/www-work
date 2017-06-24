<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/25
 * Time: 0:12
 */
abstract class Employee{
    protected $name;
    function __construct($name)
    {
        $this->name = $name;
    }
    abstract function fire();
}

//倒霉员工
class Minion extends Employee{
    function fire()
    {
        // TODO: Implement fire() method.
        print "{$this->name}：I'll clear my desk<br/>";
    }
}
//
class CluedUp extends Employee{
    function fire()
    {
        print "{$this->name}：I'll call my lawyer<br/>";
    }
}

class NastyBoss{
    private $employees = array();

    function addEmployee(Employee $employee){
        $this->employees[] = $employee;
    }
    function projectFails(){
        if(count($this->employees)>0)
        {
            $emp = array_pop($this->employees);
            $emp->fire();
        }
    }
}
$boss = new NastyBoss();
$boss->addEmployee(new Minion('harry'));
$boss->addEmployee(new Minion('bob'));
$boss->addEmployee(new Minion('mary'));

$boss->projectFails();
$boss->projectFails();
$boss->projectFails();