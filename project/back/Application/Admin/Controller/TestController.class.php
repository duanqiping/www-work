<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/7
 * Time: 18:06
 */

namespace Admin\Controller;


use Admin\Logic\ScoreContestStrategy;
use Admin\Logic\ScoreGeneralStrategy;
use Admin\Model\ScoreContestModel;
use Think\Controller;

class TestController extends Controller
{
    public function test()
    {
        $scorecontest = new ScoreContestModel(new ScoreContestStrategy());

        $condition = $scorecontest->performCondition();

        var_dump($condition);
        exit();

//        $scorecontest->_list(new ScoreGeneralStrategy(),$fields='*');
    }
} 