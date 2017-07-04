<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 10:32
 */

namespace Home\Model;


class Map
{
    private static $EARTH_RADIUS = 6378.137;//地球半径,单位千米

    protected $customer = array();//客户信息
    protected $length = 0;//最短距离

    private static function rad($d)
    {
        return $d * pi() / 180.0;
    }

    /**
     *
     * @param lat1 第一个纬度
     * @param lng1第一个经度
     * @param lat2第二个纬度
     * @param lng2第二个经度
     * @return 两个经纬度的距离
     */
    public function  getCustomerInfo( $lat1, $lng1,$data)
    {
        for($i=0,$len=count($data);$i<$len;$i++)
        {
            $lat2 = $data[$i]['latitude_x'];
            $lng2 = $data[$i]['longitude_y'];

            $radLat1 = self::rad($lat1);
            $radLat2 = self::rad($lat2);
            $a = $radLat1 - $radLat2;
            $b = self::rad($lng1) - self::rad($lng2);

            $s = 2 * asin(sqrt(pow(sin($a/2),2) +
                    cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
            $s = $s * self::$EARTH_RADIUS;
            $s = round($s * 10000) / 10000;

            if($this->length == 0 || $this->length > $s){
                $this->customer = $data[$i];
                $this->length = $s;
            }
        }
        return $this->customer;
    }
}