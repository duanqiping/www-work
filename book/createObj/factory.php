<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/25
 * Time: 16:40
 */
abstract class ApptEncoder{
    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder{
    function encode()
    {
        // TODO: Implement encode() method.
        return "Appointment data encoded in BloggsCal format\n";
    }
}
class MegaApptEncoder extends ApptEncoder{
    function encode()
    {
        // TODO: Implement encode() method.
        return "Appointment data encoded in Megacal format\n";
    }
}
class  CommsManager{
    const BLOGGS = 1;
    const MEGA = 2;
    private $mode = 1;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    function getHeaderText()
    {
        switch ($this->mode)
        {
            case (self::MEGA):
                return "MegaCal header\n";
            default:
                return "BloggsCal header\n";
        }
    }

    function getApptEncoder(){
        switch ($this->mode)
        {
            case (self::MEGA):
                return new MegaApptEncoder();
            default:
                return new BloggsApptEncoder();
        }
    }
}
$comms = new CommsManager(CommsManager::BLOGGS);
$apptEncoder = $comms->getApptEncoder();
print $apptEncoder->encode();