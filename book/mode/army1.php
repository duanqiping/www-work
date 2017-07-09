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
    abstract function addUnit(Unit $unit);
    abstract function removeUnit(Unit $unit);
}


//军队
class Army{
    private $units = array();

    function addUnit(Unit $unit){
        if(in_array($unit,$this->units,true)){
            return;
        }
        $this->units[] = $unit;
    }
    function removeUnit(Unit $unit){
        $this->units = array_udiff($this->units,array($unit),
            function ($a,$b){return ($a === $b)?0:1;});
    }
    function bombardStrength(){
        $ret = 0;
        foreach ($this->units as $unit){
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }

}