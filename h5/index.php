
<?php

$appId = "wx8859301f81950860";
$appSecret = "0f2154488ec369c2f3c0fd26b3d23367";
if(!isset($_GET['code'])) {
    printf("123312");
    exit();
}
$code = $_GET['code'];
$post_data = array ("appid" => $appId,"secret" => $appSecret,"code"=>$code,"grant_type"=>'authorization_code');
$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appId.'&secret='.$appSecret.'&code='.$code.'&grant_type=authorization_code';
// $url = "http://www.pcw365.com/ecshop2/MobileAPI/myecshop2/city/location";
        //初始化curl
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        // Set method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        // Set options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Set headers
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));

        // $body = http_build_query($post_data);

        // Set body
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);

        // echo $res;

        $data = json_decode($res,true);
        printf($res);
        // print_r($data);
        exit();

?>

<!DOCTYPE html>
<html>
<head>
    <title>test回调</title>
</head>
<body>

<div id=test></div>
<script type="text/javascript">
	var $_GET = (function() {
    'use strict';
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if (typeof(u[1]) == "string") {
        u = u[1].split("&");
        var get = {};
        for (var i in u) {
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();
var data = $_GET;
var str="";
for(key in data) {
	str += key;
	str += " : ";
	str += data[key];
	str += " --------- ";
}
document.getElementById("test").append(str);
// console.log($_GET);
</script>


</body>
</html>