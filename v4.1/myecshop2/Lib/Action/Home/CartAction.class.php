<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/8/5
 * Time: 13:54
 * 加入购物车、删除购物车、修改购物车、收藏、获取收藏夹列表、清空收藏夹、获取购物车列表
 */
class CartAction extends Action
{
    /** 加入购物车  post参数  amount goods_id type suppliers_id*/
    public function add()
    {
        //验证必须的参数是否有空
        $type = $_POST['type'];
        $goods_id = $_POST['goods_id'];//商品ID号
        $area_id = ($type == 2?10:$_POST['area_id']);
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;//供应商的id号

        checkPostData(!($type==1 ||$type==2),'type参数值只能为1或2',4804);
        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        checkPostData(!$goods_id,'goods_id值非法',4872);

        $arr = array();
        //商品数量要大于零
        $arr['amount'] = $_POST['amount'];
        if($arr['amount'] <= 0) printError('请选择数量',4806);

        $arr['goods_id'] = $goods_id;
        $arr['area_id']= $area_id;

        $shopcar = new ShopcarModel($database_type);
        $shopcar->is_login();

        //找材猫
        if( $database_type == 1) $goods_table = $shopcar->getGoodsTable($area_id,$type);
        //品材宝 黄沙水泥
        else $goods_table = 'b2b_pcy_goods';

        is_empty($arr);//检查接收的变量是否为空

        $goods = new GoodsModel($goods_table,$database_type);
        $res = $goods->getSingleInfo(array('goods_id'=>$arr['goods_id'],'is_delete'=>0),'cat_id,suppliers_id,version_id,goods_cat_id');
        if(!$res) $goods->printError('该商品已下架',4800);

        $arr['suppliers_id'] = $res['suppliers_id'];
        $arr['cat_id'] = $res['cat_id'];
        $arr['goods_cat_id'] = $res['goods_cat_id'];
        $arr['version_id'] = $res['version_id'];
        $arr['buyers_id'] = $_SESSION['temp_buyers_id'];

        $result = $shopcar -> addShopCar($arr,$database_type);//判断是否已加入购物车，已加入则直接改变数量，否则把商品加入购物车
        if(!$result) printError($shopcar->error_info,$shopcar->error_code);
        else printSuccess('加入购物车成功');
    }

    /** 删除购物车   shop_car_id*/
    public function delete()
    {
        //验证必须的参数是否有空
        $shop_car_id = $_POST['shop_car_id'];
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;//供应商的id号

        checkPostData(!$shop_car_id,'shop_car_id值非法',4804);
        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);

        $shopcar = new ShopcarModel($database_type);
        $shopcar->is_login();

        $condition['shop_car_id'] = $shop_car_id;
        $b = $shopcar->table($shopcar->tableName)->where($condition)->delete();
        if($b) printSuccess('删除成功');
        else printError('删除失败',5002);
    }

    /** 修改购物车 shop_car_id   amount  该接口 已经做废*/
    public function update()
    {
        //验证必须的参数是否有空
        $type = $_POST['type'];
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 0;//供应商的id号
        checkPostData(!($type==1 ||$type==2),'type参数值只能为1或2',4804);
        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);

        $arr['area_id']= $area_id = $_POST['area_id'];
        $arr['database_type'] = $database_type;
        $shopcar = new ShopcarModel($database_type);
        $shopcar->is_login();

        $shop_car_id = $_POST['shop_car_id'];
        $amount = $_POST['amount'];//商品数量
        if($amount <= 0) printError('请选择数量',4806);

        $data = array('amount'=>$amount);

        $condition['shop_car_id'] = $shop_car_id;
        $b = $shopcar->table($shopcar->tableName)->where($condition)->save($data);
        if($b) printSuccess('修改购物车成功');
        else printError('修改购物车失败',5003);
    }

    /** 收藏 act goods_id   type*/
    public function collect()
    {
        $type = $_POST['type'];
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 1;//供应商的id号

        checkPostData(!($type==1 ||$type==2),'type参数值只能为1或2',4804);
        checkPostData(!($database_type==1),'$database_type参数值只能为1或2',4871);

        $arr=array();
        $arr['area_id']= $area_id = ($type == 2?10:$_POST['area_id']);
        $arr['goods_id']=$_POST['goods_id'];

        $shopcar = new ShopcarModel($database_type);
        $shopcar->is_login();

        //找材猫
        $goods_table = $shopcar->getGoodsTable($area_id,$type);

        $goods = new GoodsModel($goods_table,$database_type);
        $res = $goods->getSingleInfo(array('goods_id'=>$arr['goods_id'],'is_delete'=>0),'cat_id,suppliers_id,version_id,goods_cat_id');
        if(!$res) printError("该商品已经下架",'4861');

        $arr2=array();
        $arr2['suppliers_id'] = $res['suppliers_id'];//供应商的id号
        $arr2['cat_id'] = $res['cat_id'];
        $arr2['goods_cat_id'] = $res['goods_cat_id'];
        $arr2['version_id'] = $res['version_id'];
        $arr2['goods_id']=$arr['goods_id'];
        $arr2['buyers_id'] = $_SESSION['temp_buyers_id'];
        $arr2['area_id'] = $arr['area_id'];//所在城市区域id号
        $arr2['car_type'] = 1;//收藏时car_type=1  加入购物车是car_type=0

        //判断是否已经加入收藏
        //判断收藏夹中是否已经收藏该商品
        $condition_add['buyers_id'] = $arr2['buyers_id'];
        $condition_add['goods_id'] = $arr2['goods_id'];
        $condition_add['area_id'] = $arr2['area_id'];
        $condition_add['suppliers_id'] = $arr2['suppliers_id'];
        $condition_add['car_type'] = 1;
        $result = $shopcar->table($shopcar->tableName)->where($condition_add)->field('shop_car_id')->find();
        if ($result) printSuccess(array('shop_car_id'=>$result['shop_car_id']));

        $b = $shopcar ->table($shopcar->tableName)-> data($arr2) -> add();
        if (!$b) printError('收藏失败',5001);
        else printSuccess(array('shop_car_id'=>$b));
    }

    /** 取消收藏 */
    public function cancel()
    {
        //验证必须的参数是否有空
        $type = $_POST['type'];
        $database_type = isset($_POST['database_type']) ? intval($_POST['database_type']) : 1;//供应商的id号

        checkPostData(!($type==1 ||$type==2),'type参数值只能为1或2',4804);
        checkPostData(!($database_type==1),'黄沙水泥类商品不支持收藏',4871);

        $shopcar = new ShopcarModel($database_type);
        $shopcar->is_login();

        $shop_car_id = $_POST['shop_car_id'];

        $condition['shop_car_id'] = $shop_car_id;
        $b = $shopcar->table($shopcar->tableName)->where($condition)->delete();
        if($b) printSuccess('取消成功');
        else printError('取消失败',5002);
    }

    /** 清空收藏夹*/
    public function clean()
    {
        $area_id = $_POST['area_id'];
        $uid = $_SESSION['temp_buyers_id'];

        $shopcar = new ShopcarModel($database_type = 1);
        $shopcar->is_login();

        $sql_zhaocaimao = "delete from $shopcar->tableName WHERE buyers_id='$uid' AND car_type=1 AND (area_id=10 OR area_id='$area_id')";
        $shopcar->execute($sql_zhaocaimao);

        printSuccess('清空成功');
    }

    /** 收藏夹列表*/
    public function show()
    {
        //验证必须的参数是否有空
        $limit = isset($_POST['pageSize']) ? intval($_POST['pageSize']) : 10;
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $buyers_id = $_SESSION['temp_buyers_id'];
        $area_id = $_POST['area_id'];

        checkPostData(!($area_id),'area_id值非法',4871);

        $shopcar = new ShopcarModel($database_type=1);
        $shopcar->is_login();

        $data = $shopcar -> getCollectByBuyersId($buyers_id,$area_id,$limit,$page);
        if($data === false) printError('服务器错误',5000);
        printSuccess($data);
    }

    /** 购物车列表*/
    public function cart()
    {
        $buyers_id = $_SESSION['temp_buyers_id'];
        $area_id = $_POST['area_id'];

        checkPostData(!($area_id),'area_id值非法',4871);

        $shopcar = new ShopcarModel($database_type=1);
        $shopcar->is_login();

        $data = $shopcar->getByBuyersId($buyers_id,$area_id);
        if($data === false) printError('服务器错误',5000);

        $shopcar->printSuccess($data);
    }

    /** 修改购物车选择型号*/
    public function selectVersion()
    {
        $shop_car_id = $condition['shop_car_id'] =  $_POST['shop_car_id'];
        $goods_id = $condition['goods_id'] = $data['goods_id'] = $_POST['goods_id'];
        $amount = $condition['amount'] = $data['amount'] = $_POST['amount'];
        $uid = $condition['buyers_id'] = $_SESSION['temp_buyers_id'];
        $condition['car_type'] = 0;

        $area_id = $_POST['area_id'];
        $database_type = $_POST['database_type'];

        checkPostData(!($database_type==1 || $database_type==2),'database_type值非法',4871);
        checkPostData(!$goods_id,'goods_id值非法',4871);
        checkPostData(!$amount,'数量不能为0',4871);
        checkPostData(!$shop_car_id,'shop_car_id值非法',4871);

        $shopcar = new ShopcarModel($database_type);

        $count = $shopcar->table($shopcar->tableName)->where($condition)->count();
        if($count >= 1) printSuccess('修改成功'); // 用户没有做任何修改
        else
        {
            $res = $shopcar->getSingleInfo(array('shop_car_id'=>$shop_car_id),'goods_id,amount');
            //用户仅修改数量
            if($res['goods_id'] == $goods_id)
            {
                $b1 = $shopcar->table($shopcar->tableName)->where(array('shop_car_id'=>$shop_car_id))->save(array('amount'=>$amount));//更新传过来的购物车表记录
                if($b1) printSuccess('修改成功');
                else  printError('更新失败',5003);

            }
            else
            {
                //购物车是否存在该商品
                $condition_e['goods_id'] = $goods_id;
                $condition_e['area_id'] = $area_id;
                $condition_e['buyers_id'] = $uid;
                $condition_e['car_type'] = 0;
                $shopcar_res = $shopcar->getSingleInfo($condition_e,'shop_car_id,amount');
                //存在
                if($shopcar_res)
                {
                    $data['amount'] = $data['amount'] + $shopcar_res['amount'];
                    $shopcar->startTrans();
                    $b1 = $shopcar->table($shopcar->tableName)->where(array('shop_car_id'=>$shop_car_id))->save($data);//更新传过来的购物车表记录
                    $b2 = $shopcar->table($shopcar->tableName)->where(array('shop_car_id'=>$shopcar_res['shop_car_id']))->delete();//删除存在的购物车表记录
                    if($b1 && $b2)
                    {
                        $shopcar->commit();
                        printSuccess('修改成功');
                    }
                    else
                    {
                        printError('更新失败',5003);
                        $shopcar->rollback();
                    }

                }
                //不存在
                else
                {
                    $b = $shopcar->table($shopcar->tableName)->where(array('shop_car_id'=>$shop_car_id))->save($data);
                    if(!$b) printError('更新失败',5003);
                    else printSuccess('修改成功');
                }
            }
        }

    }
}