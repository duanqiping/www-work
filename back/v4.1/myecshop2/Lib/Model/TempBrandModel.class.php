<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/5
 * Time: 10:23
 */
class TempBrandModel extends Model
{
    public $tableName = 'ecs_temp_brand';
    protected $fields = array('brand_id','brand_name','goods_category_id','sort_order','is_show','_pk'=>'brand_id','autoinc'=>true);

    public function __construct($table_name,$database_type)
    {
        parent::__construct();
        if($database_type == 2)
        {
            $this->db(1,'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_temp_brand';
        }
        else
        {
            $this -> tableName = $table_name;
        }
    }

    public function getSingleInfo($condition,$field)
    {
        return $this->table($this->tableName)->where($condition)->field($field)->find();
    }
    //获取多条记录
    public function getMultipleInfo($condition,$field,$sort_order='brand_id')
    {
        return $res = $this->table($this->tableName)->where($condition)->field($field)->order($sort_order)->select();
    }


    //获取品牌名 和 品牌id号
    public function getBrandName2($goods_category_id)
    {
        $condition['goods_category_id'] = $goods_category_id;
        $condition['is_show'] = 1;
        $res = $this ->table($this->tableName) -> where($condition) -> field('brand_id cat_id,brand_name cat_name')->order('sort_order') -> select();
        return $res?$res:array();
    }

    //通过goods_category_id 获取所有的brand_id
    public function getBrandInfo($goods_category_id)
    {
        $condition['goods_category_id'] = $goods_category_id;
        $condition['is_show'] = 1;
        $res = $this ->table($this->tableName) -> where($condition) -> field('brand_id')->order('sort_order') -> select();

        if(!$res) return array();
        else return $res;
    }
}