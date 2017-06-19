<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/3
 * Time: 9:45
 */
class CatModel extends Model
{
    protected $tableName = 'cat';

    //可以避免IO加载的效率开销
    protected $fields = array('cat_id','cat_name','_pk'=>'cat_id', '_autoinc' => true );

}