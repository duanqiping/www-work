<?php

//冒泡排序
function bubblesort(&$arr)
{
	$temp = 0;
	for($i=0,$len=count($arr);$i<$len-1;$i++)
	{
		for($j=0;$j<$len-$i-1;$j++)
		{
			//从小到大排序
			if($arr[$j]>$arr[$j+1])
			{
				$temp = $arr[$j];
				$arr[$j] = $arr[$j+1];
				$arr[$j+1] = $temp;
			}
		}
	}
}


$arr = array(17,2,3,6,7,10);

bubblesort($arr);


var_dump($arr);
