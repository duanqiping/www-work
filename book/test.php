<?php  

date_default_timezone_set("Asia/Shanghai");

$time = 25*3600+4820;

$time_day = floor($time/(24*3600));//天数

$time_hour =floor( ($time%(3600*24)) /( 3600) );//小时 //1220


$time_m =floor( ($time%(3600)) / 60 );//分钟

$time_s =floor( ($time%(3600)) % 60 );//秒



var_dump($time);
var_dump($time_day);
var_dump($time_hour);

var_dump($time_m);

var_dump($time_s);












