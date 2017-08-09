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
use Admin\Model\Easemob;
use Admin\Model\UserModel;
use Think\Controller;

class ContestController extends BaseController
{
    //创建考试\赛事
    public function index()
    {
        $uid = $_SESSION['user']['id'];

        $contest = new ContestModel();
        $contestOrder = new ContestOrderModel();

        //按钮操作 编辑 删除
        $result = $contest->clickOperate($_GET);
        if(!$result){
            exit($contest->getError());
        }else{
            //edit
            if(is_array($result)){
//                my_print($result);
                $this->assign('contestInfo', $result);//赛事的详细信息
            }else if($result == 2){
                //delete
                unset($_GET);
                $this->redirect('index');
            }
            else{
            }
        }

        $nowContest = $contest->contestSelectNow();//正在进行赛事 一维
        $conflictContest = $contest->contestSelectConflict($nowContest);//冲突中赛事 二维数组
        $soonContest = $contest->contestSelectSoon();//即将开始赛事 二维数组

        $res = $contest->getContestInfo($uid);//获取赛事列表

//        my_print($res);

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
        if($_POST)
        {
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

        }
        else
        {
            exit('fail3');
        }
    }

    //赛事人员名单
    public function info()
    {
        $contest = new ContestModel();
        $contestorder = new ContestOrderModel();

        $uid = $_SESSION['user']['id'];
        $condition = $_GET;//筛选条件

        if($_GET['contest_sn']){
            $_SESSION['contest_sn'] = $_GET['contest_sn'];
        }
        $contest_sn = $_SESSION['contest_sn'];

        if($_POST){
            $ids = $_POST;
            $ids = $ids['id'];

            $res_length = $contest->where(array('contest_sn'=>$contest_sn))->field('length_male,length_female')->find();
            $b = $contestorder->addUser($ids,$contest_sn,$res_length);
            if(!$b) exit('fail');
        }

        $condition['contest_sn'] = $contest_sn;

        $res_contest = $contest->where(array('contest_sn'=>$contest_sn))->field('is_use,end_time')->find();
        $res_contest = ContestState($res_contest);

        $res = $contestorder->contestList(makeCondition($condition,$uid,$contest_sn),$current=$_GET['current']);//赛事名单列表

        $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

        $this->assign('_list',$res);
        $this->assign('condition', $condition);//筛选的条件

        $this->assign('deptInfo', $studentInfo['dept']);
        $this->assign('gradeInfo', $studentInfo['grade']);
        $this->assign('classInfo', $studentInfo['class']);

        $this->assign('title',$contestorder->title);//标题
        $this->assign('contestInfo',$res_contest);//赛事信息 未开始(可以添加和删除用户) 和 其他情况
        $this->assign('totalNum',$contestorder->totalNum);//总页数
        $this->assign('pageSize',$contestorder->pageSize);//每页数
        $this->assign('current',$contestorder->current);//第几页

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

    //签到
    public function sign()
    {
        $contestorder = new ContestOrderModel();

        $uid = $_SESSION['user']['id'];

        $condition = $_GET;//筛选条件

        if($_GET['contest_sn']){
            $_SESSION['contest_sn'] = $_GET['contest_sn'];
        }
        $contest_sn = $_SESSION['contest_sn'];

        if($_POST){
        }

        $condition['contest_sn'] = $contest_sn;

        $res = $contestorder->contestList(makeCondition($condition,$uid,$contest_sn),$current=$_GET['current']);

        $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

        $this->assign('_list',$res);
        $this->assign('condition', $condition);

        $this->assign('deptInfo', $studentInfo['dept']);
        $this->assign('gradeInfo', $studentInfo['grade']);
        $this->assign('classInfo', $studentInfo['class']);

        $this->assign('title', $contestorder->title);

        $this->assign('totalNum',$contestorder->totalNum);//总页数
        $this->assign('pageSize',$contestorder->pageSize);//每页数
        $this->assign('current',$contestorder->current);//第几页

        $this->display();
    }

    //开始考试
    public function beginContest()
    {
        $e = new Easemob();

        $target_type = 'users';
        $target = array('0000111','0000112','0000113');

        $content = array(
            'customer_id' => '31',
            'contest_sn' => $_SESSION['contest_sn']
        );

        $content = str_replace("\\/", "/", json_encode($content));

        $content = array(
            'data' =>$content,
            'type'=>5
        );

        $content = json_encode($content);//注意 $content 得是一个字符窜

        $result = $e->sendText($from="admin",$target_type,$target,$content);//($from="admin",$target_type,$target,$content,$ext)

        if($result){
            $this->redirect('score');
        }else{
            exit('fail');
        }
    }

    //成绩单
    public function score()
    {
        $contestorder = new ContestOrderModel();

        $uid = $_SESSION['user']['id'];

        $condition = $_GET;//筛选条件

        if($_GET['contest_sn']){
            $_SESSION['contest_sn'] = $_GET['contest_sn'];
        }
        $contest_sn = $_SESSION['contest_sn'];

        $condition['contest_sn'] = $contest_sn;

        $res = $contestorder->contestList(makeCondition($condition,$uid,$contest_sn),$current=$_GET['current']);

        $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

        $this->assign('_list',$res);
        $this->assign('condition', $condition);

        $this->assign('deptInfo', $studentInfo['dept']);
        $this->assign('gradeInfo', $studentInfo['grade']);
        $this->assign('classInfo', $studentInfo['class']);

        $this->assign('title',$contestorder->title);
        $this->assign('outAchieve',$contestorder->outAchieve);

        $this->assign('totalNum',$contestorder->totalNum);//总页数
        $this->assign('pageSize',$contestorder->pageSize);//每页数
        $this->assign('current',$contestorder->current);//第几页

        $this->display();
    }

    //结束考试
    public function endContest()
    {
        $e = new Easemob();

        $target_type = 'users';
        $target = array('0000111','0000112','0000113');

        $content = array(
            'customer_id' => '31',
            'contest_sn' => $_SESSION['contest_sn']
        );

        $content = str_replace("\\/", "/", json_encode($content));

        $content = array(
            'data' =>$content,
            'type'=>3
        );

        $content = json_encode($content);//注意 $content 得是一个字符窜

        $result = $e->sendText($from="admin",$target_type,$target,$content);//($from="admin",$target_type,$target,$content,$ext)

        if($result){
            $this->redirect('score');
        }else{
            exit('fail');
        }
    }

    //创建补考
    public function makeUp()
    {
        $contestorder = new ContestOrderModel();

        $uid = $_SESSION['user']['id'];

        $condition = $_GET;//筛选条件
        if($_GET['contest_sn']){
            $_SESSION['contest_sn'] = $_GET['contest_sn'];
        }
        $contest_sn = $_SESSION['contest_sn'];

        $condition['contest_sn'] = $contest_sn;
        $condition['confirm'] = 0;

        $res = $contestorder->contestList(makeCondition($condition,$uid,$contest_sn),$current=$_GET['current']);

        $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

        $this->assign('_list',$res);
        $this->assign('condition', $condition);

        $this->assign('deptInfo', $studentInfo['dept']);
        $this->assign('gradeInfo', $studentInfo['grade']);
        $this->assign('classInfo', $studentInfo['class']);
        
        $this->assign('title',$contestorder->title);
        $this->assign('outAchieve',$contestorder->outAchieve);

        $this->assign('totalNum',$contestorder->totalNum);//总页数
        $this->assign('pageSize',$contestorder->pageSize);//每页数
        $this->assign('current',$contestorder->current);//第几页

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