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
        $contest = new ContestModel();
        $type = $_GET['type'];
        $res = $contest->_list($type);

        $this->assign('_list', $res);
        $this->display();
    }

    //添加一场赛事
    public function add()
    {
//        print_r($_POST);
//        exit();

        if ($_POST) {
            $contest = new ContestModel();
            $data = $contest->fillData($_POST);//填充数据

            if ($contest->create($data)) {
                $uid = $contest->add($data);
                if($uid){
                    $this->redirect('user');
                    exit('success');
                }else{
                    exit('fail');
                }

                $this->redirect('index');
            } else {
                exit('fail2');
                $this->display();
            }
        } else {
            exit('fail3');
            $this->display();
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
//        print_r( $_GET );
//        exit();
        $uid = $_SESSION['user']['id'];

        $user = new UserModel();

        $condition = $_GET;//筛选条件
        $res = $user->_list($user->makeCondition($condition,$uid));

        $deptInfo = $user->getDept($uid);//获取系别
        $gradeInfo = $user->getGrade($uid,$condition['dept']);//获取年级
        $classInfo = $user->getClass($uid,$condition['dept'],$condition['grade']);//获取班级

        $this->assign('_list', $res);
        $this->assign('condition', $condition);
        $this->assign('deptInfo', $deptInfo);
        $this->assign('gradeInfo', $gradeInfo);
        $this->assign('classInfo', $classInfo);

        $this->display();
    }

    //获取系别
    public function getDept(){
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
//        file_put_contents('log.txt',"111\n",FILE_APPEND );
        $list = $s->field('dept,user_id')->where($condition)->group('dept')->select();
        echo json_encode($list);
    }

    public function getGrade(){

        $dept=$_GET['dept'];
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
        $condition['dept'] = $dept;
//        file_put_contents('log.txt',$dept."111222\n",FILE_APPEND );
        $data=$s->field('user_id,grade')->where($condition)->group('grade')->select();
        echo json_encode($data);
    }
    public function getClass(){

        $grade=$_GET['grade'];
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
        $condition['grade'] = $grade;
//        file_put_contents('log.txt',$grade."111333333\n",FILE_APPEND );
        $data=$s->field('user_id,class')->where($condition)->group('class')->select();

        echo json_encode($data);

    }
}