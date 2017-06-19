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
    private $id = 0;
    private $title = "default product";
    private $shopdocerMainName = "main name";
    private $shopducerFirstName = "first name";
    protected $price = 0;
    private $discount = 0;

    public function __construct($title, $firstName, $mainName, $price)
    {
        $this->title = $title;
        $this->shopdocerMainName = $mainName;
        $this->shopducerFirstName = $firstName;
        $this->price = $price;
    }

    public function setID($id)
    {
        $this->id = $id;
    }
    //构建getInstance方法
    public static function getInstance($id,PDO $pdo){
        $stmt = $pdo->prepare("select * from products where id=?");
        $result = $stmt->execute(array($id));
        $row = $stmt->fetch();

        if(empty($row)){return null;}
        if($row['type'] == 'book')
        {
            $product = new BookProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['numpages']
            );
        }else if($row['type'] == 'cd'){
            $product = new CdProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['playlength']
            );
        }else{
            $product = new ShopProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price']
            );
        }
        $product->setID($row['id']);
        $product->setDiscount($row['discount']);
        return $product;
    }

    public function getProducer()
    {
        return $this->shopdocerMainName . ' ' . $this->shopducerFirstName;
    }

    public function getProduceerFirstName()
    {
        return $this->shopducerFirstName;
    }
    public function getProduceerMainName()
    {
        return $this->shopdocerMainName;
    }

    public function setDiscount($num)
    {
        $this->discount = $num;
    }
    public function getDiscount()
    {
        return $this->discount;
    }
    public function getTtitle()
    {
        return $this->title;
    }
    public function getPrice()
    {
        return $this->price - $this->discount;
    }
    public function getSummaryLine()
    {
        $base = $this->title.' '.$this->getProduceerFirstName().',';
        $base .= $this->getProduceerMainName();
        return $base;
    }
}

class BookProduct extends ShopProduct{
    private $numPage = 0;
    public function __construct($title,$firstName,$mainName,$price,$numPage)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPage = $numPage;
    }
    public function getNumPage()
    {
        return $this->numPage;
    }
    public function getSummary()
    {
        $base = parent::getSummaryLine();
        $base .= '.page count - '.$this->numPage;
        return $base;
    }
    public function getPrice()
    {
        return $this->getPrice();
    }
}