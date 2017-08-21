<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 10:02
 */

namespace Admin\Model;


use Think\Model;

class ContestModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
        array ('is_audit', '1', self::MODEL_INSERT),
    );

    /**获取赛事标题
     * $title 赛事标题
     * $parent_id  赛事父级id
    */
//    public function getTitle($title,$parent_id)
//    {
//        return ($parent_id != 0)?$title.'(补考)':$title;
//    }

    /**获取状态属性
    */
    public function statusProperty($end_time,$status)
    {
        $res = array();
        if($status == 4){
            $res['flag'] = '已结束';
        }else{
            if($end_time<NOW_TIME)//过期
            {
                $res['flag'] = '已过期';
            }else{
                if($status == 1) $res['flag'] = '未开始';
                else if($status == 2) $res['flag'] = '准备中';
                else $res['flag'] = '进行中';
            }
        }
        return $res;
    }

    /**获取开始按钮属性
     * $end_time 赛事结束时间
     * $status  赛事状态
    */
    public function getButtonProperty($end_time,$status,$contest_sn)
    {
        $res = array();

        $sql_count = "select count(*) as count from contest_order WHERE contest_sn='$contest_sn'";
        $res_count = $this->query($sql_count);

        if($res_count[0]['count'] < 1){//名单中没有用户
            $res['button'] = '开始';
            $res['click'] = 0;//不可点击
            $res['url'] = '';
        }else{
            if($status == 4)//完成 （如需要补考，可从名单页面中进行）
            {
                $res['button'] = '开始';
                $res['click'] = 0;//不可点击
                $res['url'] = '';
            }
            else//未完成
            {
                if($end_time<NOW_TIME)//过期
                {
                    $res['button'] = '开始';
                    $res['click'] = 0;//不可点击
                    $res['url'] = '';
                }
                else
                {
                    if($status == 1){
                        $res['button'] = '开始';
                        $res['click'] = 1;//可点击
                        $res['url'] = 'contestClick';//"{:U(url)}";
                    }else{
                        $res['button'] = '进入';
                        $res['click'] = 1;//可点击
                        $res['url'] = ($status==2)?'sign':'score';
                    }
                }
            }
        }



        return $res;
    }

    /**获取达标成绩
     * $sex 性别
     * $time    性别
    */
    public function getContestStandard($contest_sn,$user_id,$time)
    {
        $sql = "select sex from user WHERE user_id='$user_id'";
        $res_user = $this->query($sql);
        $sex = $res_user[0]['sex'];

        $condition = array('contest_sn'=>$contest_sn);
        $res_contest = $this->where($condition)->field('pass_score_male,pass_score_female')->find();

        if($sex == 1) $pass_score = $res_contest['pass_score_male'];
        else $pass_score = $res_contest['pass_score_female'];

        if($time>0 && $time<=$pass_score) return true;//成绩合格
        return false;//不合格
    }

    //按钮操作 type:edit编辑 delete删除
    public function clickOperate($getInfo)
    {
        if(!$getInfo) return 1;

        $type = $getInfo['type'];
        if($type == 'edit'){
            $contest_sn = $getInfo['contest_sn'];
            $res = $this->where(array('contest_sn'=>$contest_sn))
                ->field('contest_sn,title,length_male,length_female,pass_score_male,pass_score_female,content,begin_time,end_time')
                ->find();
            if($res){
                //将 达标成绩由秒的形式  转换成为分秒的形式
                $res['pass_score_male'] = str_pad(floor($res['pass_score_male']/60),2,0,STR_PAD_LEFT).'-'.str_pad(floor($res['pass_score_male']%60),2,0,STR_PAD_LEFT);
                $res['pass_score_female'] = str_pad(floor($res['pass_score_female']/60),2,0,STR_PAD_LEFT).'-'.str_pad(floor($res['pass_score_female']%60),2,0,STR_PAD_LEFT);

                $res['reservation-time'] = date('d/m/Y H:i',$res['begin_time']).' - '.date('d/m/Y H:i',$res['end_time']);

                unset($res['begin_time']);
                unset($res['end_time']);
                return $res;
            }else{
                $this->error = '未查到该赛事信息';
                return false;
            }
        }else if($type == 'delete'){
            $contest_sn = $getInfo['contest_sn'];
//            $b = $this->where(array('contest_sn'=>$contest_sn))->delete();
            $b = $this->where(array('contest_sn'=>$contest_sn))->setField('is_show',0);
            if($b){
                return 2;
            }else{
                $this->error = '服务器错误';
                return false;
            }
        }
    }

    //正在进行
    public function contestSelectNow()
    {
        $condition = array();
        $condition['begin_time'] = array('lt',NOW_TIME);//开始时间小于当前时间
        $condition['end_time'] = array('gt',NOW_TIME);//结束时间大于当前时间
        $res = $this->where($condition)->field('parent_id,contest_sn,title,begin_time,end_time')->order('begin_time')->limit(1)->select();
        $res = $res[0];
        return $res;
    }

    //冲突中
    public function contestSelectConflict($nowContest)
    {
        if(!$nowContest) return array();

        $end_time = $nowContest['end_time'];
        $begin_time = $nowContest['begin_time'];

        $condition['begin_time'] = array('lt',$end_time);
        $condition['begin_time'] = array('gt',$begin_time);

        $res = $this->where($condition)->field('contest_sn,title')->order('begin_time')->limit(1)->select();
        return $res;
    }

    //即将开始的考试
    public function contestSelectSoon()
    {
        //开始时间大于当前时间 开始时间小于当前时间+3天的时间
        $condition['begin_time'] = array('between',array(NOW_TIME,NOW_TIME+3600*24*3));

        $res = $this->where($condition)->field('contest_sn,title,begin_time')->order('begin_time')->limit(2)->select();
        return $res;
    }

    //获取赛事列表
    public function getContestInfo($uid)
    {
        $condition['is_show'] = 1;
        $condition['customer_id'] = $uid;

        $res = $this->where($condition)
            ->field('contest_id,contest_sn,parent_id,title,begin_time,end_time,status')
            ->order('add_time desc')
            ->select();

        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $res_button = $this->getButtonProperty($res[$i]['end_time'],$res[$i]['status'],$res[$i]['contest_sn']);//获取按钮属性
            $res_status = $this->statusProperty($res[$i]['end_time'],$res[$i]['status']);//获取状态

            $res[$i] = array_merge($res[$i],$res_button,$res_status);
        }
        return $res;
    }

    //生成赛事编码
    public function createContestSn()
    {
        $sn = random(8,0);
        $flag = true;
        while($flag){
            $count = $this->where(array('contest_sn'=>$sn))->count();
            if($count>0){
                $this->createContestSn();
            }else{
                $flag = false;
            }
        }
        return $sn;
    }

    //填充数据
    public function fillData($data)
    {
        $data['customer_id'] = $_SESSION['user']['id'];
        $data['contest_sn'] = $this->createContestSn();//生成考试编码

        $s = explode('-',$data['reservation-time']);
        unset($data['reservation-time']);

        $data['begin_time'] = strtotime($s[0]);
        $data['end_time'] = strtotime($s[1]);

        $data['pass_score_male'] = ScoreTimeExplode($data['pass_score_male']);
        $data['pass_score_female'] = ScoreTimeExplode($data['pass_score_female']);

        $data['add_time'] = NOW_TIME;

        if($_SESSION['user']['grade'] == 3){
            $data['from_id'] = $_SESSION['user']['id'];
            $data['from_name'] = '学校管理员';
        }
        else{
            $data['from_id'] = $_SESSION['user']['id'];
            $data['from_name'] = $_SESSION['user']['id'];
        }
        return $data;
    }

    //赛事重新编辑
    public function editContest($data)
    {
        $s = explode('-',$data['reservation-time']);

        $data['pass_score_male'] = ScoreTimeExplode($data['pass_score_male']);
        $data['pass_score_female'] = ScoreTimeExplode($data['pass_score_female']);

        unset($data['reservation-time']);
        $data['begin_time'] = strtotime($s[0]);
        $data['end_time'] = strtotime($s[1]);
        if($_SESSION['user']['grade'] == 3){
            $data['from_id'] = $_SESSION['user']['id'];
            $data['from_name'] = '学校管理员';
        }
        else{
            $data['from_id'] = $_SESSION['user']['id'];
            $data['from_name'] = $_SESSION['user']['id'];
        }
        $this->where(array('contest_sn'=>$data['contest_sn']))->save($data);
        return true;
    }

} 