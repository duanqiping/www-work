<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2015/11/24
 * Time: 18:13
 */
return array(

    'alipay_config'=>array(
        //合作身份者id，以2088开头的16位纯数字
        'partner' =>'2088911549097841',   //合作身份者id，以2088开头的16位纯数字

        //商户的私钥（后缀是.pen）文件相对路径
        'private_key_path'=>'./ThinkPHP/Extend/Vendor/AliPay/key/rsa_private_key.pem',
//        'private_key_path'=>'http://121.40.239.22/pcwstore/myecshop2/ThinkPHP/Extend/Vendor/AliPay/key/rsa_private_key.pem',

        //支付宝公钥（后缀是.pen）文件相对路径
        'ali_public_key_path'=>'./ThinkPHP/Extend/Vendor/AliPay/key/alipay_public_key.pem',

        //用于校验的支付宝公钥
        'ali_public_key_path2'=>'./ThinkPHP/Extend/Vendor/AliPay/key/alipay_public_key2.pem',

        //签名方式 不需修改
        'sign_type'=>strtoupper('RSA'),

        //字符编码格式 目前支持 gbk 或 utf-8
        'input_charset'=> strtolower('utf-8'),

        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        'cacert'=> './ThinkPHP/Extend/Vendor/AliPay/cacert.pem',
//        'cacert'=>'http://121.40.239.22/pcwstore/myecshop2/ThinkPHP/Extend/Vendor/AliPay/cacert.pem',


        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        'transport'=> 'http',

    ),
);