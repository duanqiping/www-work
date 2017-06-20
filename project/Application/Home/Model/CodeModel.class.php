<?php
namespace Home\Model;
use Think\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/20
 * Time: 16:51
 */

class CodeModel extends Model
{

    public function addCode($mobile,$checkcode)
    {
        $data = array(
            'mobile' => $mobile,
            'code' => $checkcode,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'createAt' => date(NOW_TIME),
            'expireAt' => date(NOW_TIME+30*60),
        );
        return $this->add($data);
    }

    public function checkCode($mobile)
    {
        $now = NOW_TIME;
        $condition['mobile'] = $mobile;
        $condition['expireAt'] = array('GT',$now);
        $row = $this->where($condition)->field('id,mobile,code')->order('id desc')->limit(1)->find();

        return $row;
    }

    //更新验证码信息
    public function updateCode($id)
    {
        $condition['id'] = $id;
        $data = array(
            'isUse' => 1,
            'usingAt' => NOW_TIME,
        );
        $this->where($condition)->save($data);
    }

    //检测用户发短信行为
    public function checkAction($mobile)
    {
        $end = NOW_TIME;
        $begin = NOW_TIME - 24 * 60 * 60;
        $sql_num = "select count(*) as num from code where mobile='$mobile' and createAt between '{$begin}' and '{$end}'";
        $countmobile = $this->query($sql_num);
        if ($countmobile[0]['num'] >= 10) {
            //老大，都给你手机号发10次了还收不到
            return '短信今天已经发了10次，请明天再申请';
        }
        return null;
    }
} 