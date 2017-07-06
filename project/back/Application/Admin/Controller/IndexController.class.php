<?php
namespace Admin\Controller;


use Admin\Model\MonModel;
use Think\Controller;
use Think\Db\Driver\Mongo;

class IndexController extends Controller
{
    //后台首页....
    public function index(){
        $this->display('public/login');
    }

    //测试
    public function test()
    {
        $this->display('public/base');
    }

    public function test2()
    {
        $mon = new MonModel('col');

        $res = $mon->where(array('type'=>'database'))->select();

        echo count($res);
        foreach ($res as $id => $value)
        {
            echo "$id: ";
            echo "<pre>";
            print_r($value);
            echo "</pre>";
        }
    }

}