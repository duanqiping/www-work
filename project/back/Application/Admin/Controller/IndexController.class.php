<?php
namespace Admin\Controller;


use Think\Controller;

class IndexController extends Controller
{
    //后台首页....
    public function index(){
        $this->display('public/login');
    }

    //测试
    public function test()
    {
        $device = M('device');
        $res = $device->select();

        $user = M('user');
        $res_user = $user->field('user_id')->select();

        //循环插入数据
        for($i=0;$i<=count($res_user);$i++){
            $data = array();
            $data['code'] = $i+1;
            $data['user_id'] = $res_user[$i]['user_id'];
            $uid = $device->add($data);
            if(!$uid){
                exit('fail');
            }
        }
        echo "success";
        var_dump($res);
        var_dump($res_user);
        exit();
    }



}