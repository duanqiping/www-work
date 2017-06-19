<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/9
 * Time: 10:02
 */
class GoodsAreaModel extends BaseModel
{
    protected $fields = array('goods_area_id','goods_area','goods_table','gallery_table','brand_table','version_table','goods_name_table','goods_category_table','ali_area_name','_pk'=>'goods_area_id','_autoinc'=>true);

    //获取单条记录
//    public function getSingleInfo($condition,$field)
//    {
//        return $this->where($condition)->field($field)->find();
//    }

    //返回对应的表信息
    public function materialTableInfo($type,$area_id)
    {
        $data = array();
        if($type == 1)
        {
            $goods_table = $this->getGoodsTable($area_id,$type);

            //获取城市对应的二级分类表
            $data = $this->getSingleInfo(array('goods_table'=>$goods_table),'brand_table,goods_category_table,root_id');
        }
        else
        {
            $data['goods_category_table'] = 'ecs_goods_category_pcb';
            $data['brand_table'] ='ecs_temp_brand_pcb';
            $data['root_id'] = 1;
        }
        return $data;
    }

}