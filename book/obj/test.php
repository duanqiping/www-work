<?php

//function str_change($str)
//{
//    $str = str_replace ("_", " ", $str);
//
//    $str = ucwords ( $str );
//
//    $str = str_replace (" ", "", $str);
//    return $str;
//}
//
//$str = 'open_door';
//$res = str_change($str);
//var_dump($res);
//exit();

require_once 'shopProduct1.php';

echo (int)'a123';
exit();

function classData(ReflectionClass $class)
{
    $detail = '';
    $name = $class->getName();

    if($class->isFinal()){
        $detail .= "$name is a final class\n";
    }else{
        $detail .= "$name can not be instantiated\n";
    }
    return $detail;
}

$prod_class = new ReflectionClass('BookProduct');

//ReflectionClass::export($prod_class);

print  classData($prod_class);

//print_r (array(1));//报错
//$d = dir(dirname(__file__));
//$d = dir(dirname(__file__));
//
//while ( false !== ($entry = $d->read ()) )
//{
//    echo $entry . " ";
//    echo "<br/>";
//
//}
//
//$d->close ();
