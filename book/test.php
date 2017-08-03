<?php  


date_default_timezone_set("Asia/Shanghai");


var_dump(1 & 1);
var_dump(2 & 1);
var_dump(3 & 1);
var_dump(4 & 1);
	
	
//是用来 过滤其他数据
function odd($var)
{
	
    // returns whether the input integer is odd
	//file_put_contents('log.txt',$val."\n",FILE_APPEND );
    return($var & 1);//位运算
}

function even($var)
{
    // returns whether the input integer is even
    return(!($var & 1));
}

$array1 = array("a"=>1, "b"=>2, "c"=>3, "d"=>4, "e"=>5);
$array2 = array(6, 7, 8, 9, 10, 11, 12);

echo "Odd :\n";
print_r(array_filter($array1, "odd"));//Array ( [a] => 1 [c] => 3 [e] => 5 ) 

exit();


echo "Even:\n";
print_r(array_filter($array2, "even"));// Array ( [0] => 6 [2] => 8 [4] => 10 [6] => 12 )