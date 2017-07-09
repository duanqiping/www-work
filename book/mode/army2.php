<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/29
 * Time: 23:14
 */

class UnitException extends Exception{}

//战斗单元
abstract class Unit{
    abstract function bombardStrength();//战斗力
    function addUnit(Unit $unit){
        throw new UnitException(get_class($this)."is a leaf");
    }
    function removeUnit(Unit $unit){
        throw new UnitException(get_class($this)."is a leaf");
    }
}


//射手
class Archer extends Unit {
    private $units = array();

    function addUnit(Unit $unit){
        throw new UnitException(get_class($this)."is a leaf");
    }
    function removeUnit(Unit $unit){
        throw new UnitException(get_class($this)."is a leaf");
    }
    function bombardStrength(){
        return 4;
    }

}