<?php  
	
	date_default_timezone_set("Asia/Shanghai");
    
	$time = time();
	
	echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))),"\n"; //本周起始时间 周一为一周的开始
	
	echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))),"\n"; //本月起始时间  1498838399 1498838400
	
	
	echo date("Y-m-d H:i:s",mktime(0,0,0,1,1,date("Y", time())))."<br>"; //本年起始时间
	
	function rankChoiceRule($flag)
	{
		if($flag == 'year'){
			return  date("Y-m-d H:i:s",mktime(0,0,0,1,1,date("Y", time()))) ;//本年起始时间
		}else if($flag == 'month'){
			return  date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))) ;//本月起始时间
		}else{
			return  date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))) ;//本周起始时间
		}
	}
	
	echo $time=strtotime(rankChoiceRule('year')),"\n";
	echo $time=strtotime(rankChoiceRule('month')),"\n";
	echo $time=strtotime(rankChoiceRule('week')),"\n";
	
	
		
	
	
	

