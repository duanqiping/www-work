<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/11/10
 * Time: 17:36
 */
$key = "example_key";
$token = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = AesModel::encode($token, $key);
$decoded = AesModel::decode($jwt, $key, array('HS256'));

print_r($decoded);