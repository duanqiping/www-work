<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/7/31
 * Time: 16:45
 */
class GoodsGalleryModel extends Model
{
    protected $tableName = 'ecs_goods_gallery';//默认的表名
    protected $fields = array('img_id','goods_id','img_url','thumb_url','img_original','_pk'=>'img_id','_autoinc'=>true);

    public function __construct($table_name,$database_type)
    {
        parent::__construct();
        if($database_type == 2)
        {
            $this->db(1,'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_goods_gallery';
        }
        else
        {
            $this -> tableName = $table_name;
        }
    }

    //获取展示图片  展示的图片和goods_img图片一样的放在第一位
    public function getImgs($goods_id,$goods_img,$database_type)
    {
        $res = $this ->table($this->tableName)-> where("goods_id=$goods_id")-> field('img_url') ->order("img_url='$goods_img' desc") -> select();

        if(!$res) return array();

        for($i=0,$len=count($res); $i<$len; ++$i)
        {
            $res[$i] = ImgDeal($res[$i]['img_url'],$database_type);//完善图片路径
        }
        return $res;
    }
}