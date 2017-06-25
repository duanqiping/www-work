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
abstract class  CommsManager{
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getFooterText();
}
class BloggsCommsManager extends CommsManager{
    function getHeaderText(){
        return "BloggsCal header\n";
    }
    function getApptEncoder(){
        return new BloggsApptEncoder();
    }
    function getFooterText()
    {
        return "BoggCal footer\n";
    }
}
$BloggsCommsManager = new BloggsCommsManager();
