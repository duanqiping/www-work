<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2015/7/22
 * Time: 15:29
 */
class TempBuyersModel extends BaseModel
{
    protected $fields = array('temp_buyers_id','is_check','temp_buyers_mobile','temp_buyers_password','add_time','nick','is_regist','photo','info','client','role','lastlogin','vip','invitation','invitation_person','company_id','area_id','state','balence_pwd','balence_pwd_time','user_replenish_lock','_pk'=>'temp_buyers_id','_autoinc'=>'true');

    //获取单条信息
    public function getSingleInfo($condition,$field)
    {
        return $res=$this->where($condition)->field($field)->find();
    }

    //判断迷你看图用户，返回number:1 用户密码正确　2 用户存在，密码不正确　3　用户不存在
    public function isMiniUser($name,$password)
    {
        //M('表名','表前缀','数据库连接信息''); 数据库连接信息参数支持格式一 type://username:passwd@hostname:port/DbName
        $user = M('user','va_','mysql://sync_user_127:SrGmsF2529jgS^4@10.25.37.223/vipapps');
        $userpassword = $user->where(array('phone'=>$name))->getField('password');
        if($userpassword){//用户存在
            $num = ($userpassword == $password)?1:2;
        }else{//用户不存在
            $num = 3;
        }
        if($num == 1)
        {//帮在品材注册
            $va_data = array(
                'is_check'=>1,
                'temp_buyers_mobile'=>$name,
                'temp_buyers_password'=>$password,
                'add_time'=>time(),
                'nick'=>$name,
                'lastlogin'=>time(),
                'vip'=>1,
                'invitation'=>random(6,0),
                'invitation_person'=>9
            );
            $newuserid = $this->add($va_data);

            $res =$this->where(array('temp_buyers_id'=>$newuserid))->find();
            if(!$res) return false;
            else return true;
        }
        else if($num == 2){//用户存在密码不正确
            exit('{"success":"false","error":{"msg":"账号或密码不正确","code":"4116"}}');

        }else{
            return false;
        }
    }

    public function getById($buyers_id,$payer_id)
    {
        if($payer_id > 0)
        {
            //该订单为请求代付款订单,也取出代付款人信息
            $condition['temp_buyers_id'] = $buyers_id;
            $res1 = $this -> where($condition) -> field('temp_buyers_id,temp_buyers_mobile,nick') -> find();
            $condition2['temp_buyers_id'] = $payer_id;
            $res2 = $this -> where($condition2) -> field('temp_buyers_id,temp_buyers_mobile,nick') -> find();

            $res[] = $res1;
            $res[] = $res2;
            return $res;
        }
        else{
            $condition['temp_buyers_id']=$buyers_id;
            $res = $this -> where($condition) -> field('temp_buyers_id,temp_buyers_mobile,nick') -> select();
            $res[1] = $res[0];
            return $res;
        }
    }

    //登录 消息推送咱叔需要
    public function login($name, $password)
    {
        $condition['temp_buyers_mobile'] = $name;
        $res = $this->where($condition)->find();
        if($res['temp_buyers_password'] == md5($password))
        {
            return true;
        }
        return false;
    }

//    //开始注册
//    public function checkUser($mobile)
//    {
//        $condition['temp_buyers_mobile'] = $mobile;
//        $res = $this->where($condition)->field('temp_buyers_id,is_check,temp_buyers_mobile,temp_buyers_password,nick,photo,vip,invitation,invitation_person,company_id,area_id')->find();
//        return $res;
//    }

    //验证邀请码是否合法
    public function checkInvitation($invitation)
    {
        $condition['invitation'] = $invitation;
        return $res = $this->where($condition)->field('temp_buyers_id,temp_buyers_mobile,invitation_person,company_id')->find();
    }
    public function reg($data)
    {
        if($this->getSingleInfo(array('temp_buyers_mobile'=>$data['temp_buyers_mobile']),'temp_buyers_id')){
            return false;
        }
        //生成自己的邀请码
        $flag = 0;
        $invitation = "";
        while ($flag == 0) {
            $invitation = random(6, 0);
            $sqlhasinv = "select count(*) from ecs_temp_buyers where invitation='{$invitation}'";
            $rowhasinv = mysql_fetch_row(mysql_query($sqlhasinv));
            if ($rowhasinv[0] == 0)//生成的邀请码没有被使用
            {
                $flag = 1;
            }
        }

        $data['add_time'] = time();
        $data['is_check'] = 1;
        $data['client'] = 2;
        $data['lastlogin'] = time();
        $data['invitation'] = $invitation;//生成自己的邀请码
        $data['temp_buyers_password'] = md5($data['temp_buyers_password']);

        $b = $this->add($data);
        if(!$b)
        {
            return false;
        }else {
            return true;
        }
    }

//    //通过id获取用户信息
//    public function getInfoById($id)
//    {
//        $condition['temp_buyers_id']=$id;
//        $res = $this->where($condition)->field('temp_buyers_id,temp_buyers_mobile,temp_buyers_password,photo,nick,info')->find();
//        return $res;
//    }

    //更新用户信息
    public function updateInfo($data,$id)
    {
        $condition['temp_buyers_id'] = $id;
        return $b = $this->where($condition)->save($data);
    }
}