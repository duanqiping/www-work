<?php
namespace Common\Model\Rest;
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2015/11/2
 * Time: 11:41
 */
class RestRequest
{
    private $request_vars;   //客户端传的参数
    private $data;
    private $http_accept;
    private $method;

    public function __construct()
    {
        $this->request_vars		= array();
        $this->data				= '';
        //$this->http_accept		= (strpos($_SERVER['HTTP_ACCEPT'], 'json')) ? 'json' : 'xml';
        $this->http_accept		= (strpos($_SERVER['HTTP_ACCEPT'], 'xml')) ? 'xml' : 'json'; //HTTP_ACCEPT头部如果没被提供  默认设置为json
        $this->method			= 'post';
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setRequestVars($request_vars)
    {
        $this->request_vars = $request_vars;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHttpAccept()
    {
        return $this->http_accept;
    }

    public function getRequestVars()
    {
        return $this->request_vars;
    }

}