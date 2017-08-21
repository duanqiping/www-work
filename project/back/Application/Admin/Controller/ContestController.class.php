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

class ContestController extends BaseController
{
    //创建考试\赛事
    public function index()
    {
        $contestInfo = I('get.');//赛事编辑的信息（clickOperate）
        if($contestInfo){
            $contestInfo['reservation-time'] = date('d/m/Y H:i',$contestInfo['begin_time']).' - '.date('d/m/Y H:i',$contestInfo['end_time']);
            unset($contestInfo['begin_time']);
            unset($contestInfo['end_time']);
        }
        
        $uid = $_SESSION['user']['id'];

        $contest = new ContestModel();
        $contestOrder = new ContestOrderModel();

        $nowContest = $contest->contestSelectNow();//正在进行赛事 一维
        $conflictContest = $contest->contestSelectConflict($nowContest);//冲突中赛事 二维数组
        $soonContest = $contest->contestSelectSoon();//即将开始赛事 二维数组

        $res = $contest->getContestInfo($uid);//获取赛事列表

        $list = $contestOrder->getContestNum($res);//获取赛事名单人数

        $this->assign('_list', $list);
        $this->assign('nowContest', $nowContest);
        $this->assign('conflictContest', $conflictContest);
        $this->assign('soonContest', $soonContest);

        $this->assign('contestInfo', $contestInfo);

        $this->display();
    }

    //赛事按钮操作
    public function clickOperate()
    {
        //按钮操作 编辑 删除
        $contest = new ContestModel();
        $result = $contest->clickOperate($get = I('get.'));
//        var_dump($result);
//        my_print($result);
        if(!$result){
            exit($contest->getError());
        }else{
            if(is_array($result)){//edit
                $this->redirect('index',$result);
            }else if($result == 2){
                unset($get); //delete
                $this->redirect('index');
            }
        }
    }

    //添加或编辑一场赛事
    public function add()
    {
        $data = I('post.');
        if($data)
        {
            $contest = new ContestModel();
            if($data['contest_id']){
                //对赛事信息进行修改
                $contest->editContest($data);

                $this->redirect('index');
            }
            else{
                //添加一场赛事
                $data = $contest->fillData($data);//填充数据

                if($uid = $contest->add($data))
                {
                    $_SESSION['contest_sn'] = $data['contest_sn'];//保存到session中
                    $this->redirect('user',array('contest_sn'=>$data['contest_sn']));
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
        $contestorder = new ContestOrderModel();

        $uid = $_SESSION['user']['id'];

        $condition = I('get.');//筛选条件

        if(I('get.contest_sn')) $_SESSION['contest_sn']=I('get.contest_sn');
        $contest_sn = $_SESSION['contest_sn']?$_SESSION['contest_sn']:I('get.contest_sn');

        $condition['contest_sn'] = $contest_sn;

        $res = $contestorder->contestList(makeCondition($condition,$uid,$contest_sn),$current=$_GET['current']);//赛事名单列表
        $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);//获取系、年级、班级

        $this->assign('_list',$res);
        $this->assign('condition', $condition);//筛选的条件

        $this->assign('deptInfo', $studentInfo['dept']);
        $this->assign('gradeInfo', $studentInfo['grade']);
        $this->assign('classInfo', $studentInfo['class']);

        $this->assign('title',$contestorder->title);//标题
        $this->assign('status',$contestorder->status);//赛事状态
        $this->assign('valid',$contestorder->valid);//是否过期

        $this->assign('totalNum',$contestorder->totalNum);//总页数
        $this->assign('pageSize',$contestorder->pageSize);//每页数
        $this->assign('current',$contestorder->current);//第几页

        $this->display('info');
    }

    //学校名单列表
    public function user()
    {
        $uid = $_SESSION['user']['id'];

        if(I('get.contest_sn')) $_SESSION['contest_sn']=I('get.contest_sn');
        $contest_sn = $_SESSION['contest_sn']?$_SESSION['contest_sn']:I('get.contest_sn');

        $contest = new ContestModel();
        $parent_id = $contest->where(array('contest_sn'=>$contest_sn))->getField('parent_id');

        $condition = I('get.');//筛选条件

        if($parent_id > 0){
            //补考 全部不合格学生的名单
            $contest_sn = $contest->where(array('contest_id'=>$parent_id))->getField('contest_sn');//获取父订单的赛事id号

            $contestorder = new ContestOrderModel();
            $condition = makeCondition($condition,$uid,$contest_sn);
            $condition['up_standard'] = 0;
            $res = $contestorder->contestList($condition,$current=$condition['current']);
            $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

            $this->assign('_list',$res);
            $this->assign('condition', $condition);

            $this->assign('deptInfo', $studentInfo['dept']);
            $this->assign('gradeInfo', $studentInfo['grade']);
            $this->assign('classInfo', $studentInfo['class']);

            $this->assign('totalNum',$contestorder->totalNum);//总页数
            $this->assign('pageSize',$contestorder->pageSize);//每页数
            $this->assign('current',$contestorder->current);//第几页
        }else{//非补考  所有学生的名单
            $user = new UserModel();
            $res = $user->_list(makeCondition($condition,$uid,$contest_sn=0),$current=$_GET['current']);

            $deptInfo = $user->getDept($uid);//获取系别
            $gradeInfo = $user->getGrade($uid,$condition['dept']);//获取年级
            $classInfo = $user->getClass($uid,$condition['dept'],$condition['grade']);//获取班级

            $this->assign('_list', $res);
            $this->assign('condition', $condition);
            $this->assign('deptInfo', $deptInfo);
            $this->assign('gradeInfo', $gradeInfo);
            $this->assign('classInfo', $classInfo);

            $this->assign('totalNum',$user->totalNum);//总页数
            $this->assign('pageSize',$user->pageSize);//每页数
            $this->assign('current',$user->current);//第几页
        }

        $this->display();
    }

    //添加赛事人员
    public function addUser()
    {
        $data = I('post.');
        $contest_sn = $_SESSION['contest_sn'];
        if($data){

            $ids = $data['id'];

            $contest = new ContestModel();
            $contestorder = new ContestOrderModel();
            $res_length = $contest->where(array('contest_sn'=>$contest_sn))->field('length_male,length_female')->find();
            $b = $contestorder->addUser($ids,$contest_sn,$res_length);
            if(!$b) exit('fail');
            else $this->redirect('info',array(array('contest_sn'=>$contest_sn)));
        }else{
            $this->redirect('user',array(array('contest_sn'=>$contest_sn)));
        }
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

    //考试 按钮 type 2:开始 5:确认开始 3:结束考试
    public function contestClick()
    {
        $type = $_GET['type'];
        $flag = $_GET['flag'];
        $contest_sn = $_GET['contest_sn'];

        $customer_id = $_SESSION['user']['id'];
        $_SESSION['contest_sn'] = $contest_sn;

        $e = new Easemob();

        $target_type = 'users';
        $target = array('0000111','0000112','0000113');

        $content = array(
            'customer_id' => $customer_id,
            'contest_sn' => $contest_sn
        );

        $content = str_replace("\\/", "/", json_encode($content));

        $content = array(
            'data' =>$content,
            'type'=>$type
        );

        $content = json_encode($content);//注意 $content 得是一个字符窜

        $result = $e->sendText($from="admin",$target_type,$target,$content);//($from="admin",$target_type,$target,$content,$ext)

        if($result){
            $contest = new ContestModel();
            if($type == 2){//开始考试
                $contest->where(array('contest_sn'=>$contest_sn,'status'=>1))->setField('status',2);//修改赛事状态
                $this->redirect('sign');
            }else if($type == 5){//确认开始考试
                $contest->where(array('contest_sn'=>$contest_sn,'status'=>2))->setField('status',3);//修改赛事状态
                $this->redirect('score');
            }else if($type == 3){//结束考试
                $contest->where(array('contest_sn'=>$contest_sn,'status'=>3))->setField('status',4);//修改赛事状态
                if($flag == 1){
                    $this->redirect('makeUp');//补考界面
                }else{
                    $this->redirect('index');
                }
            }
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

    //创建补考
    public function makeUp()
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
            $reservationtime = $_POST['reservation-time'];

            //创建补考 和 补考赛事名单
            $b = $contestorder->makeUpStudent($ids,$_SESSION['contest_sn'],$reservationtime);
            if(!$b) exit('fail');
            else {
                $this->redirect('index');
            }
        }
        $contest_sn = $_SESSION['contest_sn'];

        $condition['contest_sn'] = $contest_sn;
        $condition['confirm'] = 0;

        $condition = makeCondition($condition,$uid,$contest_sn);//列表筛选条件
        $condition['up_standard'] = 0;
        $res = $contestorder->contestList($condition,$current=$_GET['current']);

        $studentInfo = $contestorder->getStudentInfo($condition,$contest_sn);

        $this->assign('_list',$res);
        $this->assign('condition', $condition);

        $this->assign('deptInfo', $studentInfo['dept']);
        $this->assign('gradeInfo', $studentInfo['grade']);
        $this->assign('classInfo', $studentInfo['class']);
        
        $this->assign('title',$contestorder->title);
        $this->assign('outAchieve',$contestorder->outAchieve);
        $this->assign('isFather',$contestorder->isFather);

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