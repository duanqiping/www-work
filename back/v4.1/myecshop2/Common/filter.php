<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/7/29
 * Time: 15:31
 */

//判断用户名是否规范
function is_name_legal($name)
{
    //如果名字过长
    if($b = (strlen($name)>20))
    {
        $response = array('success' => 'false', 'error' => array('msg' => '输入的名字过长', 'code' => 4146));
        $response = ch_json_encode($response);
        exit($response);
    }//名字中是否有数字
    else if($b = preg_match('/(\d)/i',$name))
    {
        $response = array('success' => 'false', 'error' => array('msg' => '姓名中不能含有数字', 'code' => 4148));
        $response = ch_json_encode($response);
        exit($response);
    }
    else
    {
        return true;
    }
}

//验证手机号码是否规范
function is_mobile_legal($mobile)
{
    if(!$res=preg_match("/^1[34578][0-9]{9}$/i",$mobile,$res))
    {
        $response = array('success' => 'false', 'error' => array('msg' => '手机号码不规范', 'code' => 4108));
        $response = ch_json_encode($response);
        exit($response);
    }
}

//验证身份证是否规范
function is_card_legal($card)
{
    //15位身份证
    if(strlen($card) == 15)
    {
        if(!$res=preg_match('/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/i',$card,$res))
        {
            $response = array('success' => 'false', 'error' => array('msg' => '身份证号不规范', 'code' => 4809));
            $response = ch_json_encode($response);
            exit($response);
        }
    }
    //18位身份证
    else if(strlen($card) == 18)
    {
        if(!$res=preg_match('/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/i',$card,$res))
        {
            $response = array('success' => 'false', 'error' => array('msg' => '身份证号码不规范', 'code' => 4809));
            $response = ch_json_encode($response);
            exit($response);
        }
    }
    else
    {
        $response = array('success' => 'false', 'error' => array('msg' => '身份证号码不规范', 'code' => 4809));
        $response = ch_json_encode($response);
        exit($response);
    }
}

function is_address_legal($address)
{
    //验证添加地址
    if(strlen($address)>200)
    {
        $response = array('success' => 'false', 'error' => array('msg' => '地址太长', 'code' => 4108));
        $response = ch_json_encode($response);
        exit($response);
    }
    return true;
}

