<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/4/20
 * Time: 16:40
 */
abstract class DomainObject
{
    private $group;
    public function __construct(){
        $this->group = static::getGroup();
    }
    public static function create()
    {
        return new static();
    }
    static function getGroup(){
        return "default";
    }
}

class User extends DomainObject{
}
class Document extends DomainObject{
    //方法重写
    static function getGroup()
    {
        return "document";
    }
}
class SpreadSheet extends Document{

}
print_r(User::create());//default
print_r(SpreadSheet::create());//document