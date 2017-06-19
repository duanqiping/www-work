<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/3/27
 * Time: 19:53
 */
//抽象类
abstract class ShopProductWrite
{
    public $products = array();
    //参数类型提示
    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[] = $shopProduct;
    }
    abstract public function  write();
}

class XmlShopProductWrite extends ShopProductWrite
{
    public function write()
    {
        print('xml');
    }
}

$xmlobj = new XmlShopProductWrite();
$xmlobj->write();