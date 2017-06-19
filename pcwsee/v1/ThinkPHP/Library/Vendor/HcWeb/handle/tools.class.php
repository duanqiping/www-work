<?php
require_once dirname(__FILE__).'/room.class.php';
require_once dirname(__FILE__).'/../DB/dataOper.class.php';
class Calproject {
	/**
	 * 房间默认定额，工程量算法
	 * $homeid    房间类型
	 * $projectid 项目id
	 * $room 房间信息
	 */
	public static function getNum($projectid,Room $room){
		$homeid = $room->kind;
		$fNum = 0.00;
		$bground = ($projectid == 1  || $projectid == 2  || $projectid == 3  || $projectid == 4
				 || $projectid == 5  || $projectid == 6  || $projectid == 15 || $projectid == 16
				 || $projectid == 17 || $projectid == 18 || $projectid == 19 || $projectid == 20
				 || $projectid == 21 || $projectid == 22 || $projectid == 25 || $projectid == 26
				 || $projectid == 59 || $projectid == 60 || $projectid == 61 || $projectid == 65 
				 || $projectid == 23 || $projectid == 24);
// 		if(!$bground){
// 			$bground |= ($projectid ==23 || $projectid ==24);//地砖填缝剂
// 		}
		if ($bground){
			$fNum = $room->getArea();
		}elseif($projectid == 136 || $projectid == 137){//PPR水管
			if($homeid == 4 || $homeid == 5 ){//卫生间  厨房
				$fNum = 24.0;
			}elseif ($homeid == 6){
				$fNum = 21.0;
			}		
		}elseif ($projectid == 27 || $projectid == 28 || $projectid == 29){//防水处理
			if($homeid == 5){//卫生间
				$fNum = ($room->getTotallength()-2)*0.3+2*1.8;
			}else{
				$fNum = ($room->getTotallength())*0.3;
			}
		}elseif ($projectid == 31){//大理石挡水
			$fNum = $room->long;
		}elseif ($projectid == 33){//大理石门槛
			foreach ($room->door as $d){
				$fNum += $d->width;
			}
		}elseif ($projectid==11 || $projectid==12 || $projectid==13 || $projectid==14 ||
				$projectid==96 || $projectid==123){//铺设围边   踢脚线
			$fNum = $room->getTotallength();
		}elseif ($projectid==132 || $projectid==133 || $projectid==128 ||
				$projectid==129 || $projectid==130){//乳胶漆  顶面   滚胶 批嵌
			$fNum = $room->getTotallength()*$room->height + $room->getArea();
			foreach ($room->door as $_v){
				$fNum -= $_v->getArea();
			}
			foreach ($room->window as $_w){
				$fNum -= $_w->getArea();
			}
		}elseif ($projectid == 41){//墙顶面   处理
			$fNum == $room->getArea()*3;
		}elseif ($projectid == 45){//修粉门窗樘
			$fNum = count($room->window);
		}elseif ($projectid==56 || $projectid==59 || $projectid==60 || $projectid==61 || $projectid==135
			  || $projectid==62 || $projectid==63 
			  || $projectid==57 ||
				$projectid==65){//墙面铺   墙砖填缝剂   铺墙砖   铺砖墙面找平层
			$fNum = $room->getTotallength()*2.4;
			foreach ($room->door as $_d){
				$fNum -= $_d->getArea();
			}
			foreach ($room->window as $_w){
				$fNum -= $_w->getArea()*0.5;
			}
			if($fNum < 0){
				$fNum = 0.0;
			}
		}elseif ($projectid==64 || $projectid==269){//拼角
			foreach ($room->window as $_w){
				$fNum += $_w->getTotalLength();
			}
		}elseif ($projectid==86 || $projectid==87){//窗帘盒
		foreach ($room->window as $_w){
				$fNum += $_w->width;
			}
		}elseif ($projectid==88){//石膏线
			$fNum = $room->getTotallength();
		}elseif ($projectid==89){//厨卫集成吊顶
			$fNum = $room->getArea();
		}elseif ($projectid==93){//成品套装门
			$fNum = count($room->door);
		}elseif ($projectid==91 || $projectid==92 || $projectid==94 || $projectid==95){//套装
			foreach ($room->door as $_d){
				$fNum += $_d->getTotalLength();
			}
		}elseif ($projectid==98){//移门道轨
			foreach ($room->door as $_d){
				$fNum += $_d->width*2;
			}
		}elseif ($projectid==99 || $projectid==97){//吊轮  锁
			$fNum = count($room->door);
		}elseif ($projectid==100 || $projectid==101 || $projectid==102 ||$projectid==103 ||
				$projectid==104 || $projectid==261 || $projectid==262 || $projectid==263 ||
				 $projectid==267 ){//大理石窗台板
			foreach ($room->window as $_w){
				$fNum += $_w->width;
				$fNum += 0.4;
			}
		}elseif ($projectid==112){//铰链
			$fNum = count($room->door)*3;
		}elseif ($projectid==138){//1.5平方单芯线
			$fNum = $room->getArea()*4;
		}elseif ($projectid==139){//2.5平方单芯线
			$fNum = $room->getArea()*6;
		}elseif ($projectid==140 ||$projectid==141 || $projectid==142){//平方电线 
			 if($homeid == 3){//客厅
			 	$fNum = 30;
			 }
		}elseif ($projectid==143 || $projectid==145 || $projectid==144){//网络线  电视线   电话线
			$fNum = 15;
		}elseif ($projectid==146){//音响线
			if($homeid == 3){//客厅
				$fNum = 30;
			}
		}elseif ($projectid == 13 || $projectid == 14 || $projectid == 58 || $projectid == 88
			  || $projectid == 96 || $projectid == 115 || $projectid == 123 || $projectid == 138
			  || $projectid == 139 || $projectid == 140 || $projectid == 141 || $projectid == 142
			  || $projectid == 143 || $projectid == 144 || $projectid == 145 || $projectid == 146
			  || $projectid == 147 || $projectid == 150 || $projectid == 151 || $projectid == 152
			  || $projectid == 153 || $projectid == 154 || $projectid == 155 || $projectid == 89){//线 腰线
				$fNum = 30;
				if($projectid == 147){ //pvc电线管
					$fNum = $room->getArea()*3.3;
				}elseif($projectid == 148 || $projectid == 149 || $projectid == 150 //墙开槽
					 || $projectid == 151 || $projectid == 152
			  		 || $projectid == 153 || $projectid == 154 || $projectid == 155){
					$fNum = $room->getArea()/5;
				}
		}elseif ($projectid==156 || $projectid==157 || $projectid==158){//落水管
			$fNum = 3;
		}elseif ($projectid == 30){//地漏
			if($homeid == 5){//卫生间
				$fNum = 2;
			}
		}elseif ($projectid == 192){//三角阀及波纹管
			if($homeid == 5){//卫生间
				$fNum = 5;
			}elseif ($homeid == 4){//厨房
				$fNum = 2;
			}
		}elseif ($projectid == 195){//灯具安装
			$fNum = $room->getArea();
		}elseif ($projectid==78 || $projectid==80 || $projectid==77 || $projectid==79){//石膏板高低吊顶  石膏板平面吊顶(平顶)
			$fNum = $room->getArea()*0.3;
		}elseif ($projectid == 86){//暗藏式窗帘盒
			$fNum = $room->width;
		}elseif ($projectid == 221 || $projectid == 217 || $projectid == 218){//浴霸安装
			$fNum = 1;
		}elseif ($projectid == 174){//插座防溅盖板
			$fNum = 1;
		}elseif($projectid == 167){//五孔插座
			if ($homeid == 1){//主卧
				$fNum = 10;
			}elseif ($homeid == 2){//次卧
				$fNum = 5;
			}elseif ($homeid == 3){//客厅
				$fNum = 11;
			}elseif ($homeid == 4){//厨房
				$fNum = 8;
			}elseif ($homeid == 6){//阳台
				$fNum = 2;
			}
		}elseif ($projectid == 168){//带开关五孔插座
			if ($homeid == 4){
				$fNum = 3;
			}
		}elseif ($projectid == 160){//一位电脑插座
			if($homeid == 1 || $homeid == 2){
				$fNum = 2;
			}
		}
		else {
			$fNum = 1;
		}
		if ($fNum<=0){
			$fNum = 1;
		}
		return $fNum;//round($fNum);
	}
	/**
	 * 根据房间类型返回施工项目
	 * @param unknown $id 
	 */
// 	public static  function getProjects($id){
// 		switch ($id){
// 			case 1://主卧
// 			case 2://次卧
// 				return array(25,2,96,
// 							132,128,129,100,107,
// 							167,177,176,175,160,138,139,
// 							143,144,145,147,151,153,
// 							155,195,86);//27
// 				break;
// 			case 3://客厅
// 				return array(25,3,96,15,
// 							23,79,78,84,129,128,
// 							132,100,107,
// 							111,86,114,167,177,176,
// 							175,163,138,139,143,
// 							144,145,146,147,151,153,
// 							155,195,202,201);//35
// 				break;
// 			case 4://厨房
// 				return array(26,15,23,27,
// 							56,65,62,64,89,97,
// 							98,99,107,223,222,192,
// 							167,168,159,138,139,147,
// 							151,153,155,156,
// 							195,136);//29
// 				break;
// 			case 5://卫生间
// 				return array(26,28,15,23,
// 							56,65,62,64,89,97,
// 							98,99,210,216,192,30,	167,159,
// 							138,139,147,174,151,153,
// 							155,156,193,195,221);//30
// 				break;
// 			case 6://阳台
// 				return array(15,
// 							23,129,
// 							128,132,194,193,30,167,159,
// 							138,139,147,151,
// 							153,155,195);//18
// 				break;
// 		}
// 	}
	//
	public static function req_handle($code,$param="",$msg=""){
		$res=array('code'=>$code,'param'=>$param,'msg'=>$msg);
		echo json_encode($res);
		exit;
	}

}

?>