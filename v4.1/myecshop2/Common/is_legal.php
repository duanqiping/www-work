<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/17
 * Time: 15:04
 */
//加密
function passport_encrypt($txt, $key) {
    srand((double)microtime() * 1000000);
    $encrypt_key = md5(rand(0, 32000));
    $ctr = 0;
    $tmp = '';
    for($i = 0;$i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
    }

    return base64_encode(passport_key($tmp, $key));
}

//解密
function passport_decrypt($txt, $key) {

    $txt = passport_key(base64_decode($txt), $key);

    $tmp = '';
    for($i = 0;$i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }

    return $tmp;
}
//在加密和解密函数内部会调用
function passport_key($txt, $encrypt_key) {
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}

function is_empty($arr)  //一维数组
{
    foreach($arr as $k=>$v)
    {
        if($v=='')
        {
            $response = array("success"=>"false","error"=>array("msg"=>$k.'不能为空','code'=>4122));
            $response = ch_json_encode($response);
            exit($response);
        }
    }
}