<?php

$array = array(1,6,3,2,-1,0);

function selectSort(&$array)
{
	$temp = 0;
	//最后一个数无需比较
	for($i=0,$len=count($array);$i<$len-1;$i++)
	{
		$minVal = $array[$i];
		$minIndex = $i;
		for($j=$i+1;$j<$len;$j++)
		{
			if($minVal > $array[$j])
			{
				$minVal = $array[$j];
				$minIndex = $j;
			}
		}
		$temp = $array[$i];
		$array[$i] = $array[$minIndex];
		$array[$minIndex] = $temp;
																																																																																																																																																																																																																																			
	}
}
selectSort($array);

var_dump($array);