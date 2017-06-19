<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/8
 * Time: 17:04
 */
//检查前端post的数据是否合法
function checkPostData($b,$msg,$code)
{
    if($b)
    {
        $response = array('success' => 'false', "error"=>array("msg"=>$msg,'code'=>$code));
        $response = ch_json_encode($response);
        exit($response);
    }
    else
    {
        return true;
    }
}
function printSuccess2($data)
{
    $response = ch_json_encode($data);
    exit($response);
}



/** $data 可以为数组或字符串*/
function printSuccess($data)
{
    $response = array('success' => 'true', 'data' => $data);
    $response = ch_json_encode($response);
    exit($response);
}

/** 打印错误信息*/
function printError($msg,$code,$other=null)
{
    if($code>=5000 && (APP_DEBUG===false) ) $msg = '服务器错误';

    if($other) $response = array('success' => 'false', "error"=>array("msg"=>$msg,'code'=>$code),'data'=>$other);
    else $response = array('success' => 'false', "error"=>array("msg"=>$msg,'code'=>$code));
    $response = ch_json_encode($response);
    exit($response);
}

//品才宝 用户头像处理
function b2bImgDeal($img)
{
    if(!$img)
    {
        return '';
    }
    else
    {
        $img = 'http://'.$_SERVER['HTTP_HOST'].'/pcshop/pcServ'.$img;
        $img = str_replace('./','/',$img);
        $img = preg_replace('/ /i','%20', $img);
        return $img;
    }
}

//无用  可以去除
function arr_reform($res, $rate=1)//该函数仅对 goods 表有用
{
    for($i=0; $i<count($res); $i++)
    {
        $res[$i]['color']=array();//在res1添加一个 color数组字段
        $res[$i]['brand']=array();//在res1添加一个 brand数组字段
        $res[$i]['version']=array();//在res1添加一个version数组字段

        $res[$i]['color']['color_name'] = $res[$i]['goods_color'];//color数组中添加color元素
        $res[$i]['color']['color_id'] = $res[$i]['color_id'];
        unset($res[$i]['color_id']);//删除$res数组中color_id元素

        $res[$i]['brand']['brand_name'] = $res[$i]['brand_name'];
        $res[$i]['brand']['brand_id'] = $res[$i]['brand_id'];
        unset($res[$i]['brand_id']);
        unset($res[$i]['brand_name']);

        $res[$i]['version']['version_name'] = $res[$i]['goods_version'];
        $res[$i]['version']['version_id'] = $res[$i]['version_id'];
        unset($res[$i]['version_id']);
        unset($res[$i]['goods_version']);

        $res[$i]['shop_price'] = $res[$i]['shop_price']*$rate;

        if(!$res[$i]['goods_img'])//如果图片为空
        {
            $res[$i]['goods_img']="";
        }else
        {
            $res[$i]['goods_img']=NROOT.'/customer/'.$res[$i]['goods_img'];//完善图片路径
        }
        $res[$i]['type'] = 1;//默认辅材
        if($_POST['type'] == 2)
        {
            $res[$i]['type'] =2;
        }

    }
    return $res;
}

//无用  可以去除
//在线交易订单支付处理函数
//函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
//返回值：如果订单已经成功支付，返回true，否则返回false；
function checkorderstatus($ordid){
    $Ord=M('Orderlist');
    $ordstatus=$Ord->where('ordid='.$ordid)->getField('ordstatus');
    if($ordstatus==1){
        return true;
    }else{
        return false;
    }
}

//无用  可以去除
//处理订单函数
//更新订单状态，写入订单支付后返回的数据
function orderhandle($parameter){
    $ordid=$parameter['out_trade_no'];
    $data['payment_trade_no']      =$parameter['trade_no'];
    $data['payment_trade_status']  =$parameter['trade_status'];
    $data['payment_notify_id']     =$parameter['notify_id'];
    $data['payment_notify_time']   =$parameter['notify_time'];
    $data['payment_buyer_email']   =$parameter['buyer_email'];
    $data['ordstatus']             =1;
    $Ord=M('Orderlist');
    $Ord->where('ordid='.$ordid)->save($data);
}



