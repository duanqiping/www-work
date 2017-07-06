<?php  
    //$m = new Mongo(); 
	
	$m = new MongoClient(); // 连接默认主机和端口为：mongodb://localhost:27017
	//$db = $m->runoob; // 获取名称为 "test" 的数据库
	echo "<pre>";
	print_r($m->listDBs());
	echo "</pre>";
	
	$db = $m->runoob->col;
	
	MongoDB::createCollection('mmm');
	
	//$db->createCollection('mmm'); 
	
	
	$doc = array(
		"name" => "MongoDB",
		"type" => "database",
		"count" => 1,
		"info" => (object)array( "x" => 203,"y" => 102),
		"versions" => array("11","22"),
	);
	
	//$collection = $db->col;
	
	echo "<pre>";
	print_r($db);
	echo "</pre>";
	
	//$db->insert($doc);
	
	$res = $db->find(array('type'=>'database'));
	//$res = $db->findOne();
	
	foreach ($res as $id => $value) 
	{
		echo "$id: ";
		echo "<pre>";
		print_r($value);
		echo "</pre>";
	}
	
	echo "<pre>";
	print_r($res);
	echo "</pre>";
	
	
	//var_dump($db);