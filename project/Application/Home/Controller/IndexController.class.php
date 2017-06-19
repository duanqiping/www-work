<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class IndexController extends Controller {
    public function index(){
        $this->display();
    }
    public function test()
    {
        echo "ehllo";

    }
}