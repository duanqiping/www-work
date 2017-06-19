<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/3
 * Time: 9:37
 * 首页、商品列表
 */
class MaterialAction extends Action
{
    /** 首页*/
    public function sub()
    {
        $tempbuyers = M('TempBuyers');
        $uid = $_SESSION['temp_buyers_id'];
        $condition['temp_buyers_id'] = $uid;
        if($uid) $tempbuyers->where($condition)->setField('area_id',$_POST['area_id']);//更新用户的area_id
        
        $type = $_POST['type']?$_POST['type']:1;//1辅材 2主材商城
        $area_id = $_POST['area_id']?$_POST['area_id']:1;//批发area_id=10

        $goodsarea = new GoodsAreaModel();
        $info = $goodsarea->materialTableInfo($type,$area_id);

        $goodscategory = new GoodsCategoryModel($info['goods_category_table'],$database_type = 1);

        if($type == 1)
        {
            $data = $goodscategory -> getFirstName($info['root_id'],$type);  //一级栏目...
            $data = $goodscategory -> getSecondName($data);  //一级栏目+二级栏目
            $data = $goodscategory -> getThirdName($data,$info['brand_table'],$area_id);  //一级栏目+二级栏目+三级栏目
        }
        else
        {
            $data = $goodscategory -> getFirstName($info['root_id'],$type);  //一级栏目...
            $data = $goodscategory -> getSecondNameB2B($data);  //一级栏目+二级栏目
            $data = $goodscategory -> getThirdNameB2B($data);
        }
        printSuccess($data);
    }

    /** 商品列表*/
    public function brandlist2()
    {
        $limit = isset($_POST['pageSize']) ? intval($_POST['pageSize']) : 10;
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $type = isset($_POST['type'])?$_POST['type']:1;//默认对应辅材....
        $area_id = $_POST['area_id'];
        $database_type = $type;

        if($database_type == 1)
        {
            $goodsarea = new GoodsAreaModel();
            $goods_table = $goodsarea->getGoodsTable($area_id,$type);

            $res = $goodsarea->getSingleInfo(array('goods_table'=>$goods_table),'brand_table');
            $brand_table = $res['brand_table'];
        }
        else
        {
            $goods_table = 'b2b_pcy_goods';
            $brand_table = 'b2b_pcy_temp_brand';
        }

        $goodsModel = new GoodsModel($goods_table,$database_type);
        $goodsModel->is_if_login();//没要求必须登录

        if(isset($_POST['goods_category_id']))
        {
            $goods_category_id = $_POST['goods_category_id'];

            $tempbrand = new TempBrandModel($brand_table,$database_type);
            $brandinfo = $tempbrand -> getBrandInfo($goods_category_id);//goods_category_id 获取所有的brand_id

            $data = array();
            for($i=0,$len=count($brandinfo);$i<$len;$i++)
            {
                $dataInfo = $goodsModel->getGoodsInfoByBrandID($area_id,$type,$brandinfo[$i]['brand_id'],$limit,$page,$database_type);
                $data = array_merge($data,$dataInfo);
            }
            printSuccess($data);
        }
        else if(isset($_POST['brand_id']))
        {
            $brand_id = $_POST['brand_id'];
            $name = isset($_POST['name'])?$_POST['name']:'';//$name 1.区分 来自搜索 调用商品列表接口 2.区分是否是智能搜索
            $data = $goodsModel->getGoodsInfoByBrandID($area_id,$type,$brand_id,$limit,$page,$database_type,$name);
            printSuccess($data);
        }
        else
        {
            printError('id不能为空',4106);
        }
    }

    /** 获取三级分类(购物车 找相似)
     * goods_id type  area_id  database_type
     */
    public function brandInfo()
    {
        $goods_id = $_POST['goods_id'];
        $type = $_POST['type'];
        $area_id = ($type==2)?10:$_POST['area_id'];
        $database_type = $_POST['database_type'];

        checkPostData(!$goods_id,'goods_id参数非法',4880);
        checkPostData(!($type==1 || $type==2),'type参数非法',4880);
        checkPostData(!$area_id,'goods_id参数非法',4880);
        checkPostData(!($database_type==1 || $database_type==2),'database_type参数非法',4880);

        $goodsarea = new GoodsAreaModel();
        if($database_type == 1)
        {
            $goods_table = $goodsarea->getGoodsTable($area_id,$type);
            //获取城市对应的二级分类表
            $res = $goodsarea->getSingleInfo(array('goods_table'=>$goods_table),'brand_table');
            $brand_name_table = ($type==2)?'ecs_temp_brand_pifa':$res['brand_table'];
        }
        else
        {
            $goods_table = 'b2b_pcy_goods';
            $brand_name_table = 'b2b_pcy_temp_brand';
        }

        $goodsModel = new GoodsModel($goods_table,$database_type);
        $data = $goodsModel->getSingleInfo(array('goods_id'=>$goods_id),'brand_id,brand_name');
        if(!$data) return array();

        $brandModel = new TempBrandModel($brand_name_table,$database_type);
        $brand_res = $brandModel->getSingleInfo(array('brand_id'=>$data['brand_id']),'goods_category_id');

        $sql = "SELECT b.brand_id cat_id,b.brand_name cat_name FROM $brandModel->tableName b".
            " WHERE ( b.goods_category_id = '{$brand_res['goods_category_id']}' ) AND ( b.is_show = 1 ) ".
            "AND exists (select goods_id from $goodsModel->tableName g where g.brand_id=b.brand_id and  g.is_delete=0 and g.is_pass=1)".
            " ORDER BY b.sort_order";

        $info  = $brandModel->query($sql);

        $data['area_id'] = $area_id;
        $data['type'] = $type;
        $data['database_type'] = $database_type;
        printSuccess($info);
    }

    /** 黄沙水泥 获取品牌*/
    public function sub3()
    {
        $suppliers_id = $_POST['suppliers_id'];//
        checkPostData(!$suppliers_id,'suppliers_id不能为空',4889);

        //AND exists (select goods_id from $goodsModel->tableName g where g.brand_id=b.brand_id and  g.is_delete=0 and g.is_pass=1)
        $base = new BaseModel();
//        $sql = "SELECT b.brand_id cat_id,b.brand_name cat_name FROM pcwb2bs.b2b_pcy_temp_brand b LEFT JOIN pcwb2bs.b2b_pcy_goods bg ON b.brand_id=bg.brand_id  ".
//            "WHERE  b.is_show = 1  AND bg.is_delete=0 AND bg.is_pass=1 AND bg.suppliers_id='$suppliers_id' GROUP BY b.brand_id ORDER BY b.sort_order ";
        $sql = "SELECT b.brand_id cat_id,b.brand_name cat_name FROM pcwb2bs.b2b_pcy_temp_brand b ".
            "WHERE  b.is_show = 1 AND exists (select bg.goods_id from pcwb2bs.b2b_pcy_goods bg where bg.brand_id=b.brand_id and  bg.is_delete=0 AND bg.is_pass=1 AND bg.suppliers_id='$suppliers_id') ORDER BY b.sort_order ";
        $res = $base->query($sql);
        printSuccess($res);
    }

    /** 商品列表 黄沙水泥砖  这个以后得合并到 brandlist2 下面*/
    public function brandlist3()
    {
        $area_id = isset($_POST['area_id']) ? intval($_POST['area_id']) : 1;
        $type = isset($_POST['type']) ? intval($_POST['type']) : 1;

        $limit = isset($_POST['pageSize']) ? intval($_POST['pageSize']) : 10;
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $brand_id = isset($_POST['brand_id']) ? intval($_POST['brand_id']) : 0;


        checkPostData(!$brand_id,'品牌id非法','4866');

        $offset = ($page-1)*$limit;//偏移量

        $goodsModel = new GoodsModel('b2b_pcy_goods',2);
        $goodsModel->is_if_login();

        $shop_price = $goodsModel->returnPriceField(1,1,1,2);

        $sql = "SELECT a.goods_name_id,a.goods_id,a.goods_cat_id,a.goods_version,a.goods_name,a.goods_unit,a.brand_name,a.$shop_price shop_price,a.version_id,a.brand_id,a.suppliers_id,a.goods_thumb, a.goods_img  FROM $goodsModel->tableName a ".
            "WHERE a.is_pass=1 and a.is_delete=0 and a.brand_id='$brand_id' ".
            "AND (SELECT COUNT(*) FROM $goodsModel->tableName WHERE goods_name_id = a.goods_name_id AND version_id=a.version_id AND shop_price < a.shop_price and is_pass=1 and is_delete=0) < 1 ".
            "group by a.goods_name_id,a.version_id ORDER BY a.brand_id desc,a.sort_order asc, a.add_time desc limit $offset,$limit";
        $res = $goodsModel->query($sql);

        for($i=0,$len = count($res); $i<$len; $i++)
        {
            $res[$i]['type'] = $area_id;
            $res[$i]['area_id'] = $type;
            $res[$i]['database_type'] = 2;

            $res[$i] = $goodsModel->goodsModel($res[$i],$type=1,$area_id=1);
        }

        printSuccess($res);
    }

    /** 黄沙水泥砖供应商信息*/
    public function info()
    {
        $cat_id = $_POST['cat_id'];
        checkPostData(($cat_id <= 0),'cat_id值非法',4871);

        $model = new Model();
        $sql_b2b_category = "select bc.b2b_category_id from  ecs_b2b_category bc WHERE bc.goods_category_id='$cat_id'";
        $res_b2b_category = $model->query($sql_b2b_category);
        if(!$res_b2b_category) printSuccess(array());

        $sql_b2b_suppliers = "select pu.user_id,pu.sp_rank,pu.img,pu.telephone,pu.address,pu.pcy_company_person,pu.pcy_companyname,pu.pcy_company_area,pu.global_trans_desc from ecs_b2b_suppliers bs LEFT JOIN pcwb2bs.b2b_user pu ON bs.suppliers_id=pu.user_id WHERE b2b_category_id='{$res_b2b_category[0]['b2b_category_id']}' ORDER BY bs.sort_order";
        $res_b2b_suppliers = $model->query($sql_b2b_suppliers);

        foreach($res_b2b_suppliers as $k=>$v)
        {
            $res_b2b_suppliers[$k]['img'] = b2bImgDeal($v['img']);
        }
        printSuccess($res_b2b_suppliers);
    }

    /** 推荐商品*/
    public function recommend()
    {
        $database_type = 2;
        $goodsModel = new GoodsModel('b2b_pcy_goods',$database_type);

        $data = $goodsModel->goodsRecommend($database_type);
        printSuccess($data);
    }
}