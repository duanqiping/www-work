<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/9
 * Time: 21:57
 */
class XmlException extends Exception
{
    private $error;

    function __construct(LibXMLError $error)
    {
        $shortfile = basename($error->file);
        $msg = "[{$shortfile}, line {$error->line}, col {$error->column}] {$error->message}";
        $this->error=$error;
        parent::__construct($msg,$error->code);
    }
    function getLibXmlError()
    {
        return $this->error;
    }
}

class FlieException extends Exception{}
class ConfExcettion extends Exception{}
