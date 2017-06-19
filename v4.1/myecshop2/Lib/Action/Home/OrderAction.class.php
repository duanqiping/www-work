<?php

/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/14
 * Time: 14:35
 */
class OrderAction extends Action
{

    /**
     * receive_time送货时间 description备注
     * transportation运费  goods对象
     * use_balance是否使用余额
     * temp_buyers_address_id地址id
     * temp_purchase_id补单id(可选)
     */
    public function confirm()
    {
        $goodsInfo = $_POST['goods'];//商品信息(对象)

        $database_type = $_POST['database_type'];
        $type = $goodsInfo[0]['type'];
        $area_id = $_POST['area_id'] = ($type==2?10:$_POST['area_id']);
        $temp_buyers_address_id = $_POST['temp_buyers_address_id'];//补货的时候 没有传temp_buyers_address_id
        $uid = $_SESSION['temp_buyers_id'];

        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        checkPostData(!($type==1 || $type==2),'type值非法',4871);
        checkPostData(!$area_id,'area_id值非法',4871);

        $temppurchase = new TempPurchaseModel($database_type);
        $temppurchase->is_login();//判断是否登录

        $order_id = isset($_POST['temp_purchase_id'])?$_POST['temp_purchase_id']:null;//补货的情况下，会传一个temp_purchase_id

        //获取地址等信息
        $AddressData = $temppurchase->getAddressInfo($order_id);
        if(!$AddressData) printError($temppurchase->error_info,$temppurchase->error_code);

        $goods_table = $temppurchase->getGoodsTable($area_id,$type);

        $good = new GoodsModel($goods_table,$database_type);
        $b = $good->MinNum($goodsInfo);
        if(!$b) $good->printError($good->error_info,$good->error_code);
        $total_money = $good->TotalMoney($goodsInfo,$area_id,$type,$database_type,$uid);//商品总价
        if($total_money <= 0) printError('订单金额小于等于0的情况为非法操作',4811);
        $TempGoodsInfo = $good->TempGoodsInfo($goodsInfo,$area_id,$type,$database_type,$uid);//ecs_temp_purchase_goods表入库数据

        //获取供应商信息
        $SuppliersData = $temppurchase->SuppliersInfo($database_type,$TempGoodsInfo[0]['suppliers_id'],$goodsInfo[0]['goods_id']);

        //获取第一商品的名字，把它插入到purchase_title这个字段中
        $name = $good->getSingleInfo(array('goods_id'=>$goodsInfo[0]['goods_id']),'goods_name');

        $OrderData = array();//订单入库数据
        $OrderData['temp_buyers_address_id'] = $temp_buyers_address_id;//地址id号
        $OrderData['receive_time'] = $_POST['receive_time'];//送货时间
        $OrderData['description'] = $_POST['description']; //备注, 这个应该可以为空
        $OrderData['transportation'] = $_POST['transportation'];//物流费用
        $OrderData['state'] = 1;//状态 待付款
        $OrderData['money'] = $total_money + $OrderData['transportation'];//总价加上物流真的总价
        $OrderData['difference_money'] = $OrderData['money'];//默认要支付的钱为订单总额
        $OrderData['temp_purchase_sn'] = get_cash_sn($uid);//获取订单号
        $OrderData['area_id'] = $area_id;
        $OrderData['time'] = time();
        $OrderData['buyers_id'] = $uid;
        $OrderData['purchase_title'] = $name['goods_name'];
        $OrderData = array_merge($OrderData,$AddressData,$SuppliersData);

        if ($_POST['use_balance'] && $database_type==1) {
            //使用了余额支付
            $account = new TempAccountModel($database_type);
            $account_data = $account->payUseAccount($OrderData['money']);

            if(!$account_data) printError($account->error_info,$account->error_code);

            $OrderData['state'] = $account_data['state'];
            $OrderData['account_money'] = $account_data['account_money'];
            $OrderData['difference_money'] = $account_data['difference_money'];
            $OrderData['finish_time'] = $account_data['finish_time'];
            $OrderData['pay_time'] = $account_data['pay_time'];
            $OrderData['method'] = $account_data['method'];
        }


        $temp_purchase_id = $temppurchase->tempPurchaseAdd($OrderData);//先对temp_purchase表进行插入
        if(!$temp_purchase_id) printError($temppurchase->error_info,$temppurchase->error_code);
        $data1 = $temppurchase->getByTempId($temp_purchase_id,$database_type);//获取订单详情
//        $data1 = $temppurchase->getById($temp_purchase_id,$database_type);//获取订单详情

        for ($i = 0, $len = count($TempGoodsInfo); $i < $len; $i++) {
            $TempGoodsInfo[$i]['temp_purchase_id'] = $temp_purchase_id;
        }

        $temppurchasegoods = new TempPurchaseGoodsModel($database_type);

        $b = $temppurchasegoods->table($temppurchasegoods->tableName)->addAll($TempGoodsInfo);//订单商品入库

        if($b) $temppurchasegoods->commit();
        else{$temppurchasegoods->rollback();printError('订单商品入库失败','5002');}

        if($database_type == 1)
        {
            $sql = "select goods_table,goods_category_table from ecs_goods_area where goods_area_id='$area_id'";
            $res_table = $temppurchase->query($sql);
            $res_table = $res_table[0];
        }
        else
        {
            $res_table['goods_table'] = 'b2b_pcy_goods';
            $res_table['goods_category_table'] = 'b2b_pcy_goods_category';
        }

        $data2 = $temppurchasegoods->getByTempGoodsId($temp_purchase_id,$database_type,$res_table);
        $data1['goods'] = $data2;

        //如果完全使用余额支付，现在也做返红包处理 (事务将在对 ecs_temp_purchase_goods 进行插入完成后提交)
        $temppurchase->startTrans();
        if($data1['state'] == 2 && $data1['suppliers_id']==1024)
        {
            //首单返红包
            $temppurchase->isFirstOrder($data1['buyers_id'],$data1['temp_purchase_id'],$data1['money']);
        }

        if($data1['state'] == 2)
        {
            $temppurchase->returnCashOrder($data1['buyers_id'],$data1['temp_purchase_id'],$data1['money']);
        }
        $temppurchase->commit();

        //往 ecs_temp_purchase_goods_add 表中插入对应的信息
        //temp_purchase_id,temp_purchase_new_id,temp_purchase_goods_id,goods_id,amount,area_id,add_type
        if($order_id)
        {
            $b = $temppurchasegoods->insertPurchaseGoodsAdd($order_id,$temp_purchase_id);
            if(!$b) printError('ecs_temp_purchase_goods_add表入库失败','5001');
        }

        //移除购物车中的商品
        $temppurchase->deleteShopcarInfo($goodsInfo,$database_type);

        printSuccess($data1);
    }

    //点击补货 或取消补货 按钮
    public function clickAdd()
    {
        $temppurchase = new TempPurchaseModel(1);
        $temppurchase->is_login();//判断是否登录

        $temp_purchase_id = $_POST['temp_purchase_id'];
        $act = $_POST['act'];//add 补货 cancel 取消补货
        $uid = $_SESSION['temp_buyers_id'];

        $condition_purchase = array('temp_purchase_id'=>$temp_purchase_id,'buyers_id'=>$uid);

        $sql = "select count(*) as count from ecs_temp_purchase_goods_add WHERE temp_purchase_new_id='$temp_purchase_id'";
        $count_res = $temppurchase->query($sql);
        if($count_res[0]['count']>0) $temppurchase->printError('子订单不能进行补货操作','4557');

        $res = $temppurchase->getSingleInfo($condition_purchase,'state,pay_time,replenish_state,area_id');

        if(!$res) $temppurchase->printError('没有查询到该订单信息','4451');
        if($act == 'add')
        {
            $b = $temppurchase->is_add($temp_purchase_id,$res['state'],$res['pay_time'],$res['area_id']);
            if($b != 1)
            {
                $temppurchase->printError('已过15:30时间限制,不能进行补单','4452');
            }
            else
            {
                $temppurchase->table($temppurchase->tableName)->where(array('state'=>2,'replenish_state'=>1,'buyers_id'=>$uid,'is_delete'=>0))->save(array('replenish_state'=>0));

                date_default_timezone_set('PRC');
                $time = time();
                $is_time = buHuoTime();//当天15:30:00
                if($time>$is_time) $msg = '请在明天15:30之前完成补货订单操作';
                else $msg = '请在今天15:30之前完成补货订单操作';

                $a = $temppurchase->table($temppurchase->tableName)->where($condition_purchase)->save(array('replenish_state'=>1));

                if($a) $temppurchase->printSuccess(array('msg'=>$msg));
                else $temppurchase->printError('补货更新失败','5001');
            }
        }
        else if($act == 'cancel')
        {
            //取消补货，如果有子订单，应该取消掉
            $sql = "select a.temp_purchase_new_id from ecs_temp_purchase_goods_add a LEFT JOIN ecs_temp_purchase p on p.temp_purchase_id=a.temp_purchase_new_id where a.temp_purchase_id='$temp_purchase_id' AND p.state=1 GROUP BY a.temp_purchase_new_id";
            $res = $temppurchase->query($sql);

            for($i=0,$len=count($res);$i<$len;$i++)
            {
                $condition['temp_purchase_id'] = $res[$i]['temp_purchase_new_id'];
                $condition['state'] = 1;
                $b = $temppurchase->table($temppurchase->tableName)->where($condition)->save(array('state'=>0));
                if(!$b) $temppurchase->printError('待付款的子订单取消失败',5002);
            }

            $a = $temppurchase->table($temppurchase->tableName)->where($condition_purchase)->save(array('replenish_state'=>0));
            if($a) $temppurchase->printSuccess(array('msg'=>'取消成功'));
            else $temppurchase->printError('取消补货操作失败','5001');
        }
        else
        {
            $temppurchase->printError('act参数有误','4453');
        }
    }

    //订单详情
    public function detail()
    {
        $temp_purchase_id = $_POST['temp_purchase_id'];
        $database_type = $_POST['database_type'];
        checkPostData(!$temp_purchase_id,'订单id号不能为空',4881);
        checkPostData(!$database_type,'订单database_type不能为空',4882);

        $temppurchase = new TempPurchaseModel($database_type);
        $temppurchase->is_login();//判断是否登录

        $data1 = $temppurchase->getById($temp_purchase_id,$database_type);//通过订单id 获取订单详情

        $temppurchasegoods = new TempPurchaseGoodsModel($database_type);

        if($database_type == 1)
        {
            $sql = "select goods_table,goods_category_table from ecs_goods_area where goods_area_id='{$data1['area_id']}'";
            $res_table = $temppurchase->query($sql);
            $res_table = $res_table[0];
        }
        else
        {
            $res_table['goods_table'] = 'b2b_pcy_goods';
            $res_table['goods_category_table'] = 'b2b_pcy_goods_category';
        }
        $data2 = $temppurchasegoods->getByTempGoodsId($temp_purchase_id,$database_type,$res_table);//通过id 获取订单商品信息
        $data1['goods'] = $data2;//把两个数组合并成一个数组

        $temppurchase->printSuccess($data1);
    }

    /**订单列表 state type page pageSize*/
    public function orderList()
    {
        //接收订单状态码
        $state = isset($_POST['state']) ? $_POST['state'] + 0 : "";//默认待付款
        //注意 下面严格相等
        if ($state === 0)  printError('订单已经取消，不能查看',4800);

        $type = isset($_POST['type']) ? $_POST['type'] + 0 : 1;//0卖家1买家
        $page = !isset($_POST['page']) ? 1 : $_POST['page'] + 0; //接收页码
        $limit = !isset($_POST['pageSize']) ? 5 : $_POST['pageSize'] + 0;//每页显示多少条
        $uid = $_SESSION['temp_buyers_id'];

        $purchase = new TempPurchaseModel(1);
        $purchasegoods = new TempPurchaseGoodsModel(1);
        $purchase->is_login();

        $purchase->cleanOrder($uid);//对补货单及其子单有效性进行判断

        $data = $purchase->orderList($state, $uid, $type, $page, $limit);//获取订单信息....

        //获取订单商品信息
        for($i=0,$len=count($data);$i<$len;$i++)
        {
            $database_type = $data[$i]['database_type'];
            if($database_type == 1)
            {
                $sql = "select goods_table,goods_category_table from ecs_goods_area where goods_area_id={$data[$i]['area_id']}";
                $res_table = $purchasegoods->query($sql);
                $res_table = $res_table[0];
            }
            else
            {
                $res_table['goods_table'] = 'b2b_pcy_goods';
                $res_table['goods_category_table'] = 'b2b_pcy_goods_category';
            }
            $data[$i]['goods'] = $purchasegoods->getByTempGoodsId($data[$i]['temp_purchase_id'],$database_type,$res_table);
        }
        $purchase->printSuccess($data);
    }

    /** 订单按钮操作 temp_purchase_id state is_back*/
    public function click()
    {
        $uid = $_SESSION['temp_buyers_id'];
        $state = isset($_POST['state']) ? intval($_POST['state']) : false;
        $order_id = isset($_POST['temp_purchase_id']) ? intval($_POST['temp_purchase_id']) : 0;
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;//供应商的id号

        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        checkPostData(!$order_id,'order_id错误',4800);
        checkPostData($state === false,'状态码不能为空',4871);

        $purchase = new TempPurchaseModel($database_type);
        $purchase->is_login();

        //判断能不能修改状态
        $field = 'temp_purchase_id,state,temp_purchase_sn,suppliers_id,area_id,method,money,suppliers_id,account_money,payer_id,withdraw_rate';
        if($database_type == 2) $field = $field.',share_is_gen';

        $purchase_info = $purchase->getSingleInfo(array('temp_purchase_id'=>$order_id), $field);//取出订单信息（state,temp_purchase_sn,method,money,account_money）

        $st = $purchase_info['state']; //原来订单状态
        $method = $purchase_info['method'];   //订单支付方式

        if ($state == 0 && $purchase_info['payer_id'] == $uid && $database_type==1)//表示是代付款人取消订单
        {
            $b = $purchase->cancelOrder($order_id);
            if(!$b) $purchase->printError($purchase->error_info,$purchase->error_code);
            else $purchase->printSuccess('订单状态已经修改成功');
        }

        $result = $purchase->statusValidate($order_id,$state,$st,$method,$database_type);//订单状态判断
        if(!$result){$purchase->printError($purchase->error_info,$purchase->error_code);}

        //根据状态修改订单状态
        if ($state != 6)
        {
            if ($state == 0) $updata = array('state' => $state, 'payer_id' => '-1'); //订单取消,不管有无代付人(主要防止代付人在消息中查看到订单详情)
            else $updata = array('state' => $state);

            $b = $purchase->table($purchase->tableName)->where(array('temp_purchase_id'=>$order_id,'buyers_id'=>$uid))->save($updata);
            if (!$b) $purchase->printError('订单状态修改失败',5002);
        }

        //发短息，业务逻辑
        $db_name = C('DB_NAME');
        $sql = "select b.temp_buyers_mobile as buyermobile from $purchase->tableName p left join $db_name.ecs_temp_buyers b on b.temp_buyers_id = p.buyers_id where p.temp_purchase_id ='$order_id'";
        $mobiles = $purchase->query($sql);//查询买家手机号
        $mobiles = $mobiles[0];

        //更新订单时间 为排序准备
        $result = $purchase->table($purchase->tableName)->where(array('temp_purchase_id' => $order_id))->save( array('finish_time' => time()) );//这是更新 ecs_temp_purchase表的时间
        if (!$result) $purchase->printError('订单时间更新失败',5002);

        //订单业务处理
        $b2 = $purchase->serviceOrder($purchase_info,$state,$uid,$mobiles['buyermobile'],$database_type);
        if(!$b2) {$purchase->printError($purchase->error_info,$purchase->error_code);}

        $response = array("success" => "true", "data" => array("msg" => '订单状态已经修改成功'));
        $response = ch_json_encode($response);
        exit($response);
    }

    /** 取消代付订单*/
    public function cancel()
    {
        $temppurchase = new TempPurchaseModel(1);
        $temppurchase->is_login();

        //接收参数temp_purchase_id
        $order_id = isset($_POST['temp_purchase_id']) ? intval($_POST['temp_purchase_id']) : 0;
        if (!$order_id) $temppurchase->printError('order_id错误',4154);

        $contidition['temp_purchase_id'] = $order_id;
        $res = $temppurchase->table($temppurchase->tableName)->where($contidition)->field('payer_id')->find();
        if ($res['payer_id'] == -1)  $temppurchase->printSuccess('取消成功');

        $b = $temppurchase->table($temppurchase->tableName)->where($contidition)->save(array('payer_id' => -1));
        //必须在状态1的时候
        if ($b) $temppurchase->printSuccess('取消成功');
        else $temppurchase->printError('取消失败',4919);
    }

    //删除订单接口
    public function delete()
    {
        $order_id = $_POST['temp_purchase_id'];
        $database_type = $_POST['database_type'];

        $temppurchase = new TempPurchaseModel($database_type);
        $temppurchase->is_login();

        if (isset($_POST['temp_purchase_id']))
        {
            $condition['temp_purchase_id'] = $order_id;
            $condition['state'] = 0;
            $data['is_delete'] = 2;

            $b = $temppurchase->table($temppurchase->tableName)->where($condition)->save($data);
            if(!$b) exit('{"success":"false","error":{"msg":"订单删除失败","code":"4800"}}');

            $temppurchase->printSuccess('订单删除成功');
        }
        else
        {
            $temppurchase->printError('订单id号不能为空',4802);
        }
    }

    //提醒卖家发货
    public function remind()
    {
        $response = array("success" => "true", "data" => array("msg" => '提醒卖家发货成功'));
        $response = ch_json_encode($response);
        exit($response);
    }
}
