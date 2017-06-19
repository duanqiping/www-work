<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/29
 * Time: 21:31
 */
class Product
{
    public $name;
    public $price;
    function __construct($name,$price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale
{
    private $callbacks;

    function registerCallback($callback)
    {
        if(! is_callable($callback))//bool true if name is callable, false otherwise
        {
            throw new Exception("callback not callable");
        }
        $this->callbacks[] = $callback;
    }

    function sale($product)
    {

        print "{$product->name}: processing \n";
        foreach ($this->callbacks as $callback)
        {
            call_user_func($callback,$product);//第一个参数 callback 是被调用的回调函数，其余参数是回调函数的参数。
        }
    }
}
//$logger = create_function('$product','print "  loogging ({$product->name})\n";');//Returns a unique function name as a string, or FALSE on error.
$logger2 = function($product)//比较优雅的创建匿名函数
{
  print "  logging ({$product->name})";
};

class Totalizer{
    static function warnAmount($amt)
    {
        $count = 0;
        return function ($product) use ($amt, &$count)
        {
//            var_dump($product->price);
            $count += $product->price;
            print " count: $count\n";
            if($count>$amt)
            {
                print " high price reached：{$count}\n";
            }
        };
    }
}


$processor = new ProcessSale();
//$processor->registerCallback($logger);
//$processor->registerCallback($logger2);
$processor->registerCallback(Totalizer::warnAmount(15));

$processor->sale(new Product("shoes", 6));
print "\n";
$processor->sale(new Product("coffee",8));