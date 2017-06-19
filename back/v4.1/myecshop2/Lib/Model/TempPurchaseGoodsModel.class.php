<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2015/7/23
 * Time: 18:29
 */
class TempPurchaseGoodsModel extends BaseModel
{
    public $tableName = 'ecs_temp_purchase_goods';

    protected $fields = array('temp_purchase_goods_id','temp_purchase_id','version','amount','unit','price','description','goods_id','name','goods_cat_id','brand_name','goods_color','area_id','goods_sn','private_price','shop_price','_pk'=>'temp_purchase_goods_id','autoinc'=>true);

    public function __construct($database_type)
    {
        parent::__construct();
        if ($database_type == 2)
        {
            $this->db(1, 'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_purchase_goods';
        }
    }

    //获取多条记录
    public function getMultipleInfo($condition,$field)
    {
        return $res = $this->table($this->tableName)->where($condition)->field($field)->select();
    }

    //对tempPurchaseGoodsAdd表插入相应的信息
    public function insertPurchaseGoodsAdd($order_id,$temp_purchase_id)
    {
        $purchase_info = $this->getMultipleInfo(array('temp_purchase_id'=>$temp_purchase_id),'temp_purchase_goods_id,temp_purchase_id,goods_id,amount,area_id');
        $purchase_info_add = array();
        for($i=0,$len=count($purchase_info);$i<$len;$i++)
        {
            $purchase_info_add[$i]['temp_purchase_id'] = $order_id;
            $purchase_info_add[$i]['temp_purchase_new_id'] = $temp_purchase_id;
            $purchase_info_add[$i]['temp_purchase_goods_id'] = $purchase_info[$i]['temp_purchase_goods_id'];
            $purchase_info_add[$i]['goods_id'] = $purchase_info[$i]['goods_id'];
            $purchase_info_add[$i]['amount'] = $purchase_info[$i]['amount'];
            $purchase_info_add[$i]['area_id'] = $purchase_info[$i]['area_id'];
            $purchase_info_add[$i]['add_type'] = 1;
        }
        $temppurchasegoodsadd = M('tempPurchaseGoodsAdd');
        $b = $temppurchasegoodsadd->addAll($purchase_info_add);
        return $b;
    }

    //判断订单是否支持货到付款
    public function huoDaoPay($order_id)
    {
        $condition['temp_purchase_id'] = $order_id;
        $res = $this->table($this->tableName)->where($condition)->field('area_id')->select();

        if($res[0]['area_id'] == 7) return true;//武汉开通货到付款权限

        //查看用户权限
        $sql = "select temp_buyers_permission_id from ecs_temp_buyers_permission WHERE  area_id='{$res[0]['area_id']}' AND permission_id=1 AND temp_buyers_id=".$_SESSION['temp_buyers_id'];
        if ($res2 = $this -> query($sql))  return true;

//        //查看用户的vip等级
//        $sql_vip = "select vip from ecs_temp_buyers where company_id>0 AND temp_buyers_id=".$_SESSION['temp_buyers_id'];
//        $res_vip = $this->query($sql_vip);
//        if ($res2 = $this -> query($sql) || $res_vip[0]['vip']==5)  return true;

        return false;
    }

    //获取商品信息 (确认下单接口，订单详情接口,订单列表,去结算接口)
    public function getByTempGoodsId($temp_purchase_id,$database_type,$res_table)
    {
        $condition['temp_purchase_id']=$temp_purchase_id;
        $condition['amount'] = array('gt',0);

        //找材猫
        if($database_type == 1)
        {
            $sql = "select a.version,a.amount,a.unit goods_unit,a.price shop_price,a.description,a.name goods_name,a.goods_cat_id,a.goods_id,a.brand_name,a.area_id,a.goods_color,b.goods_cat_id,b.sort_order,b.goods_thumb from $this->tableName a left join {$res_table['goods_table']} b on a.goods_id=b.goods_id left join {$res_table['goods_category_table']} c on b.goods_cat_id=c.goods_category_id where a.temp_purchase_id='$temp_purchase_id' and a.amount>0 order by c.sort_order,b.goods_cat_id";
        }
        //品材宝
        else
        {
            $sql = "select a.version,a.amount,a.unit goods_unit,a.price shop_price,a.description,a.name goods_name,a.goods_cat_id,a.goods_id,a.brand_name,a.area_id,a.goods_color,b.goods_cat_id,b.sort_order,b.goods_thumb from pcwb2bs.b2b_pcy_purchase_goods a left join pcwb2bs.{$res_table['goods_table']} b on a.goods_id=b.goods_id left join pcwb2bs.{$res_table['goods_category_table']} c on b.goods_cat_id=c.goods_category_id where a.temp_purchase_id='$temp_purchase_id' and a.amount>0 order by c.sort_order,b.goods_cat_id";
        }

        $res = $this->query($sql);

        for($i=0; $i<count($res); $i++)
        {
            $res[$i]['goods_thumb']=ImgDeal($res[$i]['goods_thumb'],$database_type);

            $res[$i]['type'] = ($res[$i]['area_id'] == 10)?2:1; //3为主材尾货 其他情况为辅材
            $res[$i]['database_type'] = $database_type;

            $res[$i]['version_name'] = $res[$i]['version'];//这一步搞了我很久
            unset($res[$i]['version']);

            $res[$i]['color']['color_name'] = $res[$i]['goods_color'];

            $res[$i]['brand']['brand_name'] = $res[$i]['brand_name'];

            if($res[$i]['goods_color'] == '默认')  $res[$i]['version']['version_name'] = $res[$i]['version_name'];
            else $res[$i]['version']['version_name'] = $res[$i]['version_name'];

            $res[$i]['cat']['cat_id'] = $res[$i]['goods_cat_id'];

            unset($res[$i]['brand_name']);
            unset($res[$i]['version_name']);
            unset($res[$i]['goods_cat_id']);

            $res[$i]['amount'] = floor($res[$i]['amount']);//数量只能为整数
        }
        return $res;
    }

    //商品名获取 已售数量
    public function  getGoodsMount($name)
    {
        //$name="卫生间吊顶";//测试数据
        $sql = "select amount from ecs_temp_purchase_goods where name='{$name}'";
        $res = $this->query($sql);

        $totalNum = 0;
        foreach($res as $k=>$v)
        {
            $totalNum += $res[$k]['amount'];
        }
        return $totalNum;
    }

    //判断商品表是否还有对应的商品
//    public function goodsIfExist($goods_id,$area_id)
//    {
//
//        //获取对应的goods表就行
//        $area_sql = "select goods_table from ecs_goods_area where goods_area_id=".$area_id;
//        $area_result = $this ->query($area_sql);
//        $goods_table = $area_result[0]['goods_table'];
//
//        $sql = "select goods_name from ".$goods_table." where goods_id='$goods_id' and is_pass=1";
//
//        $result = $this->query($sql);
//
//        if($result)
//        {
//            return 1;//商品表还有对应的商品
//        }else
//        {
//            return 0;//商品表已经移除对应的商品
//        }
//
//    }

    //订单完成接口,更新对应的goods表中的sales
    public function updateGoodsTable($data,$database_type)
    {
        //获取对应的goods表就行
        if($database_type == 1)
        {
            $area_sql = "select goods_table from ecs_goods_area where goods_area_id=".$data[0]['area_id'];
            $area_result = $this -> query($area_sql);
            $goods_table = $area_result[0]['goods_table'];
        }
        else
        {
            $goods_table = 'b2b_pcy_goods';
        }


        for($i=0,$len=count($data);$i<$len;$i++ )
        {
            $goods_sql = "update $goods_table set sales=sales+'{$data[$i]['amount']}' WHERE goods_id='{$data[$i]['goods_id']}' AND is_pass=1";

            $b = $this->execute($goods_sql);
            if(!$b)
            {
                //商品已经无效
                continue;//结束本次循环
            }
        }


    }

    //取消订单  商品回购物车
    public function backShopCar($order_id,$uid,$area_id,$database_type)
    {
        if($database_type == 1)
        {
            $sql = "select goods_table from ecs_goods_area where goods_area_id=$area_id";
            $res_table = $this->query($sql);
            $goods_table = $res_table[0]['goods_table'];//对应的商品表
        }
        else
        {
            $goods_table = 'b2b_pcy_goods';//对应的商品表
        }

        $sql_goods = "SELECT pg.goods_id,pg.amount,pg.area_id,g.suppliers_id,g.version_id,g.cat_id,g.goods_cat_id FROM $this->tableName pg LEFT JOIN $goods_table g on pg.goods_id=g.goods_id WHERE ( pg.temp_purchase_id = $order_id ) AND ( pg.amount > 0 ) and g.is_delete=0";
        $data = $this->query($sql_goods);

        $shopcar = new ShopcarModel($database_type);
        for ($i = 0, $len = count($data); $i < $len; ++$i)
        {
            $data[$i]['car_type'] = 0;//购物车 0
            $data[$i]['buyers_id'] = $uid;//

            $condition_shop['goods_id'] = $data[$i]['goods_id'];
            $condition_shop['area_id'] = $data[$i]['area_id'];
            $condition_shop['buyers_id'] = $data[$i]['buyers_id'];
            $condition_shop['car_type'] = $data[$i]['car_type'];
            $res = $shopcar->getSingleInfo($condition_shop, 'shop_car_id');

            if ($res)
            {
                //购物车有这个商品  更新数量
                $b = $shopcar->table($shopcar->tableName)->where(array('shop_car_id'=>$res['shop_car_id']))->setInc('amount',$data[$i]['amount']);
                if ($b != 1)
                {
                    $this->rollback();
                    return false;
                }
            }
            else
            {
                $b = $shopcar->table($shopcar->tableName)->add($data[$i]);//加入购物车
                if ($b < 1) {
                    $this->rollback();//回滚
                    return false;
                }

            }
        }
        return true;
    }
}