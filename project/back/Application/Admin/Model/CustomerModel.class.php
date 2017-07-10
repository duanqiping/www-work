<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:05
 */

namespace Admin\Model;


class CustomerModel extends ConsumerHandleModel
{
    protected $tableName = 'customer';

    protected $custom_fields = 'customer_id id,name,passwd,account,grade';

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
    );

    public function getList()
    {
        $condition['is_show'] = 1;
        $info = $this->where($condition)
            ->field('customer_id,account,name,agent_id,customer_addr,score_table,description,last_login_time,last_login_ip')
            ->order('agent_id desc')
            ->select();
        return  $info ;
    }

    //完善数据
    public function makeData($data)
    {
        //生成自己的code
        $flag = 0;
        $code = "";
        while ($flag == 0) {
            $code = random(5, 0);
            $count = $this->where(array('code'=>$code))->count();
            if ($count == 0)//生成的编码没有被使用
            {
                $flag = 1;
            }
        }
        $data['code'] = $code;
        $data['score_table'] =  $score_table= 'z_score_'.$code;
        $data['rank_y_table'] =  $rank_y_table= 'z_rank_y_'.$code;
        $data['rank_m_table'] =  $rank_m_table= 'z_rank_m_'.$code;
        $data['rank_w_table'] =  $rank_w_table= 'z_rank_w_'.$code;
        return $data;
    }

    //客户概述信息
    public function mainInfo()
    {
        //用户量
        $user = new UserModel();
        $condition['customer_id'] = $_SESSION['user']['id'];
        $count = $user->where($condition)->count();

        //累计最长距离
        $res_length = $user->where($condition)->field('length')->order('length desc')->limit(1)->select();
        $max_length = $res_length[0]['length'];

        //活跃用户量
        $condition['length'] = array('gt',30000);
        $count_active = $user->where($condition)->count();

        $data = array();
        $data['count'] = $count;
        $data['max_length'] = round($max_length/1000,2);
        $data['count_active'] = $count_active;
//        print_r($max_length);
////        echo $user->_sql();
//        print_r($count);
//        exit();
        return $data;

    }

    //创建成绩表和排行表
    public function createScoreAndRankTable($data)
    {
        $score_table = $data['score_table'];
        $rank_y_table = $data['rank_y_table'];
        $rank_m_table = $data['rank_m_table'];
        $rank_w_table = $data['rank_w_table'];

        $sql = "CREATE TABLE IF NOT EXISTS $score_table (
                      score_id bigint(20) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      begin_time int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
                      end_time int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '比赛耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '跑步长度',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      mode tinyint(4) NOT NULL DEFAULT '0' COMMENT '成绩类型：1训练 2考试 3比赛',
                      flag int(11) NOT NULL DEFAULT '0' COMMENT '一次成绩的标志',
                      PRIMARY KEY (score_id),
                      KEY user_id (user_id),
                      KEY time (time),
                      KEY customer_id (customer_id),
                      KEY add_time (add_time),
                      KEY flag (flag)
                    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
                ";
        $sql2 = "CREATE TABLE IF NOT EXISTS $rank_y_table (
                      rank_id int(11) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      score_id int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
                      cycles tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '长度',
                      PRIMARY KEY (rank_id),
                      KEY user_id (user_id),
                      KEY customer_id (customer_id),
                      KEY score_id (score_id),
                      KEY cycles (cycles),
                      KEY time (time),
                      KEY add_time (add_time),
                      KEY length (length)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
                ";
        $sql3 = "CREATE TABLE IF NOT EXISTS $rank_m_table (
                      rank_id int(11) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      score_id int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
                      cycles tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '长度',
                      PRIMARY KEY (rank_id),
                      KEY user_id (user_id),
                      KEY customer_id (customer_id),
                      KEY score_id (score_id),
                      KEY cycles (cycles),
                      KEY time (time),
                      KEY add_time (add_time),
                      KEY length (length)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
                ";
        $sql4 = "CREATE TABLE IF NOT EXISTS $rank_w_table (
                      rank_id int(11) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      score_id int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
                      cycles tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '长度',
                      PRIMARY KEY (rank_id),
                      KEY user_id (user_id),
                      KEY customer_id (customer_id),
                      KEY score_id (score_id),
                      KEY cycles (cycles),
                      KEY time (time),
                      KEY add_time (add_time),
                      KEY length (length)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
                ";

        $b = $this->execute($sql);
        $b2 = $this->execute($sql2);
        $b3 = $this->execute($sql3);
        $b4 = $this->execute($sql4);
        if($b === false || $b2===false || $b3 === false || $b4===false){
            $this->error = '服务器错误';
            $sql1 = "DROP TABLE IF EXISTS $score_table";
            $sql2 = "DROP TABLE IF EXISTS $rank_y_table";
            $sql3 = "DROP TABLE IF EXISTS $rank_m_table";
            $sql4 = "DROP TABLE IF EXISTS $rank_w_table";
            $this->execute($sql1);
            $this->execute($sql2);
            $this->execute($sql3);
            $this->execute($sql4);
            return false;
        }
        else return true;
    }


    //创建成绩表和排行表
    public function createScoreAndRankTable2($data)
    {
        $score_table = $data['score_table'];
        $rank_y_table = $data['rank_y_table'];
        $rank_m_table = $data['rank_m_table'];
        $rank_w_table = $data['rank_w_table'];

        $sql = "CREATE TABLE IF NOT EXISTS $score_table (
                      score_id bigint(20) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      begin_time int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
                      end_time int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '比赛耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '跑步长度',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      mode tinyint(4) NOT NULL DEFAULT '0' COMMENT '成绩类型：1训练 2考试 3比赛',
                      flag int(11) NOT NULL DEFAULT '0' COMMENT '一次成绩的标志',
                      PRIMARY KEY (score_id),
                      KEY user_id (user_id),
                      KEY time (time),
                      KEY customer_id (customer_id),
                      KEY add_time (add_time),
                      KEY flag (flag)
                    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
                ";
        $sql2 = "CREATE TABLE IF NOT EXISTS $rank_y_table (
                      rank_id int(11) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      score_id int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
                      cycles tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '长度',
                      PRIMARY KEY (rank_id),
                      KEY user_id (user_id),
                      KEY customer_id (customer_id),
                      KEY score_id (score_id),
                      KEY cycles (cycles),
                      KEY time (time),
                      KEY add_time (add_time),
                      KEY length (length)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
                ";
        $sql3 = "CREATE TABLE IF NOT EXISTS $rank_m_table (
                      rank_id int(11) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      score_id int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
                      cycles tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '长度',
                      PRIMARY KEY (rank_id),
                      KEY user_id (user_id),
                      KEY customer_id (customer_id),
                      KEY score_id (score_id),
                      KEY cycles (cycles),
                      KEY time (time),
                      KEY add_time (add_time),
                      KEY length (length)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
                ";
        $sql4 = "CREATE TABLE IF NOT EXISTS $rank_w_table (
                      rank_id int(11) NOT NULL AUTO_INCREMENT,
                      user_id int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                      customer_id int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
                      score_id int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
                      cycles tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
                      time int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
                      add_time int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
                      length int(11) NOT NULL DEFAULT '0' COMMENT '长度',
                      PRIMARY KEY (rank_id),
                      KEY user_id (user_id),
                      KEY customer_id (customer_id),
                      KEY score_id (score_id),
                      KEY cycles (cycles),
                      KEY time (time),
                      KEY add_time (add_time),
                      KEY length (length)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
                ";

        $b = $this->execute($sql);
        $b2 = $this->execute($sql2);
        $b3 = $this->execute($sql3);
        $b4 = $this->execute($sql4);
        if($b === false || $b2===false || $b3 === false || $b4===false){
            $this->error = '服务器错误';
            $sql1 = "DROP TABLE IF EXISTS $score_table";
            $sql2 = "DROP TABLE IF EXISTS $rank_y_table";
            $sql3 = "DROP TABLE IF EXISTS $rank_m_table";
            $sql4 = "DROP TABLE IF EXISTS $rank_w_table";
            $this->execute($sql1);
            $this->execute($sql2);
            $this->execute($sql3);
            $this->execute($sql4);
            return false;
        }
        else return true;
    }


    //删除一个客户及其关联表
    public function deleteCustomerInfo($customer_id)
    {
        $condition['customer_id'] = $customer_id;


        $res = $this->where($condition)->field('score_table,rank_y_table,rank_m_table,rank_w_table')->find();

        foreach($res as $v){
            $sql = "DROP TABLE IF EXISTS $v";
            $b = $this->execute($sql);
        }

//        $b = $this->where('customer_id=25')->delete();
        $sql = "delete from customer WHERE customer_id='$customer_id'";
        $b = $this->execute($sql);
        if(!$b){
            exit('服务器错误1');
        }
//        echo $this->_sql();
//        print_r($res);
        return true;
    }
}