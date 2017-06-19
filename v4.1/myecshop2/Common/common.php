<?php

function buHuoTime()
{
    date_default_timezone_set('PRC');
    $time = time();
    return $is_time = strtotime(date('Y-m-d 15:30:00', $time));//当天15:30:00
}


// 递归转义数组
function _addslashes($arr) {
    foreach($arr as $k=>$v) {
        if(is_string($v)) {
            $arr[$k] = addslashes(trim($v));
        } else if(is_array($v)) {  // 再加判断,如果是数组,调用自身,再转
            $arr[$k] = _addslashes($v);
        }
    }
    
    return $arr;
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
                      $data [$k] = urlencode ( $v );
                     } else if (is_object ( $data )) {
                         $data->$k = urlencode ( $v );
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
//获取IP
function GetIP(){ 
if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
$ip = getenv("HTTP_CLIENT_IP"); 
else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
$ip = getenv("HTTP_X_FORWARDED_FOR"); 
else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
$ip = getenv("REMOTE_ADDR"); 
else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
$ip = $_SERVER['REMOTE_ADDR']; 
else 
$ip = "unknown"; 
return($ip); 
} 
//5分钟后的时间
function timeadd(){
  return time()+300;
}
//上传域名为name[]的数组转化
function multiple($_files, $top = TRUE)
{
    $files = array();
    foreach($_files as $name=>$file){
        if($top) {
            $sub_name = $file['name'];
        }else{
            $sub_name = $name;
        }
         
        if(is_array($sub_name)){
            foreach(array_keys($sub_name) as $key){
                $files[$name][$key] = array(
                        'name'     => $file['name'][$key],
                        'type'     => $file['type'][$key],
                        'tmp_name' => $file['tmp_name'][$key],
                        'error'    => $file['error'][$key],
                        'size'     => $file['size'][$key]
                );
                $files[$name] = multiple($files[$name], FALSE);
            }
        }else{
            $files[$name] = $file;
        }
    }
    return $files;
}
//流水号
function getRandomNumber(){
       
    $current_date = date('ymdHis');
    return  $current_date.str_pad($_SESSION['temp_buyers_id'],6,"0",STR_PAD_LEFT).substr(microtime(),2,4);
  
  }
//生成订单订单号
function get_cash_sn($user_id){
    $sn = date('ymdHis').str_pad($user_id,6,"0",STR_PAD_LEFT).substr(microtime(),2,4);
    return $sn;
}

//图片路径处理 分找材猫 品材宝
function ImgDeal($img,$database_type)
{

    if($database_type == 1) return preg_replace('/ /i','%20', NROOT.'/customer/'. $img);//找材猫
    else return  preg_replace('/ /i','%20', PROOT.$img);//品材宝
}

