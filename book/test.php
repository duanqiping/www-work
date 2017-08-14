<?php  

date_default_timezone_set("Asia/Shanghai");

function getTimeBegin($year,$time_flag,$num)
{
    if($time_flag == 'week'){
        //$begin_time = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y')); //当周起始时间
        $begin_time = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y')); //当周起始时间
    }else if($time_flag == 'month'){
        //$begin_time = mktime(0,0,0,date('m'),1,date('Y')); //当月起始时间
        $begin_time = mktime(0,0,0,$num,1,$year); //当月起始时间
    }else if($time_flag == 'year'){
        //$begin_time =  mktime(0,0,0,1,1,date('Y')-1);//当年起始时间
        $begin_time =  mktime(0,0,0,1,1,2017);//当年起始时间
    }else{
        return false;
    }
    return $begin_time;
}

function getMonth($year,$month)
{
	$date = date("$year-$month");
		
	$firstDay = $weekday['start'] = date('Y-m-01', strtotime($date));
	$weekday['end'] =  date('Y-m-d 23:59:59', strtotime("$firstDay +1 month -1 day"));
	
	$weekday['start'] = strtotime($weekday['start']);
	$weekday['end'] = strtotime($weekday['end']);
	
	return $weekday;
}

function yearDay($year)
    {
        $yearday = array();
        $date = date("$year");

        $firstDay = $weekday['start'] = date("$year-01-01", strtotime($date));

        $end =  date('Y-m-d 23:59:59', strtotime("$firstDay +12 month -1 day"));

        $yearday[] = strtotime($firstDay);
        $yearday[] = strtotime($end);

        return $yearday;
    }



//echo getTimeBegin($year=2017,$flag='month',$num = 5);

var_dump(getMonth(2016,8));
var_dump(yearDay(2015));













