<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 9:50
 */

namespace Admin\Controller;


use Admin\Model\RanKMongoModel;
use Think\Controller;

class RankController extends BaseController{
    public function index()
    {
//        $page = 1;
//        $pageSize = 10;
//        $flag = 'single';
//        $cycles = '';
//        if($_GET){
//            $flag = $_GET['flag'];
//            $cycles = $_GET['cycles'];
//        }

//        $customer_id = $_SESSION['user']['id'];
//
//        $rank = new RankMongoModel();
//        $data = $rank->getScoreRank($customer_id,$flag,$cycles,$page,$pageSize);
////        $data = $rank->getScoreRank2($customer_id,$flag='month',$cycles,$page,$pageSize,$year=2017,$month=8,$week=1);
//
//        if($flag == 'single'){
//            $rankName = '单圈最佳成绩';
//        }else if($flag == 'week'){
//            $rankName = '当周'.$cycles.'圈成绩';
//        }else if($flag == 'month'){
//            $rankName = '当月'.$cycles.'圈成绩';
//        }else if($flag == 'year'){
//            $rankName = '当年'.$cycles.'圈成绩';
//        }else if($flag == 'marathon'){
//            if($cycles == 26){$rankName = '四分之一程马拉松成绩';}
//            else if($cycles == 52){$rankName = '半程马拉松成绩';}
//            else{$rankName = '全程马拉松成绩';}
//        }else{
//            $rankName = '单圈最佳成绩';
//        }

        $array_month = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $array_week = array();
        for($i=1;$i<53;$i++){
            $array_week[] = $i;
        }

//        $this->assign('_list',$data);
//        $this->assign('rankName',$rankName);
        $this->assign('month',$array_month);
        $this->assign('week',$array_week);
        $this->display();
    }

    public function getRank()
    {
        $string = '';
        $condition = I('get.');
        foreach($condition as $k=>$v){
            $string .=$k.'->'.$v;
        }
        file_put_contents('log.txt',$string."\n",FILE_APPEND );
        $customer_id = $this->customer_id;

        $rank = new RankMongoModel();
        $data = $rank->getScoreRank2($customer_id,$condition);

        echo json_encode($data);
    }
} 