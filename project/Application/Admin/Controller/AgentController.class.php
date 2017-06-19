<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/15
 * Time: 17:42
 */

namespace Admin\Controller;


use Think\Controller;

class AgentController extends Controller
{

    public function index()
    {
        $this->display();
    }
    /*添加设备商
     * name 设备商名称
     * account 设备商账号
     * grade 级别
     * parent_id 归属
     * address 地址
     * mobile 联系方式
     * */
    public function add($name = '', $account = '', $grade = '', $parent_id = '',$address='',$mobile='')
    {
        if (IS_POST) {

//            $code = random(4);
//            var_dump($name);
//            exit();

            /* 调用注册接口注册用户 */
            $uid = D ( 'Common/User' )->register ( $name, $account, $grade,$parent_id,$address,$mobile );




            echo "nimei";

            var_dump($uid);
            exit();

            if (0 < $uid) { // 注册成功
                $this->success ( '用户添加成功！', U ( 'index' ) );
            } else { // 注册失败，显示错误信息
                $this->error ( '用户添加失败！' );
            }
        } else {
            $this->meta_title = '新增用户';
            $this->display ();
        }
    }
}