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

class RankController extends Controller{
    public function index()
    {
        $page = 1;
        $pageSize = 10;
        $flag = 'single';
        $cycles = '';
        if($_GET){
            $flag = $_GET['flag'];
            $cycles = $_GET['cycles'];
        }

        $customer_id = $_SESSION['user']['id'];

        $rank = new RankMongoModel();
        $data = $rank->getScoreRank($customer_id,$flag,$cycles,$page,$pageSize);
//        $data = $rank->getScoreRank2($customer_id,$flag='month',$cycles,$page,$pageSize,$year=2017,$month=8,$week=1);

        if($flag == 'single'){
            $rankName = '单圈最佳成绩';
        }else if($flag == 'week'){
            $rankName = '当周'.$cycles.'圈成绩';
        }else if($flag == 'month'){
            $rankName = '当月'.$cycles.'圈成绩';
        }else if($flag == 'year'){
            $rankName = '当年'.$cycles.'圈成绩';
        }else if($flag == 'marathon'){
            if($cycles == 26){$rankName = '四分之一程马拉松成绩';}
            else if($cycles == 52){$rankName = '半程马拉松成绩';}
            else{$rankName = '全程马拉松成绩';}
        }else{
            $rankName = '单圈最佳成绩';
        }

        $this->assign('_list',$data);
        $this->assign('rankName',$rankName);
        $this->display();
    }

    public function getRank()
    {
        $page = 1;
        $pageSize = 10;

        $string = '';
        $condition = $_GET;
        foreach($condition as $k=>$v){
            $string .=$k.'->'.$v;
        }
        file_put_contents('log.txt',$string."\n",FILE_APPEND );
        $customer_id = $_SESSION['user']['id'];

        $cycles = $condition['length']/400;
        $year = $condition['year'];
        $month = $condition['month'];
        $week = $condition['week'];

        if($month){
            $flag='month';
        }else if($week){
            $flag='week';
        }else{
            $flag='year';
        }


        $year = 2017;
        $month = 8;
        $cycles = 2;
        $flag = 'month';

        $rank = new RankMongoModel();
        $data = $rank->getScoreRank2($customer_id,$flag,$cycles,$page,$pageSize,$year,$month,$week);

        echo json_encode($data);
    }
} 