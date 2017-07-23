<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/7/23
 * Time: 22:27
 */

namespace Admin\Controller;


use Think\Controller;

class ContestController extends Controller
{
    //创建考试\赛事
    public function index()
    {
        $this->display();
    }
    public function add()
    {
        $this->display();
        echo "add";
        exit();
    }
}