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
        $data['device_tabel'] =  $device_table= 'device_'.$code;
        $b = $this->createDeviceTable($device_table = 'device_7484');
        if(!$b){
            $this->error = '设备表创建失败';
            return false;
        }else{
            return $data;
        }
    }
    private function createDeviceTable($table)
    {
        $sql = "CREATE TABLE IF NOT EXISTS $table (
                        customer_id int(11) NOT NULL AUTO_INCREMENT,
                      code char(6) NOT NULL DEFAULT '0' COMMENT '系统生成唯一编码',
                      name varchar(50) NOT NULL DEFAULT '' COMMENT '客户名称',
                      account char(11) NOT NULL DEFAULT '' COMMENT '客户账号',
                      passwd char(32) NOT NULL DEFAULT '' COMMENT '客户密码',
                      agent_id int(11) NOT NULL DEFAULT '0' COMMENT '客户归属',
                      customer_addr varchar(200) NOT NULL DEFAULT '' COMMENT '地址',
                      customer_mobile int(11) NOT NULL DEFAULT '0' COMMENT '联系号码',
                      device_num int(11) NOT NULL DEFAULT '0' COMMENT '设备数量',
                      grade tinyint(4) NOT NULL DEFAULT '3' COMMENT '用户级别',
                      score_table varchar(30) NOT NULL DEFAULT '' COMMENT '对应成绩表',
                      sort_table varchar(30) NOT NULL DEFAULT '' COMMENT '对应成绩排行表',
                      description varchar(50) NOT NULL DEFAULT '' COMMENT '赛道种类',
                      is_show tinyint(4) NOT NULL DEFAULT '1' COMMENT '0屏蔽 1开启',
                      last_login_time timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次登陆时间',
                      last_login_ip varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
                      login_count int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
                      PRIMARY KEY (customer_id)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
                ";
        $b = $this->execute($sql);
        if($b === false) return false;
        else return true;

    }
}