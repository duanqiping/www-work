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
        $data = array(
            '0' => array(
                'expireAt'=>100,
                'next'=>2,
            ),
            '1' => array(
                'expireAt'=>100,
                'next'=>0,
            ),
            '2' => array(
                'expireAt'=>100,
                'next'=>1,
            ),
        );
        $res = json_encode($data);

        var_dump($res) ;

        $res2 = json_decode($res);
        var_dump($res2) ;

    }
}