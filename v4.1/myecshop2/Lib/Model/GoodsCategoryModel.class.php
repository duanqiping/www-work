<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/3
 * Time: 11:13
 */
class GoodsCategoryModel extends Model
{
    protected $tableName = "ecs_goods_category";

    protected $fields = array('goods_category_id','goods_category_name','cat_id','parent_id','sort_order','root_id','style','grade','img_url','is_show','_pk'=>'goods_category_id','_autoinc'=>true);

    public function __construct($table_name,$database_type)
    {
        parent::__construct();
        if($database_type == 2)
        {
            $this->db(1,'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_goods_category';
        }
        else
        {
            $this -> tableName = $table_name;
        }
    }

    public function getSingleInfo($condition,$field)
    {
        return $res = $this->table($this->tableName)->where($condition)->field($field)->find();
    }

    //获取一级分类  id和名字.....
    public function getFirstName($parent_id,$type)
    {
        $condition['grade'] = 2;
        $condition['parent_id'] = $parent_id;
        $condition['is_show'] = 1;

        if($type == 1)
        {
            $res = $this -> table($this->tableName)-> where($condition) -> field("goods_category_id cat_id,goods_category_name cat_name,img_url,'' as cat_desc") ->order('sort_order') -> select();
        }
        else
        {
            $res = $this -> table($this->tableName)-> where($condition) -> field("goods_category_id cat_id,goods_category_name cat_name,img_url,goods_category_desc cat_desc") ->order('sort_order') -> select();
        }

        if(!$res) return array();
        return $res;
    }

    //获取二级分类
    public function getSecondName($data)//parent_id 也就是一级分类goods_category_id
    {
        $res_info = array();

        for($i=0,$j=0,$len = count($data); $i<$len; $i++)
        {

            $condition['parent_id'] =$data[$i]['cat_id'];//goods_category_id
            $condition['is_show'] = 1;

            $res = $this -> table($this->tableName)-> where($condition) -> field('goods_category_id cat_id,goods_category_name cat_name') ->order('sort_order') -> select();

            if(!$res)  continue; //一级栏目下没有二级栏目 (不显示该一级栏目)


            //泥
            if($data[$i]['cat_id'] == 81 && $_POST['type']==1 && $_POST['area_id']==1)
            {
                foreach($res as $key=>$v)
                {
                    //水泥黄沙砖
                    if($v['cat_id']==199 )
                    {
                        $res[$key]['cat_url'] = 'http://www.pcw365.com/ecshop2/MobileAPI/h5/pcb/index.html';
                        $res[$key]['suppliers_id'] = -1;
                        $res[$key]['type'] = 1;//0默认分类 1显示店铺列表（如水泥黄沙） 2跳到网页  3跳到专店
                    }
                }
            }

            //专区
            if($data[$i]['cat_id'] == 182 && $_POST['type']==1 && $_POST['area_id']==1)
            {
                foreach($res as $key=>$v)
                {
                    //壁纸专卖
                    if($v['cat_id']==205 )
                    {

//                            if($_SESSION['token']) $res[$key]['cat_url'] = "http://b2b.pcw365.com/?token={$_SESSION['token']}";
//                            else $res[$key]['cat_url'] = 'http://b2b.pcw365.com/';
                        $res[$key]['cat_url'] = 'http://www.pcw365.com/ecshop2/MobileAPI/h5/pcb/index.html';
                        $res[$key]['suppliers_id'] = -1;
                        $res[$key]['type'] = 1;//0默认分类 1显示店铺列表（如水泥黄沙） 2跳到网页  3跳到专店
                    }
                }
            }


            $res_info[$j] = $data[$i];
            $res_info[$j]['cat_children'] = $res;

            $j++;
        }


        return $res_info;

    }

    //获取二级分类
    public function getSecondNameB2B($data)//parent_id 也就是一级分类goods_category_id
    {
        for($i=0,$len=count($data);$i<$len;$i++)
        {
            $data[$i]['img_url'] = CROOT.$data[$i]['img_url'];//图片路径处理
            $sql_b2b_suppliers = "select pu.user_id cat_id,pu.pcy_companyname_abbreviation cat_name,pcy_companyname from pcwb2bs.b2b_user pu ".
                " WHERE pu.ecs_pcb_category_id='{$data[$i]['cat_id']}' AND exists (select goods_id from pcwb2bs.b2b_pcy_goods where is_pass=1 and is_delete=0 and suppliers_id=pu.user_id limit 1)";
            $res_b2b_suppliers = $this->query($sql_b2b_suppliers);

            $data[$i]['cat_children'] = $res_b2b_suppliers;
        }
        return $data;
    }

    //获取三级分类
    public function getThirdName($data,$brand_table,$area_id)
    {
        for($i=0,$len=count($data);$i<$len;$i++)
        {
            for($j=0,$len_j=count($data[$i]['cat_children']);$j<$len_j;$j++)
            {
                $res_bought = array();
                if($uid = $_SESSION['temp_buyers_id'])
                {
                    $sql__bought = "select b.brand_id cat_id,bd.brand_name cat_name from ecs_temp_bought b LEFT JOIN $brand_table bd ON b.brand_id=bd.brand_id ".
                        "WHERE b.buyers_id = '$uid' AND b.area_id='$area_id' AND b.goods_cat_id='{$data[$i]['cat_children'][$j]['cat_id']}' limit 1";
                    $res_bought=  $this->query($sql__bought);
                    $res_bought = $res_bought[0];
                }
                $goods_category_id = $data[$i]['cat_children'][$j]['cat_id'];

                $sql = "SELECT brand_id cat_id,brand_name cat_name FROM $brand_table WHERE ( goods_category_id = '$goods_category_id' ) AND ( is_show = 1 ) ORDER BY sort_order ";
                $res_brand = $this->query($sql);
                if($res_bought) array_unshift($res_brand,$res_bought);//把我的常用放到前面

                $data[$i]['cat_children'][$j]['cat_children'] = array();
                if($res_brand) $data[$i]['cat_children'][$j]['cat_children'] = $res_brand;
            }
        }

        return $data;

    }

    //获取三级分类
    public function getThirdNameB2B($data)
    {
        for($i=0,$len=count($data);$i<$len;$i++)
        {
            for($j=0,$len_j=count($data[$i]['cat_children']);$j<$len_j;$j++)
            {
                $sql = "SELECT b.brand_id cat_id,b.brand_name cat_name FROM pcwb2bs.b2b_pcy_temp_brand b ".
                    "WHERE  b.is_show = 1 AND exists (select bg.goods_id from pcwb2bs.b2b_pcy_goods bg where bg.brand_id=b.brand_id and  bg.is_delete=0 AND bg.is_pass=1 AND bg.suppliers_id='{$data[$i]['cat_children'][$j]['cat_id']}') ORDER BY b.sort_order ";
                $res_brand = $this->query($sql);

                $data[$i]['cat_children'][$j]['cat_children'] = array();
                if($res_brand) $data[$i]['cat_children'][$j]['cat_children'] = $res_brand;

                if(! $data[$i]['cat_children'][$j]['cat_name']) $data[$i]['cat_children'][$j]['cat_name'] = $data[$i]['cat_children'][$j]['pcy_companyname'];
                unset($data[$i]['cat_children'][$j]['pcy_companyname']);
            }
        }
        return $data;
    }

}