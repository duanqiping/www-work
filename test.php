<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/3/23
 * Time: 19:49
 */

 
 $arr = ['a','b','c'];
 
 unset( $arr['1'] );
 $arr['a'] = "123";
 
 foreach($arr as $key=>$value )
 {
	//echo $value;
	 //echo "hell0";
 }
	 //echo $arr[$i];
 
 var_dump( json_encode($arr) );