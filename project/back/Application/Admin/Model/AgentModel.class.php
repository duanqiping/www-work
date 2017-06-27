<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2017/6/18
 * Time: 23:05
 */

namespace Admin\Model;


class AgentModel extends ConsumerHandleModel
{
    protected $tableName = 'agent';

    protected $_validate = array(
        array ('name', '1,16', '昵称不能太长', self::EXISTS_VALIDATE, 'length'),
        array('account','/^1[34578][0-9]{9}$/i','请正确填写手机号码','0','regex',1),
        array ('account', '', '该账号已被使用', self::EXISTS_VALIDATE, 'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array (
        array ('passwd', 'md5', self::MODEL_BOTH, 'function'),
        array ('add_time', NOW_TIME, self::MODEL_INSERT),//只能是当前模型的方法
//        array ('is_audit', '1', self::MODEL_INSERT),
    );

    public function getList()
    {
        $condition['is_show'] = 1;
        $info = $this->where($condition)
            ->field('agent_id,account,name,rank,parent_id,agent_address,agent_mobile,last_login_time,last_login_ip')
            ->order('agent_id desc')
            ->select();
        return  $info ;
    }


    //数据完善
//    public function makeData($data)
//    {
//        //生成自己的code
//        $flag = 0;
//        $code = "";
//        while ($flag == 0) {
//            $code = random(4, 0);
//            $count = $this->where(array('code'=>$code))->count();
//            if ($count == 0)//生成的编码没有被使用
//            {
//                $flag = 1;
//            }
//        }
//        $data['code'] = $code;
//        $data['device_tabel'] =  $device_table= 'device_'.$code;
//        $b = $this->createDeviceTable($device_table = 'device_7484');
//        if(!$b){
//            $this->error = '设备表创建失败';
//            return false;
//        }else{
//            return $data;
//        }
//    }
//    private function createDeviceTable($device_table)
//    {
//        $sql = "CREATE TABLE IF NOT EXISTS $device_table(
//                  ms_id int(11) NOT NULL AUTO_INCREMENT,
//                  ms_code varchar(50) NOT NULL DEFAULT '' COMMENT '主机编码',
//                  agent_id int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
//                  customer_id int(11) NOT NUlL DEFAULT '0' COMMENT '客户id',
//                  time timestamp NOT NULL COMMENT '投放时间',
//                  status tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0故障',
//                  detail varchar(500) NOT NULL DEFAULT '' COMMENT '设备详细信息',
//                  PRIMARY KEY (ms_id)
//                ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
//                ";
//        $b = $this->execute($sql);
//        if($b === false) return false;
//        else return true;
//
//    }
}