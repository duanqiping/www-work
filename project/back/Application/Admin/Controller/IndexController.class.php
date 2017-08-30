<?php
namespace Admin\Controller;


use Admin\Logic\MyException;
use Admin\Logic\TestException;
use Admin\Model\DeviceModel;
use Think\Controller;
use Think\Exception;

class IndexController extends Controller
{
    //后台首页....
    public function index(){
        $this->display('public/login');
    }

    //测试
    public function test()
    {
        try{
            $testObj2 =new TestException(2);          //使用默认参数创建异常的擦拭类对象
            echo "********<br>";                     //没有抛出异常这条语句就会正常执行
        }catch (MyException $e){
            echo "捕获自定义的异常：$e<br>";          //按自定义的方式输出异常消息
            $e->customFunction();                    //可以调用自定义的异常处理方法
        }catch(Exception $e){                        //捕获PHP内置的异常处理类的对象
            echo "捕获默认的异常：".$e->getMessage()."<br>";       //输出异常消息
        }

        var_dump($testObj2);        //判断对象是否创建成功，如果没有任何异常，则创建成功
        exit();
    }



}