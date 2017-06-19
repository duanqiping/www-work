<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2015/7/24
 * Time: 18:23
 */
class GoodsModel extends BaseModel
{
    public $tableName = 'ecs_goods';

    //表中所有的字段
//    protected $fields = array('goods_id','cat_id','goods_sn','goods_version','goods_name','goods_unit','brand_name','suppliers_name','shop_price','public_price','private_price','goods_desc','goods_thumb','goods_img','original_img','add_time','sort_order','is_delete','last_update','suppliers_id','is_pass','reason','admin_id','admin_time','mobile_sort_order','goods_cat_id','color_id','version_id','brand_id','hotbrand_id','goods_color','goods_name_id','min_amount','transportation','transportation_type','addition_fee','_pk'=>'goods_id','_autoinc'=>true);

    //准备查询的商品字段 (商品列表 商品详情 商品搜索等接口)
    protected $fields_s = 'g.goods_name_id,g.goods_id,g.suppliers_id,g.goods_cat_id,g.goods_version,g.goods_name,g.goods_unit,g.brand_name,g.version_id,g.brand_id,g.color_id,g.goods_color,g.goods_thumb, g.goods_img,g.min_amount';

    //命名规范  商品的默认分组和排序..
    protected $_scope = array(
        'default'=>array(
            'order'=>'mobile_sort_order,CONVERT(goods_name USING gb2312),shop_price',
            'group'=>'goods_name_id,version_id',
        ),
    );

    //计算普通商品的一个条件
    private $condition_shanghai_is= array('not in',array(104,162,136,137,131,185,186,187,188,189,190,157,183,184,107,109,147));//上海(有板材)
    private $condition_shanghai_no= array('not in',array(104,162,136,137,131,185,186,187,188,189,190,157,183));//上海(没板材)

    private $condition_weifang= array('not in',array(12));//


    private $s_banCai_catID_is = array('in',array(104,162,136,137,184,107,109,147));//上海(有板材)
    private $s_banCai_catID_no = array('in',array(104,162,136,137));//上海(没板材)

    public function __construct($table_name,$database_type)
    {
        if($database_type == 2)
        {
            $this->db(1,'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_goods';
        }
        else
        {
            $this -> tableName = $table_name;
        }

        parent::__construct($table_name);
    }

    //返回板材 goods_cat_id 条件
    private function banCaiCount($goods)
    {
        $goods_in = array();
        for($i=0,$len=count($goods);$i<$len;$i++)
        {
            $goods_in[] = $goods[$i]['goods_id'];
        }
        $condition_judge['goods_id'] = array('in',$goods_in);
        $condition_judge['goods_cat_id'] = $this->s_banCai_catID_no;
        $count = $this->where($condition_judge)->count();

        return $count;
    }

//    //获取单条记录
//    public function getSingleInfo($condition,$field)
//    {
//        return $res = $this->table($this->tableName)->where($condition)->field($field)->find();
//    }

    //获取多条记录
    public function getMultipleInfo($condition,$field)
    {
        return $res = $this->where($condition)->field($field)->select();
    }

    //商品model组装
    public function goodsModel($data,$type,$area_id)
    {
        $data['type'] = $type;
        $data['area_id'] = $area_id;

        if(!$data['goods_thumb']) $data['goods_thumb']="";//如果图片为空 缩略图
        else $data['goods_thumb']=ImgDeal($data['goods_thumb'],$data['database_type']);
        if(!$data['goods_img']) $data['goods_img']="";//如果图片为空
        else $data['goods_img']=ImgDeal($data['goods_img'],$data['database_type']);

        $data['color']['color_id'] = $data['color_id'];
        $data['color']['color_name']=$data['goods_color'];
        unset($data['color_id']);
        unset($data['goods_color']);

        $data['cat']['cat_id'] = $data['goods_cat_id'];
        unset($data['cat_id']);

        $data['version']['version_name']=$data['goods_version'];
        $data['version']['version_id']=$data['version_id'];
        unset($data['goods_version']);
        unset($data['version_id']);

        $data['brand']['brand_name']=$data['brand_name'];
        $data['brand']['brand_id']=$data['brand_id'];
        unset($data['brand_name']);
        unset($data['brand_id']);

        return $data;
    }

    //批发商城每个一级分类下的商品总价不得低于1000元
    public function piFaMinPrice($goodsInfo,$area_id,$type,$min_price)
    {
        $res = array();
        for($i=0,$len=count($goodsInfo);$i<$len;$i++)
        {
            $res_brand = $this->getSingleInfo(array('goods_id'=>$goodsInfo[$i]['goods_id']),'brand_id,suppliers_id');
            $brand_id = $res_brand['brand_id'];
            $suppliers_id = $res_brand['suppliers_id'];
            $price_field = $this->returnPriceField($area_id,$type,$brand_id,$suppliers_id);//获取对应商品价格字段

            $conditon['goods_id'] = $goodsInfo[$i]['goods_id'];
            $res[$i] = $this->table($this->tableName)->where($conditon)->field("$price_field shop_price,cat_id")->find();
            $res[$i]['amount'] = $goodsInfo[$i]['amount'];
        }

        //对数组的cat_id 相同的进行重新分组
        $result =   array();
        foreach($res as $k=>$v){
            $result[ $v['cat_id'] ][]    =   $v;
        }

        //判断一级分类下的商品总价是否大于1000
        foreach($result as $k=>$v)
        {
            $total = 0;
            for($j=0,$len_j=count($v);$j<$len_j;$j++)
            {
                $total += $v[$j]['shop_price']*$v[$j]['amount'];
            }
            if($total < $min_price and $v[0]['cat_id']==5)
            {
                //查出一级分类的名字
                $sql = "select goods_category_name from ecs_goods_category_pifa where cat_id=".$v[0]['cat_id'];
                $res_name = $this->query($sql);
                $res_name[0]['goods_category_name'] = str_replace("\r\n",'、',$res_name[0]['goods_category_name']);

                $this->error_info = $res_name[0]['goods_category_name'].'类批发商品总价不得少于'.$min_price;
                $this->error_code = 4808;
                return false;
            }
            if($total < 1000 and $v[0]['cat_id']!=5)
            {
                //查出一级分类的名字
                $sql = "select goods_category_name from ecs_goods_category_pifa where cat_id=".$v[0]['cat_id'];
                $res_name = $this->query($sql);
                $res_name[0]['goods_category_name'] = str_replace("\r\n",'、',$res_name[0]['goods_category_name']);

                $this->error_info = $res_name[0]['goods_category_name'].'类批发商品总价不得少于1000';
                $this->error_code = 4809;
                return false;
            }
        }
        return true;
    }
    //计算商品总价
    public function getPrice($goods,$area_id,$type,$database_type)
    {
        $res_brand = $this->getSingleInfo(array('goods_id'=>$goods['goods_id']),'brand_id');
        $brand_id = $res_brand['brand_id'];

        $price_field = $this->returnPriceField($area_id,$type,$brand_id,$database_type);

        $condition['goods_id']=$goods['goods_id'];
        $res = $this->getSingleInfo(array('goods_id'=>$goods['goods_id']),"min_amount,$price_field price,goods_cat_id");

        $company_id = $this->returnCompanyId();
        //对商品价格进行处理
        $res['price'] = $this->shopPriceDeal($company_id,$area_id,$type,$database_type,$res['price'],$res['goods_cat_id'],$_SESSION['temp_buyers_id']);

        $total =($res['price']*$goods['amount']);//计算商品的总价

        if($res['min_amount'] > $goods['amount'])
        {
            $this->error_info = $res['goods_name'].'购买数量不能少于'.$res['min_amount'];
            $this->error_code = 4808;
        }
        else
        {
            return $total;
        }
    }

    //确认下单 最少数量
    public function TempGoodsInfo($goodsInfo,$area_id,$type,$database_type,$uid)
    {
        $tempGoods = array();
        for ($i = 0,$len = count($goodsInfo);$i<$len;$i++)
        {
            //商品价格优惠率
            $res_brand = $this->getSingleInfo(array('goods_id'=>$goodsInfo[$i]['goods_id']),'brand_id,suppliers_id');
            $brand_id = $res_brand['brand_id'];

            $price_field = $this->returnPriceField($type,$area_id,$brand_id,$database_type);//获取对应商品价格字段

            $condition['goods_id']=$goodsInfo[$i]['goods_id'];
            $res = $this->table($this->tableName)
                ->where($condition)
                ->field("goods_version version,goods_unit unit,goods_name,min_amount,$price_field price,goods_desc description,goods_name name,cat_id goods_cat_id,brand_name,goods_id,goods_color,goods_sn,suppliers_id,private_price,goods_cat_id true_goods_cat_id,shop_price")
                ->find();
            $company_id = $this->returnCompanyId();
            //对商品价格进行处理
            $res['price'] = $this->shopPriceDeal($company_id,$area_id,$type,$database_type,$res['price'],$res['true_goods_cat_id'],$uid);

            unset($res['min_amount']);
            unset($res['true_goods_cat_id']);
            $res['amount'] = $goodsInfo[$i]['amount'];
            $res['area_id'] = $area_id;
            $tempGoods[] = $res;
        }
        return $tempGoods;
    }

    //计算商品总金额
    public function TotalMoney($goodsInfo,$area_id,$type,$database_type,$uid)
    {
        $total = 0.00;
        $company_id = $this->returnCompanyId();
        for ($i = 0,$len = count($goodsInfo);$i<$len;$i++)
        {
            //商品价格优惠率
            $res_brand = $this->getSingleInfo(array('goods_id'=>$goodsInfo[$i]['goods_id']),'brand_id,suppliers_id');
            $brand_id = $res_brand['brand_id'];

            $price_field = $this->returnPriceField($type,$area_id,$brand_id,$database_type);//获取对应商品价格字段

            $condition['goods_id']=$goodsInfo[$i]['goods_id'];
            $res = $this->table($this->tableName)->where($condition)->field("$price_field price,goods_cat_id")->find();

            //对商品价格进行处理
            $res['price'] = $this->shopPriceDeal($company_id,$area_id,$type,$database_type,$res['price'],$res['goods_cat_id'],$uid);

            $total +=($res['price']*$goodsInfo[$i]['amount']);//计算商品的总价
        }


        return $total;
    }

    //商品最少购买数量
    public function MinNum($goodsInfo)
    {
        for ($i = 0,$len = count($goodsInfo);$i<$len;$i++)
        {
            //商品价格优惠率
            $condition['goods_id']=$goodsInfo[$i]['goods_id'];
            $res = $this->table($this->tableName)->where($condition)->field("min_amount")->find();
            if($res['min_amount'] > $goodsInfo[$i]['amount'])
            {
                $this->error_info=$res['goods_name'].'购买数量不能少于'.$res['min_amount'];
                $this->error_code=4808;
                return false;
            }
        }
        return true;
    }

    //潍坊
    public function ni_sha_price_weifang($goods)
    {
        $total = 0;//特殊商品总价
        $res=array();

        $condition['goods_cat_id'] = 12;//水泥黄沙对应的goods_cat_id
        for($i=0; $i<count($goods); $i++)
        {
            $res_brand = $this->getSingleInfo(array('goods_id'=>$goods[$i]['goods_id']),'brand_id,suppliers_id');
            $brand_id = $res_brand['brand_id'];
            $suppliers_id = $res_brand['suppliers_id'];

            $price_field = $this->returnPriceField(1,9,$brand_id,$suppliers_id);

            $condition['goods_id'] = $goods[$i]['goods_id'];
            $res[$i] = $this -> getSingleInfo($condition,"$price_field shop_price");

            if(!$res[$i]) continue;//结束 本次循环

            $total+=($res[$i]['shop_price']*$goods[$i]['amount']);//特殊商品总价

        }
        if($total==0 || $total>=288) return 1;
        else return null;//不过
    }

    //对辅材商品价格限制做判断
    public function judgeNormal($goods,$min_price,$uid,$area_id,$type,$database_type)
    {
        $total_all = 0;//所以商品总价
        $total_transportation = 0;//运费补差价

        $company_id = $this->returnCompanyId();

        if($area_id == 1)
        {
            //$count = $this->banCaiCount($goods);
            //if($count>=1) $condition_normal['goods_cat_id'] = $this->condition_shanghai_is;//有板材
            //else $condition_normal['goods_cat_id'] = $this->condition_shanghai_no;//没有板材
        }
        else if($area_id == 9) $condition_normal['goods_cat_id'] = $this->condition_weifang;

        for($i=0,$len=count($goods); $i<$len; $i++)
        {
            $res_brand = $this->getSingleInfo(array('goods_id'=>$goods[$i]['goods_id']),'brand_id,suppliers_id');
            $brand_id = $res_brand['brand_id'];

            $price_field = $this->returnPriceField($area_id,$type,$brand_id,$database_type);

            $condition_all['goods_id'] = $goods[$i]['goods_id'];
            $res_all = $this -> getSingleInfo($condition_all,"$price_field shop_price,goods_cat_id");

            $res_all['shop_price'] = $this->shopPriceDeal($company_id,$area_id,$type,$database_type,$res_all['shop_price'],$res_all['goods_cat_id'],$_SESSION['temp_buyers_id']);

            if($res_all['goods_cat_id'] == 164) $total_transportation += $res_all['shop_price']*$goods[$i]['amount'];//计算运费补差价总金额

            $total_all+=($res_all['shop_price']*$goods[$i]['amount']);//计算普通商品的总价
        }
        $result = null;

        if($total_all >= $min_price || $total_transportation>=50) $result = null;
        else $result = '辅材总价不能少于'.$min_price;//不过（不含特殊商品）

        if($result != null && $area_id==1)
        {
            $db_name = C('DB_NAME');
            $sql = "select c.goods_id,g.goods_cat_id from $db_name.ecs_shopcar c LEFT JOIN $db_name.ecs_goods g on c.goods_id=g.goods_id WHERE c.buyers_id='$uid' AND c.car_type=0 AND c.area_id='$area_id'";
            $res_shopcar = $this->query($sql);
            $transonly=1;
            foreach($res_shopcar as $k=>$v)
            {
                if($v['goods_cat_id'] != 164) $transonly=0;//如果购物车中仅有164,如果有其他商品，则不能结算
            }
            if ($transonly==1) return null;
            else return $result;
        }
        else
        {
            return $result;
        }
    }

    //对特殊商品价格做判断
    public function judugeAll($goods,$price,$min_price) {
        $b1 = $this->ni_sha_price_weifang($goods,$price,$min_price);
        if($b1 == 0) return  '水泥黄沙砖类商品总价不得少于288，请致电客服：4006002063';
        return null;
    }

    //价格判断 统一函数（来自於心力 2）
    public function processLeastMoneyForShanghai0818($goods,$min_money,$area_id,$type,$database_type)
    {
        if($area_id!=1) return null;

        $totalyichen = 0;
        $totalaiwei = 0;
        $totalcommon=0;
        $totalfuhai = 0;//福海板材类商品
        $totaltrans = 0;//运费补差价
        $totalelse=0;
        $total=0;

        $company_id = $this->returnCompanyId();

        for($i=0,$len=count($goods);$i<$len;$i++)
        {
            $res_brand = $this->getSingleInfo(array('goods_id'=>$goods[$i]['goods_id']),'brand_id,suppliers_id');
            $brand_id = $res_brand['brand_id'];

            $price_field = $this->returnPriceField($type,$area_id,$brand_id,$database_type);

            $g = $this->table($this->tableName)->where(array('goods_id'=>$goods[$i]['goods_id']))->field("$price_field shop_price,goods_hotcat_id,goods_cat_id,cat_id,cms_suppliers_id,brand_id,hotbrand_id")->find();

            $g['shop_price'] = $this->shopPriceDeal($company_id,$area_id,$type,$database_type,$g['shop_price'],$g['goods_cat_id'],$_SESSION['temp_buyers_id']);

            if($area_id==1&&($g['goods_cat_id']== 162||$g['goods_cat_id']== 136||$g['goods_cat_id']== 137 || $g['goods_cat_id']== 104)&&($g['hotbrand_id']!= 350&&$g['hotbrand_id']!= 378&&$g['hotbrand_id']!= 381&&$g['hotbrand_id']!= 36&&$g['hotbrand_id']!= 393))
            {
                $price = floatval($goods[$i]['amount'])*$g['shop_price'];
                $totalyichen += $price;
            }

            if($area_id==1 && ($g['brand_id']== 350||$g['brand_id']==378||$g['brand_id']==381||$g['brand_id']==36||$g['brand_id']== 393)){
                $price = floatval($goods[$i]['amount'])*$g['shop_price'];
                $totalaiwei += $price;
            }

            if($area_id==1&&($g['goods_cat_id']== 162||$g['goods_cat_id']== 136||$g['goods_cat_id']== 137||$g['goods_cat_id']== 104)&& ($g['hotbrand_id']== 350||$g['hotbrand_id']==378||$g['hotbrand_id']==381||$g['hotbrand_id']== 36 || $g['hotbrand_id']== 393))
            {
                $price = floatval($goods[$i]['amount'])*$g['shop_price'];
                $totalcommon += $price;
            }
            if($area_id==1&&$g['goods_cat_id']== 197)
            {
                $price = floatval($goods[$i]['amount'])*$g['shop_price'];
                $totalfuhai += $price;
            }
            if($g['goods_cat_id'] == 164){
                $totaltrans += $g['shop_price']*$goods[$i]['amount'];//计算运费补差价总金额
            }
            if($area_id==1 && $g['goods_cat_id']!=164 && $g['goods_cat_id']!=197 && $g['goods_cat_id']!=162 && $g['goods_cat_id']!=136 && $g['goods_cat_id']!=137 && $g['goods_cat_id']!=104 && $g['brand_id']!= 350 && $g['brand_id']!=378 && $g['brand_id']!=381 && $g['brand_id']!=36 && $g['brand_id']!= 393)
            {
                $price = floatval($goods[$i]['amount'])*$g['shop_price'];
                $totalelse += $price;
            }

            $price = floatval($goods[$i]['amount'])*$g['shop_price'];
            $total += $price;
        }
        
        if($totalelse>0 && $total<$min_money)
        {
            $totaltrans=$totaltrans-50;
        }

        if($totalfuhai<600 && $totalfuhai>0)
        {
            if($totaltrans<100)
            {
                return '福海板材类商品总价不得少于600，请致电客服：4006002063';
            }
            else
            {
                $totaltrans=$totaltrans-100;
            }

        }

        if((($totalyichen+$totalcommon)<600) && $totalyichen>0)
        {
            if($totaltrans<100)
            {
                return  '板材类商品总价不得少于600，请致电客服：4006002063';
            }
            else
            {
                $totaltrans=$totaltrans-100;
            }
        }
        if(($totalaiwei+$totalyichen==0)&&$totalcommon<600&&$totalcommon>0)
        {
            if($totaltrans<100)
            {
                return  '板材类商品总价不得少于600，请致电客服：4006002063';
            }
            else
            {
                $totaltrans=$totaltrans-100;
            }

        }

        if($totalyichen>=600 || $totalyichen==0)
        {
            $totalcommon2=$totalcommon;
        }
        else
        {
            $totalcommon2=$totalyichen+$totalcommon-800;
        }
        if($totalcommon2<0)
        {
            $totalcommon2=0;
        }

        if((($totalaiwei+$totalcommon2)<600) && ($totalaiwei>0))
        {
            if($totaltrans<100)
            {
                return '德丽斯类商品总价不得少于600，请致电客服：4006002063';
            }
        }

        return null;
    }

    //模糊查询(通过型号 或者 名字 模糊查询)
    //下面搜索逻辑 仅适用非智能搜索
    //搜索逻辑说明  1用户输入的关键字-》关键字后面第三个字后面加一个空格(关键字长度大于三)-》关键字后面第二个字后面加一个空格-》取前面三个字-》取前面两个字-》取前面一个字
    //egg 多乐士二代五合一  多乐士二代五合一 ==》多乐士 二代五合一 ==》多乐 士二代五合一 ==》多乐士 ==》多乐 ==》多
    public function getByNameLike($name,$page,$pageSize,$brand_ids='',$brand_table,$database_type)
    {
        $uid = $_SESSION['temp_buyers_id'];
        $offset = ($page - 1) * $pageSize;//

        $map['goods_name|goods_version|brand_name'] = array('like', '%' . $name . '%');
        $map['is_pass'] = 1;
        $map['is_delete'] = 0;

        $this->is_if_login($_POST['token']);

        $price_field = $this->returnPriceField($_POST['type'], $_POST['area_id'],1,$database_type);

        $company_id = $this->returnCompanyId();
        $company_count = $this->returnCompanyCount($company_id);

        $res = array();
        if (!$brand_ids)
        {
            //举例说明 多乐士二代五合一净味
            $sql = "SELECT $this->fields_s,g.$price_field shop_price  FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.is_search=1 and (g.goods_name LIKE '%$name%' OR g.goods_version LIKE '%$name%' OR g.brand_name LIKE '%$name%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0 and g.is_search=1) < 1 ";
            if($company_count>0){
                $sql=$sql." and find_in_set('".$company_id."',companies)";
            }
            $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";

            $res = $this->query($sql);
            if($res) $_SESSION['key_word'] = $name;
        }

        if(!$res && !$brand_ids && mb_strlen($name,"utf-8")> 3)
        {
            //举例说明 多乐士二代五合一净味 ==》多乐士 二代五合一净味（第三个字后面加空格）
            $name1 = mb_substr($name, 0, 3, 'utf-8') . ' ' . mb_substr($name, 3, mb_strlen($name), 'utf-8');
            $sql = "SELECT $this->fields_s,g.$price_field shop_price  FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.is_search=1 and (g.goods_name LIKE '%$name1%' OR g.goods_version LIKE '%$name1%' OR g.brand_name LIKE '%$name1%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0 and g.is_search=1) < 1 ";
            if($company_count>0){
                $sql=$sql." and find_in_set('".$company_id."',companies)";
            }
            $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";
            $res = $this->query($sql);
            if($res) $_SESSION['key_word'] = $name1;

            if(!$res)
            {
                //举例说明 多乐士二代五合一净味 ==》多乐 士二代五合一净味（第二个字后面加空格）
                $name2 = mb_substr($name, 0, 2, 'utf-8') . ' ' . mb_substr($name, 2, mb_strlen($name), 'utf-8');
                $sql = "SELECT $this->fields_s,g.$price_field shop_price  FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.is_search=1 and (g.goods_name LIKE '%$name2%' OR g.goods_version LIKE '%$name2%' OR g.brand_name LIKE '%$name2%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0 and g.is_search=1) < 1";
                if($company_count>0){
                    $sql=$sql." and find_in_set('".$company_id."',companies)";
                }
                $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";
                $res = $this->query($sql);
                if($res) $_SESSION['key_word'] = $name2;
            }
        }

        if(!$res)
        {
            $res = $this->searchAgain($price_field,$name,$offset,$pageSize,$brand_ids,$brand_table,$company_id,$company_count);
        }

        if(!$res)  return array();//搜索没有该商品

        //返回优惠率
        $type = $_POST['type'];

        $company_id = $this->returnCompanyId();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $res[$i] = $this->goodsInfoPack($res[$i],$company_id,$_POST['area_id'],$type,$database_type,$res[$i]['shop_price'],$res[$i]['goods_cat_id'],$uid);
        }
        return $res;
    }

    public function getByNameLikeB2B($name,$page,$pageSize,$database_type)
    {
        $uid = $_SESSION['temp_buyers_id'];
        $offset = ($page - 1) * $pageSize;//

        $map['goods_name|goods_version|brand_name'] = array('like', '%' . $name . '%');
        $map['is_pass'] = 1;
        $map['is_delete'] = 0;

        $this->is_if_login($_POST['token']);

        $price_field = $this->returnPriceField($_POST['type'], $_POST['area_id'],1,$database_type);

        $res = array();
        $suppliers_in = $this->suppliersSelect();
        if(!$res && mb_strlen($name,"utf-8")> 3)
        {
            //举例说明 多乐士二代五合一净味 ==》多乐士 二代五合一净味（第三个字后面加空格）
            $name1 = mb_substr($name, 0, 3, 'utf-8') . ' ' . mb_substr($name, 3, mb_strlen($name), 'utf-8');
            $sql = "SELECT $this->fields_s,g.$price_field shop_price  FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.suppliers_id in $suppliers_in and (g.goods_name LIKE '%$name1%' OR g.goods_version LIKE '%$name1%' OR g.brand_name LIKE '%$name1%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0) < 1 ";
            $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";
            $res = $this->query($sql);
            if($res) $_SESSION['key_word'] = $name1;

            if(!$res)
            {
                //举例说明 多乐士二代五合一净味 ==》多乐 士二代五合一净味（第二个字后面加空格）
                $name2 = mb_substr($name, 0, 2, 'utf-8') . ' ' . mb_substr($name, 2, mb_strlen($name), 'utf-8');
                $sql = "SELECT $this->fields_s,g.$price_field shop_price  FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.suppliers_id in $suppliers_in and  (g.goods_name LIKE '%$name2%' OR g.goods_version LIKE '%$name2%' OR g.brand_name LIKE '%$name2%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0) < 1";
                $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";
                $res = $this->query($sql);
                if($res) $_SESSION['key_word'] = $name2;
            }
        }
        if(!$res)
        {
            $res = $this->searchAgainB2B($price_field,$name,$offset,$pageSize,$suppliers_in);
        }

        if(!$res)  return array();//搜索没有该商品

        //返回优惠率
        $type = $_POST['type'];

        $company_id = $this->returnCompanyId();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            //对商品价格进行处理
            $res[$i] = $this->goodsInfoPack($res[$i],$company_id,$_POST['area_id'],$type,$database_type,$res[$i]['shop_price'],$res[$i]['goods_cat_id'],$uid);
        }
        return $res;
    }

    //搜索接口进行再次搜索
    public function searchAgain($price_field,$name,$offset,$pageSize,$brand_ids,$brand_table,$company_id,$company_count)
    {
        if($brand_ids)
        {
            $name = explode(' ',$name );
            $name = $name[0];
            $sql = "SELECT $this->fields_s,g.$price_field shop_price,b.sort_order FROM $this->tableName g  LEFT JOIN $brand_table b ON g.brand_id=b.brand_id WHERE g.is_pass=1 and g.is_delete=0 and g.brand_id in $brand_ids and ( g.goods_version LIKE '%$name%' OR g.goods_color LIKE '%$name%' OR g.goods_name LIKE '%$name%')  ";
            if($company_count>0){
                $sql=$sql." and find_in_set('".$company_id."',companies)";
            }
            $sql = $sql." ORDER BY b.sort_order,g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";
        }
        else
        {
            $sql = "SELECT $this->fields_s,g.$price_field shop_price FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.is_search=1 and (g.goods_name LIKE '%$name%' OR g.goods_version LIKE '%$name%' OR g.brand_name LIKE '%$name%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0 and g.is_search=1) < 1";
            if($company_count>0){
                $sql=$sql." and find_in_set('".$company_id."',companies)";
            }
            $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";
        }
        $res = $this->query($sql);
        
        if(!$res && mb_strlen($name,"utf-8")>=1 )
        {
            if(mb_strlen($name,"utf-8")> 3)
            {
                $name=mb_substr($name,0,3,'utf-8');
                return $this->searchAgain($price_field,$name,$offset,$pageSize,$brand_ids,$brand_table,$company_id,$company_count);
            }
            else if(mb_strlen($name,"utf-8")> 2)
            {
                $name=mb_substr($name,0,2,'utf-8');
                return $this->searchAgain($price_field,$name,$offset,$pageSize,$brand_ids,$brand_table,$company_id,$company_count);
            }
            else if(mb_strlen($name,"utf-8") == 2)
            {
                $name=mb_substr($name,0,1,'utf-8');
                return $this->searchAgain($price_field,$name,$offset,$pageSize,$brand_ids,$brand_table,$company_id,$company_count);
            }
            else
            {
                return false;
            }
        }
        else
        {
            $_SESSION['key_word'] = $name;//从搜索接口进入到品牌列表中需要
            return $res;
        }
    }

    //搜索接口进行再次搜索
    public function searchAgainB2B($price_field,$name,$offset,$pageSize,$suppliers_in)
    {
        $sql = "SELECT $this->fields_s,g.$price_field shop_price FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.suppliers_id in $suppliers_in and (g.goods_name LIKE '%$name%' OR g.goods_version LIKE '%$name%' OR g.brand_name LIKE '%$name%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0) < 1";
        $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$pageSize";

        $res = $this->query($sql);

        if(!$res && mb_strlen($name,"utf-8")>=1 )
        {
            if(mb_strlen($name,"utf-8")> 3)
            {
                $name=mb_substr($name,0,3,'utf-8');
                return $this->searchAgainB2B($price_field,$name,$offset,$pageSize,$suppliers_in);
            }
            else if(mb_strlen($name,"utf-8")> 2)
            {
                $name=mb_substr($name,0,2,'utf-8');
                return $this->searchAgainB2B($price_field,$name,$offset,$pageSize,$suppliers_in);
            }
            else if(mb_strlen($name,"utf-8") == 2)
            {
                $name=mb_substr($name,0,1,'utf-8');
                return $this->searchAgainB2B($price_field,$name,$offset,$pageSize,$suppliers_in);
            }
            else
            {
                return false;
            }
        }
        else
        {
            $_SESSION['key_word'] = $name;//从搜索接口进入到品牌列表中需要
            return $res;
        }
    }

    //主材搜索 供应商范围
    private function suppliersSelect()
    {
        $sqlsuppliers="select user_id from pcwb2bs.b2b_user where ecs_pcb_category_id in (select goods_category_id FROM ecshop.ecs_goods_category_pcb WHERE parent_id=1 AND grade=2 AND is_show=1)";
        $ressuppliers = $this->query($sqlsuppliers);
        $in_suppliers = '(';
        for($i=0,$len=count($ressuppliers);$i<$len;$i++)
        {
            if($i == $len-1)
            {
                $in_suppliers .= $ressuppliers[$i]['user_id'].')';
            }
            else
            {
                $in_suppliers .= $ressuppliers[$i]['user_id'].',';
            }

        }
        return $in_suppliers;
    }

    //商品详情接口
    public function GoodsDetail($goods_id, $area_id,$type,$goods_gallery_table,$database_type)
    {
        $uid = $_SESSION['temp_buyers_id'];

        $condition_temp['goods_id']=$goods_id;
        $condition_temp['is_delete']=0;

        $res = $this ->table($this->tableName)-> where($condition_temp)->field('version_id,brand_id,goods_name_id')->find();
        if(!$res) return false;

        //查询对应的价格字段
        $price_field = $this->returnPriceField($type,$area_id,$res['brand_id'],$database_type);

        $company_id = 0;
        if( $database_type==1 )
        {
            $company_id = $this->returnCompanyId();
            $company_count = $this->returnCompanyCount($company_id);

            //is_collect 判断是否已经收藏 1已经收藏 0未收藏
            $sql = "SELECT $this->fields_s,g.$price_field shop_price FROM  $this->tableName  g ".
                "WHERE (   g.version_id  = {$res["version_id"]} ) AND (   g.brand_id  = {$res["brand_id"]} ) ".
                "AND (   g.goods_name_id  = {$res["goods_name_id"]} ) AND (   g.is_pass  = 1 ) AND (   g.is_delete  = 0 )";
            if($company_count>0){
                $sql=$sql." and find_in_set('".$company_id."',companies)";
            }
            $sql =$sql ." ORDER BY g.mobile_sort_order,g.shop_price,g.goods_id ";
            $res1 = $this->query($sql);
        }
        else
        {
            $sql = "SELECT g.goods_name_id,g.goods_id,g.goods_cat_id,g.goods_version,g.goods_name,g.goods_unit,g.brand_name,g.version_id,g.brand_id,g.color_id,g.suppliers_id,g.goods_color,g.goods_thumb, g.goods_img,g.min_amount,g.$price_field shop_price FROM  $this->tableName  g ".
                "WHERE (   g.version_id  = {$res["version_id"]} ) AND (   g.brand_id  = {$res["brand_id"]} ) AND (   g.goods_name_id  = {$res["goods_name_id"]} ) AND (   g.is_pass  = 1 ) AND (   g.is_delete  = 0 ) ORDER BY g.mobile_sort_order,g.shop_price,g.goods_id ";
            $res1 = $this->query($sql);
        }

        //获取商品 对应的图片集合
        $goodsgallery = new GoodsGalleryModel($goods_gallery_table,$database_type);

        $shopcar = new ShopcarModel($database_type);
        for($i=0,$len=count($res1); $i<$len; $i++)
        {
            $res_shopcar = $shopcar->getSingleInfo(array('goods_id'=>$res1[$i]['goods_id'],'buyers_id'=>$uid,'suppliers_id'=>$res1[$i]['suppliers_id'],'area_id'=>$area_id,'car_type'=>1),'shop_car_id');
            $shop_car_id = $res_shopcar['shop_car_id'];

            $res1[$i]['shop_car_id'] = $shop_car_id;
            if($shop_car_id) $res1[$i]['is_collection'] = 1;
            else $res1[$i]['is_collection'] = 0;

            $imgs[$i] = $goodsgallery -> getImgs($res1[$i]['goods_id'],$res1[$i]['goods_img'],$database_type);//获取图片集
            $res1[$i]['imgs'] = $imgs[$i];

            //对商品价格进行处理
            $res1[$i] = $this->goodsInfoPack($res1[$i],$company_id,$area_id,$type,$database_type,$res1[$i]['shop_price'],$res1[$i]['goods_cat_id'],$uid);
        }
        return $res1;
    }

    //通过brand_id查询商品信息(商品列表、搜索接口)
    public function getGoodsInfoByBrandID($area_id,$type,$brand_id,$limit=10,$page=1,$database_type,$name='')
    {
        $condition['brand_id'] = $brand_id;
        $condition['is_pass'] = 1;
        $condition['is_delete'] = 0;

        $offset = ($page-1)*$limit;////偏移量

        $price_field = $this->returnPriceField($type,$area_id,$brand_id,$database_type);

        $company_id = $this->returnCompanyId();
        $company_count = $this->returnCompanyCount($company_id);

        //查询是我的常用商品（找材猫）
        $flag = false;
        $res_goods = array();
        $uid = $_SESSION['temp_buyers_id'];
        if($uid>0 && $database_type==1)
        {
            $sql  = "select goods_id from ecs_temp_bought WHERE buyers_id='$uid' AND brand_id='$brand_id'".
                " AND area_id='$area_id' group by goods_id ORDER BY temp_bought_id DESC limit $offset,$limit ";
            $res_goods = $this->query($sql);
            if($res_goods) $flag = true;
        }

        $res = array();
        //我的常用
        if($flag)
        {
            for($i=0,$len=count($res_goods); $i<$len; $i++)
            {
                $condition_f['goods_id'] = $res_goods[$i]['goods_id'];
                $condition_f['is_delete'] = 0;
                $condition_f['is_pass'] = 1;
                $resgoods = $this->table("$this->tableName g")->where($condition_f)->field("$this->fields_s,g.$price_field shop_price")->find();
                if(!$resgoods) continue;
                $res[] = $resgoods;
            }
        }
        //找材猫列表
        else if($database_type == 1)
        {
            if(!$name)
            {
                //商品列表 （bands_id 全部商品）
                $sql = "select $this->fields_s,g.$price_field shop_price FROM $this->tableName g ".
                    "WHERE g.is_pass=1 and g.is_delete=0 and (g.brand_id='$brand_id' or g.hotbrand_id='$brand_id') ".
                    "AND g.shop_price=(SELECT shop_price FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id and (brand_id='$brand_id' OR hotbrand_id='$brand_id') and is_pass=1 and is_delete=0";
                if($company_count>0){
                    $sql=$sql." and find_in_set('".$company_id."',companies)";
                }
                $sql=$sql." order by hotbrand_id desc,shop_price limit 0,1) group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$limit";
            }
            else
            {
                //商品列表 （bands_id 和 $name 条件下查找出符号条件的商品）

                load("@.search");

                $pointArray = returnSearchNext();//搜索指定的二级数据
                $where_brand_ids = returnBrandIds($pointArray,$name);//指定搜索关键字  brand_ids 处理

                $name = $_SESSION['key_word'];//搜索关键字 使用session中保存的
                if($where_brand_ids)
                {
                    //智能搜索（美其名曰）
                    $sql = "SELECT $this->fields_s,g.$price_field FROM $this->tableName g   WHERE g.is_pass=1 and g.is_delete=0 and g.brand_id = $brand_id and ( g.goods_version LIKE '%$name%' OR g.goods_color LIKE '%$name%' OR g.goods_name LIKE '%$name%')";
                    if($company_count>0){
                        $sql=$sql." and find_in_set('".$company_id."',companies)";
                    }
                    $sql = $sql." limit $offset,$limit";
                }
                else
                {
                    //普通搜索
                    $sql = "SELECT $this->fields_s,g.$price_field shop_price FROM $this->tableName g  WHERE g.is_pass=1 and g.is_delete=0 and g.brand_id = $brand_id and (g.goods_name LIKE '%$name%' OR g.goods_version LIKE '%$name%' OR g.brand_name LIKE '%$name%') AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = g.goods_name_id AND version_id=g.version_id AND shop_price < g.shop_price and is_pass=1 and is_delete=0) < 1";
                    if($company_count>0){
                        $sql=$sql." and find_in_set('".$company_id."',companies)";
                    }
                    $sql = $sql." group by g.goods_name_id,g.version_id ORDER BY g.mobile_sort_order,CONVERT(g.goods_name USING gb2312),g.shop_price limit $offset,$limit";
                }
            }
            $res = $this->query($sql);
            if(!$res) return array();
        }
        //品材宝列表
        else
        {
            if(!$name)
            {
                $sql = "SELECT a.goods_name_id,a.goods_id,a.goods_cat_id,a.goods_version,a.goods_name,a.goods_unit,a.brand_name,a.$price_field shop_price,a.version_id,a.suppliers_id,a.brand_id,a.goods_thumb, a.goods_img  FROM $this->tableName a ".
                    "WHERE a.is_pass=1 and a.is_delete=0 and a.brand_id='$brand_id' ".
                    "AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = a.goods_name_id AND version_id=a.version_id AND shop_price < a.shop_price and is_pass=1 and is_delete=0) < 1 ".
                    "group by a.goods_name_id,a.version_id ORDER BY a.brand_id desc,a.sort_order asc, a.add_time desc limit $offset,$limit";

            }
            else
            {
                //商品列表 （bands_id 和 $name 条件下查找出符号条件的商品）
                $name = $_SESSION['key_word'];//搜索关键字 使用session中保存的

                $sql = "SELECT a.goods_name_id,a.goods_id,a.goods_cat_id,a.goods_version,a.goods_name,a.suppliers_id,a.goods_unit,a.brand_name,a.$price_field shop_price,a.version_id,a.brand_id,a.goods_thumb, a.goods_img  FROM $this->tableName a ".
                    "WHERE a.is_pass=1 and a.is_delete=0 and a.brand_id='$brand_id' and (a.goods_name LIKE '%$name%' OR a.goods_version LIKE '%$name%' OR a.brand_name LIKE '%$name%') ".
                    "AND (SELECT COUNT(*) FROM $this->tableName WHERE goods_name_id = a.goods_name_id AND version_id=a.version_id AND shop_price < a.shop_price and is_pass=1 and is_delete=0) < 1 ".
                    "group by a.goods_name_id,a.version_id ORDER BY a.brand_id desc,a.sort_order asc, a.add_time desc limit $offset,$limit";
            }
            $res = $this->query($sql);
            if(!$res) return array();
        }
        for($i=0,$len=count($res); $i<$len; $i++)
        {
            $res[$i] = $this->goodsInfoPack($res[$i],$company_id,$area_id,$type,$database_type,$res[$i]['shop_price'],$res[$i]['goods_cat_id'],$uid);
        }
        return $res;
    }

    //智能下单
    public function cleverGoodsInfo($goodsInfo)
    {
        $type = 1;//默认辅材
        $area_id = 1;//默认上海
        $company_id = $this->returnCompanyId();

        $res2 = array();
        for($i=0,$len = count($goodsInfo);$i<$len;$i++)
        {
            if($goodsInfo[$i]['amount'] < 1) continue;

            $res_brand = $this->table($this->tableName)->where(array('goods_id'=>$goodsInfo[$i]['goods_id']))->field('brand_id')->find();
            $price_field = $this->returnPriceField($type,$area_id,$res_brand['brand_id'],1);
            
            $condition['goods_id'] = $goodsInfo[$i]['goods_id'];
            $condition['is_delete'] = 0;
            $res = $this->table($this->tableName) -> where($condition) -> field("goods_id,goods_version,goods_name,goods_unit,brand_name,$price_field shop_price,color_id,brand_id,version_id,goods_color,goods_thumb,goods_img,min_amount,goods_cat_id") -> find();

            $res['amount'] = $goodsInfo[$i]['amount'];

            //对商品价格进行处理
            $res2[] = $this->goodsInfoPack($res,$company_id,$area_id,$type,1,$res['shop_price'],$res['goods_cat_id'],$_SESSION['temp_buyers_id']);
        }
        return $res2;
    }

    //主材商城 首页产品推荐
    public function goodsRecommend($database_type)
    {
        $area_id = $_POST['area_id']?$_POST['area_id']:1;
        $type = $_POST['type']?$_POST['type']:1;

        $company_id = $this->returnCompanyId();
        $price_field = $this->returnPriceField($type,$area_id,'',$database_type);

        $condition['is_hot'] = 1;
        $condition['is_delete'] = 0;
        $condition['is_pass'] = 1;

        $res = $this->table($this->tableName)->where($condition)->field("goods_id,goods_version,goods_name,goods_unit,brand_name,$price_field shop_price,public_price,color_id,brand_id,version_id,suppliers_id,goods_color,goods_thumb,goods_img,min_amount,goods_cat_id")->select();

        for($i=0,$len = count($res);$i<$len;$i++)
        {
            $res[$i] = $this->goodsInfoPack($res[$i],$company_id,$area_id,$type,$database_type,$res[$i]['shop_price'],$res[$i]['goods_cat_id'],$_SESSION['temp_buyers_id']);
        }
        return $res;
    }

    //供应商 产品推荐
    public function suppliersGoodsRecommend($database_type,$suppliers_id)
    {
        $area_id = $_POST['area_id']?$_POST['area_id']:1;
        $type = $_POST['type']?$_POST['type']:1;

        $company_id = $this->returnCompanyId();
        $price_field = $this->returnPriceField($type,$area_id,'',$database_type);

        $condition['suppliers_id'] = $suppliers_id;
        $condition['is_delete'] = 0;
        $condition['is_pass'] = 1;

        $res = $this->table($this->tableName)
            ->where($condition)
            ->field("goods_id,goods_version,goods_name,goods_unit,brand_name,$price_field shop_price,public_price,color_id,brand_id,version_id,suppliers_id,goods_color,goods_thumb,goods_img,min_amount,goods_cat_id")
            ->order('goods_id desc')
            ->limit(5)
            ->select();

        for($i=0,$len = count($res);$i<$len;$i++)
        {
            $res[$i] = $this->goodsInfoPack($res[$i],$company_id,$area_id,$type,$database_type,$res[$i]['shop_price'],$res[$i]['goods_cat_id'],$_SESSION['temp_buyers_id']);
        }
        return $res;
    }

    //收藏夹列表
    public function getById($arr,$type,$database_type)
    {
        $uid = $_SESSION['temp_buyers_id'];
        $res_brand = $this->getSingleInfo(array('goods_id'=>$arr['goods_id']),'brand_id');
        $brand_id = $res_brand['brand_id'];

        $price_field = $this->returnPriceField($type,$arr['area_id'],$brand_id,$database_type);

        $condition['goods_id']=$arr['goods_id'];
        $condition['is_delete']=0;
        $res = $this ->table($this->tableName)
            -> where($condition)
            -> order('version_id')
            -> field("goods_id,goods_version,goods_name,goods_unit,brand_name,$price_field shop_price,color_id,version_id,brand_id,suppliers_id,goods_color,goods_img,goods_thumb,goods_cat_id,min_amount")
            -> find();

        if(!$res)
        {
            //如果没有了对应的商品，则删除无效的收藏
            $shopcar = new ShopcarModel($database_type);
            $b = $shopcar->table($shopcar->tableName)->where(array('shop_car_id'=>$arr['shop_car_id'],'buyers_id'=>$uid))->delete();
            return $b?true:false;
        }
        else
        {
            $res['shop_car_id'] = $arr['shop_car_id'];
            $res['amount'] = $arr['amount'];
            if(isset($arr['is_collection'])) $res['is_collection'] = $arr['is_collection'];//购物车 需要这个参数
            //对商品价格进行处理
            $company_id = $this->returnCompanyId();
//            $res['database_type'] = $database_type;
//            $res = $this->goodsModel($res,$type,$arr['area_id']);
//            $res['shop_price'] = $this->shopPriceDeal($company_id,$arr['area_id'],$type,$database_type,$res['shop_price'],$res['goods_cat_id'],$_SESSION['temp_buyers_id']);
            $res = $this->goodsInfoPack($res,$company_id,$arr['area_id'],$type,$database_type,$res['shop_price'],$res['goods_cat_id'],$uid);

            return $res;
        }

    }

    //购物车列表
    public function getByIdCartList($arr,$type,$database_type)
    {
        $uid = $_SESSION['temp_buyers_id'];
        $res_goods = $this->getSingleInfo(array('goods_id'=>$arr['goods_id']),'brand_id');
        $brand_id = $res_goods['brand_id'];

        $price_field = $this->returnPriceField($type,$arr['area_id'],$brand_id,$database_type);

        $condition['goods_id']=$arr['goods_id'];
        $condition['is_delete']=0;
        $res = $this ->table($this->tableName)
            -> where($condition)
            -> order('version_id')
            -> field("goods_id,goods_version,goods_name,goods_unit,brand_name,$price_field shop_price,color_id,version_id,brand_id,suppliers_id,goods_color,goods_img,goods_thumb,goods_cat_id,min_amount")
            -> find();

        if(!$res)
        {
            //如果没有了对应的商品，则删除无效的收藏
            $shopcar = new ShopcarModel($database_type);
            $b = $shopcar->table($shopcar->tableName)->where(array('shop_car_id'=>$arr['shop_car_id'],'buyers_id'=>$uid))->delete();
            return $b?true:false;
        }
        else
        {
            $res['shop_car_id'] = $arr['shop_car_id'];
            $res['amount'] = $arr['amount'];
            if(isset($arr['is_collection'])) $res['is_collection'] = $arr['is_collection'];//购物车 需要这个参数
            //对商品价格进行处理
            $company_id = $this->returnCompanyId();
            $res = $this->goodsInfoPack($res,$company_id,$arr['area_id'],$type,$database_type,$res['shop_price'],$res['goods_cat_id'],$uid);

            return $res;
        }

    }

    //计算运费接口
    public function transportation($goods,$id)
    {
        $sql_region = "select region_id from ecs_temp_buyers_address WHERE temp_buyers_address_id='$id'";
        $res_region = $this->query($sql_region);

        if(!$res_region)
        {
            $response = array('success' => 'false', 'error' => array('msg' => '请更新你的收货地址', 'code' => '4809'));
            $response = ch_json_encode($response);
            exit($response);
        }

        $total_transportation = 0;//运费
        for($i=0,$len=count($goods);$i<$len;$i++)
        {
            $sql_goods = "SELECT g.transportation,g.transportation_type,g.cat_id,g.addition_fee,t.price FROM $this->tableName g LEFT JOIN ecs_region_transportation t ON g.transportation_type=t.transportation_type WHERE  g.goods_id = '{$goods[$i]['goods_id']}' AND t.region_id='{$res_region[0]['region_id']}'";
            $res = $this->query($sql_goods);

            $addition_fee = 0;//起步价
            if($res[0]['transportation_type'] == 2)
            {
                $addition_fee = $res[0]['addition_fee'];//起步价
            }
            if($res[0]['transportation_type'] == 1 && ($res[0]['cat_id']==2 or $res[0]['cat_id']==3))
            {
                $sql_shanghai="select father_id from ecs_region where region_id=".$res_region[0]['region_id'];
                $res_shanghai = $this->query($sql_shanghai);
                $father_id = $res_shanghai[0]['father_id'];
                if($father_id==3001)
                {
                    $res[0]['transportation']=0;
                }

            }
            if($res[0]['transportation_type'] == 1 && ($res[0]['cat_id']==1))
            {
                $sql_shanghai="select pcw_order from ecs_region where region_id=".$res_region[0]['region_id'];
                $res_shanghai = $this->query($sql_shanghai);
                $pcw_order = $res_shanghai[0]['pcw_order'];
                if($pcw_order==2 || $pcw_order==10 || $pcw_order==11)
                {
                    $res[0]['transportation']=0;
                }

            }
            $total_transportation += ($addition_fee+$res[0]['transportation']*$res[0]['price'])*$goods[$i]['amount'];
        }
        return $total_transportation;
    }

    //找平施工 额外计算价钱
    private function zhaoPingSiGong($area_id,$type,$goods_cat_id,$temp_buyers_id,$shop_price)
    {
        if($area_id == 1 && $type && $goods_cat_id==183 && $temp_buyers_id)
        {
            $sql = "select count(*) as count from ecs_temp_buyers_permission WHERE area_id=1 AND permission_id=3 AND temp_buyers_id='$temp_buyers_id'";
            $res_count = $this->query($sql);
            if($res_count[0]['count'] >= 1) return $shop_price = $shop_price*1.5;
            else return $shop_price;
        }
        else
        {
            return $shop_price;
        }
    }

    //商品信息进行包装1
    private function goodsInfoPack($res,$company_id,$area_id,$type,$database_type,$shop_price,$goods_cat_id,$uid)
    {
        $res['shop_price'] = $this->shopPriceDeal($company_id,$area_id,$type,$database_type,$shop_price,$goods_cat_id,$uid);
        $res['database_type'] = $database_type;
        $type = $database_type;//批发商品 已经没有
        return $res = $this->goodsModel($res,$type,$area_id);//对商品信息进行组装
    }

    //对商品价格做处理
    private function shopPriceDeal($company_id,$area_id,$type,$database_type,$shop_price,$goods_cat_id,$temp_buyers_id)
    {
        if( $database_type == 1 )
        {
            if($company_id == 11 && $area_id == 1 && $type==1)
            {
                $shop_price = $shop_price*1.06;
            }

            if($company_id == 12 && $area_id == 1 && $type==1)
            {
                $shop_price = $shop_price/0.95;
            }

            //找平施工
            if($area_id == 1 && $type==1 && $goods_cat_id==183 && $temp_buyers_id)
            {
                $shop_price = $this->zhaoPingSiGong($area_id,$type,$goods_cat_id,$temp_buyers_id,$shop_price);
            }
            return $shop_price;
        }
        else
        {
            return $shop_price;
        }
    }

}
