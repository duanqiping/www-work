<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2015/9/24
 * Time: 10:30
 */
class OtherAction extends Action
{
    //版本型号接口
    public function version()
    {
        $device = 0;

        if (isset($_POST['device'])) {
            $device = $_POST['device'];
        }
        $data = array();
        if ($device == 0) {//android
            $data['version'] = '4.0.2';
            $data['versionCode'] = 129;
            $data['desc'] = "1.专区原生展示商品;\n2.专区支持微信支付;\n3.购物车支持修改商品规格/颜色。";
            $data['url'] = 'http://www.aec188.com/askprice/download/PcwStore.apk';
        }else { //ios
            $data['version'] = '3.3.0';
//            $data['desc'] = "1.未发货的订单可以随时补货了;\n2.搜索商品智能化、个性化，更快更方便;\n3.优化下单流程，下单更快方便。";
            $data['desc'] = "1.新增自动化智能下单，一键自动计算各工种的材料清单及智能下单;\n2.新增智能搜索;\n3.优化现场下单、公司支付的流程。";
            $data['url'] = 'https://geo.itunes.apple.com/cn/app/zhao-cai-mao-zhuang-xiu-fu/id1033784965?mt=8';
        }
        $data['force'] = false;//true开启 false不开启 是否强制升级
        $data['hiddenMainMaterial']=false;//false 开启批发 true 隐藏批发
        $data['isTest']=isTest;//测试数据库true  正式数据库false

        $data['MainMaterial']['title'] = '主材商城';
        $data['MainMaterial']['short_title'] = '批发商品';
        $data['MainMaterial']['desc'] = '辅材、主材、专店商品请分别下单';

        $response = array('success' => 'true', 'data' => $data);
        $response = ch_json_encode($response);
        exit($response);
    }

    //价格限制说明
    public function desc()
    {
        $goodsarea = new GoodsAreaModel();

        $condition['goods_area_id'] = $_POST['area_id'];
        $res_f = $goodsarea->where($condition)->field('min_money')->find();//获取辅材去结算的最低限制价格
        $condition['goods_area_id'] = 10;
        $res_z = $goodsarea->where($condition)->field('min_money')->find();//获取批发去结算的最低限制价格

        $data['desc_f'] = "满".$res_f['min_money']."才可下单";
        $data['desc_z'] = "满".$res_z['min_money']."才可下单";

        $response = array('success' => 'true', 'data' => $data);
        $response = ch_json_encode($response);
        exit($response);
    }

    //md5
    public function rnjsbundle()
    {
        $md5 = $_POST['md5'];

        $str = file_get_contents($_SERVER['DOCUMENT_ROOT'].'Download/main.ios.jsbundle');

        if($md5 == md5($str))
        {
            $response = array('success' => 'false', 'error' => array('msg'=>'md5 一样','code'=>'4157'));
            $response = ch_json_encode($response);
            exit($response);
        }else
        {
            $md5_url = NROOT.'/Download/main.ios.jsbundle';
            $data = array('download'=>$md5_url);
            $response = array('success' => 'true', 'data' => $data);
            $response = ch_json_encode($response);
            exit($response);
        }
    }

    //接收参数 打印log
    public function log()
    {
        import('ORG.Rest.RestUtils');

        $rest = new RestUtils();
        $result = $rest->processRequest();
        $data = $result->getData();

        $string = '';
        foreach($data as $k=>$v)
        {
            $string .= $k.'=>'.$v.' ';
        }
        $time = time();

        $b = file_put_contents('./Runtime/Logs/other/log.txt',   $string . '--' . $time . "\n", FILE_APPEND);
        if($b)
        {
            $response = array('success' => 'success', 'data' => '存储成功');
            $response = ch_json_encode($response);
            exit($response);
        }else
        {
            $response = array('success' => 'false', 'error' => array('msg'=>'存储日志失败','code'=>'4157'));
            $response = ch_json_encode($response);
            exit($response);
        }

    }

    //删除数据库 用户信息 用户账号  订单信息 购物车信息等
    public function delete()
    {
        $buyers = new TempBuyersModel();
        $mobile = $_POST['mobile'];
        if($_SESSION['temp_buyers_mobile'] != '18621715257')
        {
            echo "只有管理员才能执行此项操作";
            exit();
        }
        else
        {
            $condition['temp_buyers_mobile']=$mobile;
            $buyers_info = $buyers->where($condition)->field('temp_buyers_id')->find();
            $user_id = $buyers_info['temp_buyers_id'];
            //ecs_temp_buyers 表删除
            $b1 = $buyers->where($condition)->delete();
            if($b1) echo "ecs_temp_buyers 删除成功";
            else echo "ecs_temp_buyers 删除失败";
            echo "<br/>";
            //ecs_temp_account 表删除
            $sql_account = "delete from ecs_temp_account WHERE temp_buyers_id=".$user_id;
            $b2 = $buyers->execute($sql_account);
            if($b2) echo "ecs_temp_account 删除成功";
            else echo "ecs_temp_account 删除失败";
            echo "<br/>";

            //ecs_temp_purchase 表删除
            $sql_account = "delete from ecs_temp_purchase WHERE buyers_id=".$user_id;
            $b2 = $buyers->execute($sql_account);
            if($b2) echo "ecs_temp_purchase 删除成功";
            else echo "ecs_temp_purchase 删除失败";
            echo "<br/>";

            //ecs_shopcar 表删除
            $sql_account = "delete from ecs_shopcar WHERE buyers_id=".$user_id;
            $b2 = $buyers->execute($sql_account);
            if($b2) echo "ecs_shopcar 删除成功";
            else echo "ecs_shopcar 删除失败";
            echo "<br/>";



        }
    }
}
