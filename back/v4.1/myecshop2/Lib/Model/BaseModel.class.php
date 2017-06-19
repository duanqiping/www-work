<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2015/7/24
 * Time: 10:00
 */
class BaseModel extends Model
{
    public $error_info = '错误信息';
    public $error_code = '4800';

    /** $data 可以为数组或字符串*/
    public function printSuccess($data)
    {
        $response = array('success' => 'true', 'data' => $data);
        $response = ch_json_encode($response);
        exit($response);
    }

    /** 打印错误信息*/
    public function printError($msg,$code,$other=null)
    {
        if($code>=5000 && (APP_DEBUG===false) ) $msg = '服务器错误';

        if($other) $response = array('success' => 'false', "error"=>array("msg"=>$msg,'code'=>$code),'data'=>$other);
        else $response = array('success' => 'false', "error"=>array("msg"=>$msg,'code'=>$code));
        $response = ch_json_encode($response);
        exit($response);
    }

    //检查前端post的数据是否合法
    public function checkPostData($b,$msg,$code)
    {
        if($b)
        {
            $response = array('success' => 'false', "error"=>array("msg"=>$msg,'code'=>$code));
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            return true;
        }
    }

    //通过area_id获取对应的goods_table
    public function getGoodsTable($area_id,$type)
    {
        $db_name = C('DB_NAME');
        if($type == 2)
        {
            return 'b2b_pcy_goods';
        }
        else
        {
            $sql = "select goods_table from $db_name.ecs_goods_area WHERE goods_area_id=".$area_id;
            $res = $this->query($sql);
            return $res[0]['goods_table'];
        }
    }
    //通过area_id获取对应的goods_table (d待去除)
    public function GoodsAreaInfo($area_id)
    {
        $db_name = C('DB_NAME');
        $sql = "select * from $db_name.ecs_goods_area WHERE goods_area_id=".$area_id;
        $res = $this->query($sql);
        return $res[0];
    }

    //判断登录状态   使用于一些必须要登录的接口
    public function is_login()
    {
        //token  找材猫用户对应的token
        if(isset($_POST['token']))// 传了参数 token
        {
            $token = passport_decrypt($_POST['token'], 'qiping');

            $newstr = explode("@",$token);//$user_id= $newstr[1]; 用户的temp_buyers_id号
            $old_time=$newstr[2];
            $temp_buyers_id = $newstr[1];
            //判断token是否过期
            if(time()-3600*24*7 > $old_time)
            {
                $response = array("success"=>"false","error"=>array("msg"=>'token已经过期','code'=>4150));
                $response = ch_json_encode($response);
                exit($response);
            }
            //判断用户是否存在  存在并把用户信息保存 到session中
            $db_name = C('DB_NAME');
            $sql = "select * from $db_name.ecs_temp_buyers WHERE temp_buyers_id='$temp_buyers_id'";
            $res = $this->query($sql);
            $res = $res[0];

            if(!$res)
            {
                $response = array("success"=>"false","error"=>array("msg"=>'用户不存在','code'=>4116));
                $response = ch_json_encode($response);
                exit($response);
            }
            //把用户的信息保存到session中
            $_SESSION['temp_buyers_id'] = $res['temp_buyers_id'];
            $_SESSION['temp_buyers_mobile'] = $res['temp_buyers_mobile'];
            $_SESSION['nick'] = $res['nick'];
            $_SESSION['photo'] = $res['photo'];
            $_SESSION['vip'] = $res['vip'];
            $_SESSION['invitation'] = $res['invitation'];
            $_SESSION['info'] = $res['info'];
            $_SESSION['temp_buyers_password'] = $res['temp_buyers_password'];

        }
        //b2b_token  供应商对应的用户(供应商有些接口会调找材猫中的接口)
        else if(isset($_POST['b2b_token']))
        {
            $token = passport_decrypt($_POST['b2b_token'], 'qiping');

            $newstr = explode("@",$token);//$user_id= $newstr[1]; 用户的temp_buyers_id号
            $old_time=$newstr[2];
            $user_id = $newstr[1];
            //判断token是否过期
            if(time()-3600*24*7 > $old_time)
            {
                $response = array("success"=>"false","error"=>array("msg"=>'token已经过期','code'=>4150));
                $response = ch_json_encode($response);
                exit($response);
            }

            $sql = "SELECT `user_id`,`role_id`,`category_id`,`password`,`shop_sn`,`access_time`,`status`,`name`,`telephone`,`img`,`salt`,`sex`,`email`,`address`,`pcy_companyname`,`pcy_company_person`,`default_cms_supplier_id`,`temp_buyers_id` FROM pcwb2bs.b2b_user WHERE user_id='$user_id' LIMIT 1  ";
            $res = $this->query($sql);
            $res = $res[0];
            // 保存电商的 session 信息
            $_SESSION['admin']= array(
                "id"=>$res['user_id'],
                'supplier_id' =>$res['default_cms_supplier_id'],
                'role_id'=>$res['role_id'],
                'category_id'=>$res['category_id'],
                'access_time'=>$res['access_time'],
                'telephone'=>$res['telephone'],
                'address'=>$res['address'],
                'temp_buyers_id'=>$res['temp_buyers_id']
            );
            return;
        }
        else
        {
            if( !(isset($_SESSION['temp_buyers_id'])&&$_SESSION['temp_buyers_id']>0) && !(isset($_SESSION['admin']['id']) && $_SESSION['admin']['id'] > 0) ){
                $response = array("success"=>"false","error"=>array("msg"=>'你还没有登录','code'=>4120));
                $response = ch_json_encode($response);
                exit($response);
            }
        }

    }

    //判断登录状态   适用于一些 没必要登录的接口
    public function is_if_login()
    {
        $token = passport_decrypt($_POST['token'], 'qiping');
        $newstr = explode("@",$token);//$user_id= $newstr[1]; 用户的temp_buyers_id号
        $old_time=$newstr[2];
        $temp_buyers_id = $newstr[1];

        if(time()-time()-3600*24*7 > $old_time) ////判断token是否过期
        {
            return false;
        }
       //判断用户是否存在  存在并把用户信息保存 到session中
        $db_name = C('DB_NAME');
        $sql = "select * from $db_name.ecs_temp_buyers WHERE temp_buyers_id='$temp_buyers_id'";
        $res = $this->query($sql);
        $res = $res[0];
        if(!$res)
        {
            return false;
        }
        //把用户的信息保存到session中
        $_SESSION['temp_buyers_id'] = $res['temp_buyers_id'];
        $_SESSION['temp_buyers_mobile'] = $res['temp_buyers_mobile'];
        $_SESSION['nick'] = $res['nick'];
        $_SESSION['photo'] = $res['photo'];
        $_SESSION['vip'] = $res['vip'];
        $_SESSION['invitation'] = $res['invitation'];
        $_SESSION['info'] = $res['info'];
        $_SESSION['temp_buyers_password'] = $res['temp_buyers_password'];


    }

    //2015：10：1 后消费达到一定程度后，商品的价格给一定的优惠价
    public function getRate($type){

//        //主材 在 南京 哈尔滨 没有优惠，价钱反而偏高
//        if($type == 2 && ($_POST['area_id'] == 2 || $_POST['area_id'] == 6))
//        {
//            return 1.1;
//        }

        if($type == 1 && $_POST['area_id']==2)//南京对应的辅材
        {
            return 1;

            $sqlmoney1="select sum(money) as money from ecs_temp_purchase where state=4 and buyers_id=".$_SESSION['temp_buyers_id']." and suppliers_id=1152 and time>=1446307200";
            $sqlmoney2="select sum(money) as money from ecs_temp_purchase where state=4 and suppliers_id=1152 and buyers_id in (select temp_buyers_id from ecs_temp_buyers where invitation_person=".$_SESSION['temp_buyers_id'].") and time>=1446307200";

            $sum1 = $this->query($sqlmoney1);
            $sum2 = $this->query($sqlmoney2);

            if($sum1[0]['money']==null or !is_numeric($sum1[0]['money']))
            {
                $sum1[0]['money']=0;
            }

            if($sum2[0]['money']==null or !is_numeric($sum2[0]['money']))
            {
                $sum2[0]['money']=0;
            }

            $sum = $sum1[0]['money']+$sum2[0]['money'];
            if($_SESSION['temp_buyers_id']==1086)
            {
                return 1;
            }
            else {
                if ($sum < 30000) {
                    //$_SESSION['rate']=1;
                    return 1;
                }
                if ($sum >= 30000 and $sum < 80000) {
                    //$_SESSION['rate']=0.99;
                    return 0.99;
                }
                if ($sum >= 80000) {
                    //$_SESSION['rate']=0.98;
                    return 0.98;
                }
            }
        }

        else
        {
            return 1;
        }


    }

    //返回CompanyID
    public function returnCompanyId()
    {
        $company_id = 0;
        $db_name = C('DB_NAME');
        if($_SESSION['temp_buyers_id']>0)
        {
            $sql = "select company_id from $db_name.ecs_temp_buyers where temp_buyers_id=".$_SESSION['temp_buyers_id'];
            $res = $this->query($sql);
            $company_id = $res[0]['company_id'];
        }
        return $company_id;
    }

    //返回companyCount
    public function returnCompanyCount($company_id)
    {
        //经测试 find_in_set ('".$company_id."',companies)" 相当于$company_id in()的用法 egg 12 in (0,12)
        $company_show="select count(*) from $this->tableName where find_in_set ('".$company_id."',companies)";//companies字段值 '0' '0,12'
        $res_show  = $this->query($company_show);
        $company_count = $res_show[0]['count(*)'];

        return $company_count;
    }

    //取出商品表 对应的 price 字段  type=1辅材2批发  $b是否首次下单 $role用户表中的role
    public function returnPriceField($type,$area_id,$brand_id,$database_type)
    {
        $db_name = C('DB_NAME');

        $buyer_info = array();
        if($_SESSION['temp_buyers_id']>0)
        {
            $sql = "select invitation_person,role,company_id from $db_name.ecs_temp_buyers where temp_buyers_id=".$_SESSION['temp_buyers_id'];
            $res = $this->query($sql);
            $buyer_info['invitation_person'] = $res[0]['invitation_person'];
            $buyer_info['company_id'] = $res[0]['company_id'];
        }
        $invitation_person = $buyer_info['invitation_person'];
        $company_id = $buyer_info['company_id'];

        if( $database_type==1 )
        {
            $buyer_info = array();
            $buyer_info['invitation_person'] = 0;
            $buyer_info['role'] = 0;

            //找材猫
//            if($brand_id==324 || $brand_id==323) return 'first_buy_price';

            //$b  false->非首次下单  true->首次下单
            $sql = "select count(*) as count from $db_name.ecs_temp_purchase pu LEFT JOIN $db_name.ecs_temp_purchase_goods po ON pu.temp_purchase_id=po.temp_purchase_id where pu.buyers_id='{$_SESSION['temp_buyers_id']}' and pu.suppliers_id='1024' and po.area_id=1 and pu.state BETWEEN 2 AND 7";
            $res_count = $this->query($sql);

            if($res_count[0]['count']>=1) $b=false;//非首次下单
            else $b=true;//首次下单

            if($b && $area_id==1 && $type==1 && $invitation_person>1 && $company_id!=11)
            {
                return 'first_buy_price';
            }
            else
            {
                if($company_id==11 && $type==1 && $area_id==1) return 'shop_price';
                else if($invitation_person < 1)  return 'public_price';
                else return 'shop_price';
            }
        }
        else
        {
            if($invitation_person >=1 ) return 'shop_price';
            else return 'public_price';
        }


    }
    public function redis()
    {
        $redis = new Redis();
        $conn = $redis->connect('localhost','6379');

        if(!$conn) return false;
        $redis->auth('w1tU$O^6%h5knzZN');

        return $redis;
    }

}