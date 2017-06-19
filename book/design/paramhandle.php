<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 22:20
 */
abstract class ParamHandle
{
    protected $source;
    protected $params = array();

    function __construct($source)
    {
        $this->source = $source;
    }

    function addParam($key,$val)
    {
        $this->params[$key] = $val;
    }
    function getAllParams()
    {
        return $this->params;
    }
    //
    static public function getInstance($filename)
    {
        if(preg_match("/\.xml$/i",$filename))
        {
            return new XmlParamHandle($filename);
        }
        return new TextParameHandle($filename);
    }
    abstract function write();
    abstract function read();

}