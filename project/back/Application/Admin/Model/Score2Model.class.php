<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/7
 * Time: 17:49
 */

namespace Admin\Model;


use Admin\Logic\ScoreStrategy;
use Think\Model;

abstract class Score2Model extends Model{
    private $scoreStrategy;

    protected $dept = array();
    protected $grade = array();
    protected $class = array();

    abstract public function _list($condition,$fields);//成绩列表

    public function __construct(ScoreStrategy $scoreStrategy)
    {
        parent::__construct();
        $this->scoreStrategy = $scoreStrategy;
    }

    public function performCondition()
    {
        return $this->scoreStrategy->condition();
    }
    public function getCondition(ScoreStrategy $scoreStrategy)
    {
        $this->scoreStrategy = $scoreStrategy;
    }
} 