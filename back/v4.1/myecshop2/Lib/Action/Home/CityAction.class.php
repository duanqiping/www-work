<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/8
 * Time: 11:33
 * 获取城市列表、获取定位城市、搜索接口、城市选择接口、返回支持的城市地区
 */

class CityAction extends Action
{
    /** 获取城市列表*/
    public function show()
    {
        $goodsarea = new  GoodsAreaModel();
        $data = $goodsarea->where('app_is_show=1')->field('goods_area_id,goods_area,goods_table')->select();

        $goodsarea->printSuccess($data);
    }

    /** 获取定位城市*/
    public function location()
    {
        import('ORG.Net.IpLocation');
        $goodsarea = new  GoodsAreaModel();
        $ip = get_client_ip();//获取用户的IP

        $Ip = new IpLocation('UTFWry.dat'); // 传入IP地址库文件名
        $location = $Ip->getlocation($ip); // 获取某个IP地址所在的位置  218.64.55.216  -》 江西省南昌市  218.79.93.194=>上海市

        $info = $location['country'];//1. 上海市 、北京市  2.江西省南昌市、福建省泉州市  有这两种情况  后面还发现有ip直接对应到 中国 无语咯

        if (preg_match('/省/i', $info, $res))//江西省南昌市
        {
            $city = explode('省', $info);
            $city = explode('市', $city[1]);
        } else {
            $city = explode('市', $info);//上海市
        }

        if ($city[0] == '中国') $city[0] = '上海';

        $_SESSION['city'] = $city[0];//保存定位城市，返回用户信息能用的着

        //通过查询城市名 判断该城市是否入库
        $res = $goodsarea->getSingleInfo(array('goods_area' => $city[0]), 'goods_area_id,goods_area,goods_table');
        if (!$res) {
            $res['goods_area_id'] = 0;
            $res['goods_area'] = $city[0];
            $res['goods_table'] = '';
        }
        $_SESSION['area_id'] = $res['goods_area_id'];//保存定位城市id号

        $goodsarea->printSuccess($res);
    }

    /** 搜索接口 name用户输入的 type=1辅材 2批发*/
    public function search()
    {
        load("@.search");
        $base = new BaseModel();

        $name = isset($_POST['name']) ? trim($_POST['name']) : 0;

        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $pageSize = isset($_POST['pageSize']) ? $_POST['pageSize'] : 10;

        $database_type = $_POST['type'];//默认只搜索找材猫

        if ($name == '0') exit('{"success":"true","data":[]}');//用户没有输入搜索内容

        $sql = "select goods_table,brand_table from ecs_goods_area WHERE goods_area_id=".$_POST['area_id'];
        $res = $base->query($sql);
        $goods_table = $res[0]['goods_table'];
        $brand_table = $res[0]['brand_table'];

        $goods_table = ($_POST['type'] == 2) ? 'b2b_pcy_goods':$goods_table;//对应的商品表

        $goods = new GoodsModel($goods_table,$database_type);

        $pointArray = returnSearchNext();//搜索指定的二级数据

        $where_brand_ids = returnBrandIds($pointArray,$name);//指定搜索关键字  brand_ids 处理

        if($database_type == 1)
        {
            $data = $goods->getByNameLike($name, $page, $pageSize,$where_brand_ids,$brand_table,$database_type);//$where_brand_ids (58,219,288,289,227)
        }else
        {
            $data = $goods->getByNameLikeB2B($name, $page, $pageSize,$database_type);//$where_brand_ids (58,219,288,289,227)
        }


        $goods->printSuccess($data);
    }

    /** 搜索返回固定参数 name 用户输入*/
    public function searchPoint()
    {
        load("@.search");

        $base = new BaseModel();

        $name = isset($_POST['name']) ? trim($_POST['name']) : 0;
        $name =  strtoupper($name);//将英文字母转大写

        $array1 = returnSearchTop();//搜索指定的一级数据

        $b = in_array($array1[$name],$array1);

        if($b === false) $base->printError('没有匹配到关键字',4456);
        else $base->printSuccess($array1[$name]);
    }

    /** 城市选择接口*/
    public function select()
    {
        if (empty($_SESSION['temp_buyers_id']))//未登录的情况下...............
        {
            $arr['goods_area_id'] = isset($_POST['area_id']) ? $_POST['area_id'] : 1;//接收传过来的城市名
            if ($arr['goods_area_id'] == 1) {  //取默认城市上海
                $data['goods_area_id'] = 1;
                $data['city'] = "上海";
                $data['goods_table'] = 'ecs_goods';

                $response = array('success' => 'true', 'data' => $data);
                $response = ch_json_encode($response);
                exit($response);
            } else { //取本地城市
                $goodsarea = M('GoodsArea');
                $res = $goodsarea->where("goods_area_id={$arr['goods_area_id']}")->field('goods_area_id,goods_area,goods_table')->find();

                $data['goods_area_id'] = $res['goods_area_id'];
                $data['city'] = $res['goods_area'];
                $data['goods_table'] = $res['goods_table'];

                $response = array('success' => 'true', 'data' => $data);
                $response = ch_json_encode($response);
                exit($response);
            }
        } //已经登录的情况下
        else {
            $goods_area_id = $_POST['area_id'];

            $tempbuyers = M('TempBuyers');
            $condition['temp_buyers_id'] = $_SESSION['temp_buyers_id'];
            $tempbuyers->where($condition)->setField('area_id', $goods_area_id);//更新用户的area_id

            $goodsarea = M('GoodsArea');
            $res = $goodsarea->where("goods_area_id='$goods_area_id'")->field('goods_area_id,goods_area,goods_table')->find();

            $data['goods_area_id'] = $res['goods_area_id'];
            $data['city'] = $res['goods_area'];
            $data['goods_table'] = $res['goods_table'];

            $response = array('success' => 'true', 'data' => $data);
            $response = ch_json_encode($response);
            exit($response);

        }

    }

    /** 返回支持的城市地区*/
    public function support()
    {
        $base = new BaseModel();
        $base->is_login();

        $redis = $base->redis();
        if(!$redis) $base->printError('redis服务器错误',4900);

        //显示的支持的省份 城市 区域的所有信息（如果信息有任何变化，得及时更新缓存）
        $sql_res = "SELECT *  FROM ecs_region WHERE is_show=1";
        $res = $base->query($sql_res);
        $json_res = json_encode($res);
        $md5_res = md5($json_res);

//        $cache_len = file_get_contents('./Runtime/Cache/judge.txt');
        $cache_len = $redis->get('city_judge');
        if ($cache_len == $md5_res) {
//            $city_string = file_get_contents('./Runtime/Cache/city.txt');
            $city_string = $redis->get('city');
            exit($city_string);
        }

        //更新缓存
//        file_put_contents('./Runtime/Cache/judge.txt', $md5_res);
        $redis->set('city_judge', $md5_res);

        $data = array();
        //直辖市
        $sql_s = "select region_id id, region_name name,region_code from ecs_region WHERE father_id=0 AND is_show=1";
        $res_s = $base->query($sql_s);

        for ($i = 0, $len = count($res_s); $i < $len; $i++)
        {
            $data[$i]['id'] = $res_s[$i]['id'];
            $data[$i]['name'] = $res_s[$i]['name'];

            $sql_c = "select region_id id, region_name name,region_code from ecs_region  WHERE father_id='{$res_s[$i]['region_code']}' AND is_show=1";
            $res_c = $base->query($sql_c);
            $data[$i]['children'] = $res_c;
            for ($j = 0, $len_j = count($res_c); $j < $len_j; $j++) {
                $data[$i]['children'][$j]['name'] = $res_c[$j]['name'];

                $sql_d = "select region_id id, region_name name from ecs_region WHERE father_id='{$res_c[$j]['region_code']}' AND is_show=1";
                unset($data[$i]['children'][$j]['region_code']);
                $res_d = $base->query($sql_d);

                $data[$i]['children'][$j]['children'] = $res_d;
            }
        }
        $response = array('success' => 'true', 'data' => $data);
        $response = ch_json_encode($response);

        //更新缓存
//        file_put_contents('./Runtime/Cache/city.txt', $response);
        $redis->set('city', $response);

        exit($response);
    }

}