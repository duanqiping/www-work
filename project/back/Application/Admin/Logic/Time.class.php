<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/14
 * Time: 13:35
 */

namespace Admin\Logic;


class Time {
    /**
     * 获取某年第几周的开始日期和结束日期
     * @param int $year
     * @param int $week 第几周;
     */
    public function weekday($year,$week=1){
        $year_start = mktime(0,0,0,1,1,$year);
        $year_end = mktime(0,0,0,12,31,$year);

        // 判断第一天是否为第一周的开始
        if (intval(date('W',$year_start))===1){
            $start = $year_start;//把第一天做为第一周的开始
        }else{
//            $week++;
            $start = strtotime('+1 monday',$year_start);//把第一个周一作为开始
        }

        // 第几周的开始时间
        if ($week===1){
            $weekday['start'] = $start;
        }else{
            $weekday['start'] = strtotime('+'.($week-0).' monday',$start);
        }

        // 第几周的结束时间
//        $weekday['end'] = strtotime('+1 sunday',$weekday['start']);
        $weekday['end'] = strtotime('+1 sunday',$weekday['start'])+ 23*3600+59*60+59;
        if (date('Y',$weekday['end'])!=$year){
            $weekday['end'] = $year_end;
        }
        $array_week[] = $weekday['start'];
        $array_week[] = $weekday['end'];
        return $array_week;
    }

    /**
     * 计算一年有多少周，每周从星期一开始，
     * 如果最后一天在周四后（包括周四）算完整的一周，否则不计入当年的最后一周
     * 如果第一天在周四前（包括周四）算完整的一周，否则不计入当年的第一周
     * @param int $year
     * return int
     */
    public function week($year){
        $year_start = mktime(0,0,0,1,1,$year);
        $year_end = mktime(0,0,0,12,31,$year);
        if (intval(date('W',$year_end))===1){
            return date('W',strtotime('last week',$year_end));
        }else{
            return date('W',$year_end);
        }
    }

    /**
     * 获取某年第几月的开始日期和结束日期
    */
    public function monthDay($year,$month)
    {
        $weekday = array();
        $date = date("$year-$month");

        $firstDay = date('Y-m-01', strtotime($date));//某个月的开始时间
        $end = date('Y-m-d 23:59:59', strtotime("$firstDay +1 month -1 day"));//某个月的结束时间

        $weekday[] = strtotime($firstDay);
        $weekday[] = strtotime($end);

        return $weekday;
    }

    /**
     * 获取某年的开始日期和结束日期
     */
    public function yearDay($year)
    {
        $yearday = array();
        $date = date("$year");

        $firstDay = $weekday['start'] = date("$year-01-01", strtotime($date));

        $end =  date('Y-m-d 23:59:59', strtotime("$firstDay +12 month -1 day"));

        $yearday[] = strtotime($firstDay);
        $yearday[] = strtotime($end);

        return $yearday;
    }
} 