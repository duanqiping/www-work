<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/7
 * Time: 17:34
 */

namespace Admin\Logic;

//考试\赛事
class ScoreContestStrategy extends ScoreStrategy{

    public function condition()
    {
        return "contest condition";
    }
} 