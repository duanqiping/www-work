<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/9
 * Time: 17:08
 */
class conf
{
    private $file;
    private $xml;
    private $lastmatch;

    function __construct($file)
    {
        $this->file = $file;
        if(!file_exists($file))
        {
            throw new Exception("file '$file' does not exist");
        }
        $this->xml = simplexml_load_file($file,null,LIBXML_NOERROR);
        if(! is_object($this->xml))
        {
            throw new XmlException(libxml_get_last_error());
        }
        print gettype($this->xml);
        $matches = $this->xml->xpath("/conf");
        if(!count($matches))
        {
            throw new ConfException("could not find root element: conf");
        }
    }
    function write()
    {
        if(!is_writeable($this->file))
        {
            throw new Exception("file '{$this->file}' is not writeable ");
        }
        file_put_contents($this->file,$this->xml->asXML());
    }
    function get($str)
    {
        $matchs = $this->xml->xpath("/conf/item[@name=\"$str\"]");

        if(count($matchs))
        {
            $this->lastmatch = $matchs[0];
            return (string)$matchs[0];
        }
        return null;
    }

    function set($key,$value)
    {
        if(!is_null($this->get($key)))
        {
            $this->lastmatch[0]=$value;
            return;
        }
        $conf = $this->xml->conf;
        $this->xml->addChild('item',$value)->addAttribute('name',$key);
    }
}

class FlieException extends Exception{}
class ConfExcettion extends Exception{}


//$conf  = new conf("localhost/book/obj/senior/user.xml");//false
////$conf  = new conf("C:/wamp/www/book/obj/senior/user.xml");//相对路径
//$res = $conf->write();
