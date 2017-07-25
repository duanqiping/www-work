<?php  

date_default_timezone_set("Asia/Shanghai");
	
	
	
//echo $beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w'),date('Y')); //当周起始时间
echo "\n";
//echo $beginThismonth=mktime(0,0,0,date('m'),1,date('Y')); //当月起始时间
	
echo mktime(0,0,0,1,1,date('Y'));
