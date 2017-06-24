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

class RegistrationMgr{
    function register(Lesson $lesson)
    {
        //处理该课程

        //通知某人
        $notifier = Notifier::getNotifier();
        $notifier->inform("new lesson: cost ({$lesson->cost()}).</BR>");
    }
}
abstract class Notifier{
    static function getNotifier()
    {
        //根据配置或其他逻辑获得具体的类

        if(rand(1,2) == 1)
        {
            return new MailNotifier();
        }
        else
        {
            return new TextNotifier();
        }
    }
    abstract function inform($message);
}
class MailNotifier extends Notifier{
    function inform($message)
    {
        // TODO: Implement inform() method.
        print "MAIL notification: {$message}\n";
    }
}
class TextNotifier extends Notifier{
    function inform($message)
    {
        // TODO: Implement inform() method.
        print "TEXT notification: {$message}\n";
    }
}


class Lecture extends Lesson{

}
class Seminar extends Lesson{
}

$lessons1 = new Seminar(4,new TimedCostStrategy());
$lessons2 = new Lecture(4,new FixedCostStrategy());

$mgr = new RegistrationMgr();
$mgr->register($lessons1);
$mgr->register($lessons2);











