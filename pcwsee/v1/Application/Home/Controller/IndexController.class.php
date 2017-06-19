<?php
namespace Home\Controller;

use Home\Model\PcyGoodsModel;
use LeanCloud\Client;
use LeanCloud\CloudException;
use LeanCloud\FileCloud;
use LeanCloud\Object;
use LeanCloud\User;
use Think\Controller;
use Think\Exception;
use Think\Storage\Driver\File;



class IndexController extends Controller
{
    public function index(){

        vendor('Leancloud.src.autoload');


        // 参数依次为 AppId, AppKey, MasterKey
//        Client::initialize("LKobAEumiJV2asAtokNNB197-gzGzoHsz", "q0KUI9KixqVTfaY60YdWNR64", "lrm60zGsfSDPf8qkrOdDv7i9");
        Client::initialize(C('app_id'), C('app_key'), C('app_master'));

        $file = FileCloud::createWithUrl("test.gif",'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png');

        var_dump($file);

//        $testObject = new Object("TestObject");
//        $testObject->set("words", "Hello World! nihaoya qiping");
//        try {
//            $testObject->save();
//            echo "Save object success!";
//        } catch (Exception $ex) {
//            echo "Save object fail!";
//        }
//
//        print_r($testObject);


//        $user = new User();
//        $user->setUsername("alice11111111");
//        $user->setEmail("alice@example.net");
//        $user->setPassword("passpass");
//        try {
//            $user->signUp();
//        } catch (CloudException $ex) {
//            // 如果 LeanCloud 返回错误，这里会抛出异常 CloudException
//            // 如用户名已经被注册：202 Username has been taken
//        }

        // 注册成功后，用户被自动登录。可以通过以下方法拿到当前登录用户和
        // 授权码。
//        var_dump(User::getCurrentUser());
//        var_dump(User::getCurrentSessionToken());

//        var_dump($user->getEmail());


    }

    public function test3()
    {
        //qiping
//        $headers = array(
//            "X-LC-Id: KWKBqvdY06v992wBUJtV4A0N-gzGzoHsz",
//            "X-LC-Key: 07Kyu2gkASViasInfONaD7FO",
//            "Content-Type: application/json",
//        );
        //品材宝
        $headers = array(
            "X-LC-Id: LKobAEumiJV2asAtokNNB197-gzGzoHsz",
            "X-LC-Key: q0KUI9KixqVTfaY60YdWNR64",
            "Content-Type: application/json",
        );

        $post_data['data'] = array('alert'=>'LeanCloud 问候 666');//向所有人推送
//        $post_data['where']=array('deviceType'=>'android','person'=>'67');//推送person为67的用户
        $post_data['where']=array('person'=>'67');//推送person为67的用户
        $post_data['prod'] = 'dev';//ios  dev开发证书  prod生产证书

//        $post_data['where']=array('deviceType'=>'android');//推送android 所有用户

        $data_string = json_encode($post_data);


        $ch = curl_init ();
//        $url = 'https://leancloud.cn/1.1/installations';
        $url = 'https://leancloud.cn/1.1/push';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT,5);   //超时设置(秒) 只需要设置一个秒的数量就可以
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = json_decode(curl_exec($ch));//转成对象
        print_r($output);
    }
}