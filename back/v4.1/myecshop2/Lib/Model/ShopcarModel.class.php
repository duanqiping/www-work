<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/7
 * Time: 10:29
 */
class ShopcarModel extends BaseModel
{
    public $tableName = 'ecs_shopcar';

    //获取商品的收藏状态
    protected $fields = array('shop_car_id','goods_id','amount','buyers_id','suppliers_id','car_type','version_id','area_id','cat_id','goods_cat_id','invitation_person','_pk'=>'shop_car_id','_autoinc'=>true);

    public function __construct($database_type)
    {
        parent::__construct();
        if($database_type == 2)
        {
            $this->db(1,'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_shopcar';
        }
    }

    //获取单条记录
    public function getSingleInfo($condition,$field)
    {
        return $res = $this->table($this->tableName)->where($condition)->field($field)->find();
    }

    //获取多条信息
    public function getMultipleInfo($condition,$field)
    {
        return $res=$this->where($condition)->field($field)->select();
    }

    //判断商品是否存在  存在就改变数量  否则就添加一条新纪录到购物车表
    public function addShopCar($arr,$database_type)
    {
        $condition['goods_id'] = $arr['goods_id'];
        $condition['buyers_id'] = $arr['buyers_id'];
        if($database_type != 2) $condition['area_id'] = $arr['area_id'];//品材宝商品不区分城市
        $condition['suppliers_id'] = $arr['suppliers_id'];
        $condition['car_type'] = 0;

        $res = $this ->table($this->tableName)-> where($condition) -> field('shop_car_id')->find();//查询购物车中是否存在

        if($res)
        {
            $b = $this->table($this->tableName)->where(array('shop_car_id'=>$res['shop_car_id']))->setInc('amount',$arr['amount']);

            if(!$b)
            {
                $this->error_info = '更新数量失败';
                $this->error_code = '5001';
                return false;
            }
            else
            {
                return true;//商品已存在， 添加数量即可
            }
        }
        else
        {
            if($this->table($this->tableName)->add($arr))
            {
                return true;//加入购物车
            }
            else
            {
                $this->error_info = '加入购物车失败';
                $this->error_code = '5002';
                return false;
            }
        }
    }

    //获取购物车中的数据
    public function getByBuyersId($buyers_id,$area_id)
    {
        $sql_area = "select goods_table,goods_category_table from ecshop.ecs_goods_area WHERE goods_area_id='$area_id'";
        $res_area = $this->query($sql_area);
        $goods_table = $res_area[0]['goods_table'];
        $goods_category_table = $res_area[0]['goods_category_table'];


        $res = array();
//        //批发商品  以后得去掉
//        $sql_z = "select a.shop_car_id,a.goods_id,a.suppliers_id,1 as database_type,a.amount,a.area_id,IF((select count(*) from ecs_shopcar s where s.goods_id=a.goods_id AND s.buyers_id='$buyers_id' AND s.car_type='1' AND s.area_id='10'),1,0) as is_collection from ecs_shopcar a  where a.car_type=0 and  a.area_id='10' and a.buyers_id='$buyers_id' order by a.cat_id,a.shop_car_id DESC";
//        $res_zhu = $this->query($sql_z);
//        if($res_zhu)
//        {
//            $zhucai['title'] = '批发商品';
//            $zhucai['desc'] = '满'.$this->minMoney(10).'才可下单';
//            $zhucai['suppliers_id'] = 5060;
//            $zhucai['type'] = 2;
//            $zhucai['data'] = $res_zhu;
//            $res[] = $zhucai;
//        }
        //仅查询出辅材
        $sql_f = "select a.shop_car_id,a.goods_id,a.suppliers_id,1 as database_type,a.amount,a.area_id,b.goods_cat_id,b.sort_order,IF((select count(*) from ecs_shopcar s where s.goods_id=a.goods_id AND s.buyers_id='$buyers_id' AND s.car_type='1' AND s.area_id='$area_id'),1,0) as is_collection from ecs_shopcar a left join $goods_table b on a.goods_id=b.goods_id left join $goods_category_table c on b.goods_cat_id=c.goods_category_id where a.car_type=0 and  a.area_id='$area_id' and a.buyers_id='$buyers_id' order by c.sort_order,b.goods_cat_id,a.shop_car_id DESC ";
        $res_f = $this->query($sql_f);
        if($res_f)
        {
            $fucai['title'] = '辅材';
            $fucai['desc'] = '满'.$this->minMoney($area_id).'才可下单';
            $fucai['suppliers_id'] = 1024;
            $fucai['type'] = 1;
            $fucai['data'] = $res_f;
            $res[] = $fucai;
        }

        //主材商城
        $sql_h = "select a.shop_car_id,a.goods_id,a.suppliers_id,2 as database_type,a.amount,a.area_id,IF((select count(*) from pcwb2bs.b2b_pcy_shopcar s where s.goods_id=a.goods_id AND s.buyers_id='$buyers_id' AND s.car_type='1'),1,0) as is_collection from pcwb2bs.b2b_pcy_shopcar a  where a.car_type=0 and a.buyers_id='$buyers_id' order by a.cat_id,a.shop_car_id DESC";
        $res_h = $this->query($sql_h);
        $result =   array();
        foreach($res_h as $k=>$v){
            $result[$v['suppliers_id']][]    =   $v;//suppliers_id 相同的再进行分组
        }
        $result = array_values($result);

        for($i=0,$len=count($result);$i<$len;$i++)
        {
            $sql_user = "select pcy_companyname,pcy_companyname_abbreviation,pcy_company_person from pcwb2bs.b2b_user where user_id='{$result[$i][0]['suppliers_id']}'";
            $res_user = $this->query($sql_user);
            $res_user = $res_user[0];

//            $huangsha['title'] = $res_user['pcy_companyname_abbreviation']?$res_user['pcy_companyname_abbreviation']:$res_user['pcy_companyname'];
            $huangsha['title'] = $res_user['pcy_companyname'];
            $huangsha['desc'] = '';
            $huangsha['suppliers_id'] = $result[$i][0]['suppliers_id'];
            $huangsha['type'] = 2;
            $huangsha['data'] = $result[$i];
            $res[] = $huangsha;
        }

        if(count($res)<1) return array();

        for($i=0,$len=count($res); $i<$len; ++$i)
        {
            $goodsinfo = array();
            for($j=0,$len_j=count($res[$i]['data']);$j<$len_j;$j++)
            {
                $database_type=$res[$i]['data'][$j]['database_type'];
                $area_id = $res[$i]['data'][$j]['area_id'];
                $type = $res[$i]['type'];

                if( $database_type == 1) $goods_table = $this->getGoodsTable($area_id,$type); //找材猫
                else $goods_table = 'b2b_pcy_goods'; //品材宝 黄沙水泥

                $goods = new GoodsModel($goods_table,$database_type);
                $result = $goods -> getByIdCartList($res[$i]['data'][$j],$type,$database_type);

                //注意这里要显示严格相等
                if($result === true) continue;
                else if($result === false) return false;
                else $goodsinfo[] = $result;
            }
            $res[$i]['data'] = $goodsinfo;
        }
        return $res;
    }

    //获取收藏列表的数据
    public function getCollectByBuyersId($buyers_id,$area_id, $limit=10, $page=1)
    {
        $condition['buyers_id']=$buyers_id;
        $condition['car_type']=1;
        $condition['_string'] = "area_id=10 or area_id=$area_id"; //主材 辅材一起显示

        //偏移量
        $offset = ($page-1)*$limit;

        $res = array();
        $fucai = array();
        $zhucai = array();

        $sql_zhucai = "SELECT shop_car_id,goods_id,area_id,suppliers_id FROM $this->tableName WHERE buyers_id = '$buyers_id'  AND  car_type = 1  AND  area_id='10' ORDER by shop_car_id DESC";
        $res_zhucai = $this->query($sql_zhucai);
        if($res_zhucai)
        {
            $zhucai['title'] = '批发商品';
            $zhucai['desc'] = '满'.$this->minMoney(10).'才可下单';
            $zhucai['type'] = 2;
            $zhucai['data'] = $res_zhucai;
            $res[] = $zhucai;
        }

        $sql_fucai = "SELECT shop_car_id,goods_id,area_id,suppliers_id  FROM $this->tableName WHERE buyers_id = '$buyers_id'  AND  car_type = 1  AND  area_id='$area_id' ORDER by shop_car_id DESC";
        $res_fucai = $this->query($sql_fucai);

        if($res_fucai)
        {
            $fucai['title'] = '辅材';
            $fucai['desc'] = '满'.$this->minMoney($area_id).'才可下单';
            $fucai['type'] = 1;
            $fucai['data'] = $res_fucai;
            $res[] = $fucai;
        }

        if(!$res) return array();

        for($i=0,$len=count($res); $i<$len; ++$i)
        {
            $goodsinfo = array();
            for($j=0,$len_j=count($res[$i]['data']);$j<$len_j;$j++)
            {
                $area_id = $res[$i]['data'][$j]['area_id'];
                $type = $res[$i]['type'];

                //收藏只有 找材猫支持
                $goods_table = $this->getGoodsTable($area_id,$type);

                $goods = new GoodsModel($goods_table,$database_type=1);
                $result = $goods -> getById($res[$i]['data'][$j],$type,$database_type=1);

                //注意这里要显示严格相等
                if($result === true) continue;
                else if($result === false) return false;
                else $goodsinfo[] = $result;
            }
            unset($res[$i]['type']);
            $res[$i]['data'] = $goodsinfo;
        }
        return $res;
    }

    //智能下单 批量加入购物车
    public function cleverAddAll($goodsInfo,$uid,$area_id)
    {
        $this->startTrans();

        for ($i = 0, $len = count($goodsInfo); $i < $len; ++$i)
        {
            $condition['goods_id'] = $goodsInfo[$i]['goods_id'];
            $condition['area_id'] = $goodsInfo[$i]['area_id'] = $area_id;
            $condition['buyers_id'] = $goodsInfo[$i]['buyers_id'] = $uid;
            $condition['car_type'] = $goodsInfo[$i]['car_type'] = 0;

            $res = $this->getSingleInfo($condition, 'shop_car_id');

            if ($res)
            {
                $b = $this->table($this->tableName)->where(array('shop_car_id'=>$res['shop_car_id']))->setInc('amount',$goodsInfo[$i]['amount']);
                if ($b != 1)
                {
                    $this->rollback();
                    return false;
                }
            }
            else
            {
                //获取商品的cat_id、suppliers_id、version_id、goods_cat_id
                $sql = "select cat_id,suppliers_id,version_id,goods_cat_id from ecs_goods WHERE goods_id='{$goodsInfo[$i]['goods_id']}'";
                $res_goods = $this->query($sql);
                $res_goods = $res_goods[0];

                if(!$res_goods)
                {
                    $this->rollback();
                    return false;
                }
                else
                {
                    $goodsInfo[$i]['cat_id'] = $res_goods['cat_id'];
                    $goodsInfo[$i]['suppliers_id'] = $res_goods['suppliers_id'];
                    $goodsInfo[$i]['version_id'] = $res_goods['version_id'];
                    $goodsInfo[$i]['goods_cat_id'] = $res_goods['goods_cat_id'];
                }

                $b = $this->table($this->tableName)->add($goodsInfo[$i]);//加入购物车
                if ($b < 1) {
                    $this->rollback();//回滚
                    return false;
                }
            }
        }

        $this->commit();
        return true;
    }

    //获取最小下单金额
    public function minMoney($area_id)
    {
        $sql = "select min_money from ecs_goods_area WHERE goods_area_id='$area_id'";
        $res_area = $this->query($sql);
        return $res_area[0]['min_money'];
    }
}
