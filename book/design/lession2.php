<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/23
 * Time: 23:09
 */
abstract class Lesson
{
    private $duration;
    private $costStrategy;

    function __construct($duration,CostStrategy $costStrategy)
    {
        $this->duration = $duration;
        $this->costStrategy = $costStrategy;
    }
    function cost()
    {
        return $this->costStrategy->cost($this);
    }
    function chargeType()
    {
        return  $this->costStrategy->chargeType();
    }
    function getDuration()
    {
        return $this->duration;
    }
}
abstract class CostStrategy{
    abstract function cost(Lesson $lesson);
    abstract function chargeType();
}
class TimedCostStrategy extends CostStrategy{
    function cost(Lesson $lesson){
        return ($lesson->getDuration()*5);
    }
    function chargeType()
    {
        // TODO: Implement chargeType() method.
        return "hourly rate";
    }
}
class FixedCostStrategy extends CostStrategy{
    function cost(Lesson $lesson){
        return 30;
    }
    function chargeType()
    {
        // TODO: Implement chargeType() method.
        return "fixed rate";
    }
}


class Lecture extends Lesson{

}
class Seminar extends Lesson{
}

$lessons[] = new Seminar(4,new TimedCostStrategy());
$lessons[] = new Lecture(4,new FixedCostStrategy());

foreach ($lessons as $lesson)
{
    print "lesson charge {$lesson->cost()}. ";
    print "Charge type {$lesson->chargeType()}<br/>";
}











