<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/11/18
 * Time: 9:46
 */
namespace Index\Controller;

use Common\Controller\BaseController;
use Org\Net\IpLocation;

class CityController extends BaseController
{
    //城市定位
    public function location()
    {
        import('ORG.Net.IpLocation');
        $ip = get_client_ip();//获取用户的IP

        $Ip = new IpLocation('UTFWry.dat'); // 传入IP地址库文件名
        $location = $Ip->getlocation($ip); // 获取某个IP地址所在的位置  218.64.55.216  -》 江西省南昌市  218.79.93.194=>上海市

        $info = $location['country'];
        if (preg_match('/省/i', $info, $res))//江西省南昌市
        {
            $city = explode('省', $info);
            $city = explode('市', $city[1]);
        } else {
            $city = explode('市', $info);//上海市
        }

        if ($city[0] == '中国') $city[0] = '上海';

        $data = array('name'=>$city[0]);

        sendSuccess($data);
    }
}