<?php
ini_set('date.timezone','Asia/Shanghai');

require_once dirname(__FILE__).'/operate.class.php';
require_once dirname(__FILE__).'/tool.class.php';
class DataOper extends operate{
	function __construct() {
		parent::__construct("hc_project");
	}
	//获取所有项目
	public function getClasses(){
		$sql = "select id,name,kind from hc_classfy";
		$datas = $this->dbHelper->select($sql);
		return $datas;
	}
	/**
	 * 根据分类  获取所有施工项目 
	 * @param unknown $id
	 * @return multitype:multitype:
	 */
	public function getProjects($id){
		$sql = sprintf("select pid,name,describtion,unit,loss,main,mainprofit,auxiliary,auxiprofit,laborcost,laborprofit from hc_project where classid = %s",$id);
		$projects = $this->dbHelper->select($sql);
		return $projects;
	}
	/**
	 * 根据项目id获取项目信息
	 * @param unknown $id
	 * @return multitype:multitype:
	 */
	public function getProjectByID($id){
		$sql = sprintf("select pid,class,name,describtion,unit,loss,main,mainprofit,auxiliary,auxiprofit,laborcost,laborprofit from hc_project where pid = %s",$id);
		$projects = $this->dbHelper->select($sql);
		return $projects;
	}
	/**
	 * 根据施工项目获取材料
	 * @param unknown $pid
	 * @return 材料
	 */
	public function getMaterial($pid){
		$sql = sprintf("select mid,pid,name,model,rat,orderunit,price,num,brand,notice,url from hc_material where pid = %s",$pid);
		$materials = $this->dbHelper->select($sql);
		return $materials;
	}
	/**
	 * 根据房间类型获取对应工程
	 */
	public function getProjectsByhome($hometype,$classid){
//		$sql = sprintf("select pid from hc_homepros where classid='$classid' AND hometype = %s ",$hometype);
//		$sql = "select hh.pid,hp.name,hp.laborcost from hc_homepros hh LEFT JOIN hc_project hp ON hh.pid=hp.pid where hh.classid='$classid' AND hh.hometype = '$hometype'";
		$sql = "select hh.pid,hp.name,hp.main,hp.mainProfit,hp.auxiliary,hp.auxiProfit,hp.laborcost laborCost,hp.laborProfit,loss from hc_homepros hh LEFT JOIN hc_project hp ON hh.pid=hp.pid ".
            "where hh.classid='$classid' AND hh.hometype = '$hometype' AND EXISTS (select mid from hc_material where pid=hp.pid limit 1)";
		$projects = $this->dbHelper->select($sql);
		return $projects;
	}

    public function getProjectsClassInfo($hometype)
    {
        $sql = "select c.id,c.name,c.kind from hc_homepros h LEFT JOIN hc_classfy c ON h.classid=c.id ".
            "WHERE h.hometype='$hometype' and exists (SELECT hh.pid,hp.name,hp.laborcost FROM hc_homepros hh LEFT JOIN hc_project hp ON hh.pid=hp.pid WHERE hh.classid=c.id AND hh.hometype = '$hometype' AND EXISTS (SELECT MID FROM hc_material WHERE pid=hp.pid LIMIT 1))  GROUP by h.classid";

        $classInof = $this->dbHelper->select($sql);
        return $classInof;
    }
}
?>