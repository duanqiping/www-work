<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 15:25
 */

namespace Admin\Logic;


use Think\Exception;

class MyException extends Exception{
    //重定义构造器使第一个参数message变为必须被指定的属性
    public function __construct($message, $code=0){
        //可以在这里定义一些自己的代码
        //建议同时调用parent::construct()来检查所有的变量是否已被赋值
        parent::__construct($message, $code);
    }
    //重写父类中继承过来的方法，自定义字符串输出的样式
    public function __toString(){
        return __CLASS__.":[".$this->code."]:".$this->message."<br>";
    }
    //为这个异常自定义一个处理方法
    public function customFunction(){
        echo "按自定义的方法处理出现的这个类型的异常";
    }
} 