<?php  
	
	$arr    =   array
	(
		0 => array
			(
				'initial' => 'A',
				'typename' => '奥迪'
			),
		1 => array
			(
				'initial' => 'F',
				'typename' =>'F1'
			),
		2 => array
			(
				'initial' => 'F',
				'typename' => 'F2'
			)
	);
$result =   array();
foreach($arr as $k=>$v){
    $result[$v['initial']][]    =   $v;
}

echo "<pre>";		
print_r($result);
echo "</pre>";
	
	

