<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/24
 * Time: 10:02
 */

namespace Admin\Controller;

use Admin\Model\AdminModel;
use Admin\Model\CustomerModel;
use Admin\Model\DeviceMsModel;

class AdminController extends BaseController {

    public function index()
    {
        $customer = new CustomerModel();
        $sql = "SELECT customer_id,name FROM customer WHERE customer_id ".
            "NOT IN (select customer_id FROM device_ms GROUP BY customer_id)";
        $res = $customer->query($sql);

        $this->assign('_list',$res);//没有添加设备的客户
        $this->display();
    }

    public function addDevice()
    {
        $data = $_POST;
        print_r($data);
        exit();


//        $this->display();
    }

    //往后台中添加设备
    public function addDeviceMs()
    {

    }

    //设备注册
    public function register()
    {
        $account = trim($_GET['account']);//设备编码
        $passwd = 123456;//设备设定默认密码

        $devicems = new DeviceMsModel();
        $res = $devicems->EaseRegister($account,$passwd);
        if(!$res){
            sendError($devicems->getError());
        }else{
            sendSuccess($res);
        }
    }

    //添加 管理员、代理商、客户
    public function add()
    {
        $flag = $_POST['flag'];

        //权限判断
        if(!$this->isAdminLogin()){
            exit('该操作只能由管理员进行');
        }

        $consumer = $this->getInstance($flag);
        if($consumer instanceof AdminModel){
            if(!$consumer->powerControl()){
                exit($consumer->getError());
            }
        }
        unset($_POST['flag']);

        $data = $consumer->makeData($_POST);

        $admin = new AdminModel();
        $uid = $admin->addConsumer($consumer,$data);

        if (0 < $uid) { // 注册成功
            exit('用户添加成功');
            return true;
        } else { // 注册失败，显示错误信息
            exit($consumer->getError());
        }
    }

    //删除 管理员、代理商、客户
    public function delete($id,$flag)
    {
        //权限判断
        if(!$this->isAdminLogin()){
            exit('该操作只能由管理员进行');
        }

        $consumer = $this->getInstance($flag);
        if($consumer instanceof AdminModel){
            if(!$consumer->powerControl()){
                exit($consumer->getError());
            }
        }

        if($consumer->where(array('admin_id'=>$id))->save(array('is_show'=>0))) {
            exit('删除成功');
        }else{
            exit('删除失败');
        }
    }

    //获取用户列表
    public function getList($flag)
    {
        //权限判断
        if(!$this->isAdminLogin()){
            exit('该操作只能由管理员进行');
        }

        $consumer = $this->getInstance($flag);
        $info = $consumer->getList();

        print_r($info);
        exit();
    }


}
