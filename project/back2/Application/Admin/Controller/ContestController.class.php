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
        }
    }

    //赛事人员名单
    public function info()
    {
        $contestorder = new ContestOrder();

        if($_GET['contest_sn']){
            $_SESSION['contest_sn'] = $_GET['contest_sn'];
        }
        if($_POST){
            $ids = $_POST;
            $ids = $ids['id'];

            $contestorder->addUser($ids);
        }

        $condition['contest_sn'] = $_SESSION['contest_sn'];
        $res = $contestorder->_list($condition);

        $this->assign('_list',$res);
        $this->display('info');
    }

    //添加赛事人员
    public function user()
    {
        $user = new UserModel();

        $condition['customer_id'] = $_SESSION['user']['id'];
        $condition = $user->makeCondition($_POST);//筛选条件

        $page = 1;
        $pageSize=10;

        $res = $user->_list($condition,$page,$pageSize);

        unset($condition['customer_id']);
        $condition_string = '';
        foreach ($condition as $k=>$v){
            if($k == 'sex'){
                $v = ($v==1)?'男':'女';
            }
            $condition_string = $condition_string.' '.$v;
        }

        $this->assign('_list', $res);
        $this->assign('condition_string', $condition_string);

        $this->display();
    }

    public function changeStatus()
    {
        var_dump($_POST);
        exit();
    }
}