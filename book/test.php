<?php  


date_default_timezone_set("Asia/Shanghai");


	
	
	
function getMillisecond() { 
list($s1, $s2) = explode(' ', microtime()); 
return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); //411
} 

/** 格式化时间戳，精确到毫秒，x代表毫秒 */

function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

$res = getMillisecond();//1501232826
//$res1 = microtime_format("Y-m-d H:i:s",time());
$res2 = microtime_float();

var_dump($res);
var_dump($res2);