<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/3/27
 * Time: 19:53
 */
class ShopProduct
{
    public $title = "default product";
    public $shopdocerMainName = "main name";
    public $shopducerFirstName = "first name";
    public $price = 0;

    public function __construct($title, $firstName, $mainName, $price)
    {
        $this->title = $title;
        $this->shopdocerMainName = $mainName;
        $this->shopducerFirstName = $firstName;
        $this->price = $price;
    }

    public function getProducer()
    {
        return $this->shopdocerMainName . ' ' . $this->shopducerFirstName;
    }
    public function getPrice()
    {
        return $this->price;
    }
}

class ShopProductWrite
{
    public $products = array();
    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[] = $shopProduct;
    }
    public function  write(){
        $str = '';
//        var_dump($this->products);
//        exit;
        foreach($this->products as $shopProduct)
        {
            var_dump($shopProduct);
            exit();
            $str .= $shopProduct->title;
            $str .= $shopProduct->getProducer;
            $str .= $shopProduct->getPrice;
        }
        print $str;
    }
}
$product1 = new ShopProduct("My Antonia",'Willa','Cather1',5.99);
$product2 = new ShopProduct("My Antonia",'Willa','Cather1',5.98);
$product3 = new ShopProduct("My Antonia",'Willa','Cather1',5.97);

var_dump($product1);
exit();

$write =new ShopProductWrite();
$write->addProduct($product1);
$write->addProduct($product2);
$write->addProduct($product3);
$write->write();
