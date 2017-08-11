<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/10
 * Time: 17:05
 */

namespace Admin\Model;


use Think\Model;

class UserModel extends Model{

    public $totalNum=0;//总记录条数
    public $pageSize=15;//每页的条数
    public $current = 1;//当前页

    public function test()
    {
        return 'hello';
    }

    //系别
    public function getDept($uid)
    {
        $res = $this->where(array('customer_id'=>$uid))->field('dept')->group('dept')->select();
        return $res?$res:array();
    }
    //获取年级
    public function getGrade($uid,$dept)
    {
        $res = $this->where(array('customer_id'=>$uid,'dept'=>$dept))->field('grade')->group('grade')->select();
        return $res?$res:array();
    }
    //获取班级
    public function getClass($uid,$dept,$grade)
    {
        $res = $this->where(array('customer_id'=>$uid,'dept'=>$dept,'grade'=>$grade))->field('class')->group('class')->select();
        return $res?$res:array();
    }

    //获取用户名
    public function getUserName($code)
    {
        $sql = "select u.name,u.user_id from device d LEFT JOIN user u ON d.user_id = u.user_id WHERE d.code='$code'";
        $res = $this->query($sql);
        if(!$res){
            $this->error = '该用户尚未注册或未绑定手环';
            return false;
        }else{
            return $res[0];
        }
    }

    //排行表中获取用户信息
    public function getUserInfoFromRank($res)
    {
        for($i=0,$len=count($res);$i<$len;$i++)
        {
            $condition_user['user_id'] = $res[$i]['user_id'];
            $userInfo = $this->where($condition_user)->field('name,dept,grade,studentId,class')->find();
//            if($userInfo['img']) $res[$i]['img'] = NROOT.$userInfo['img'];
//            else $res[$i]['img'] = null;

            $res[$i]['name'] = $userInfo['name'];
            $res[$i]['studentId'] = $userInfo['studentId'];
            $res[$i]['grade'] = $userInfo['grade'];
            $res[$i]['dept'] = $userInfo['dept'];
            $res[$i]['class'] = $userInfo['class'];
        }
        return $res;
    }
    //用户列表
    public function _list($condition,$page)
    {
        if($page<1)$page=1;
        $this->current = $page;

        $offset = ($page-1)*$this->pageSize;
        $this->totalNum = $this->where($condition)->count();

        $where = '';
        foreach($condition as $k=>$v){
            //最后一个元素
            if(end($condition) == $v){
                $where .= "u.$k='$v'";
            }else{
                $where .= "u.$k='$v' AND ";
            }
        }
        
        $sql = "SELECT u.user_id,u.name,u.studentId,u.sex,u.grade,u.dept,u.class,u.last_login_time,u.last_login_ip,u.login_count,d.device_id ".
            "FROM user u left join device d on u.user_id=d.user_id WHERE $where ORDER BY u.add_time desc limit $offset,$this->pageSize";
        $res = $this->query($sql);

        return $res;
    }
} 