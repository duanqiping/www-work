<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/12/7
 * Time: 14:40
 */
//经营方式 字符串处理(英文字符转中文)
function b2bPayMethodToChina($method)
{
    if($method == 'ONLY_CASH') $method = '仅现结支付';
    else if($method == 'CASH_AND_COD') $method = '现结及货到付款';
    else $method = false;

    return $method;
}
//经营方式 字符串处理(英文字符转中文)
function b2bPayMethodToEnglish($method)
{
    if($method == '仅现结支付') $method = 'ONLY_CASH';
    else if($method == '现结及货到付款') $method = 'CASH_AND_COD';
    else $method=false;

    return $method;
}