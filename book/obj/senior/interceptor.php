<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/23
 * Time: 22:31
 */

//拦截器
class Person
{
    private $_name;
    private $_age;

    function __set($property,$value)
    {
        $method = "set{$property}";
//        var_dump($this->$method($value));
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }
    }

    function __get($property)
    {
        $method = "get{$property}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

    //判断方法是否存在
    function __isset($property)
    {
        $method = "get{$property}";
        return method_exists($this, $method);
    }

    function getName()
    {
        return "Bob";
    }

    function getAge()
    {
        return 44;
    }

    function setName($name)
    {
        echo $name;
        $this->_name = $name;
        if(! is_null($name))
        {
            var_dump(strtoupper($this->_name));
            $this->_name = strtoupper($this->_name);
        }
    }
    function setAge($age)
    {
        $this->_age = strtoupper($age);
    }
}
$p = new Person();

print $p->name;//Bob
print $p->age;//44

//方法存在返回true 否则false
if(isset($p->name))
{
    print $p->name;//Bob
}

$p->name = 'nihao';




