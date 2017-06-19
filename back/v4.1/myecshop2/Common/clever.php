<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/9/8
 * Time: 14:24
 */
function getNums($classfy,$arg,$other){
    switch($classfy){
        case 1://水
            return calWater($arg);
        case 2://电 电线管件
            return calElectricOther($arg);
        case 3://客厅航空顶
            return calSitting($arg);
        case 4://批墙油工
            return calOiler($arg,$other);
        case 5://泥工
            return calMason($arg);
        case 6://轻钢龙骨吊顶
            return calQgdd($arg);
        case 7://轻钢龙骨隔墙
            return calQggq($arg);
        case 8://柜台
            return calDesk((int)$arg["deskType"],$arg["deskHeight"]);
        case 9://电 开关
            return calElectricSwitches($arg);
        default:
            break;
    }
}
//水
function calWater($arg){
    $json_string = file_get_contents('Public/json/water.json');
    $data = json_decode($json_string,true);

    $res = array();
    foreach ($data as $v){
        $item = array();
//        $item["name"]  = $v["name"];
//        $item["model"] = $v["model"];
//        $item["num"]   = water((int)$v["ID"],$arg);
        $item["amount"]   = water((int)$v["ID"],$arg);
        if($v['ID'] == 1) $item["amount"]=ceil($item["amount"]/3);
        if($v['ID'] == 14) $item["amount"]=$item["amount"]*50;
        if($v['ID'] == 16) $item["amount"]=ceil($item["amount"]/4);

        $item['goods_id'] = $v['goods_id'];
        $res[] = $item;
    }

    return $res;
}
function water($id,$arg){
    $area = (int)$arg["area"];//面积
    $roomnum = (int)$arg["roomN"];//室
    $sittingnum = (int)$arg["sittingN"];//厅
    $kitchennum = (int)$arg["kitchenN"];//厨
    $toiletnum  = (int)$arg["toiletN"];//卫
    $balconynum = (int)$arg["balconyN"];//阳台
    $toiletnum1 = 0;//第一卫
    $toiletnum2 = 0;//第二卫
    $balconynum1 = 0;//第一阳台
    $balconynum2 = 0;//第二阳台
    if($toiletnum == 1){$toiletnum1 = 1;}
    elseif ($toiletnum == 2){$toiletnum1 = 1;$toiletnum2 = 1;}

    if($balconynum == 1){$balconynum1 = 1;}
    elseif ($balconynum == 2){$balconynum1 = 1;$balconynum2 = 1;}
    $standarea = 0; //标准户型才有面积系数
    if(($kitchennum+$toiletnum+$balconynum)==2)     {$standarea = 75; }
    else if(($kitchennum+$toiletnum+$balconynum)==3){$standarea = 100;}
    else if(($kitchennum+$toiletnum+$balconynum)==4){$standarea = 130;}
    else if(($kitchennum+$toiletnum+$balconynum)==5){$standarea = 150;}
    $num = 0.0;//用量
    $num1 = 0.0;//基础用量
    $num2 = 0.0;//面积系数
    switch($id){//PPR管
        case 1:
            $num1 = $kitchennum*16+$toiletnum1*14+$toiletnum2*20+$balconynum1*15+$balconynum2*10;
            break;
        case 2://直通
            $num1 = $kitchennum*2+$toiletnum1*3+$toiletnum2*4+$balconynum1*3+$balconynum2*3;
            break;
        case 3://90度弯头D25
            $num1 = $kitchennum*16+$toiletnum1*14+$toiletnum2*20+$balconynum1*10+$balconynum2*20;
            break;
        case 4://管堵、丝堵、堵头
            $num1 = $kitchennum*7+$toiletnum1*8+$toiletnum2*5+$balconynum2*5;
            break;
        case 5://等径三通
            $num1 = $kitchennum*4+$toiletnum1*6+$toiletnum2*5+$balconynum1*5+$balconynum2*5;
            break;
        case 6://过桥弯
            $num1 = $kitchennum*2+$toiletnum1*2+$toiletnum2*2+$balconynum1*0+$balconynum2*2;
            break;
        case 7://内丝接头
            $num1 = $kitchennum*2+$toiletnum1*2+$toiletnum2*2;
            break;
        case 8://内丝三通
            $num1 = $kitchennum*1+$toiletnum1*1+$toiletnum2*3+$balconynum1*0+$balconynum2*1;
            break;
        case 9://内丝弯头
            $num1 = $kitchennum*2+$toiletnum1*5+$toiletnum2*3+$balconynum1*2+$balconynum2*3;
            break;
        case 10://地漏
            $num1 = $kitchennum*0+$toiletnum1*2+$toiletnum2*2+$balconynum1*1+$balconynum2*1;
            break;
        case 11://45度弯头 d25
            $num1 = $kitchennum*1+$toiletnum1*1+$toiletnum2*0+$balconynum1*2+$balconynum2*2;
            break;
        case 12://大小头(D32/D25)
            return 1;
        case 13://生料带
            $num1 = $kitchennum*2+$toiletnum1*3+$toiletnum2*2+$balconynum1*3+$balconynum2*2;
            break;
        case 14://塑料U型管卡
            return 1;
        case 15://三角阀
            $num1 = $kitchennum*4+$toiletnum1*5+$toiletnum2*4+$balconynum1*2+$balconynum2*2;
            break;
        case 16://PVC下水管 4米/根
            $num1 = 4;
            break;
        case 17://顺水三通
            $num1 = $kitchennum*0.5+$toiletnum1*0.5+$toiletnum2*1+$balconynum1*1+$balconynum2*1;
            break;
        case 18://90度弯头 d40
            $num1 = $kitchennum+$toiletnum1+$toiletnum2*2+$balconynum1*2+$balconynum2*2;
            break;
        case 19://管箍(直接)
// 			$num1 = $kitchennum+$toiletnum1+$toiletnum2+$balconynum1+$balconynum2;
// 			break;
        case 20://45度弯头 d40
            $num1 = $kitchennum+$toiletnum1+$toiletnum2+$balconynum1+$balconynum2;
            break;
        case 21://PVC专用胶水
            return 1;
    }
    if($standarea != 0){//标准房型  面积系数
        $num2 = 0.2*$num1*($area-$standarea)/$standarea;
    }
    $num = $num1 + $num2;
    return round($num);
}
//电 开关
function calElectricSwitches($arg) {
    return calElectric($arg,'Public/json/electric_switches.json');
}
//电电线管类
function calElectricOther($arg) {
    return calElectric($arg,'Public/json/electric.json');
}

function calElectric($arg,$file){
    $json_string = file_get_contents($file);
    $data = json_decode($json_string,true);

    $res = array();
    foreach ($data as $v){
        $num = eletric((int)$v["ID"],$arg);

        if($v["ID"] == "14"||$v["ID"] =="15"||$v["ID"] == "16"||$v["ID"] == "17"){//PVC电线管   U迫码  杯梳  梳杰
            $red =  ceil(($num/3)*2);
            $item = array();
            $item["amount"]   = $red;
            $item['goods_id'] = $v['goods_id'];
//            $item["num"]   = $red;
            $res[] = $item;
            $item1 = array();
            $item1["amount"]   = $num-$red;

            $item1['goods_id'] = $v['goods_id2'];
//            $item1["num"]   = $num-$red;
            $res[] = $item1;

        }else if($v["ID"] == "20"){//86 胶暗箱
            $red = ceil(($num/6)*5);
            $item = array();
            $item["amount"]   = $red;
            $item['goods_id'] = $v['goods_id'];
//            $item["num"]   = $red;
            $res[] = $item;
            $item1 = array();
            $item1["amount"]   = $num-$red;
            $item1['goods_id'] = $v['goods_id2'];
//            $item1["num"]   = $num-$red;
            $res[] = $item1;
        }else if($v["ID"] == "29"){//配电箱
            $item = array();
            if($num <8){
                $item['goods_id'] = $v['goods_id'];
            }else{
                $item['goods_id'] = $v['goods_id2'];
            }
            $item["amount"]   = 1;
            $res[] = $item;
        }
        else{

            $item = array();
            $item["amount"]   = $num;

            if($v["ID"] =="8") continue;

            if($v["ID"] =="7") $item["amount"] = ceil($item["amount"]/5);//处理切件
            if($v["ID"] =="9") $item["amount"] = ceil($item["amount"]/5)*2;//处理切件

            $item['goods_id'] = $v['goods_id'];
            $res[] = $item;
        }
    }

    $res[] = array('amount'=>1,'goods_id'=>8956);
    $res[] = array('amount'=>1,'goods_id'=>26833);

    if($arg['roomN'] == 1) $goods_id = 8756;
    else if($arg['roomN'] == 2) $goods_id = 8756;
    else if($arg['roomN'] == 3) $goods_id = 8757;
    else if($arg['roomN'] == 4) $goods_id = 8758;
    else $goods_id = 8758;

    $res[] = array('amount'=>1,'goods_id'=>$goods_id);//电视分配器

    return $res;
}
function eletric($id,$arg){
    $area = (int)$arg["area"];//面积
    $roomnum = (int)$arg["roomN"];//室
    $sittingnum = (int)$arg["sittingN"];//厅
    $kitchennum = (int)$arg["kitchenN"];//厨
    $toiletnum  = (int)$arg["toiletN"];//卫
    $balconynum = (int)$arg["balconyN"];//阳台
    $sum = $roomnum + $sittingnum + $kitchennum + $toiletnum + $balconynum;//总房间数
    $num = 0.0;//用量
    $type = 0;//房型
    if($area==75){$type = 5;}
    elseif ($area==100){$type = 7;}
    elseif ($area==130){$type = 9;}
    elseif ($area==150){$type = 10;}

    switch($id){
        case 1://电线1.5 红
            $num = ceil($area/100);
            break;
        case 2://电线1.5 蓝
        case 3://电线1.5  白
        case 4://电线2.5  红
        case 5://电线2.5 蓝
        case 6://电线2.5 双色
            $num = 1+floor(($area-70)/30);
            break;
        case 7://电线4.0 红
        case 8://电线4.0 蓝
        case 9://电线4.0 双色
            $num = floor($area/100)*10;
            break;
        case 10://网线
        case 11://视频线
        case 12://电话线
            $num = ceil($area/100);
            break;
        case 13://电工胶
            $num = 3 + round(($area-70)/25);
            break;
        case 14://pvc电线管
            if($area<=75){$num = 50;}
            elseif ($area>75 && $area<=100){$num = 100;}
            elseif ($area>100 && $area<=130){$num = 130;}
            elseif ($area>130 && $area <=150){$num = 135;}
            elseif ($area>150){$num = 135 + ($area-150)/5;}

            $num2 = 0;
            if($area==75){$num2 = 5;}
            elseif ($area==100){$num2 = 7;}
            elseif ($area==130){$num2 = 9;}
            elseif ($area==150){$num2 = 10;}

            $num += ($sum-$num2)*2;
            $num = round($num);
            break;
        case 15://U迫码
            if($area<=75){$num = 50;}
            elseif ($area>75 && $area<=100){$num = 100;}
            elseif ($area>100 && $area<=150){$num = 120;}
            elseif ($area>150){$num = 120 + round((a-150)/5);}
            break;
        case 16://杯梳
        case 17://梳杰
            if($area<=75){$num = 50;}
            elseif ($area>75 && $area<=100)  {$num = 100;}
            elseif ($area>100 && $area<=130) {$num = 150;}
            elseif ($area>130 && $area <=150){$num = 170;}
            elseif ($area>150){$num = 170 + ($area-150);}
            break;
        case 18://八角灯头箱
        case 19://八角灯头盒盖板
            if($sum<=5){$num = 5;}
            elseif ($sum==6){$num = 7;}
            elseif ($sum==7){$num = 10;}
            elseif ($sum==8){$num = 15;}
            elseif ($sum==9){$num = 20;}
            elseif ($sum>=10){$num = 20 + $sum-9;}
            break;
        case 20://86 胶暗箱
            if($sum<=5){$num = 30;}
            elseif ($sum==6){$num = 45;}
            elseif ($sum==7){$num = 60;}
            elseif ($sum==8){$num = 70;}
            elseif ($sum==9 || $sum==10 || $sum==11){$num = 80;}
            elseif ($sum>11){$num = 80 + ($sum-11)*10;}
            break;
        case 21://方刚弹簧
            return 1;
        case 22://蛇皮袋
            return 1;
        case 23://铁锹
            return 1;
        case 24://断路器 63A
            if($sum>5){$num = 1;}
            break;
        case 25://断路器 40A
            if($sum<=5){$num = 1;}
            break;
        case 26://断路器 25A
            $num = 1 + floor(($sum-5)/2);
            break;
        case 27://断路器 20A
            $num = $roomnum + ($sittingnum>0?1:0) + ($toiletnum>0?1:0);
            break;
        case 28://断路器 16A
            return 1;
        case 29://配电箱   返回房间总数   数量=1  按房间数确定型号 <8 12回路   else 16回路
            //num = 1;
            $num = $sum;
            break;
        case 30://开关 一位双控
            $num = $roomnum*2 + ($sittingnum>0?1:0)*2;
            break;
        case 31://开关 一位单控
            $num = $sittingnum + $kitchennum + $toiletnum + $balconynum;
            break;
        case 32://开关 三位单控
            return 1;
        case 33://插座5孔
            $num = 25+($roomnum-2>0?$roomnum-2:0)*5+($toiletnum-1>0?$toiletnum-1:0)*3+$balconynum;
            break;
        case 34://插座3孔
            return 4;
        case 35://插座5孔 带开关
            return 2;
        case 36://插座3孔 带开关
            $num = $roomnum + ($sittingnum>0?1:0);
            break;
        case 37://电话插座
            return 2;
        case 38://电视电脑插座
            $num = $roomnum;
            break;
        case 39://电脑插座
            return 2;
    }
    return $num;
}
//批墙油工
function calOiler($arg,$other){

    $json_string = file_get_contents('Public/json/oiler.json');
//    $json_string2 = file_get_contents('Public/json/oiler_data.json');
    $data = json_decode($json_string,true);

    $res = array();
    foreach ($data as $v){

        //用户腻子粉选择了否
        if(!$other && $v['ID'] == "1")
        {
            continue;
        }
        if($other && ($v['ID'] == "2" || $v['ID'] == "3" || $v['ID'] == "4"))
        {
            continue;
        }

        $item = array();
//        $item["name"]  = $v["name"];
//        $item["model"] = $v["model"];
        $item["amount"]   =($other&&$v['ID'] == "6")?ceil(oiler((int)$v["ID"],$arg)/2): ceil(oiler((int)$v["ID"],$arg));//选了腻子粉，
        $item['goods_id'] = $v['goods_id'];

        if(($v['ID'] == 24 || $v['ID'] == 25) && $item["amount"]%3 != 0)
        {
            $item1 = array();
            $item1['amount'] =  $item["amount"]%3;//取余，小桶数量
            $item1['goods_id'] =  $v['goods_id'];

            $item2 = array();
            $item2['amount'] = intval($item["amount"]/3);//取整，大桶数量
            $item2['goods_id'] = ($v['ID'] == 24)?908:6440;

            $res[] = $item1;
            $res[] = $item2;
        }else
        {
            $res[] = $item;
        }


//        $res[] = $item;

//        $goods_id = $v["goods_id"];
//        $item['amount'] = oiler((int)$v["ID"],$arg);
    }

    return $res;
}
function oiler($id,$arg){
    $area = (int)$arg["area"];//面积
    $roomnum = (int)$arg["roomN"];//室
    $sittingnum = (int)$arg["sittingN"];//厅
    $kitchennum = (int)$arg["kitchenN"];//厨
    $toiletnum  = (int)$arg["toiletN"];//卫
    $balconynum = (int)$arg["balconyN"];//阳台
    $num = 0.0;//用量
    $sum = $roomnum + $sittingnum + $kitchennum + $toiletnum + $balconynum;//总房间数
    if($sittingnum>0){$sittingnum = 1;}//多厅只算一个
    switch($id){
        case 1://腻子粉
            $num1 = ($roomnum + $sittingnum + $balconynum)*6;
            $offarea = 0;
            if($sum == 5){$offarea = 75;}
            elseif ($sum == 7) {$offarea = 100;}
            elseif ($sum == 9) {$offarea = 130;}
            elseif ($sum == 10){$offarea = 150;}
            if($offarea != 0){
                $num = round($num1 + 0.4*$num1*($area-$offarea)/$offarea);
            }else{
                $num = $num1;
            }
            break;
        case 2://石膏粉
            $num1 = $roomnum + $sittingnum + $balconynum;
            $offarea = 0;
            if($sum == 5){$offarea = 75;}
            elseif ($sum == 7) {$offarea = 100;}
            elseif ($sum == 9) {$offarea = 130;}
            elseif ($sum == 10){$offarea = 150;}
            if($offarea != 0){
                $num = round($num1 + 0.4*$num1*($area-$offarea)/$offarea);
            }else{
                $num = $num1;
            }
            break;
        case 3://滑石粉
            $num1 = ($roomnum + $sittingnum + $balconynum)*5;
            $offarea = 0;
            if($sum == 5){$offarea = 75;}
            elseif ($sum == 7) {$offarea = 100;}
            elseif ($sum == 9) {$offarea = 130;}
            elseif ($sum == 10){$offarea = 150;}
            if($offarea != 0){
                $num = round($num1 + 0.4*$num1*($area-$offarea)/$offarea);
            }else{
                $num = $num1;
            }
            break;
        case 4://熟胶粉
            $num = round(($roomnum + $sittingnum + $balconynum)*1.4);
            break;
        case 5://填缝膏
            $num = ceil(($roomnum + $sittingnum + $balconynum)*0.2);
            break;
        case 6://801胶
            $num = round(($roomnum + $sittingnum + $balconynum)*0.5);
            break;
        case 7://白胶
            $num = round(($roomnum + $sittingnum + $balconynum)*0.33);
            break;
        case 8://网格布
            $num = round(($roomnum + $sittingnum + $balconynum)*0.33);
            break;
        case 9://纸绷带
            $num = round(($roomnum + $sittingnum + $balconynum)*0.33);
            break;
        case 10://砂皮
            $num = round(($roomnum + $sittingnum + $balconynum)*0.5);
            break;
        case 11://砂皮架
            $num = round(($roomnum + $sittingnum + $balconynum)*0.3);
            break;
        case 12://粗毛滚筒
            $num = round(($roomnum + $sittingnum + $balconynum)*0.2);
            break;
        case 13://细毛滚筒
            $num = round(($roomnum + $sittingnum + $balconynum)*0.2);
            break;
        case 14://羊毛刷
            $num = round(($roomnum + $sittingnum + $balconynum)*0.5);
            break;
        case 15://船用刷,4寸
            $num = round(($roomnum + $sittingnum + $balconynum)*0.33);
            break;
        case 16://船用刷，2.5寸
            $num = round(($roomnum + $sittingnum + $balconynum)*0.33);
            break;
        case 17://阳角条
            $num1 = ($roomnum + $sittingnum + $balconynum)*3;
            $offarea = 0;
            if($sum == 5){$offarea = 75;}
            elseif ($sum == 7) {$offarea = 100;}
            elseif ($sum == 9) {$offarea = 130;}
            elseif ($sum == 10){$offarea = 150;}
            if($offarea != 0){
                $num = round($num1 + 0.2*$num1*($area-$offarea)/$offarea);
            }else{
                $num = $num1;
            }

            break;
        case 18://美纹纸
            $num = round(($roomnum + $sittingnum + $balconynum)*0.5);
            break;
        case 19://小白桶
            $num = round(($roomnum + $sittingnum + $balconynum)*0.6);
            break;
        case 20://美工刀
// 			$num = round(($roomnum + $sittingnum + $balconynum)*0.2);
// 			break;
        case 21://美工刀片
            $num = round(($roomnum + $sittingnum + $balconynum)*0.2);
            break;
        case 22://乳胶漆面漆
            return 0;
        case 23://乳胶漆低漆  安小桶计算
            return 0;
        case 24://乳胶漆面漆
            $num = $roomnum + (int)$arg["sittingN"] + $balconynum;
            break;
        case 25://乳胶漆底漆
            $num = $roomnum + (int)$arg["sittingN"] + $balconynum;
            break;
    }
    return $num;
}

//轻钢龙骨隔墙
function calQggq($arg){
    $json_string = file_get_contents('Public/json/qggq.json');
    $data = json_decode($json_string,true);
    $res = array();

    foreach ($data as $cont){
        $item["amount"]   = qggq($cont["ID"],$arg);
        $item['goods_id'] = $cont['goods_id'];
//        $item["num"]   = qggq($cont["ID"],$arg);
        //console.log(item);
        if($cont["ID"] == 1 || $cont["ID"]==3)
        {
            $item["amount"] = ceil($item["amount"]/3);
        }

        array_push($res, $item);
    }
    return $res;
}
//轻钢龙骨函数
function qggq($id,$arg){
    $sittingarea = $arg["sitArea"];//厅
    $num = 0;
    switch($id){
        case 1://天地龙骨
            if($sittingarea <= 7){$num = 5;}
            else{$num = round(($sittingarea/7)*5);}
            break;
        case 2://竖向龙骨
            if($sittingarea <= 7){$num = 7;}
            else{$num = round(($sittingarea/7)*7);}
            break;
        case 3://穿心龙骨
            if($sittingarea <= 7){$num = 5;}
            else{$num = round(($sittingarea/7)*5);}
            break;
        case 4://支撑卡
            if($sittingarea <= 7){$num = 14;}
            else{$num = round(($sittingarea/7)*14);}
            break;
        case 5://隔音棉/玻璃棉
            if($sittingarea <= 7){$num = 1;}
            else{$num = round(($sittingarea/7)*1);}
            break;
        case 6://石膏板
            if($sittingarea <= 7){$num = 4;}
            else{$num = round(($sittingarea/7)*4);}
            break;
        case 7://干壁钉
            if($sittingarea <= 7){$num = 2;}
            else{$num = round(($sittingarea/7)*2);}
            break;
        case 8://外膨胀螺丝
            if($sittingarea <= 7){$num = 1;}
            else{$num = round(($sittingarea/7)*1);}
            break;
        default:
            break;
    }
    return $num;
}
//轻钢吊顶
function calQgdd($arg){
    $json_string = file_get_contents('Public/json/qgdd.json');
    $data = json_decode($json_string,true);
    $res = array();

    foreach ($data as $cont){
        $item["amount"]   = qgdd($cont["ID"],$arg);
        $item['goods_id'] = $cont['goods_id'];
//        $item["num"]   = qgdd($cont["ID"],$arg);
        //console.log(item);
        if($cont["ID"] == 1 || $cont["ID"]==3)
        {
            $item["amount"] = ceil($item["amount"]/3);
        }

        array_push($res, $item);
    }
    return $res;
}

function qgdd($id,$arg){
    $sitarea = $arg['sitArea'];
    $num = 0;

    switch ($id){
        case 1:
            if($sitarea <= 12){$num = 6;}
            else{$num = round(($sitarea/12)*6);}
            break;
        case 2://副龙骨
            if($sitarea <= 12){$num = 10;}
            else{$num = round(($sitarea/12)*10);}
            break;
        case 3://边龙骨
            if($sitarea <= 12){$num = 15;}
            else{$num = round(($sitarea/12)*15);}
            break;
        case 4://大吊
            if($sitarea <= 12){$num = 8;}
            else{$num = round(($sitarea/12)*8);}
            break;
        case 5://中吊
            if($sitarea <= 12){$num = 20;}
            else{$num = round(($sitarea/12)*20);}
            break;
        case 6://螺杆
            if($sitarea <= 12){$num = 1;}
            else{$num = round($sitarea/12);}
            break;
        case 7://内膨胀螺丝三组合   对销螺丝/穿心螺丝
            if($sitarea <= 12){$num = 10;}
            else{$num = round(($sitarea/12)*10);}
            break;
        case 8://对销螺丝/穿心螺丝
            if($sitarea <= 12){$num = 8;}
            else{$num = round(($sitarea/12)*8);}
            break;
        case 9://螺丝螺母
            if($sitarea <= 12){$num = 20;}
            else{$num = round(($sitarea/12)*20);}
            break;
        case 10://螺丝螺母
            if($sitarea <= 12){$num = 5;}
            else{$num = round(($sitarea/12)*5);}
            break;
        case 11://螺丝螺母
            if($sitarea <= 12){$num = 2;}
            else{$num = round(($sitarea/12)*2);}
            break;
        default:
            break;
    }
    return $num;
}
//柜台
function calDesk($type,$height){
    $json_string = file_get_contents('Public/json/desk.json');
    $data = json_decode($json_string,true);
    $res = array();

//    if($type<0.5) {
//
//    } else if($type<1.5) {
//        $type = 1;
//    } else if($type<3) {
//        $type = 2;
//    } else if ($type<4.5) {
//        $type = 3;
//    } else {
//        $type = 3;
//    }

    foreach ($data as $cont){
        $item["amount"]   = desk($cont["ID"],$height,$type);
        $item['goods_id'] = $cont['goods_id'];
//        $item["num"]   = desk($cont["ID"],$height,$type);
        //console.log(item);
        array_push($res, $item);
    }
    return $res;
}
function desk($id,$height,$type){
    $num = 0;
    switch ($id){
        case 1://生态板
            if($type == '1'){$num = 3;}
            elseif ($type == '2'){$num = 6;}
            elseif ($type == '3'){$num = 4;}
            elseif ($type == '4'){$num = 8;}
            break;
        case 2://背板
            if($type == '1'){$num = 1;}
            elseif ($type == '2'){$num = 2;}
            elseif ($type == '3'){$num = 2;}
            elseif ($type == '4'){$num = 4;}
            break;
        case 3://U型扣条
            if($type == '1'){$num = 6;}
            elseif ($type == '2'){$num = 12;}
            elseif ($type == '3'){$num = 8;}
            elseif ($type == '4'){$num = 16;}
            break;
//        case 3://U型扣条
//            if($type == '1'){$num = 6;}
//            elseif ($type == '2'){$num = 12;}
//            elseif ($type == '3'){$num = 8;}
//            elseif ($type == '4'){$num = 16;}
//            break;
        case 4://枪钉
            if($type == '1'){$num = 1;}
            elseif ($type == '2'){$num = 1;}
            elseif ($type == '3'){$num = 1;}
            elseif ($type == '4'){$num = 2;}
            break;
        case 5://镀锌干壁钉
            if($type == '1'){$num = 1;}
            elseif ($type == '2'){$num = 1;}
            elseif ($type == '3'){$num = 1;}
            elseif ($type == '4'){$num = 2;}
            break;
        case 6://免钉胶
            if($type == '1'){$num = 1;}
            elseif ($type == '2'){$num = 1;}
            elseif ($type == '3'){$num = 1;}
            elseif ($type == '4'){$num = 2;}
            break;
        case 7://挂衣杆
            if($type == '1'){$num = 1;}
            elseif ($type == '2'){$num = 1;}
            elseif ($type == '3'){$num = 1;}
            elseif ($type == '4'){$num = 2;}
            break;
        default:
            break;
    }
    if ($height == '1.2'){//以上为2.5  用量  1.2减半
        $num = ceil($num/2);
    }
    return $num;
}
function calMason($arg){
    $json_string = file_get_contents('Public/json/mason.json');
    $data = json_decode($json_string,true);
    $res = array();

    foreach ($data as $cont){
        if($cont['ID'] == '4'){
            continue;
        }
        //去掉 玻化砖
        else if( $cont['ID'] == 3)
        {
            continue;
        }
        else
        {
            if( $cont["ID"]==1)
            {
                $item["amount"]   = mason($cont["ID"],$arg);
                $item['goods_id'] = $cont['goods_id'];
                array_push($res, $item);
            } else if( $cont["ID"]==2) {

            } else
            {
                $item["amount"]   = mason($cont["ID"],$arg);
                $item['goods_id'] = $cont['goods_id'];
                array_push($res, $item);
            }
//            $item["num"]   = mason($cont["ID"],$arg);
            //console.log(item);
        }
    }
    return $res;
}
function mason($id,$arg){
    $area = $arg["area"];
    $room = $arg["roomN"];
    $sitting = $arg["sittingN"];
    $kitchenN = $arg["kitchenN"];
    $toiletN = $arg["toiletN"];
    $balconyN = $arg["balconyN"];
    $sum = $room + $sitting + $kitchenN + $toiletN + $balconyN;
    $num = 0;
    $balconynum1 = 0;//第一阳台
    $balconynum2 = 0;//第二阳台
    if($balconyN == 1){$balconynum1 = 1;}
    elseif ($balconyN == 2){$balconynum1 = 1;$balconynum2 = 1;}

    switch ($id){
        case 1://釉面砖粘结剂
        case 2://瓷砖粘结剂
        case 3://玻化砖粘结剂
            $offarea = 0;
            if ($sum == 5){$offarea = 75;}
            elseif ($sum == 7){$offarea = 100;}
            elseif ($sum == 9){$offarea = 130;}
            elseif ($sum == 10){$offarea = 150;}
            $num1 = $kitchenN*15 + $toiletN*12 + $balconynum1*10 + $balconynum2*5;
            if($offarea != 0){
                $num = $num1 + round(0.4*$num1*($area-$offarea)/$offarea);
            }else {
                $num = $num1;
            }
            break;
        case 5://防水涂料
            $num = $toiletN + $balconyN;
            break;
        case 6://填缝剂
            if($sum<=8){$num = 2;}
            else if($sum>8){$num = 3;}
            break;
        case 7://十字架  基础配置
            return  10;
        case 8://毛巾 基础配置
            return 5;
    }
    return $num;
}
function calSitting($arg){
    $json_string = file_get_contents('Public/json/ceiling.json');
    $data = json_decode($json_string,true);
    $res = array();
    foreach ($data as $v){
        $item = array();
        $item["amount"]   = sitting((int)$v["ID"],$arg);
        $item['goods_id'] = $v['goods_id'];
//        $item["num"]   = sitting((int)$v["ID"],$arg);
        $res[] = $item;
    }
    return $res;
}
function sitting($id,$arg){
    $sitarea = (int)$arg['sitArea'];
    $num = 0.0;
    switch($id){
        case 1://木方（根）
            if($sitarea<16){$num = round(10*$sitarea/16);}
            else{$num = $sitarea;}
            break;
        case 2://细木工板
            if($sitarea<20){$num = 1;}
            else{$num = 1 + round(($sitarea-20)/5);}
            break;
        case 3://石膏板
            if($sitarea<20){$num = 1;}
            else{$num = 1 + round(($sitarea-20)/5);}
            $num = 2*$num;
            if($num >= 2 && $num < 4) $num++;
            break;
        case 4://铁钉
            if($sitarea<20){$num = 1;}
            else{$num = 1 + round(($sitarea-20)/5);}
            $num = 2*$num;
            break;
        case 5://枪钉
            if($sitarea<20){$num = 1;}
            else{$num = 1 + round(($sitarea-20)/5);}
            $num = 2*$num;
            break;
        case 6://干壁钉
            if($sitarea<20){$num = 1;}
            else{$num = 1 + round(($sitarea-20)/5);}
            $num += 1;
            break;
    }
    return $num;
}
