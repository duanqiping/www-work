<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/29
 * Time: 23:14
 */
//战斗单元
abstract class Unit{
    abstract function bombardStrength();//战斗力
}
//射手
class Archer extends Unit{
    function bombardStrength()
    {
        // TODO: Implement bombardStrength() method.
        return 4;
    }
}
//激光炮
class LaserCannonUnit extends Unit{
    function bombardStrength()
    {
        // TODO: Implement bombardStrength() method.
        return 44;
    }
}

//军队
class Army{
    private $units = array();

    private $armies = array();

    function addUnit(Unit $unit){
        array_push($this->units, $unit);
    }
    function addArmy(Army $army){
        array_push($this->armies,$army);
    }
    function bombardStrength(){
        $ret = 0;
        foreach ($this->units as $unit){
            $ret += $unit->bombardStrength();
        }
        foreach ($this->armies as $army){
            $ret += $army->bombardStrength();
        }
        return $ret;
    }

}