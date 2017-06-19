<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/3/23
 * Time: 20:14
 *
 **/

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
}
class ShopProductWrite{
//    public function  write($shopProduct){
//        $str = $shopProduct->title.": ".$shopProduct->getProducer().$shopProduct->price;
//        print $str;
//    }

    //类的类型提示
    public function  write(ShopProduct $shopProduct){
        $str = $shopProduct->title.": ".$shopProduct->getProducer().$shopProduct->price;
        print $str;
    }
}

class Wrong{};

/*$product1 = new ShopProduct();
$product1->title = 'My Antonia'
$product1->shopdocerMainName = 'Cather';
$product1->shopducerFirstName = 'Willa';*/

$product1 = new ShopProduct("My Antonia",'Willa','Cather1',5.99);

$write =new ShopProductWrite();
$write->write($product1);
//$write->write(new Wrong());

print "author: {$product1->getProducer()}";