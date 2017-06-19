<?php

require_once dirname(__FILE__).'/room.class.php';
require_once dirname(__FILE__).'/tools.class.php';
require_once dirname(__FILE__).'/../DB/dataOper.class.php';


function budget($data)
{
    $homeType    = $data['type'];//房间类型
    $dataType       = $data['dataType'];//数据类型
    $dataHeight = $data['height'];
    $dataWidth = $data['width'];
    $dataLength = $data['length'];
    $dataDoorWindow = $data['doorWindows'];

//    $homeData    = $data['HomeData'];//房间参数
//    $doorData   = $data['DoorData'];//门
//    $windowData = $data['WindowData'];//窗

    if(!(isset($homeType) && isset($dataType) && isset($dataHeight) && isset($dataWidth) && isset($dataLength) && isset($dataDoorWindow)) ) {
            return false;
    }

        //创建房间
    $rm = new Room($dataLength, $dataWidth, $dataHeight,$dataType,$homeType);
//        if ($dataType == '0'){//长 宽 高
//
//        }else{// 周长 面积  高
//            $rm = new Room((float)$homeData['lengthOrPerimeter'], (float)$homeData['widthOrArea'], (float)$homeData['height'],1,$homeType);
//        }

    if(is_array($dataDoorWindow)) {
        foreach ($dataDoorWindow as $_d){
            if($_d['type']=="window") {
                $door = new Door((float)$_d['width'], (float)$_d['height']);
//                $rm->addDoorWindows($door);
                $rm->AddDoor($door);


            } else {
                $window = new Window((float)$_d['width'], (float)$_d['height']);
//                $rm->addDoorWindows($window);
                $rm->AddWindow($window);
            }

        }
    }

//        if($doorData != ""){
//            foreach ($doorData as $_d){
//                $door = new Door((float)$_d['widthOrArea'], (float)$_d['height']);
//                $rm->AddDoor($door);
//            }
//        }
//        if($windowData != ""){
//            foreach ($windowData as $_w){
//                $window = new Window((float)$_w['widthOrArea'], (float)$_w['height']);
//                $rm->AddWindow($window);
//            }
//        }



        $oper = new DataOper();
        $mlist = array();//材料清单
        $plist = array();//工程清单

        $classinfo = $oper->getProjectsClassInfo((int)$rm->kind);//0 [id] => 1  [kind] => 地面

        $projects = array();
        foreach($classinfo as $k=>$v)
        {
            //根据房间类型 获取所有施工项目
            $info = $oper->getProjectsByhome((int)$rm->kind,$v['id']);//1
            $classinfo[$k]['projects'] = $info;
        }



        for($i=0,$len=count($classinfo);$i<$len;$i++)
        {
            for($j=0,$len_j=count($classinfo[$i]['projects']);$j<$len_j;$j++)
            {
                $pro = $oper->getProjectByID($classinfo[$i]['projects'][$j]['pid']);

                //获取工程量
                $projectnum = Calproject::getNum((int)$classinfo[$i]['projects'][$j]['pid'], $rm);
                $p = $pro[0];
                $p["num"] = $projectnum;
                $plist[] = $p;

                $classinfo[$i]['projects'][$j]['quantities'] = $p["num"];//新定义工程量

                //获取当前施工项目 的材料
                $materias = $oper->getMaterial($classinfo[$i]['projects'][$j]['pid']);

                //添加到材料清单
                $mt = array();
                foreach ($materias as $k4=>$_m){
                    $_m["num"] = ceil((float)$_m["num"]/(float)$_m["rat"]);//数量=num/rate

                    $mt[] = array('mid'=>$_m['mid'],"name"=>$_m["name"],"model"=>$_m["model"],"brand"=>$_m["brand"],
                        "unit"=>$_m["orderunit"],"number"=>$_m["num"],
                        "price"=>$_m["price"],"notice"=>$_m["notice"],"rate"=>$_m["rat"],'url'=>$_m['url']);
                }
                $classinfo[$i]['projects'][$j]['materials'] = $mt;
            }
        }

//    $budget = Array();
//    $budget->type = $homeType;
//    $budget->width = $dataWidth;
//    $budget->height = $dataHeight;
//    $budget->length = $dataLength;
//    $do
        return $classinfo;
}
function budgets($rooms) {
    $data = array();
    foreach($rooms as $key=>$val)
    {
        $res = budget($val);
        $val['constructions'] = $res;
//        $data[] = ($val['constructions'] = $res);
        $data[] = $val;
    }
    return $data;
}

function size ($roomInfo) {
    $area     = $roomInfo["Area"];     //总面积

    $roomN    = (int)$roomInfo["RoomN"];    //室数量
    $sittingN = (int)$roomInfo["SittingN"]; //厅数量
    $kitchenN = (int)$roomInfo["KitchenN"]; //厨房数
    $toiletN  = (int)$roomInfo["ToiletN"];  //卫生间数
    $balconyN = (int)$roomInfo["BalconyN"]; //阳台数

    checkPostData( (1<=$roomN && $roomN<=4),'室数量范围1-4',400);
    checkPostData( (1<=$sittingN && $sittingN<=2),'厅数量范围1-2',400);
    checkPostData( (1==$kitchenN || $kitchenN==0),'厨房数量范围0-1',400);
    checkPostData( (1==$toiletN || $toiletN==2),'卫生间数量范围1-2',400);
    checkPostData( (0<=$balconyN && $balconyN<=2),'阳台数量范围0-2',400);


    //计算门 室1/间个  卫生间1/间   厅的门为其他房间门的总和+1,如果是2厅，客厅为其他房间门的总和2/3 +1 ，余下的为餐厅（第二个厅）的
    if($sittingN == 1) $doorN = $roomN+$toiletN+($roomN+1);
    else $doorN = $roomN+$toiletN+floor($roomN*2/3+1);

//        $data = array();
//        $data['door']['width'] = 0.9;
//        $data['door']['height'] = 2;
//        $data['door']['num'] = $doorN;

    $data = array();

    //室 12 (4:3)
    for($i = 0;$i<$roomN;$i++)
    {
        if($i == 0) $info['type'] = 1;
        else $info['type'] = 2;

        $info['dataType'] = 0;//0长宽高 1周长面积
        $info['length'] = 4;//房 长
        $info['width'] = 3;//房 宽
        $info['height'] = 2.8;//房 高

        $info['doorWindows'] = array(getDoor(),getWindow());

        $data[] = $info;
    }
    //厅 15  6 (3:2)
    if($sittingN==1) {
        $info['type'] = 3;//0长宽高 1周长面积
        $info['dataType'] = 0;
        $info['length'] = 5;//房 长
        $info['width'] = 3;//房 宽
        $info['height'] = 2.8;//房 高
        $info['doorWindows'][] = getWindow();
        for($i=0; $i<$roomN;$i++) {
            $info['doorWindows'][] = getDoor();
        }
        $data[] = $info;
    }
    else if($sittingN == 2) {
        $info['type'] = 3;//0长宽高 1周长面积
        $info['dataType'] = 0;
        $info['length'] = 5;//房 长
        $info['width'] = 3;//房 宽
        $info['height'] = 2.8;//房 高
        $fistSetting = ceil($roomN*2/3 +1);
        $info['doorWindows'][] = getWindow();
        for($i=0; $i<$fistSetting;$i++) {
            $info['doorWindows'][] = getDoor();
        }
        $data[] = $info;


        $info['type'] = 3;//0长宽高 1周长面积
        $info['dataType'] = 0;
        $info['length'] = 3;//房 长
        $info['width'] = 2;//房 宽
        $info['height'] = 2.8;//房 高
//        $info['doorWindows'] = array(getDoor(),getWindow());
        for($i=0; $i<$roomN - $fistSetting;$i++) {
            $info['doorWindows'][] = getDoor();
        }
        $data[] = $info;
    }

    //厨房 6 (3:2)
    $info['type'] = 4;//0长宽高 1周长面积
    $info['dataType'] = 0;
    $info['length'] = 3;//房 长
    $info['width'] = 2;//房 宽
    $info['height'] = 2.8;//房 高
        $info['doorWindows'] = array(getDoor(),getWindow());

    $data[] = $info;

    //卫生间 4 (3:2)
    for($i = 0;$i<$toiletN;$i++)
    {
        $info['type'] = 5;//0长宽高 1周长面积
        $info['dataType'] = 0;
        $info['length'] = 2.7;//房 长
        $info['width'] = 1.5;//房 宽
        $info['height'] = 2.8;//房 高
        $info['doorWindows'] = array(getDoor(),getWindow());

        $data[] = $info;
    }
    //阳台(2:1)
    for($i = 0;$i<$balconyN;$i++)
    {
        $info['type'] = 6;//0长宽高 1周长面积
        $info['dataType'] = 0;
        $info['length'] = 2.7;//房 长
        $info['width'] = 1.5;//房 宽
        $info['height'] = 2.8;//房 高
        $info['doorWindows'] = array(getDoor());
        $data[] = $info;
    }
    $totalArea = 0;
    foreach($data as $room) {
        $totalArea+= $room['length']* $room['width'];
    }

        $avgArea = sqrt($area/$totalArea);
        foreach($data as $key=>$room) {
             $data[$key]['length'] =round( $avgArea*$data[$key]['length'],2);
            $data[$key]['width'] = round($avgArea*$data[$key]['width'],2);
        }


    return $data;
}

function getWindow() {
    $dataWin1 = Array();
    $dataWin1['width'] =  1;//窗 宽
    $dataWin1['height'] =  1;//窗 高
    $dataWin1['type'] = 'window';
    return $dataWin1;
}

function getDoor() {
    $dataDoor1 = Array();
    $dataDoor1['width'] =  0.9;//门 宽
    $dataDoor1['height'] =   2;//门 高
    $dataDoor1['type'] = 'door';
    return $dataDoor1;
}



	
?>