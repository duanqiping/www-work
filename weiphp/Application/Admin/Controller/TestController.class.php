<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/19
 * Time: 9:41
 */

namespace Admin\Controller;


use Think\Controller;

class TestController extends Controller
{
    public function test()
    {
        $this->display('public/base');//test
    }
}