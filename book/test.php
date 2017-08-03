<?php  


date_default_timezone_set("Asia/Shanghai");


	
	
//是用来 过滤其他数据
	
function odd($var)
{
	print_r($var);
	exit();
    // returns whether the input integer is odd
    return($var & 1);
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


echo "Even:\n";
print_r(array_filter($array2, "even"));// Array ( [0] => 6 [2] => 8 [4] => 10 [6] => 12 )