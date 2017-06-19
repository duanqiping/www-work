<?php
require_once dirname(__FILE__).'/config.php';
class Tools {
		
	/*数据库操作结果*/
	public static $RES_SUCESS=0;//操作成功
	public static $RES_FAILED=-1;//操作失败
	public static $RES_STOP=-2;//操作失败,停用
	public static $RES_NONE=3;//操作无影响
	
	
}

?>