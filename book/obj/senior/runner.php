<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/5/9
 * Time: 22:13
 */
require_once 'exception.php';

class Runner{
    static function init()
    {
        try{
//            var_dump(dirname(__FILE__)."\conf01.xml");
//            exit();
            $conf = new Conf(dirname(__FILE__)."/conf01.xml");
            print "user: ".$conf->get('user')."\n";
            print "host: ".$conf->get('host')."\n";
            $conf->set("pass", "newpass");
            $conf->write();
        }catch (FlieException $e){
            //文件权限或者文件不存在
//            throw new Exception("file  does not exist1");
            echo 11;
        }catch(ConfExcettion $e) {
            //错误的XML文件格式
//            throw new Exception("file  does not exist2");
            echo 22;
        }catch(Exception $e){
            //后备捕捉器，正常情况应该不会被调用
//            throw new Exception("file  does not exist3");
            echo 33;
        }
    }
}
Runner::init();

