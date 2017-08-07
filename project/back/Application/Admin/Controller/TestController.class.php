<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/7
 * Time: 18:06
 */

namespace Admin\Controller;


use Admin\Logic\ScoreGeneralStrategy;
use Admin\Model\ScoreContestModel;
use Think\Controller;

class TestController extends Controller{
    public function test()
    {
        $scorecontest = new ScoreContestModel();

        $scorecontest->_list(new ScoreGeneralStrategy(),$fields='*');
    }
} 