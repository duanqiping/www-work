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
//    public $numPages;
//    public $playLength;
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

    public function getSummaryLine(){
        $base = $this->title.' '.$this->shopdocerMainName;
        $base .= $this->shopducerFirstName;
        return $base;
    }
}

class CdProduct extends ShopProduct{
    public $playLength;

    public function __construct($title, $firstName, $mainName, $price,$playLength){
        parent::__construct($title, $firstName, $mainName, $price);//调用父类的构造方法
        $this->playLength = $playLength;
    }

    function getPlayLength(){
        return $this->playLength;
    }

    function getSummaryLine(){
//        $base = $this->title.' '.$this->shopdocerMainName;
//        $base .= $this->shopducerFirstName;
        $base = parent::getSummaryLine();////调用被复写方法
        $base .= "playing time - $this->playLength";
        return $base;
    }
}

class BookProduct extends ShopProduct{
    public $numPages;
    public function __construct($title, $firstName, $mainName, $price,$numPages){
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPages = $numPages;
    }

    function getNumberOfPages(){
        return $this->numPages;
    }
    function getSummaryLine(){
//        $base = $this->title.' '.$this->shopdocerMainName;
//        $base .= $this->shopducerFirstName;
        $base = parent::getSummaryLine();//扩展父类的方法
        $base .= "page count - $this->numPages";
        return $base;
    }
}


$product2 = new CdProduct("My Antonia",'Willa','Cather1',5.99,64.88);

//print $product2->playLength;
//exit();

print "artist: {$product2->getSummaryLine()}";