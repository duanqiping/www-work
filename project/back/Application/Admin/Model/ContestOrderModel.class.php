<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 19:23
 */

namespace Admin\Model;


use Admin\Logic\Time;
use Think\Model;

class ContestOrderModel extends Model{

    protected $tableName = 'contest_order';
    public $title;//赛事标题
    public $status;//赛事状态
    public $valid = 1;//1有效期 0过期
    public $isFather = 0;//1有补考 0没有补考

    public $onAchieve = 0;//合格人数
    public $outAchieve = 0;//不合格人数

    public $totalNum=0;//总记录条数
    public $pageSize=15;//每页的条数
    public $current = 1;//当前页

    /**成绩状态 合格 未签到、没成绩、不合格
     * $sign 是否签到
     * $time    成绩
     * $pass_score  达标成绩
    */
    public function scoreStatus($sign,$time,$pass_score)
    {
        $achieve = '';
        if($sign != 1)
        {
            $achieve = '未签到';
            $this->outAchieve += 1;
        }
        else
        {
            if($time <= $pass_score && $time>0){
                $achieve = '合格';
                $this->onAchieve += 1;
            }else if($time == 0){
                $achieve = '无成绩';
                $this->outAchieve += 1;
            }else if($time > $pass_score){
                $achieve = '不合格';
                $this->outAchieve += 1;
            }
        }
        return $achieve;
    }

    public function _list($condition,$field)
    {
        $res = $this->where($condition)->field($field)->select();
        return $res;
    }
    //检查签到人员是否在考试名单列表中
    public function checkSignContest($user_ids,$contest_sn)
    {
        $condition = array();
        $condition['contest_sn'] = $contest_sn;

        for($i=0,$len=count($user_ids);$i<$len;$i++){
            $condition['user_id'] = $user_ids[$i];
            $count = $this->where($condition)->count();
            if($count<1){
                $this->error = "user_id为".$user_ids[$i]['user_id']."学生未在该考试名单中";
                return false;
            }
        }
        return true;
    }

    //更新用户成绩
    public function updateContest($data)
    {
        //先判断 是否已经存在这个成绩
        $condition = array();

        $condition['user_id'] = $data['user_id'];
        $condition['customer_id'] = $data['customer_id'];
        $condition['contest_sn'] = $data['contest_sn'];
        $count = $this->where($condition)->count();

        if($count<1){
            $this->error = '赛事名单中不存在该学生';
            return false;
        }

        $user = new UserModel();
        $sql = "update user set length=length+'{$data['length']}' WHERE user_id='{$data['user_id']}'";
        $user->execute($sql);

        $data['update'] = NOW_TIME;
        $data['makeup'] = $data['is_again'];

        unset($data['customer_id']);
        unset($data['contest_sn']);
        unset($data['user_id']);
        unset($data['is_again']);

        $b = $this->where($condition)->save($data);

        if(!$b){
            $this->error = '服务器错误';
            return false;
        }else{
            return true;
        }
    }

    //获取赛事名单人数
    public function getContestNum($res)
    {
        for($i=0,$len=count($res);$i<$len;$i++){
            $count = $this->where(array('contest_sn'=>$res[$i]['contest_sn']))->count();
            $res[$i]['count'] = $count;
        }
        return $res;
    }

    //赛事名单列表
    public function contestList($condition,$page)
    {
        if($page<1)$page=1;
        $this->current = $page;

        $offset = ($page-1)*$this->pageSize;
        $this->totalNum = $this->where($condition)->count();

        $contest = new ContestModel();
        $res_contest = $contest->where(array('contest_sn'=>$_SESSION['contest_sn']))
            ->field('contest_id,parent_id,title,pass_score_male,pass_score_female,end_time,status')
            ->find();

        if($res_contest['end_time']<NOW_TIME){
            $this->valid = 0;//过期
        }

        //判断状态完成的赛事是否存在补考
        if($res_contest['status'] == 4){
            $count = $contest->where(array('parent_id'=>$res_contest['contest_id']))->count();

            if($count>0) $this->isFather = 1;//存在补考
            else $this->isFather = 0;//不存在
        }

        $res = $this->where($condition)->field('*')->limit($offset,$this->pageSize)->select();

        $time = new Time();
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            if($res[$i]['sex'] == 1){
                $res[$i]['pass_score'] = $res_contest['pass_score_male'];
            }else{
                $res[$i]['pass_score'] = $res_contest['pass_score_female'];
            }
            $res[$i]['time'] = $time->timeChange($res[$i]['time']);//将时间转换成 天 时 分秒形式
            $res[$i]['achieve'] = $this->scoreStatus($res[$i]['sign'],$res[$i]['time'],$res[$i]['pass_score']);//成绩状态
        }
        $this->status = $res_contest['status'];

        return $res;
    }

    //赛事名单列表
    public function contestList2($condition)
    {
        $condition['time'] = array('gt',0);
        $res = $this->where($condition)->field('*')->select();
        return $res;
    }

    //添加赛事学生名单
    public function addUser($ids,$contest_sn,$res_length)
    {
        $user= new UserModel();

        $map['user_id'] = array('in',$ids);
        $addinfo = $user->where($map)
            ->field("customer_id,user_id,name,studentId,sex,dept,grade,class")
            ->select();

        //开启事物
        $this->startTrans();

        foreach($addinfo as $k=>$v){

            //先查询是否已经添加 customer_id contest_sn user_id
            $condition_s['customer_id'] = $v['customer_id'];
            $condition_s['contest_sn'] = $contest_sn;
            $condition_s['user_id'] = $v['user_id'];

            $count = $this->where($condition_s)->count();

            if($count<1){
                $v['length'] = ($v['sex']==1)?$res_length['length_male']:$res_length['length_female'];
                $v['contest_sn'] = $contest_sn;
                $v['add_time'] = NOW_TIME;

                $result = $this->add($v);

                if(!$result){
                    $this->rollback();
                    $this->error = '添加失败';
                    return false;
                }
            }
        }
        $this->commit();
        return true;
    }

    //添加补考学生
    public function makeUpStudent($ids,$contest_sn,$reservationtime)
    {
        $contest = new ContestModel();

        $res = $contest->where(array('contest_sn'=>$contest_sn))
            ->field('contest_id parent_id,customer_id,contest_sn,title,content,length_male,length_female,length,pass_score_male,pass_score_female')
            ->find();

        $s = explode('-',$reservationtime);
        $res['begin_time'] = strtotime($s[0]);
        $res['end_time'] = strtotime($s[1]);
        $res['add_time'] = NOW_TIME;
        $res['contest_sn'] = $contest->createContestSn();
        $res['title'] = $res['title'].'(补考)';

        if($_SESSION['user']['grade'] == 3){
            $res['from_id'] = $_SESSION['user']['id'];
            $res['from_name'] = '学校管理员';
        }
        else{
            $res['from_id'] = $_SESSION['user']['id'];
            $res['from_name'] = $_SESSION['user']['id'];
        }
        $this->startTrans();//开启事物
        $uid = $contest->add($res);//生成一条新赛事

        if(!$uid){
            $this->error = '补考赛事生成失败';
            return false;
        }

        $map['contest_order_id'] = array('in',$ids);
        $map['contest_sn'] = $contest_sn;

        $add_time = NOW_TIME;
        $res_users = $this->where($map)
            ->field("{$res['contest_sn']} as contest_sn,$add_time as add_time, customer_id,user_id,name,studentId,sex,dept,grade,class,length,mode")
            ->select();

        $b = $this->addAll($res_users);//补考人员名单

        if(!$b){
            $this->rollback();
            return false;
        }else{
            $this->commit();
            return true;
        }
    }

    //获取赛事名单  圈数、终点endMachine放到List中
    public function getContestOrder($contest_sn,$customer_id)
    {
        $data = array();

        //获取考试名单人详细信息
        $sql = "select co.class classRoom,co.name,co.user_id,co.studentId,co.length,co.sex,d.code label from contest_order co LEFT JOIN device d ON co.user_id=d.user_id WHERE ".
            "co.contest_sn=%s and co.customer_id=%d";

        //获取赛事标题和内容
        $sql2 = "select title,content from contest WHERE contest_sn=%s";

        $res = $this->query($sql,$contest_sn,$customer_id);
        $res2 = $this->query($sql2,$contest_sn);

        if(!$res){
            return array();
        }
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            if($res[$i]['sex'] == 1){
                $res[$i]['endMachine'] = '0000113';
                $res[$i]['circle'] = '3';
            }else{
                $res[$i]['endMachine'] = '0000112';
                $res[$i]['circle'] = '2';
            }
            unset($res[$i]['length_male']);
            unset($res[$i]['length_female']);
        }
        $data['list'] = $res;
        $data['customer_id'] = $customer_id;

        $data['title'] = $res2[0]['title'];
        $data['content'] = $res2[0]['content'];
        $data['is_again'] = 0;//是否为重考
        return $data;
    }

    //1某次赛事考试 和 2所有赛事考试
    //获取系、年级、班级
    public function getStudentInfo($condition,$uid,$contest_sn=0)
    {
        $studentInfo = array();
        $condition_query = array();//查询条件
        $condition_query['customer_id'] = $uid;//客户id
        if($contest_sn)$condition_query['contest_sn'] = $contest_sn;//考试赛事编码

        //查询出系别
        $studentInfo['dept'] = $this->where($condition_query)
            ->field('dept')
            ->group('dept')
            ->select();

        //查询出年级
        $condition_query['dept'] = $condition['dept'];
        $studentInfo['grade'] = $this->where($condition_query)
            ->field('grade')
            ->group('grade')
            ->select();

        //查询出班级
        $condition_query['grade'] = $condition['grade'];
        $studentInfo['class'] = $this->where(array('customer_id'=>$uid,'dept'=>$condition['dept'],'grade'=>$condition['grade']))
            ->field('class')
            ->group('class')
            ->select();
        return $studentInfo;
    }

    public function getDept($contest_sn)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn))->field('dept')->group('dept')->select();
        return $res;
    }
    public function getGrade($contest_sn,$dept)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn,'dept'=>$dept))->field('grade')->group('grade')->select();
        return $res;
    }
    public function getClass($contest_sn,$dept,$grade)
    {
        $res = $this->where(array('contest_sn'=>$contest_sn,'dept'=>$dept,'grade'=>$grade))->field('class')->group('class')->select();
        return $res;
    }
} 