<?php
require_once dirname(__FILE__).'/DB/dataOper.class.php';

$oper = new DataOper();

$classes = $oper->getClasses();

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<root>';
foreach ($classes as $_v){
	echo '<classfy name="'.$_v["name"].'"'.' kind="'.$_v["kind"].'">';
		$projects = $oper->getProjects($_v["id"]);
		foreach ($projects as $_vp){
			echo '<project '.' name="'.$_vp["name"].'"'.' describtion="'.$_vp["describtion"].'"'.' unit="'.$_vp["unit"].'"'.' loss="'.$_vp["loss"].'"'.' main="'.$_vp["main"].'"'.' mainprofit="'.$_vp["mainprofit"].'"'.' auxiliary="'.$_vp["auxiliary"].'"'.' auxiprofit="'.$_vp["auxiprofit"].'"'.' laborcost="'.$_vp["laborcost"].'"'.' laborprofit="'.$_vp["laborprofit"].'"'.'>';
				$materials = $oper->getMaterial($_vp["pid"]);
				foreach ($materials as $_vm){
					echo '<material'.' name="'.$_vm["name"].'"'.' model="'.$_vm["model"].'"'.' unit="'.$_vm["unit"].'"'.' price="'.$_vm["price"].'"'.' num="'.$_vm["num"].'"'.' brand="'.$_vm["brand"].'"'.' notice="'.$_vm["notice"].'"'.' url="'.$_vm["url"].'"'.'>';
					echo '</material>';
				}	
			echo '</project>';
		}
	echo '</classfy>';
}
echo '</root>';
?>