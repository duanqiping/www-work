<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2015/11/2
 * Time: 11:40
 */
include_once "RestRequest.class.php";
 
class RestUtils
{
    //处理接收的数据
    public static function processRequest()
    {
        // get our verb 获取动作
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);  //转成小写
        $return_obj		= new RestRequest();
        // we'll store our data here 在这里存储请求数据
        $data			= array();

        switch ($request_method){
            // gets are easy...
            case 'get':
                $data = $_GET;
                break;
            // so are posts
            case 'post':
                $data = $_POST;
                break;
            // here's the tricky bit...
            case 'put':
                //先不管
                parse_str(file_get_contents('php://input'), $put_vars);
                $data = $put_vars;
                break;
        }

        // 保存请求的方法
        $return_obj->setMethod($request_method);


        //保存请求的参数
        $return_obj->setRequestVars($data);

        if(isset($data)){

            // translate the JSON to an Object for use however you want
            $return_obj->setData($data);
        }
        return $return_obj;
    }


    //给客户端的响应
    public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {

        $status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);
        // set the status
        header($status_header);
        // set the content type
        header('Content-type: ' . $content_type);

        //body不为空
        if($body != ''){
            // send the body
            if(is_string($body))
            {
                $response = array("success"=>"true","data"=>array('msg'=>$body));
                $response = ch_json_encode($response);
                exit($response);
            }else{
                $response = array("success"=>"true","data"=>$body);
                $response = ch_json_encode($response);
                exit($response);
            }

        }
        // we need to create the body if none is passed
        else
        {
            // create some body messages
            $message = '';

            switch($status)	{
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            $response = array("success"=>"false","error"=>array("msg"=>$message,'code'=>$status));
            $response = ch_json_encode($response);
            exit($response);
        }
    }


    //返回状态码对应的信息
    public static function getStatusCodeMessage($status)
    {
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}

