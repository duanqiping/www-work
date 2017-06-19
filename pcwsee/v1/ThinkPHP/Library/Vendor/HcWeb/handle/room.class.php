<?php
class Base{
	public  $width;
	public  $height;
	function __construct() {
		$this->width = 0.0;
		$this->height = 0.0;
	}
	public function getArea(){
		return $this->width*$this->height;
	}
	//周长
	public function getTotalLength(){
		return  ($this->width+$this->height)*2;
	}
}
//门
class Door extends Base{
	function __construct($width,$height) {
		$this->width = $width;
		$this->height = $height;
	}
}
//窗
class Window extends Base{
	function __construct($width,$height) {
		$this->width = $width;
		$this->height = $height;
	}
}
//房间
class Room extends Base{
	public $kind;//房间类型 1
	public $long = 0.0;//长
	public $door;
	public $window;
	
	public $totalLength = 0.0;
	public $area = 0.0;
	function __construct($long,$width,$height,$datakind,$homekind) {
		if($datakind == '0'){//长 宽 高
			$this->long = $long;
			$this->width = $width;
			$this->totalLength = ($this->long+$this->width)*2;
			$this->area = $this->long*$this->width;
		}else{// 周长 面积  高
			$this->totalLength = $totalLength;
			$this->area = $area;
			$this->long = $totalLength/4;
			$this->width = $this->long;
		}
		$this->height = $height;
		$this->kind = $homekind;
		
		$this->door = array();
		$this->window = array();
	}

    //这方法 ???????????
    public function addDoorWindows($doorOrWindows) {
        $this->doorWindows[] = $doorOrWindows;
    }
	public function AddDoor(Door $door){
		$this->door[] = $door;
	}
	public function AddWindow(Window $window){
		$this->window[] = $window;
	}
	//周长
	public function getTotalLength(){
		return  $this->totalLength;
	}
	//面积
	public function getArea(){
		return $this->area;
	}
}
?>