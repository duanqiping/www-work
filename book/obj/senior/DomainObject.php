<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/4/20
 * Time: 16:40
 */
abstract class DomainObject
{
    public static function create()
    {
//        return new self();
        return new static();
    }
}

class User extends DomainObject{
//    public static function create(){
//        return new User();
//    }
}
class Document extends DomainObject{
//    public static function create(){
//        return new Document();
//    }
}
print_r(Document::create());