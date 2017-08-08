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
                $res['pass_score_male'] = str_pad(floor($res['pass_score_male']/60),2,0,STR_PAD_LEFT).'-'.str_pad(floor($res['pass_score_male']%60),2,0,STR_PAD_LEFT);
                $res['pass_score_female'] = str_pad(floor($res['pass_score_female']/60),2,0,STR_PAD_LEFT).'-'.str_pad(floor($res['pass_score_female']%60),2,0,STR_PAD_LEFT);

                $res['reservation-time'] = date('d-m-Y:H:i:s',$res['begin_time']).'-'.date('d-m-Y:H:i:s',$res['end_time']);
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
        $res = $this->where($condition)->field('contest_sn,title,begin_time,end_time')->order('begin_time')->limit(1)->select();
        return $res[0];
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
    public function getContestInfo()
    {
        $condition['is_show'] = 1;
        $condition['customer_id'] = $_SESSION['user']['id'];

        $res = $this->where($condition)
            ->field('contest_sn,title,begin_time,end_time,is_use')
            ->order('add_time desc')
            ->select();
        for($i=0,$len=count($res);$i<$len;$i++){
            if($res[$i]['is_use'] == 1){
                $res[$i]['flag'] = '已结束';
            }else{
                if($res[$i]['end_time']<NOW_TIME){
                    $res[$i]['flag'] = '已过期';
                }else{
                    $res[$i]['flag'] = '未开始';
                }
            }
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
        $data['contest_sn'] = $this->createContestSn();

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