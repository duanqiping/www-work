<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/7/23
 * Time: 22:27
 */

namespace Admin\Controller;


use Admin\Model\ContestModel;
use Admin\Model\ContestOrder;
use Admin\Model\UserModel;
use Think\Controller;

class ContestController extends Controller
{
    //创建考试\赛事
    public function index()
    {
//        print_r($_GET);
//        exit();

        $contest = new ContestModel();
        $type = $_GET['type'];
        $res = $contest->_list($type);

//        print_r($res);
//        exit();

        $this->assign('_list', $res);
        $this->display();
    }

    //添加一场赛事
    public function add()
    {
        if ($_POST) {
            $contest = new ContestModel();
            $data = $contest->fillData($_POST);//填充数据

            if ($contest->create($data)) {
                $contest->add($data);

                $this->redirect('index');
            } else {
                $this->display();
            }
        } else {
            $this->display();
//            echo "add";
//            exit();
        }
    }

    //赛事人员名单
    public function info()
    {
//        print_r( $_POST );
//        var_dump($_SESSION);
//        exit();
//        $this->assign('contest',array('contest_id'=>$_GET['contest_id']));

        if($_GET['contest_sn']){
            $_SESSION['contest_sn'] = $_GET['contest_sn'];
        }

        $contestorder = new ContestOrder();
        

        $this->assign('contest_sn', $_GET['contest_sn']);
        $this->display('info');
    }

    //添加赛事人员
    public function user()
    {
        $user = new UserModel();

        $condition['customer_id'] = $_SESSION['user']['id'];

        $res = $user->_list($user->makeCondition($_POST));

        $this->assign('_list', $res);
        if($_GET['contest_id']){
            $this->assign('contest_sn', $_GET['contest_sn']);
        }
        $this->display();
//        print_r( $_GET );
//        exit();

    }

    public function changeStatus()
    {
        var_dump($_POST);
        exit();
    }
}