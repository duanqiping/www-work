<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/10/9
 * Time: 15:31
 */

//生成随机字符串
function random($length = 6 , $numeric = 0) {
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
    if($numeric) {
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
    } else {
        $hash = '';
        $chars = '0123456789';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
    }
    return $hash;
}

//发送短信
function sendmessage($mobile,$message){
    $Uid = 'hebaizhong';
    $Key = '8232e869f2b94230cb54';
    $mob = $mobile;
    $url = 'http://utf8.sms.webchinese.cn/?Uid='.$Uid.'&Key='.$Key.'&smsMob='.$mob.'&smsText='.$message;
    if(Get($url)){
        return true;
    }else{
        return false;
    }

}
//生成订单订单号
function get_cash_sn($user_id){
    $sn = date('ymdHis').str_pad($user_id,6,"0",STR_PAD_LEFT).substr(microtime(),2,4);
    return $sn;
}

function Get($url){
    if(function_exists('file_get_contents')){
        $file_contents = file_get_contents($url);
    }else{
        $ch = curl_init();
        $timeout = 5;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
    }
    return trim(str_replace('\r\n', '', $file_contents));

}

//验证手机号码是否规范
function is_mobile_legal($mobile)
{
    if(!$res=preg_match("/^1[34578][0-9]{9}$/i",$mobile,$res)) return false;//不规范
    return true;//规范
}


//过滤掉英文单双引号
function is_scalar_if($arr)
{
    foreach($arr as $k=>$v) {
        if(is_string($v)) {
            //过滤掉（ ' "） 符号
            $arr[$k] = preg_replace('/(\"|\')/i','',$v);
            //对特殊字符进行转义
            $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
            $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
            $arr[$k] = str_replace($escapers, $replacements, $arr[$k]);

        } else if(is_array($v)) {  // 再加判断,如果是数组,调用自身,再转
            $arr[$k] = is_scalar_if($v);
        }
    }
    return $arr;
}

//中文json
function ch_json_encode($data) {

    $data = is_scalar_if($data);//过滤引号

    $ret = ch_urlencode ( $data );

    //这个函数好像没有对有些特殊字符转义成功
    $ret = json_encode ( $ret );
    return urldecode ( $ret );



}
function ch_urlencode($data) {
    if (is_array ( $data ) || is_object ( $data )) {
        foreach ( $data as $k => $v ) {
            if (is_scalar ( $v )) {                  // is_scalar检测变量是否是一个标量
                if (is_array ( $data )) {
                    $data [$k] = $v;
                } else if (is_object ( $data )) {
                    $data->$k = $v;
                }
            } else if (is_array ( $data )) {
                $data [$k] = ch_urlencode ( $v ); // 递归调用该函数
            } else if (is_object ( $data )) {
                $data->$k = ch_urlencode ( $v );
            }
        }
    }

    return $data;
}
//检查前端post的数据是否合法
function checkPostData($b,$msg,$code)
{
    if($b) return true;
    else sendError($msg,$code);
}


function sendSuccess($data) {
    $response = ch_json_encode($data);
    exit($response);
}

//code 0:正常消息，1：debug信息

function sendError($msg,$code = 0) {
    header('HTTP/1.1 400 Unauthorized', true, 400);//一般错误
    exit(ch_json_encode(array('msg'=>$msg,'code'=>intval($code))));
}
function sendServerError($msg,$code) {
    header('HTTP/1.1 400 Unauthorized', true, 500);//服务器错误
    exit(ch_json_encode(array('msg'=>$msg,'code'=>intval($code))));
}

