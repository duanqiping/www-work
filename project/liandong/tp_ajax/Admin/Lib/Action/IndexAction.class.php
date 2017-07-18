<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		$this->display();
    }
	public function getSection(){
	   $s= M("section");
	   $list = $s->field('id,title')->select();
	   echo json_encode($list);
	 }
  
  public function getCatid(){	
	   $sid=$_GET['id'];	
	   $c= M("category");
	   $data=$c->field('id,title')->where("sectionid=$sid")->select();	   
	   echo json_encode($data);
  }
}