<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/11/30
 * Time: 11:57
 */
function ali_log($out_trade_no,$msg)
{
    file_put_contents('./Application/Runtime/Logs/Pay/alilog.txt', $out_trade_no.'-'.$msg.'-'.date('Y-m-d H:m:s',NOW_TIME)."\n", FILE_APPEND);
}
function wx_log($out_trade_no,$msg)
{
    file_put_contents('./Application/Runtime/Logs/Pay/wxlog.txt', $out_trade_no.'-'.$msg.'-'.date('Y-m-d H:m:s',NOW_TIME)."\n", FILE_APPEND);
}