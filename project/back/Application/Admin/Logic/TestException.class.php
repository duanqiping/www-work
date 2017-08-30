<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 15:31
 */

namespace Admin\Logic;


class TestException {
    public $var;           //用来判断对象是否创建成功的成员属性
    function __construct($value=0){              //通过构造方法的传值决定抛出的异常
        switch($value){                          //对传入的值进行选择性的判断
            case 1:                              //掺入参数1，则抛出自定义的异常对象
                throw new MyException("传入的值“1”是一个无效的参数",5);break;
            case 2:                              //传入参数2，则抛出PHP内置的异常对象
                throw new MyException("传入的值“2”不允许作为一个参数",6);break;
            default:                             //传入参数合法，则不抛出异常
                $this->var=$value;break;          //为对象中的成员属性赋值
        }
    }
} 