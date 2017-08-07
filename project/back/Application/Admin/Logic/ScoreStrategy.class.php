<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/7
 * Time: 17:25
 */

namespace Admin\Logic;

//成绩策略
abstract class ScoreStrategy {
    abstract public function condition();//成绩筛选条件
} 