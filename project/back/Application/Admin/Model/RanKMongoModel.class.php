<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 16:58
 */

namespace Admin\Model;


use Admin\Logic\Time;
use Think\Model\MongoModel;

class RanKMongoModel extends MongoModel{

    protected $marathon = 42195;//全程马拉松

    protected $dbName='score';//（要连接的数据库名称）

    protected $trueTableName = '';

    protected $connection = 'DB_CONFIG1';


    protected $_idType = self::TYPE_INT; //参考手册
    protected $_autoinc = true;//参考手册

    //获取排行标签
    public function getFlag($condition)
    {
        if($condition['single']){
            $flag = 'single';//单圈最佳排行榜
        }else if($condition['marathon']){
            $flag = 'marathon';//马拉松排行榜
        }else{
            if($condition['month']){
                $flag='month';//月排行榜
            }else if($condition['week']){
                $flag='week';//周排行榜
            }else{
                $flag='year';//年排行榜
            }
        }
        return $flag;
    }

    public function dealWithSolve($table_info,$data,$length,$scoreInfo,$customer_id)
    {
        $all_time = 0;
        $cycles = count($scoreInfo);
        foreach($scoreInfo as $k=>$v){
            $all_time += $scoreInfo[$k]['time'];
        }

        $add_info = array(
            'user_id'=>$data['user_id'],
            'score_id'=>$data['score_id'],
            'cycles'=>$cycles,
            'time'=>$all_time,
            'add_time'=>NOW_TIME,
            'sex' =>$data['sex'],
            'dept' =>$data['dept'],
            'grade' =>$data['grade'],
            'class' =>$data['class'],
            'studentId' =>$data['studentId'],
            'name' =>$data['name'],
        );

        //是否 启用事物， 感觉不合适

        //单圈最佳成绩
        $b = $this->singleSolve($data,$customer_id);
        if(!$b){
            $this->error = '单圈成绩导入失败';
            return false;
        }

        //马拉松成绩录入
        $b1  = $this->marathonSolve($cycles,$all_time,$length,$data,$add_info,$customer_id);
        if(!$b1) {
            $this->error = '马拉松成绩导入失败';
            return false;
        }

        //周月年成绩录入
        $b2 = $this->dateSolve($cycles,$all_time,$table_info,$data,$add_info);
        if(!$b2){
            $this->error = '周月年成绩导入失败';
            return false;
        }

        return true;
    }

    //马拉松成绩处理
    private function marathonSolve($cycles,$all_time,$length,$data,$add_info,$customer_id)
    {
        $tableName = 'rank_marathon';
        $add_info['customer_id'] = $customer_id;

        //全程 半程 四分之一程
        $array_marathon = array(floor($this->marathon/$length),floor($this->marathon/(2*$length)),floor($this->marathon/(4*$length)) );

        if(in_array($cycles,$array_marathon))
        {
            $condition['user_id'] = $data['user_id'];
            $condition['cycles'] = $cycles;
            $res = $this->table($tableName)->where($condition)->field('time')->find();

            if(!$res) {
                $b1 = $this->table($tableName)->add($add_info);//插入
                if(!$b1) {
                    return false;
                }
            }else if($res && $res['time'] > $all_time){//更新
                $updata = array(
                    'score_id' =>$data['score_id'],
                    'time'=>$all_time,
                    'add_time'=>NOW_TIME
                );
                $b2 = $this->table($tableName)
                    ->where(array('_id'=>$res['_id']))
                    ->save($updata);
                if(!$b2) {
                    return false;
                }
            }else{
                return true;
            }
        }
        return true;
    }

    //周月年成绩录入
    private function dateSolve($cycles,$all_time,$table_info,$data,$add_info)
    {
        foreach($table_info as $k=>$v)
        {
            //查询是否有当年当月当周记录
            if($k == 'rank_y_table'){
                $timeflag = 'year';
            }else if($k == 'rank_m_table'){
                $timeflag = 'month';
            }else{
                $timeflag = 'week';
            }

            $condition['user_id'] = $data['user_id'];
            $condition['cycles'] = $cycles;
//            $condition['add_time'] = array('gt',strtotime($this->rankChoiceRule($timeflag)));
            $condition['add_time'] = array('gt',getTimeBegin($timeflag));

            $res =$this->table($v)->where($condition)->field('time,add_time')->find();

            //rank_y_table排行表插入条件：1没有该用户记录 2圈数不一样 3不在同年或同月或同周范围内
            if(!$res) {
                $b1 = $this->table($v)->add($add_info);//插入
                if(!$b1) {
                    return false;
                }//打印日志1
            }else if($res['time'] > $all_time){
                //更新
                $updata_info = array(
                    'score_id' => $data['score_id'],
                    'time' => $all_time,
                    'add_time' => NOW_TIME,
                );
                $b2 = $this->table($v)->where(array('_id'=>$res['_id']))->save($updata_info);
                if(!$b2) {
                    return false;
                }
            }
        }

        return true;
    }

    //单圈最佳成绩更新判断
    private function singleSolve($data,$customer_id)
    {
        $single_info = array(
            'user_id' => $data['user_id'],
            'score_id' => $data['score_id'],
            'customer_id' => $customer_id,
            'time' => $data['time'],
            'add_time' => NOW_TIME,
            'name' =>$data['name'],
            'studentId' =>$data['studentId'],
            'sex' =>$data['sex'],
            'dept' =>$data['dept'],
            'grade' =>$data['grade'],
            'class' =>$data['class'],
        );

        $tableName = 'rank_single';
        $condition['user_id'] = $data['user_id'];
        $res = $this->table($tableName)->where($condition)->field('time')->find();

        if(!$res){
            //插入
            if(!$this->table($tableName)->add($single_info)){
                return false;
            }
        }else{
            if($data['time']<$res['time']){
                $b = $this->table($tableName)
                    ->where(array('_id'=>$res['_id']))
                    ->save(array('time'=>$data['time'],'score_id'=>$data['score_id'],'add_time'=>NOW_TIME));
                if(!$b){
                    return false;
                }
            }
        }
        return true;
    }

    //获取单圈最佳成绩
    public function bestScore($grade)
    {
        $condition = array();
        $uid = $_SESSION['user']['id'];

        if($grade == 3 || $grade == 4){
            $condition['customer_id'] = $uid;

        }else if($grade == 2){
            $customer = new CustomerModel();
            $customer_infos = $customer->where(array('agent_id'=>$uid))->field('customer_id')->select();
            $customer_ids = array();
            for($i=0,$len=count($customer_infos);$i<$len;$i++){
                $customer_ids[] = $customer_infos[$i]['customer_id'];
            }
            $condition['customer_id'] = array('in',$customer_ids);
        }

        $min_res  = $this->table('rank_single')->where($condition)->field('time')->order('time')->limit(1)->select();
        $min_res = array_values($min_res);
        $minScore = $min_res[0]['time'];

        return $minScore;
    }

    //获取单圈最佳成绩排行
    public function getScoreRank($customer_id,$flag,$cycles,$page,$pageSize)
    {
        if($flag == 'single'){
            $tableName = 'rank_single';
        }else if($flag == 'marathon'){
            $tableName = 'rank_marathon';
        }else {
            if($flag == 'year'){
                $field = 'rank_y_table';
            }
            else if($flag == 'month'){
                $field = 'rank_m_table';
            }
            else{
                $field = 'rank_w_table';
            }
            $customer = new CustomerModel();
            $res = $customer->where(array('customer_id'=>$customer_id))->field($field)->find();
            $tableName = $res[$field];
        }

        if(($page<1)||($pageSize<1)){
            $page = 1;
            $pageSize = 20;
        }
        $offset = ($page-1)*$pageSize;

        //历史单圈最佳成绩排行
        if($flag == 'single'){
            $condition['customer_id'] = $customer_id;
            $res = $this->table($tableName)
                ->where($condition)
                ->field('user_id,customer_id,score_id,time,add_time,length')
                ->order('time')
                ->limit($offset,$pageSize)
                ->select();
        }
        //马拉松成绩排行
        else if($flag == 'marathon'){
            $condition['customer_id'] = $customer_id;
            $condition['cycles'] = intval($cycles);
            $res = $this->table($tableName)
                ->where($condition)
                ->field('user_id,customer_id,score_id,time,add_time,length')
                ->order('time')
                ->limit($offset,$pageSize)
                ->select();
        }
        //周月年排行
        else{
            $condition['cycles'] = intval($cycles);
            $condition['add_time'] = array('gt',intval(getTimeBegin($flag) ));
            $res = $this->table($tableName)
                ->where($condition)
                ->field('user_id,customer_id,score_id,cycles,time,add_time,length')
                ->order('time')
                ->limit($offset,$pageSize)
                ->select();
        }

        if(!$res) return array();
        $res = array_values($res);

        $user = new UserModel();
        $res = $user->getUserInfoFromRank($res);

        return $res;
    }

    //获取单圈最佳成绩排行
    public function getScoreRank2($customer_id,$condition_select)
    {
        $pageSize = 10;
        $flag = $this->getFlag($condition_select);//获取排行标签

//        my_print($flag);

        if($flag == 'single'){
            $tableName = 'rank_single';
        }else if($flag == 'marathon'){
            $tableName = 'rank_marathon';
        }
        else {
            if($flag == 'year'){
                $field = 'rank_y_table';
            }
            else if($flag == 'month'){
                $field = 'rank_m_table';
            }
            else{
                $field = 'rank_w_table';
            }
            $customer = new CustomerModel();
            $res = $customer->where(array('customer_id'=>$customer_id))->field($field)->find();
            $tableName = $res[$field];
        }

        //历史单圈最佳成绩排行
        if($flag == 'single'){
            $condition['customer_id'] = $customer_id;
            $field = 'user_id,customer_id,score_id,time,add_time,length';
        }
        //马拉松成绩排行
        else if($flag == 'marathon'){
            $cycles = $condition_select['length']/400;

            $condition['customer_id'] = $customer_id;
            $condition['cycles'] = intval($cycles);
            $field = 'user_id,customer_id,score_id,time,add_time,length';
        }
        //周月年排行
        else{
            $cycles = $condition_select['length']/400;
            $year = $condition_select['year'];
            $month = $condition_select['month'];
            $week = $condition_select['week'];

            $time = new Time();
            if($flag == 'month') $date_res = $time->monthDay($year,$month);
            else if($flag == 'year') $date_res = $time->yearDay($year);
            else $date_res = $time->weekday($year,$week);

            $condition['add_time'] = array('between',$date_res);
            $condition['cycles'] = intval($cycles);
            $field = 'user_id,customer_id,score_id,cycles,time,add_time,length';
        }

        $res = $this->table($tableName)
            ->where($condition)
            ->field($field)
            ->order('time')
            ->limit(0,$pageSize)
            ->select();
//        echo $this->_sql();
//        exit();
        if(!$res) return array();
        $res = array_values($res);

        $user = new UserModel();
        $res = $user->getUserInfoFromRank($res);

        return $res;
    }
} 