<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/7/23
 * Time: 22:27
 */

namespace Admin\Controller;


use Admin\Model\ContestModel;
use Admin\Model\ContestOrderModel;
use Admin\Model\UserModel;
use Think\Controller;

class ContestController extends Controller
{
    //创建考试\赛事
    public function index()
    {
        $contest = new ContestModel();
        $contestOrder = new ContestOrderModel();

        //按钮操作 编辑 删除
        $result = $contest->clickOperate($_GET);
        if(!$result){
            exit($contest->getError());
        }else{
            //edit
            if($result !== true){
                $this->assign('contestInfo', $result);//赛事的详细信息
            }
        }

        $nowContest = $contest->contestSelectNow();//正在进行赛事 一维
        $conflictContest = $contest->contestSelectConflict($nowContest);//冲突中赛事 二维数组
        $soonContest = $contest->contestSelectSoon();//即将开始赛事 二维数组

        $res = $contest->getContestInfo();//获取赛事列表
        $list = $contestOrder->getContestNum($res);//获取赛事名单人数

        $this->assign('_list', $list);
        $this->assign('nowContest', $nowContest);
        $this->assign('conflictContest', $conflictContest);
        $this->assign('soonContest', $soonContest);

        $this->display();
    }

    //添加一场赛事
    public function add()
    {
        if ($_POST) {
            $contest = new ContestModel();
            if($_POST['contest_sn']){
                //对赛事信息进行修改
                $contest->editContest($_POST);

                $this->redirect('index');
            }
            else{
                //添加一场赛事
                $data = $contest->fillData($_POST);//填充数据

                if($contest->add($data))
                {
                    $_SESSION['contest_sn'] = $data['contest_sn'];//保存到session中
                    $this->redirect('user');
                }else{
                    exit('fail');
                }
            }

        } else {
            exit('fail3');
            $this->display();
        }
    }

    //赛事人员名单
    public function info()
    {
        $contestorder = new ContestOrderModel();

        $uid = $_SESSION['user']['id'];

        $condition = $_GET;//筛选条件

        if($_GET['contest_sn']){
            $_SESSION['contest_sn'] = $_GET['contest_sn'];
        }
        if($_POST){
            $ids = $_POST;
            $ids = $ids['id'];

            $b = $contestorder->addUser($ids);
            if(!$b) exit('fail');
        }

        $condition['contest_sn'] = $_SESSION['contest_sn'];

        $res = $contestorder->contestList(makeCondition($condition,$uid,$_SESSION['contest_sn']));

        $deptInfo = $contestorder->getDept($_SESSION['contest_sn']);//获取系别
        $gradeInfo = $contestorder->getGrade($_SESSION['contest_sn'],$condition['dept']);//获取年级
        $classInfo = $contestorder->getClass($_SESSION['contest_sn'],$condition['dept'],$condition['grade']);//获取班级

        $this->assign('_list',$res);
        $this->assign('condition', $condition);
        $this->assign('deptInfo', $deptInfo);
        $this->assign('gradeInfo', $gradeInfo);
        $this->assign('classInfo', $classInfo);

        $this->display('info');
    }

    //添加赛事人员
    public function user()
    {
        $uid = $_SESSION['user']['id'];

        $user = new UserModel();

        $condition = $_GET;//筛选条件

        $res = $user->_list(makeCondition($condition,$uid,$contest_sn=0));

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

    //删除赛事人员
    public function delete()
    {
        $condition = array();

        if($_GET['id']){
            $condition['contest_order_id'] = $_GET['id'];//单个删除
        }else if($_POST['id']){
            $condition['contest_order_id'] = array('in',$_POST['id']);//批量删除
        }else{
            exit('id获取失败');
        }

        $contestOrder = new ContestOrderModel();
        $result = $contestOrder->where($condition)->delete();

        if(!$result) exit('服务器错误');
        else $this->redirect('info');
    }

    //获取系别
    public function getDept(){
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
//        file_put_contents('log.txt',"111\n",FILE_APPEND );
        $list = $s->field('dept,user_id')->where($condition)->group('dept')->select();
        echo json_encode($list);
    }

    //获取年级
    public function getGrade(){

        $dept=$_GET['dept'];
        $s= new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
        $condition['dept'] = $dept;
//        file_put_contents('log.txt',$dept."111222\n",FILE_APPEND );
        $data=$s->field('user_id,grade')->where($condition)->group('grade')->select();
        echo json_encode($data);
    }

    //获取班级
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