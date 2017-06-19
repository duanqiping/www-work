<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2015/7/22
 * Time: 15:12
 *
 * 商品详情、找好友代付款、货到付款接口、去结算接口、物流说明及相关描述
 */

class IndexAction extends Action
{
    /** 商品详情*/
    public function goodsdetail()
    {
        $goodsarea = new GoodsAreaModel('ecs_goods_area');

        $type = isset($_POST['type'])?$_POST['type']:1;//默认对应辅材
        $area_id = ($type==2)?10:$_POST['area_id'];
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;
        $goods_id = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

        checkPostData(!$database_type,'database_type不能为空','4867');
        checkPostData(!$goods_id,'商品id非法','4867');

        //找材猫
        if($database_type == 1)
        {
            $cityareainfo = $goodsarea->getSingleInfo(array('goods_area_id'=>$area_id),'goods_table,gallery_table');

            $goods_table = ($type==2)?'ecs_goods_pifa':$cityareainfo['goods_table'];
            $goods_gallery_table = ($type==2)?'ecs_goods_gallery_pifa':$cityareainfo['gallery_table'];
        }
        //品材宝 黄沙水泥
        else
        {
            $goods_table = 'b2b_pcy_goods';
            $goods_gallery_table = 'b2b_pcy_goods_gallery';
        }

        $goodsModel = new GoodsModel($goods_table,$database_type);
//        $goodsModel ->is_login();
        //获取商品信息
        $data = $goodsModel -> GoodsDetail($goods_id, $area_id,$type,$goods_gallery_table,$database_type);
        if(!$data) printError('该商品已经下架','4861');

        printSuccess($data);
    }

    //找好友代付款
    public function payFor()
    {
        //接收参数temp_purchase_id,mobile
        $temp_purchase_id = $_POST['temp_purchase_id'];
        $mobile = trim($_POST['mobile']);

        is_mobile_legal($mobile);

        if($mobile == $_SESSION['temp_buyers_mobile']) printError('代付人不能是自己',4158);

        //查出请求待付款人的buyers_id,然后再订单表中更新
        $temppurchse = new TempPurchaseModel(1);
        $temppurchse->is_login();

        $purchaseinfo = $temppurchse->getSingleInfo(array('temp_purchase_id'=>$temp_purchase_id),'state,payer_id');

        if($purchaseinfo['payer_id'] > 0) printError('你已经申请了代付款请求',4158);

        if($purchaseinfo['state'] != 1) printError('订单必须是待付款状态',4158);

        $sql_id = "select temp_buyers_id FROM ecs_temp_buyers WHERE temp_buyers_mobile='$mobile'";
        $res = $temppurchse->query($sql_id);
        if(!$res) printError('你好友得先注册成会员,才能进行代付款',4158);

        $sql = "update ecs_temp_purchase set payer_id='{$res[0]['temp_buyers_id']}',payer_mobile='$mobile' WHERE temp_purchase_id=".$temp_purchase_id;
        if($temppurchse->execute($sql) == 1)
        {
            //需要给好友发一条信息 1先取出好友的channel_id和设备型号 然后推送消息
            $pushmessage = new PushMessageModel();
            $sql_blind = "select * from ecs_push_blind where user_id =".$res[0]['temp_buyers_id'];
            $res_blind = $pushmessage->query($sql_blind);

            if(!$res_blind)
            {
                $push_id = 0;//没有绑定  默认情况
                $device = 1;
                $user_id = $res[0]['temp_buyers_id'];
            }
            else
            {
                $push_id = $res_blind[0]['push_id'];
                $device = $res_blind[0]['device'];
                $user_id = $res_blind[0]['user_id'];
            }

            if($device == 1) $pushmessage->single($push_id,$device,$user_id,$temp_purchase_id);
            else if($device == 2) $pushmessage->single_ios($push_id,$device,$user_id,$temp_purchase_id);

            $msg = "请求成功,等待对方付款";
            $response = array('success' => 'true', 'data' => array('msg'=>$msg));
            $response = ch_json_encode($response);
            exit($response);
        }
        else
        {
            $msg = "请求好友代付款失败";
            $response = array('success' => 'false', 'error' => array('msg'=>$msg,'code'=>'4915'));
            $response = ch_json_encode($response);
            exit($response);
        }
    }

    //微信找人代付
    public function payOther()
    {
        $database_type=  $_POST['database_type'];
        $temp_purchase_id = $_POST['temp_purchase_id'];

        $data = array(
            'title'=>'找人代付',
            "desc"=>"你有一个找人代付订单",
//            "url"=>"http://www.pcw365.com/ecshop2/MobileAPI2/pcw/myecshop2/web/order/detail??temp_purchase_id=$temp_purchase_id&datebaseType=$database_type"
            "url"=>CROOT."pcw/myecshop2/web/order/detail??temp_purchase_id=$temp_purchase_id&datebaseType=$database_type"
        );
        printSuccess($data);
    }

    //货到付款接口
    public function pay()
    {
        $temppurchase = new TempPurchaseModel(1);
        $temppurchase->is_login();//判断是否登录

        $order_id = $_POST['temp_purchase_id'];
        checkPostData(!$order_id,'订单id有误',4840);

        //判断订单是否支持货到付款
        $temppurchasegoods = new TempPurchaseGoodsModel(1);
        $resutl = $temppurchasegoods->huoDaoPay($order_id);
        if (!$resutl) printError('该城市暂不支持货到付款', 4803);

        $b = $temppurchase->updateByID($order_id);
        if ($b)
        {
            printError($temppurchase->error_info,$temppurchase->error_code);
        }
        else
        {
            $response = array('success' => 'true', 'msg' => '订单状态更新成功');
            $response = ch_json_encode($response);
            exit($response);
        }
    }

    /** 去结算接口*/
    public function judge2()
    {
        //接收参数:type:商品类型，"area_id"保持不变，goods_arr商品对象
        $goods_arr = $_POST['goods_arr'];
        $database_type = $_POST['database_type'];
        $type = $_POST['type'];
        $area_id = $post['area_id'] = ($type==2?10:$_POST['area_id']);
        $uid = $_SESSION['temp_buyers_id'];

        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        checkPostData(!$goods_arr,'商品信息不能为空',4871);
        checkPostData(!($type==1 || $type==2),'type值非法',4871);

        $purchase_add = null;

        //找材猫去结算
        if($database_type == 1)
        {
            $temppurchase = new TempPurchaseModel($database_type);
            $temppurchase -> is_login();//判断是否登录

            $arr = array();
            $arr['receive_time'] = ($type == 1)?'当天15:30前下单,次日到货(找平施工类3天内进场)':'根据距离远近，一般为一周左右';

            $goodsarea = new GoodsAreaModel();
            $condition['goods_area_id'] = $area_id;
            $res = $goodsarea->where($condition)->field('min_money')->find();//获取去结算的最低限制价格
            $arr['price'] = $res['min_money'];

            $goods_table = $temppurchase->getGoodsTable($area_id,$type);

            //查看是否有补货订单，有则返回补单详情
            if($type == 1) $purchase_add = $temppurchase->getBuHuoDetail($uid);//补货订单信息

            $total_money = 0;//商品总价
            $good = new GoodsModel($goods_table,$database_type);
            for ($i = 0,$len=count($goods_arr); $i < $len; $i++)
            {
                $price = $good->getPrice($goods_arr[$i],$area_id,$type,$database_type);//判断商品最少购买数量,同时返回商品总价及其商品信息
                if(!$price) printError($good->error_info,$good->error_code,$purchase_add);
                else $total_money = $total_money+$price;
            }

            //辅材特殊商品价格限制判断
            if($type == 1)
            {
                $error_n = null;

                //对辅材商品价格限制做判断
                $error_m = $good->judgeNormal($goods_arr, $res['min_money'], $uid, $area_id, $type,$database_type);

                if ($area_id == 1) $error_n = $good->processLeastMoneyForShanghai0818($goods_arr,$res['min_money'], $area_id, $type,$database_type);
                if ($area_id == 9) $error_n = $good->judugeAll($goods_arr, $total_money, $res['min_money']);

                if ($error_n || $error_m)
                {
                    //是否是补单
                    if ($purchase_add)
                    {
                        $sql = "select a.goods_id,a.amount from ecs_temp_purchase_goods_add a LEFT JOIN ecs_temp_purchase p ON a.temp_purchase_new_id = p.temp_purchase_id WHERE a.temp_purchase_id='{$purchase_add['temp_purchase_id']}' and a.area_id=1 and a.add_type=1 and p.state=2 and p.is_delete=0  UNION ALL select goods_id,amount from ecs_temp_purchase_goods where temp_purchase_id='{$purchase_add['temp_purchase_id']}';";
                        $res_goodsinfo = $good->query($sql);

                        //父订单和子订单商品数据整合
                        $goods_all = array_merge($goods_arr, $res_goodsinfo);

                        if ($error_m)
                        {
                            $error_m2 = $good->judgeNormal($goods_all, $res['min_money'], $uid, $area_id, $type,$database_type);
                            if ($error_m2) $good->printError($error_m2, 4800);
                            else {
                                $error_n2 = null;
                                if ($area_id == 1) $error_n2 = $good->processLeastMoneyForShanghai0818($goods_all,$res['min_money'], $area_id, $type,$database_type);
                                if ($area_id == 9) $error_n2 = $good->judugeAll($goods_all, $total_money, $res['min_money']);
                                if ($error_n2) $good->printError($error_n2, 4800);
                                else $good->printError($error_m, 4800, $purchase_add);
                            }
                        }
                        else {
                            $error_n2 = null;
                            if ($area_id == 1) $error_n2 = $good->processLeastMoneyForShanghai0818($goods_all,$res['min_money'], $area_id, $type,$database_type);
                            if ($area_id == 9) $error_n2 = $good->judugeAll($goods_all, $total_money, $res['min_money']);
                            if ($error_n2) $good->printError($error_n2, 4800);
                            else $good->printError($error_n, 4800, $purchase_add);
                        }
                    }
                    else
                    {
                        if ($error_m) $good->printError($error_m, 4808);
                        else $good->printError($error_n, 4808);
                    }
                }
            }
            //批发商城每个一级分类下的商品总价不得低于1000元
            else
            {
                $goods_arr = $_POST['goods_arr'];
                $good = new GoodsModel('ecs_goods_pifa',$database_type);
                $result = $good->piFaMinPrice($goods_arr,$area_id,$type,$arr['price']);
                if(!$result) printError($good->error_info,$good->error_code,$purchase_add);

                if($total_money < $arr['price']) printError('批发总价不能少于'.$arr['price'],4809);
            }
        }

        //品材宝黄沙水泥去结算
        else
        {
            $base = new BaseModel();
            $sql = "select pb.receive_time from pcwb2bs.b2b_user pb LEFT JOIN pcwb2bs.b2b_pcy_goods pg ON pb.user_id=pg.suppliers_id WHERE pg.goods_id='{$goods_arr[0]['goods_id']}'";
            $res_receive = $base->query($sql);
            $receive_time = $res_receive[0]['receive_time'];
            $arr = array();
            $arr['receive_time'] = $receive_time;
            $arr['price'] = 0.01;//需处理
        }
        printSuccess($arr);
    }

    //获取支付方式列表
    public function paylist()
    {
        $arr = array();

        $arr[0]['icon']=NROOT.'/Public/img/payment_icon_alipay@3x.png';
        $arr[0]['name']='支付宝';
        $arr[0]['type']='0';
        $arr[0]['pay_default']='1';//default=1表示默认支付方式

//        $arr[1]['icon']=NROOT.'/myecshop2/Lib/Widget/img/payment_icon_bank@3x.png';
//        $arr[1]['name']='银行卡支付';
//        $arr[1]['type']='4';
//        $arr[1]['pay_default']='0';

        $arr[1]['icon']=NROOT.'/Public/img/huodaofukuan.png';
        $arr[1]['name']='货到付款';
        $arr[1]['type']='1';
        $arr[1]['pay_default']='0';

        $response = array('success' => 'true', 'data' => $arr);
        $response = ch_json_encode($response);
        exit($response);
    }

    //物流说明及相关描述
    public function transportation()
    {
        $database_type = $_POST['database_type'];
        $goods_arr = $_POST['goods_arr'];//goods_arr[0]['goods_id'] goods_arr[0]['amount']
        $area_id = $_POST['area_id'];
        $type = $_POST['type'];
        $id = $_POST['temp_buyers_address_id'];

        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);

        //查出对应的goods商品表
        $base = new BaseModel();
        $base->is_login();

        if($database_type == 1)
        {
            if($type == 2)
            {
                $goods_table = 'ecs_goods_pifa';
                $goodsModel = new GoodsModel($goods_table,1);
                $transportation = $goodsModel->transportation($goods_arr,$id);
                $data['transportation_price'] = $transportation;
                $data['transportation_desc'] = '';
            }
            else
            {
                $goodsarea = new GoodsAreaModel();
                $condition['goods_area_id'] = $area_id;
                $res_f = $goodsarea->where($condition)->field('min_money')->find();//获取辅材去结算的最低限制价格

                //辅材 上海判断商品是否有美居良品库存类商品
                $data['transportation_price'] = 0; //辅材暂时没有运费需求
                $data['transportation_desc'] = '免运费搬楼费(板材类满600,其他满'.$res_f['min_money'].')';
            }
        }
        else
        {
            $data['transportation_price'] = 0; //辅材暂时没有运费需求

            $sql_b2b_user = "select pu.global_trans_desc from pcwb2bs.b2b_user pu LEFT JOIN pcwb2bs.b2b_pcy_goods pg ON pu.user_id=pg.suppliers_id WHERE pg.goods_id='{$goods_arr[0]['goods_id']}'";
            $res_b2b_user = $base->query($sql_b2b_user);
            $data['transportation_desc'] = $res_b2b_user[0]['global_trans_desc'];
        }

        printSuccess($data);
    }


    public function test()
    {
        print_r($_SERVER['SCRIPT_FILENAME']);
        exit();
        $OrderData = array();
        $OrderData['temp_purchase_sn'] = '111';//获取订单号
        $OrderData['area_id'] = '222';
        $OrderData['time'] = time();
        $OrderData['buyers_id'] = 22;
        $OrderData['purchase_title'] = 'hello';
        $AddressData['aa'] = 'aa';
        $AddressData['bb'] = 'bb';
        $AddressData['cc'] = 'cc';
        $SuppliersData['ee'] = '11';
        $SuppliersData['ff'] = 'ff';
        $OrderData = array_merge($OrderData,$AddressData,$SuppliersData);

        print_r($OrderData);

    }

}