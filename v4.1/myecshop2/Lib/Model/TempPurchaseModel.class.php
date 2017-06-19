<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2015/7/23
 * Time: 18:27
 */
class TempPurchaseModel extends BaseModel
{
    public $tableName = 'ecs_temp_purchase';
    protected $fields = array('temp_purchase_id', 'temp_purchase_sn', 'temp_inquiry_id', 'buyers_id', 'suppliers_id', 'suppliers_name', 'suppliers_alipay', 'area_id', 'time', 'money', 'account_money', 'name', 'mobile', 'address', 'state', 'description', 'receive_time', 'finish_time', 'method', 'transportation', 'temp_buyers_address_id', 'bank_id', 'bank_name', 'purchase_title', 'quotation_id', 'is_read', 'send_time', 'picture', 'is_delete', 'is_comment', 'request_id', 'delivery_time', 'suppliers_remarks', 'actually_money', 'difference_money', 'pay_time', 'payer_id', 'region_id', 'replenish_state','client','withdraw_rate', '_pk' => 'temp_purchase_id', 'autoinc' => true);

    public function __construct($database_type)
    {
        parent::__construct();
        if ($database_type == 2)
        {
            $this->db(1, 'DB_CONFIG1');
            $this->tableName = 'b2b_pcy_purchase';
        }
    }

        //订单公用model(单个订单)
    public function OrderSingleModel($condition, $field)
    {
        return $this->where($condition)->field($field)->find();
    }

    //获取订单信息（单个）
    public function getSingleInfo($condition, $fields)
    {
        return $res = $this->table($this->tableName)->where($condition)->field($fields)->find();

    }

    //获取订单信息（多个）
    public function getMultipleInfo($condition, $fields)
    {
        return $res = $this->table($this->tableName)->where($condition)->field($fields)->select();

    }

    //获取供应商信息  $suppliers_id为商品表中的suppliers_id,其在找材猫和品材宝的含义不同
    public function SuppliersInfo($database_type,$suppliers_id,$goods_id)
    {
        $suppliersInfo = array();
        if($database_type == 2)
        {
            $sql_suppliers = "select bg.suppliers_id,bg.suppliers_name,bu.pcy_companyname,bu.pcw_withdraw_rate withdraw_rate from pcwb2bs.b2b_pcy_goods bg LEFT JOIN pcwb2bs.b2b_user bu ON bg.suppliers_id=bu.user_id  where goods_id='$goods_id'";
            $res_suppliers = $this->query($sql_suppliers);
            $suppliersInfo['suppliers_id'] = $res_suppliers[0]['suppliers_id'];
            $suppliersInfo['suppliers_name'] = $res_suppliers[0]['pcy_companyname'];
            $suppliersInfo['withdraw_rate'] = $res_suppliers[0]['withdraw_rate'];//汇率（仅品材宝）
        }
        else{
            $suppliers = M('suppliers');
            //因为是分别下单，所以可以去第一个商品的suppliers_id就可以到supplers表中判断供应商的id号
            $res = $suppliers->where("suppliers_id=$suppliers_id")->field('temp_buyers_id')->find();
            if ($res['temp_buyers_id'] == 1032 || $res['temp_buyers_id'] == 5060) $suppliersInfo['suppliers_id'] = 1024;
            else $suppliersInfo['suppliers_id'] = $res['temp_buyers_id'];
            $suppliersInfo['suppliers_name'] = '找材猫';//写死 供应商名
        }
        return $suppliersInfo;
    }

    //获取订单地址等信息
    public function getAddressInfo($order_id)
    {
        //是补单，地址信息从父订单中获取
        if($order_id)
        {
            $b = $this->is_add_update($_SESSION['temp_buyers_id']);
            if(!$b){$this->error_info='补单过了时间限制,请重新下单';$this->error_code=4557;return false;}

            //如果是补货子订单，地址信息则取要进行补货订单的地址信息
            $res_address = $this->getSingleInfo(array('temp_purchase_id'=>$order_id),'temp_purchase_sn,name,mobile,region_id,address');
            $arr['name'] = $res_address['name'];
            $arr['mobile'] = $res_address['mobile'];
            $arr['region_id'] = $res_address['region_id'];
            $arr['address'] = $res_address['address'];

            $arr['suppliers_remarks'] = '该订单是订单号为 '.$res_address['temp_purchase_sn'].' 的补货订单';
        }
        //不是补单，地址信息从地址列表中获取
        else
        {
            $db_name = C('DB_NAME');
            $sql_address = "select * from $db_name.ecs_temp_buyers_address WHERE temp_buyers_address_id=".$_POST['temp_buyers_address_id'];
            $res_address = $this->query($sql_address);

            if(!$res_address){$this->error_info='送货地址无效';$this->error_code=4800;return false;}

            $arr['name'] = $res_address[0]['name'];
            $arr['mobile'] = $res_address[0]['mobile'];
            $arr['region_id'] = $res_address[0]['region_id'];
            $arr['address'] = $res_address[0]['province'].' '.$res_address[0]['city'].' '.$res_address[0]['district'].' '.$res_address[0]['short_address'];
        }
        return $arr;
    }

    /**是否可以补货函数判断 0不准补货 1可以补货   2补货进行中 */
    public function is_add($temp_purchase_id, $state, $pay_time, $area_id)
    {
        $temppurchasegoodsadd = M('tempPurchaseGoodsAdd');
        $count = $temppurchasegoodsadd->where(array('temp_purchase_new_id' => $temp_purchase_id))->count();
        if ($count > 0) return 2;//说明是补货的子订单,不允许进行补货

//        if ($replenish_state == 1 && $state == 2 && $area_id != 10) {
//            return 1;
//        }
        if ($state == 2 && $area_id != 10) {
            date_default_timezone_set('PRC');
            $time = time();
            $pay_time = intval($pay_time);
            $is_time = buHuoTime();//当天15:30:00

            //当日时间已经过了15:30:00
            if ($time > $is_time) {
                if ($pay_time < $is_time) return 0;//支付时间在当日15:30:00
                else return 1;
            } else {
                //当日时间已经没过15:30:00
                $back_time = $is_time - 1 * 24 * 3600;
                if ($pay_time < $back_time) return 0;//支付时间发生在昨天15：30之前
                else return 1;////支付时间发生在昨天15：30之后，今天还没到15：30
            }
        } else {
            return 0;
        }
    }
    //清楚无效的子订单 及 补货订单
    public function cleanOrder($uid)
    {
        date_default_timezone_set('PRC');
        $time = time();
        $is_time = buHuoTime();

        //查询是否有补货的父订单
        $condition['replenish_state'] = 1;
        $condition['buyers_id'] = $uid;
        $condition['state'] = 2;
        $condition['is_delete'] = 0;
        $res = $this->table($this->tableName)->where($condition)->field('temp_purchase_id,pay_time')->find();
        if($res)
        {
            $pay_time = $res['pay_time'];
            //当日时间已经过了15:30:00
            if ($time > $is_time)
            {
                //支付时间在当天15：30之前
                if ($pay_time < $is_time)
                {
                    $this->table($this->tableName)->where(array('temp_purchase_id'=>$res['temp_purchase_id']))->save(array('replenish_state'=>0));
                }
            }
            else
            {
                $back_time = $is_time - 1 * 24 * 3600;//前一天的15：30

                //支付时间发生在昨天15：30之前
                if ($pay_time < $back_time)
                {
                    $this->table($this->tableName)->where(array('temp_purchase_id'=>$res['temp_purchase_id']))->save(array('replenish_state'=>0));
                }
            }
        }

        //当日时间已经过了15:30:00
        if ($time > $is_time) $sql_time = $is_time;
        else  $sql_time = $is_time - 1 * 24 * 3600;//前一天的15：30

        //删除无效的待付款子订单
        $sql = "select p.temp_purchase_id from ecs_temp_purchase p where p.buyers_id='$uid' and p.state=1 AND p.is_delete=0 AND time<'$sql_time' AND EXISTS (SELECT a.temp_purchase_id FROM ecs_temp_purchase_goods_add a WHERE a.temp_purchase_new_id = p.temp_purchase_id)";
        $res_p = $this->query($sql);
        for($i = 0,$len=count($res_p);$i<$len;$i++)
        {
            $condition_c['temp_purchase_id'] = $res_p[$i]['temp_purchase_id'];
            $this->table($this->tableName)->where($condition_c)->save(array('state'=>0));
        }
    }

    //对补货订单时效性进行处理(订单列表接口、去结算接口)
    public function is_add_update($uid)
    {
        //取出补货订单

        $condition['replenish_state'] = 1;
        $condition['buyers_id'] = $uid;
        $condition['state'] = 2;
        $condition['is_delete'] = 0;
        $res = $this->table($this->tableName)->where($condition)->field('temp_purchase_id,pay_time')->find();

        if (!$res) return false; //不存在补货单,直接返回
        
        $pay_time = intval($res['pay_time']);//支付时间
        $temp_purchase_id = $res['temp_purchase_id'];

        date_default_timezone_set('PRC');
        $time = time();
        $is_time = buHuoTime();

        //当日时间已经过了15:30:00
        if ($time > $is_time) {
            //支付时间在当天15：30之前
            if ($pay_time < $is_time)
            {
                $temppurchasegoodsadd = M('tempPurchaseGoodsAdd');
                $sql = "SELECT p.temp_purchase_id,p.state FROM ecs_temp_purchase_goods_add a LEFT JOIN ecs_temp_purchase p on a.temp_purchase_new_id=p.temp_purchase_id WHERE a.temp_purchase_id = '$temp_purchase_id' GROUP by a.temp_purchase_new_id ";
                $res_children = $temppurchasegoodsadd->query($sql);
                $flag = 0;
                for ($i = 0, $len = count($res_children); $i < $len; $i++) {
                    if ($res_children[$i]['state'] == 1) {
                        //取消子订单
                        $this->where(array('temp_purchase_id' => $res_children[$i]['temp_purchase_id']))->save(array('state' => 0));
                    }
                    if ($res_children[$i]['state'] == 2) {
                        $flag = 1;
                    }
                }
                if ($flag == 0 || !$res_children) {
                    //表示没有一个子订单在当日15：30之前付款,或者没有子订单的情况下，取消补货
                    $this->table($this->tableName)->where(array('temp_purchase_id' => $res['temp_purchase_id']))->save(array('replenish_state' => 0));
                }
                return false;
            } else {
                return true;//支付时间在当天15：30之后
            }
        } //当日时间已经没有过15:30:00
        else {
            $back_time = $is_time - 1 * 24 * 3600;//前一天的15：30

            //支付时间发生在昨天15：30之前
            if ($pay_time < $back_time)
            {
                $temppurchasegoodsadd = M('tempPurchaseGoodsAdd');
                $sql = "SELECT p.temp_purchase_id,p.state FROM ecs_temp_purchase_goods_add a LEFT JOIN ecs_temp_purchase p on a.temp_purchase_new_id=p.temp_purchase_id WHERE a.temp_purchase_id = '$temp_purchase_id' GROUP by a.temp_purchase_new_id ";
                $res_children = $temppurchasegoodsadd->query($sql);
                $flag = 0;
                for ($i = 0, $len = count($res_children); $i < $len; $i++)
                {
                    if ($res_children[$i]['state'] == 1) {
                        //取消子订单
                        $this->where(array('temp_purchase_id' => $res_children[$i]['temp_purchase_id']))->save(array('state' => 0));
                    }
                    if ($res_children[$i]['state'] == 2) {
                        $flag = 1;
                    }

                }
                if ($flag == 0 || !$res_children) {

                    //表示没有一个子订单在当日15：30之前付款,或者没有子订单的情况下，取消补货
                    $this->table($this->tableName)->where(array('temp_purchase_id' => $res['temp_purchase_id']))->save(array('replenish_state' => 0));
                }
                return false;
            } else  return true;//支付时间发生在昨天15：30之后
        }
    }

    //查看是否有补货订单，有则返回补单详情
    public function getBuHuoDetail($uid)
    {
        $b = $this->is_add_update($uid);//查看是否存在补单操作并对其时效性进行判断

        if($b)
        {
            $purchase_add = null;
            //查看用户订单中是否有补货订单
            $sql = "select temp_purchase_id from ecs_temp_purchase WHERE buyers_id='$uid' and state=2 and is_delete=0 and replenish_state=1";
            $res = $this -> query($sql);
            $temp_purchase_id = $res[0]['temp_purchase_id'];
            if($temp_purchase_id>0)
            {
                //有补货订单
                $purchase_add = $this->getById($temp_purchase_id,1);//通过订单id 获取订单详情

                $temppurchasegoods = new TempPurchaseGoodsModel(1);
                $sql = "select goods_table,goods_category_table from ecs_goods_area where goods_area_id='{$purchase_add['area_id']}'";
                $res_table = $this->query($sql);

                $data2 = $temppurchasegoods->getByTempGoodsId($temp_purchase_id,1,$res_table[0]);//通过id 获取订单商品信息

                $purchase_add['goods'] = $data2;//把两个数组合并成一个数组
            }
            return $purchase_add;
        }
        else
        {
            return null;
        }

    }

    //ru
    public function updateFatherSn($id)
    {
        $sql_s = "select * from ecs_temp_purchase_goods_add WHERE temp_purchase_new_id='$id' limit 1";
        $res = $this->query($sql_s);
        $res = $res[0];
        if($res)
        {
            //把父订单的replenish_state置为0
            $sql_u = "update ecs_temp_purchase set replenish_state=0 WHERE temp_purchase_id='{$res['temp_purchase_id']}'";
            $this->execute($sql_u);
        }
        return;
    }

    //快捷支付 获取需要支付的钱
    public function getMoney($order_sn)
    {
        $condition['temp_purchase_sn'] = $order_sn;
        $orderinfo = $this -> where($condition) -> field('money,account_money,state') -> find();

        if(!$orderinfo){
            $msg = '无此订单信息';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
        }
        if($orderinfo['state']!=1){
            $msg = '订单状态应该为待支付';
            $response = array("success"=>"false","error"=>array("msg"=>$msg,'code'=>4800));
            $response = ch_json_encode($response);
            exit($response);
        }
        $total_fee = $orderinfo['money']-$orderinfo['account_money'];

        return $total_fee;
    }

    //通过订单ID更改method和state
    public function updateByID($temp_purchase_id)
    {
        $data['method'] = 1;
        $data['state'] =2;
        $data['pay_time'] = time();
        $condition['temp_purchase_id'] = $temp_purchase_id;

        $b = $this ->table($this->tableName)->where($condition) ->data($data) -> save();
        if(!$b){$this->error_info = '订单状态更新失败';$this->error_code=5001;}

        //往temp_payment表和temp_account表中插入数据
        $arr = array();
        $res1 = $this ->table($this->tableName) -> where($condition) -> field('temp_purchase_sn,suppliers_id,time,money,name,mobile') -> find();

        $arr['temp_purchase_sn'] = $res1['temp_purchase_sn'];
        $arr['user_id'] = $res1['suppliers_id'];
        $arr['time'] = $res1['time'];
        $arr['money'] = $res1['money'];
        $arr['from_user'] = $res1['mobile'];

        $arr['to_user'] = '品材网支付';
        $arr['to_account'] = 'hbz@pcw268.com';
        $arr['method'] = -1;
        $arr['type'] = 5;
        $arr['client_from'] = 1;

        $temppayment = new TempPaymentModel(1);
        $b = $temppayment->table($temppayment->tableName)->add($arr);
        if(!$b) {$this->error_info='货到付款入库失败';$this->error_code=5002;}
        else  return true;
    }

    //通过订单号获取订单详情(订单详情接口、去结算接口)
    public function getById($temp_purchase_id,$database_type)
    {
        $condition['temp_purchase_id'] = $temp_purchase_id;

        $dbname = C('DB_NAME');
        if($database_type == 1)
        {
            $sql = "select p.temp_purchase_id,p.temp_purchase_sn,p.buyers_id,p.time,p.area_id,p.money,p.name,p.temp_buyers_address_id,p.address,p.mobile,p.state,p.method,p.description,p.receive_time,p.finish_time,p.method,p.transportation,p.account_money,p.payer_id,p.pay_time,p.is_comment,p.region_id,a.province,a.city,a.district from $this->tableName p LEFT JOIN ecs_temp_buyers_address a ON p.temp_buyers_address_id=a.temp_buyers_address_id WHERE p.temp_purchase_id=".$temp_purchase_id;
        }
        else
        {
            $sql = "select p.temp_purchase_id,p.temp_purchase_sn,p.buyers_id,p.time,p.area_id,p.money,p.name,p.temp_buyers_address_id,p.address,p.mobile,p.state,p.method,p.description,p.receive_time,p.finish_time,p.method,p.transportation,p.account_money,p.payer_id,p.pay_time,p.is_comment,p.region_id,pu.user_id,pu.telephone,pu.img,pu.address b2b_address,pu.pcy_companyname,pu.pcy_company_person,pu.qq,pu.weixinid,pu.pcy_company_area,pu.pcy_company_cashtype,pu.pcy_company_sellinfo,pu.receive_time b2b_receive_time,a.province,a.city,a.district from pcwb2bs.b2b_pcy_purchase p LEFT JOIN pcwb2bs.b2b_user pu ON p.suppliers_id=pu.user_id LEFT JOIN $dbname.ecs_temp_buyers_address a ON p.temp_buyers_address_id=a.temp_buyers_address_id WHERE p.temp_purchase_id=".$temp_purchase_id;
        }

        $res = $this->query($sql);
        $res = $res[0];
        $res['database_type'] = $database_type;

        //这个主要处理退款（退款money将置为0）
        $res['money'] = ($res['account_money']>$res['money'])?$res['account_money']:$res['money'];

        $res['is_add'] = $this->is_add($res['temp_purchase_id'],$res['state'],$res['pay_time'],$res['area_id']);//自定义补货字段信息
        $res['replenish_state'] = 0;
        if($database_type == 1)
        {
            if($res['is_add'] == 2){$res['is_add']=0;$res['replenish_state']=1;}//如果返回的是2,说明是子订单，此处的replenish_state实际上和订单表中的replenish_state没有关系

            $res['suppliersinfo']['user_id'] = '1024';
            $res['suppliersinfo']['telephone'] = '4006002063';
            $res['suppliersinfo']['pcy_companyname'] = '上海晓材科技有限公司';
            $res['suppliersinfo']['pcy_company_person'] = '上海晓材科技有限公司';
        }
        else
        {
            $res['is_add']=0;//
            $res['replenish_state'] = 0;
            $res['receive_time'] = $res['b2b_receive_time'];

            if($res['pcy_company_cashtype'] == 'ONLY_CASH') $res['pcy_company_cashtype'] = '仅现结支付';
            else if($res['pcy_company_cashtype'] == 'CASH_AND_COD') $res['pcy_company_cashtype'] = '现结及货到付款';
            else $res['pcy_company_cashtype'] = false;

            $res['suppliersinfo']['user_id'] = $res['user_id'];
            $res['suppliersinfo']['telephone'] = $res['telephone'];
            $res['suppliersinfo']['pcy_companyname'] = $res['pcy_companyname'];
            $res['suppliersinfo']['pcy_company_person'] = $res['pcy_company_person'];
            $res['suppliersinfo']['img'] = b2bImgDeal($res['img']);
            $res['suppliersinfo']['address'] = $res['b2b_address'];
            $res['suppliersinfo']['qq'] = $res['qq'];
            $res['suppliersinfo']['weixinid'] = $res['weixinid'];
            $res['suppliersinfo']['pcy_company_cashtype'] = $res['pcy_company_cashtype'];
            $res['suppliersinfo']['pcy_company_sellinfo'] = $res['pcy_company_sellinfo'];
            unset($res['user_id']);
            unset($res['telephone']);
            unset($res['pcy_companyname']);
            unset($res['pcy_company_person']);
            unset($res['img']);
            unset($res['b2b_address']);
            unset($res['qq']);
            unset($res['weixinid']);
            unset($res['pcy_company_cashtype']);
            unset($res['pcy_company_sellinfo']);
        }

        if( ($res['buyers_id'] != $_SESSION['temp_buyers_id']) && ($res['payer_id'] != $_SESSION['temp_buyers_id']) && ($res['state'] == 1) ) exit('{"success":"false","error":{"msg":"已经取消代付","code":"4162"}}');
        if( ($res['buyers_id'] != $_SESSION['temp_buyers_id']) && ($res['payer_id'] != $_SESSION['temp_buyers_id']) && ($res['state'] == 0) ) exit('{"success":"false","error":{"msg":"订单已经取消","code":"4158"}}');

        $tempbuyers = new TempBuyersModel();
        $data1 = $tempbuyers -> getById($res['buyers_id'],$res['payer_id']);//购买者0, 支付者1
        $res['buyersinfo']['temp_buyers_id'] = $res['buyers_id'];
        $res['buyersinfo']['temp_buyers_mobile'] = $data1[0]['temp_buyers_mobile'];
        unset($res['buyers_id']);
        $res['buyersinfo']['nick'] = $data1[0]['nick'];
        
        if($res['payer_id'] > 0)
        {
            $res['payuserinfo']['temp_buyers_id'] = $data1[1]['temp_buyers_id'];
            $res['payuserinfo']['temp_buyers_mobile'] = $data1[1]['temp_buyers_mobile'];
            $res['payuserinfo']['nick'] = $data1[1]['nick'];
        }
        else{
            $res['payuserinfo']['temp_buyers_id'] = $data1[0]['temp_buyers_id'];
            $res['payuserinfo']['temp_buyers_mobile'] = $data1[0]['temp_buyers_mobile'];
            $res['payuserinfo']['nick'] = $data1[0]['nick'];
        }

        $res['addressinfo']['id'] = $res['temp_buyers_address_id'];
        $res['addressinfo']['temp_buyers_address_id'] = $res['temp_buyers_address_id'];
        $res['addressinfo']['name']=$res['name'];
        $res['addressinfo']['address']=$res['address'];
        $res['addressinfo']['mobile']=$res['mobile'];

        $res['addressinfo']['province']=null;
        $res['addressinfo']['city']=null;
        $res['addressinfo']['district']=null;
        $res['addressinfo']['region_id']=$res['region_id'];
        unset($res['name']);
        unset($res['address']);
        unset($res['province']);
        unset($res['city']);
        unset($res['district']);
        unset($res['region_id']);
        return $res;
    }


    //通过订单ID获取订单详情
    public function getByTempId($temp_purchase_id,$database_type)
    {
        $condition['temp_purchase_id'] = $temp_purchase_id;

        $res = $this -> table($this->tableName) -> where($condition) -> field('temp_purchase_id,buyers_id,suppliers_id,temp_purchase_sn,name,time,money,mobile,transportation,method,address,state,receive_time,description,account_money') -> find();
        $res['database_type'] = $database_type;
        $res['addressinfo']['name']=$res['name'];
        $res['addressinfo']['address']=$res['address'];
        $res['addressinfo']['mobile']=$res['mobile'];
        unset($res['name']);
        unset($res['address']);
        unset($res['mobile']);
        return $res;
    }


    //生成订单
    public function tempPurchaseAdd($data)
    {
        $order_id = $this -> table($this->tableName)-> data($data) -> add();//插入成功时返回的就是 自增的id号
        if(!$order_id)
        {
            $this -> rollback();//失败 回滚
            $this->error_info = '订单入库失败';
            $this->error_code = 5001;
            return false;
        }
        if($_POST['use_balance'])//使用了余额支付, 要往payment表中插入一条记录
        {
            $condition_purchase['temp_purchase_id'] = $order_id;
            $res_purchase = $this-> table($this->tableName)->where($condition_purchase)->field('temp_purchase_sn')->find();

            $sql = "select p.account_money,p.money,p.suppliers_id,p.buyers_id,p.state,p.temp_purchase_id,p.purchase_title,b.vip,b.temp_buyers_mobile from ecs_temp_purchase p left join ecs_temp_buyers b on b.temp_buyers_id = p.suppliers_id where p.temp_purchase_sn = '{$res_purchase['temp_purchase_sn']}'";
            $res_info = $this->query($sql);
            $res_info = $res_info[0];

            $time = time();
            $sql1 = "insert into ecs_temp_payment (temp_purchase_sn,time,from_user,to_user,to_account,type,user_id,money,client_from) values ('{$res_purchase['temp_purchase_sn']}','$time','{$res_info['temp_buyers_mobile']}','品材网支付','hbz@pcw268.com',11,'{$res_info['suppliers_id']}','{$res_info['account_money']}',1)";
            $b1 = $this->execute($sql1);

            if(!$b1)
            {
                $this -> rollback();//失败 回滚
                $this->error_info = '扣款失败';
                $this->error_code = 5002;
                return false;
            }
        }
       return $order_id;
    }

    //删除购物车中的商品
    public function deleteShopcarInfo($goods,$database_type)
    {

        $where = '(';
        for ($i=0,$len=count($goods); $i < $len; $i++)
        {
            if($i==$len-1) $where .= $goods[$i]['shop_car_id'].')';
            else $where .= $goods[$i]['shop_car_id'].',';
        }

        $db = C('DB_NAME');
        if($database_type == 1) $sql = "delete from $db.ecs_shopcar WHERE shop_car_id in $where";
        else $sql = "delete from pcwb2bs.b2b_pcy_shopcar WHERE shop_car_id in $where";

        $this->execute($sql);
    }

    //订单列表
    public function orderList($state, $uid, $type, $page = 1, $limit = 5)
    {
        //偏移量
        $offset = ($page - 1) * $limit;

        $condition = "p.is_delete=0";//条件
        if ($type == 1)
        {
            $condition = $condition." and p.buyers_id=$uid";//买家

            if ($state == 5)  $condition = $condition." and state in (5,6,7)";//退款
            else if ($state == "") $condition = $condition." and state in (0,1,2,3,4,5,6,7)";//全部订单
            else if ($state == 2) $condition = $condition." and state=2";//待发货
            else if ($state == 4) $condition = $condition." and state=4";//已经确认收货
            else $condition = "(buyers_id=$uid or payer_id=$uid) and state='$state'";//待付款
        }
        else
        {
            $condition = $condition." and p.suppliers_id=$uid";//卖家
            if ($state == 5) $condition['state'] = $condition = $condition." and state in (5,6,7)";//退款
            else if ($state == "") $condition['state'] = $condition = $condition." and state in (0,1,2,3,4,5,6,7)";//全部订单
            else if ($state == 4) $condition = $condition." and state in (0,1,2,3,4)";//
            else  $condition = $condition." and state='$state'";//
        }
        //add_type 作为一个数据库标识 1表示找材猫 2表示品材宝
        $sql = "select * FROM ( (SELECT 1 as database_type, p.temp_purchase_id,p.temp_purchase_sn,p.buyers_id,p.suppliers_id,p.suppliers_name,p.time,p.area_id,p.receive_time,p.money,p.account_money,p.name,p.mobile,p.address,p.state,p.description,p.method,p.temp_buyers_address_id,p.transportation,p.is_comment,p.payer_id,p.pay_time,p.region_id,a.province,a.city,a.district FROM ecs_temp_purchase p LEFT JOIN ecs_temp_buyers_address a on p.temp_buyers_address_id=a.temp_buyers_address_id WHERE $condition)
          UNION ALL (SELECT 2 as database_type, p.temp_purchase_id,p.temp_purchase_sn,p.buyers_id,p.suppliers_id,p.suppliers_name,p.time,p.area_id,p.receive_time,p.money,p.account_money,p.name,p.mobile,p.address,p.state,p.description,p.method,p.temp_buyers_address_id,p.transportation,p.is_comment,p.payer_id,p.pay_time,p.region_id,a.province,a.city,a.district FROM pcwb2bs.b2b_pcy_purchase p LEFT JOIN ecs_temp_buyers_address a on p.temp_buyers_address_id=a.temp_buyers_address_id WHERE $condition)
          ) AS tmp ORDER BY time desc LIMIT $offset,$limit  ";

        $rows = $this->query($sql);

        $data = array();
        for ($i = 0, $len = count($rows); $i < $len; $i++)
        {
            $info['temp_purchase_id'] = $rows[$i]['temp_purchase_id'];
            $info['temp_purchase_sn'] = $rows[$i]['temp_purchase_sn'];
            $info['time'] = $rows[$i]['time'];
            $info['area_id'] = $rows[$i]['area_id'];

            //这个主要处理退款（退款money将置为0）
            $info['money'] = ($rows[$i]['account_money']>$rows[$i]['money'])?$rows[$i]['account_money']:$rows[$i]['money'];

            $info['transportation'] = $rows[$i]['transportation'];
            $info['method'] = $rows[$i]['method'];
            $info['account_money'] = $rows[$i]['account_money'];
            $info['state'] = $rows[$i]['state'];
            $info['receive_time'] = $rows[$i]['receive_time'];
            $info['is_comment'] = $rows[$i]['is_comment'];
            $info['description'] = $rows[$i]['description'];
            $info['database_type'] = $rows[$i]['database_type'];//1表示找材猫 2表示品材宝

            //是否显示补单按钮判断条件 0不行  1可以 2补单进行中
            if($rows[$i]['database_type'] == 1)
            {
                $info['is_add'] = $this->is_add($rows[$i]['temp_purchase_id'], $rows[$i]['state'], $rows[$i]['pay_time'], $rows[$i]['area_id']);//自定义补货字段信息
                $info['replenish_state'] = 0;
                if($info['is_add'] == 2){$info['is_add']=0;$info['replenish_state']=1;}//如果返回的是2,说明是子订单，此处的replenish_state实际上和订单表中的replenish_state没有关系
            }
            else
            {
                $info['is_add']=0;
                $info['replenish_state'] = 1;
            }


            $info['suppliersinfo']['temp_buyers_id'] = $rows[$i]['suppliers_id'];
            $info['suppliersinfo']['nick'] = $rows[$i]['suppliers_name'];
            $info['buyersinfo']['temp_buyers_id'] = $rows[$i]['buyers_id'];
            $info['buyersinfo']['nick'] = isset($rows[$i]['nick']) ? $rows[$i]['nick'] : '';
            $db_name = C('DB_NAME');
            if ($rows[$i]['payer_id'] > 0) {
                //取出代付人的信息
                $sql = "select temp_buyers_id,temp_buyers_mobile,nick from $db_name.ecs_temp_buyers where temp_buyers_id=" . $rows[$i]['payer_id'];
                $res_payer = $this->query($sql);

                $info['payuserinfo']['temp_buyers_id'] = $res_payer[0]['temp_buyers_id'];
                $info['payuserinfo']['temp_buyers_mobile'] = $res_payer[0]['temp_buyers_mobile'];
                $info['payuserinfo']['nick'] = $res_payer[0]['nick'];
            } else {
                $sql = "select temp_buyers_id,temp_buyers_mobile,nick from $db_name.ecs_temp_buyers where temp_buyers_id=" . $rows[$i]['buyers_id'];
                $res_buyer = $this->query($sql);
                $info['payuserinfo']['temp_buyers_id'] = $res_buyer[0]['temp_buyers_id'];
                $info['payuserinfo']['temp_buyers_mobile'] = $res_buyer[0]['temp_buyers_mobile'];
                $info['payuserinfo']['nick'] = $res_buyer[0]['nick'];
            }

            $info['addressinfo']['temp_buyers_address_id'] = $rows[$i]['temp_buyers_address_id'];
            $info['addressinfo']['name'] = $rows[$i]['name'];
            $info['addressinfo']['address'] = $rows[$i]['address'];
            $info['addressinfo']['mobile'] = $rows[$i]['mobile'];

            $info['addressinfo']['province'] = null;
            $info['addressinfo']['city'] = null;
            $info['addressinfo']['district'] = null;
            $info['addressinfo']['region_id'] = null;

            $data[$i] = $info;
        }
        return $data;
    }

    //从3月15日到3月20日。(首单优惠政策)(7,8,218,4004)
    public function isFirstOrder($buyer_id,$temp_purchase_id,$money)
    {

        //取出邀请人和company_id
        $sql_buyers = "select invitation_person,company_id from ecs_temp_buyers where temp_buyers_id='$buyer_id'";
        $res_buyers = $this->query($sql_buyers);

//        $sql2 = "select temp_buyers_permission_id from ecs_temp_buyers_permission  where permission_id=2 and area_id=1 and temp_buyers_id='{$res_buyers[0]['invitation_person']}'";
//        $res = $this->query($sql2);//取出邀请人
//        $res = $res[0];

//        $sql3 = "select count(*) as count from ecs_temp_purchase where state in(2,3,4,5,6,7) and buyers_id=" . $buyer_id;
//        $arr = $this->query($sql3);
//        $arr = $arr[0];

        $sql4 = "select count(*) as count from ecs_temp_purchase where state in(2,3,4) and buyers_id=" . $buyer_id;
        $arr4 = $this->query($sql4);
        $arr4 = $arr4[0];
        if($arr4['count'] <= 1)
        {
            $sql_purchase = "update ecs_temp_purchase set is_first=1 where temp_purchase_id=" . $temp_purchase_id;
            $this->execute($sql_purchase);//更新is_first字段
        }
//        if ($arr['count'] <= 1) {
        if (1) {

            if(time()> strtotime(date('2016-08-08 00:00:00')) && time()< strtotime(date('2017-01-31 23:59:59')) && $res_buyers[0]['company_id']!=11 && $res_buyers[0]['company_id']!=12)
            {
                $sql_goods = "select sum(pg.amount*(pg.price-g.shop_price)) as money from ecs_temp_purchase_goods pg LEFT JOIN ecs_goods g on pg.goods_id = g.goods_id WHERE (g.hotbrand_id=328 or g.hotbrand_id=329) AND pg.temp_purchase_id=".$temp_purchase_id;
                $res_goods = $this->query($sql_goods);
                $money = $res_goods[0]['money'];

                if($money>0)
                {
                    date_default_timezone_set('prc');
                    $time = time();
//                    $cash_money = $money * (0.1) <= 100 ? $money * (0.1) : 100;//首次下单
                    $cash_money = $money;

                    $user_id = $buyer_id;
                    $current_date = date('ymdHis', $time);
                    $cash_sn = $current_date . substr(microtime(), 2, 4) . rand(100000, 999999);
                    $sqlinscash = "insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,cash_time,purchase_id,cash_money) values ('7','$cash_sn','$user_id','$time','$temp_purchase_id','$cash_money')";
                    $sqlaccount = "update ecs_temp_account set total=total+'$cash_money',bonus_money=bonus_money+'$cash_money' WHERE temp_buyers_id='$user_id'";

                    $b1 = $this->execute($sqlinscash);
                    $b2 = $this->execute($sqlaccount);
                    if (!$b1 || !$b2) {
                        file_put_contents('./Runtime/Logs/pay/alilog.txt', $buyer_id . '--' . $temp_purchase_id . '--首次下单红包返回失败--' . $time . "\n", FILE_APPEND);
                        $this->rollback();
                    }
                    //收到红包,推送一条信息
                    $message = new PushMessageModel();
                    $message->CashSingle($user_id,$cash_sn);
                }
            }
        }
    }

    //判断是否给下单返现红包
    public function returnCashOrder($buyer_id,$temp_purchase_id,$money)
    {
        $sql_order = "select area_id from ecs_temp_purchase_goods WHERE temp_purchase_id='$temp_purchase_id'";
        $res = $this->query($sql_order);
        $area_id = $res[0]['area_id'];

        date_default_timezone_set('prc');
        $time = time();
        $sqlbonus = "select cash_back,bonus_id from ecs_temp_bonus where bonus_status=0 AND goods_area_id='$area_id' and send_type=3 AND min_money<='$money' and use_start_date<='$time' and use_end_date>='$time'";
        $result = $this->query($sqlbonus);
        $result = $result[0];

        if ($result) {

            $cash_money = $money * $result['cash_back'];

            $user_id = $buyer_id;
            $current_date = date('ymdHis', $time);
            $cash_sn = $current_date . substr(microtime(), 2, 4) . rand(100000, 999999);
            $sqlinscash = "insert into ecs_temp_cash (cash_bonus_id,cash_sn,user_id,cash_time,purchase_id,cash_money) values ('{$result['bonus_id']}','$cash_sn','$user_id','$time','$temp_purchase_id','$cash_money')";
            $sqlaccount = "update ecs_temp_account set total=total+'$cash_money',bonus_money=bonus_money+'$cash_money' WHERE temp_buyers_id='$user_id'";

            $b1 = $this->execute($sqlinscash);
            $b2 = $this->execute($sqlaccount);
            if (!$b1 || !$b2) {
                file_put_contents('./Runtime/Logs/pay/alilog.txt', $buyer_id . '--' . $temp_purchase_id . '--%1红包返回失败--' . $time . "\n", FILE_APPEND);
                $this->rollback();
            }
            //收到红包,推送一条信息
            $message = new PushMessageModel();
            $message->CashSingle($buyer_id,$cash_sn);
        }

    }

    //代付人 取消订单
    public function cancelOrder($order_id)
    {
        $sql_update = "update ecs_temp_purchase set payer_id=-1 where temp_purchase_id =" . $order_id;
        $b = $this->execute($sql_update);
        if ($b) {
            return true;
        }
        else
        {
            $this->error_info = '订单取消失败';
            $this->error_code = '4800';
        }
    }

    //click 订单状态判断
    public function statusValidate($order_id,$state,$st,$method,$database_type)
    {
        $db_name = C('DB_NAME');
        $sql_count = "select count(*) as count from $db_name.cms_order WHERE temp_purchase_id=".$order_id;
        //传过来的状态码
        switch ($state)
        {
            //取消订单
            case 0:
                if ($method == 1)
                {
                    //货到付款方式下 代发货的情况也能取消订单
                    if ($st != 2)
                    {
                        $this->error_info = '此订单不可以取消1';
                        $this->error_code = '4800';
                        return false;
                    }
                    else
                    {
                        $result_count = $this->query($sql_count);
                        if($result_count[0]['count']>=1 && $database_type==1)
                        {
                            $this->error_info = '该订单已备货，请电话联系客服';
                            $this->error_code = '4800';
                            return false;
                        }
                        //如果存在补货单,不允许取消
                        $sql_add = " select count(*) as count from $db_name.ecs_temp_purchase_goods_add WHERE temp_purchase_id = $order_id";
                        $res_add_count = $this->query($sql_add);
                        if($res_add_count[0]['count'] >=1 &&  $database_type==1)
                        {
                            $this->error_info = '此订单已经存在补货单,不可取消';
                            $this->error_code = '4800';
                            return false;
                        }
                    }
                }
                else   //非货到付款方式
                {
                    if ($st != 1)
                    {
                        $this->error_info = '此订单不可以取消2';
                        $this->error_code = '4800';
                        return false;
                    }
                }
                $this->startTrans();//开启事务  取消订单过程有一步出错, 回归原点
                return true;
            case 2://买家点取消退款
                if ($st != 5){
                    $this->error_info = '无权操作';
                    $this->error_code = '4800';
                    return false;
                }
                return true;
            case 3://卖家点发货
                if ($st != 2) {
                    $this->error_info = '此订单买家必须支付了才能确认发货';
                    $this->error_code = '4800';
                    return false;
                }
                return true;
            case 4://买家点收货
                if ($st != 3){
                    $this->error_info = '此订单必须卖家发货了，才能确认收货';
                    $this->error_code = '4800';
                    return false;
                }
                $this->startTrans();//开启事务
                return true;
            case 5://买家点申请退款
                if ($method == 1) {
                    $this->error_info = '抱歉，你的付款方式为货到付款';
                    $this->error_code = '4800';
                    return false;
                }
                if ($st != 2){
                    $this->error_info = '此订单不可以申请退款';
                    $this->error_code = '4800';
                    return false;
                }
                $result_count = $this->query($sql_count);
                if($result_count[0]['count']>=1 && $database_type==1){
                    $this->error_info = '该订单已备货，请电话联系客服';
                    $this->error_code = '4800';
                    return false;
                }
                $sql = "SELECT p.temp_purchase_id,p.state FROM $db_name.ecs_temp_purchase_goods_add a LEFT JOIN $db_name.ecs_temp_purchase p on a.temp_purchase_new_id=p.temp_purchase_id WHERE a.temp_purchase_id = '$order_id' GROUP by a.temp_purchase_new_id ";
                $res_add = $this->query($sql);
                if($res_add && $database_type==1)
                {
                    for($i=0,$len=count($res_add);$i<$len;$i++)
                    {
                        if($res_add[$i]['state']>=2 && $res_add[$i]['state']<=7)
                        {
                            $this->error_info = '补货订单正在处理中,不可申请退款';
                            $this->error_code = '4554';
                            return false;
                        }
                    }
                    for($i=0,$len=count($res_add);$i<$len;$i++)
                    {

                        $this->table($this->tableName)->where(array('temp_purchase_id'=>$res_add[$i]['temp_purchase_id']))->save(array('state'=>0));
                    }
                }
                $this->table($this->tableName)->where(array('temp_purchase_id'=>$order_id))->save(array('replenish_state'=>0));
                return true;
            case 6://卖家点了同意退款
                if ($st != 5)
                {
                    $this->error_info = '此订单不可以操作退款';
                    $this->error_code = '4554';
                    return false;
                }
                return true;
            default:
                $this->error_info = '你无此权限操作此订单';
                $this->error_code = '4554';
                return false;
        }
    }

    //click 订单业务处理
    public function serviceOrder($purchase_info,$state,$uid,$mobile,$database_type)
    {
        $payment = new TempPaymentModel($database_type);
        $account = new TempAccountModel($database_type);
        $sn = $purchase_info['temp_purchase_sn'];
        $order_id = $purchase_info['temp_purchase_id'];
        $method = $purchase_info['method'];
        switch ($state) {
            case 0://取消订单

                if ($purchase_info['account_money'] > 0 && $database_type==1)//不为空的时候 支付方式为有余额支付
                {
                    //判断payment表中的type是否为11 是11就更新为12
                    $res_type = $payment->getSingleInfo(array('temp_purchase_sn' => $sn), $field = 'type');
                    if ($res_type['type'] == 11)
                    {
                        $res4 = $payment->table($payment->tableName)
                            ->where(array('temp_purchase_sn' => $sn))
                            ->save( array('type' => 12));
                        if (!$res4)
                        {
                            $this->rollback();//回滚
                            $this->error_info = '服务器错误';
                            $this->error_code = 4906;
                            return false;
                        }
                        $payment->table($payment->tableName)
                            ->where(array('temp_purchase_sn' => $sn))
                            ->save(array('edit_time' => time()));//更新payment表中的时间 ->只适用  混合支付
                    }
                    //把account_money 加入到买家账户 total里面
                    $sql = "update ecs_temp_account set total=total+" . $purchase_info['account_money'] . " where temp_buyers_id=" . $uid;

                    if (!$b = $payment->execute($sql))//加入到买家账户失败
                    {
                        $this->rollback();//回滚
                        $this->error_info = '服务器错误';
                        $this->error_code = 4906;
                        return false;
                    }
                }

                if (isset($_POST['is_back']) && $_POST['is_back'] == 1)
                {
                    //把商品 重新加入到购物车中
                    $purchasegoods = new TempPurchaseGoodsModel($database_type);
                    $b = $purchasegoods->backShopCar($order_id,$uid,$purchase_info['area_id'],$database_type);
                    if(!$b) {
                        $this->rollback();//回滚
                        $this->error_info = '服务器错误';
                        $this->error_code = 4906;
                        return false;
                    }
                }
                $this->commit();//确认事务
                return true;
                break;
            case 2://取消退款，后台做逻辑
                //代码。。。
                return true;

                break;
            case 3:
                //当卖家点击确认发货时，即传来的状态码为3时发短息给买家
                $this->table($this->tableName)->where(array('temp_purchase_id' => $order_id))->save(array('delivery_time' => time()));
                $message = '您的订单号（' . $purchase_info['temp_purchase_sn'] . '），卖家已发货，请及时查收。';
                sendmessage($mobile, $message);
                return true;
                break;
            case 4://买家确认收货
                //查红包类型表，算出红包金额
                $time = time();
                $sql_bonus = "select bonus_id,cash_back from  pcwb2bs.b2b_pcy_temp_bonus where bonus_id=1 AND send_type=0 AND use_end_date> '$time'";
                $res_bonus = $payment->query($sql_bonus);
                if($res_bonus) $cash_back = $res_bonus[0]['cash_back'];
                else $cash_back=0;

                if($purchase_info['share_is_gen'] == 1 && $database_type==2) {
                    $rate = 1+$cash_back;
                }
                else {
                    $rate = 1;
                }

                //往供应商账号里加钱（品材宝）
                if($database_type == 2 && $method != 1)
                {
                    $result = $payment->toSuppliersAccount2($purchase_info['money'],$purchase_info['suppliers_id'],$purchase_info['withdraw_rate'],$rate);
                    if(!$result)
                    {
                        //把状态修改回来
                        $this->rollback();
                        $this->error_info = '服务器错误';
                        $this->error_code = 5000;
                        return false;
                    }
                }

                if ($method == 1) $payment->table($payment->tableName)->where( array('temp_purchase_sn' => $sn) )->save( array('type' => 6) );//货到付款的方式 才变成6
                if ($method == 3) $payment->table($payment->tableName)->where( array('temp_purchase_sn' => $sn) )->save( array('type' => 8) );//这货 貌似是白条支付

                $purchasegoods = new TempPurchaseGoodsModel($database_type);
                $goods_infos = $purchasegoods->getMultipleInfo(array('temp_purchase_id' => $order_id), 'goods_id,amount,area_id'); //goods_id,amount,area_id

                $purchasegoods->updateGoodsTable($goods_infos,$database_type);//跟新goods表中sales,用于统计销量

                $this->table($this->tableName)->where(array('temp_purchase_id' => $order_id))->save(array('finish_time' => time()));

                //他人代付 给分享人返红包
                //1 首先判断供应商或设计师 在品材宝和找材猫是否都有账号
                if($purchase_info['share_is_gen'] == 1 && $database_type==2)
                {
                    $b = $payment->FenXiongHongBao($purchase_info,$uid,$cash_back);
                    if(!$b)
                    {
                        $this->rollback();
                        $this->error_info = "服务器错误";
                        $this->error_code = "5000";
                        return false;
                    }
                }

                $this->commit();

                return true;
                break;
            case 5://买家申请退款
                return true;

                break;
            case 6:
                //卖家同意买家可以退款
                //在payment增加数据
                //查此订单有没有在数据库插入过数据
                $row = $payment->getSingleInfo(array('temp_purchase_sn' => $sn), 'type,user_id');
                if (!$row){
                    $this->error_info = "此订单没有交易，不可以申请退款";
                    $this->error_code = "4130";
                    return false;
                }
                if ($row['type'] == 3){
                    $this->error_info = "申请退款已经有记录";
                    $this->error_code = "4130";
                    return false;
                }

                //修改订单的状态
                $b = $this->table($this->tableName)->where(array('temp_purchase_id' => $order_id))->save(array('state' => 6));
                if (!$b){
                    $this->error_info = "状态修改失败";
                    $this->error_code = "4129";
                    return false;
                }

                //获取订单信息
                $field = 'suppliers_id,buyers_id,money';
                $rows = $this->getSingleInfo(array('temp_purchase_sn' => $sn), $field);
                //没有插入过，用事务

                //判断买家是否有账户在acount
                $yaccount = $account->getSingleInfo(array('temp_buyers_id' => $uid), 'temp_account_id');

                if (!$yaccount) {//说明没有账户，就帮创建
                    $account->addOne($uid);
                }
                //在payment把原来的订单入账信息修改为一条退款信息，type=3，同时在卖家count里的缓存减去这笔钱，在买家的count账户的缓存加上这笔钱， 在acount插入一条数据,事务
                if ($payment->refund($rows['suppliers_id'], $rows['buyers_id'], $sn, $rows['money'],$database_type))
                {
                    $response = array("success" => "true", "data" => array("msg" => '申请退款成功'));
                    $response = ch_json_encode($response);
                    exit($response);

                }
                else {
                    //把状态修改回来
                    $this->table($this->tableName)->where(array('temp_purchase_id' => $order_id))->save(array('state' => 5));
                    $this->error_info = "退款申请失败";
                    $this->error_code = "4132";
                    return false;
                }
            case 7:
                return true;
                break;

        }
    }

}