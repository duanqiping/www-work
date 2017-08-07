<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/7
 * Time: 17:50
 */

namespace Admin\Model;


class ScoreContestModel extends Score2Model
{
    protected $tableName = 'contest_order';

    public function _list($condition,$fields)
    {
        $res = $this->where($condition)->field($fields)->select();
        return $res;
    }
} 