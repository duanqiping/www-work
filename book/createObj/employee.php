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
        print "{$this->name}：I'll clear my desk\n";
    }
}

class NastyBoss{
    private $employees = array();

    function addEmployee($employeeName){
        $this->employees[] = new Minion($employeeName);
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
$boss->addEmployee('harry');
$boss->addEmployee('bob');
$boss->addEmployee('tom');
$boss->addEmployee('mary');

$boss->projectFails();