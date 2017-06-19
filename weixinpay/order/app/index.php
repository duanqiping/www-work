<?php

/**
    找人代付生成 支付订单接口
 */

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "../app/WxPay.JsApiPay.php";
require_once '../app/log.php';

error_reporting(E_ALL & ~E_NOTICE);
//ini_set("display_errors", "On");//显示所有错误信息  Off为屏蔽所有错误信息

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

$order_sn = $_GET['order_sn'];
if(!$order_sn)
{
    echo "order_sn参数不能为空";
    exit();
}

$conn =  mysql_connect('localhost', 'root','aecsqlyou');
if(!$conn){
    exit('数据库连接失败');
}
$sql = 'set names utf8';
mysql_query($sql);
$sql = 'use ecshop_mobile_test';
//$sql = 'use ecshop';
mysql_query($sql);

//查询订单信息
$sql_order = "select temp_purchase_id,temp_purchase_sn,buyers_id,time,money,name,address,mobile,state,method,description,receive_time,finish_time,method,transportation,account_money,payer_id,is_comment from ecs_temp_purchase WHERE state=1 AND is_delete=0 AND temp_purchase_sn='$order_sn'";
$rs_order = mysql_query($sql_order);
$res_order = mysql_fetch_assoc($rs_order);
if(!$res_order) exit('订单号无效');

//对应的商品表
$sql_table = "select goods_table,goods_category_table from ecs_goods_area where goods_area_id=(SELECT area_id from ecs_temp_purchase_goods WHERE temp_purchase_sn='$order_sn' limit 1)";
$rs_table = mysql_query($sql_table);
$res_table = mysql_fetch_assoc($rs_table);
$goods_table =$res_table['goods_table'];
$goods_category_table = $res_table['goods_category_table'];

//查询订单商品信息
$sql_goods = "select a.version,a.amount,a.unit goods_unit,a.price shop_price,a.description,a.name goods_name,a.goods_cat_id,a.goods_id,a.brand_name,a.area_id,a.goods_color,b.goods_cat_id,b.sort_order,b.goods_thumb from ecs_temp_purchase_goods a left join $goods_table b on a.goods_id=b.goods_id left join $goods_category_table c on b.goods_cat_id=c.goods_category_id  where a.temp_purchase_sn='$order_sn' and a.amount>0 order by c.sort_order,b.goods_cat_id";
$rs_goods = mysql_query($sql_goods);
$goods_data = array();
while($row=mysql_fetch_assoc($rs_goods))
{
    $row['goods_thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/ecshop2/customer/'.$row['goods_thumb'];
    $goods_data[] = $row;
}

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}


//$openId =  $_GET['openId'];

//②、统一下单
$total_fee = intval(($res_order['money'] - $res_order['account_money']) * 100);

$input = new WxPayUnifiedOrder();
$input->SetBody("品材商品");
$input->SetAttach("用户id");//需要传
//$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetOut_trade_no($res_order['temp_purchase_sn']);
$input->SetTotal_fee($total_fee);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://www.pcw365.com/ecshop2/MobileAPI/weixinpay/order/app/notifyFor.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);


$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */

?>

<!--</head>-->
<!--<body>-->
<!--<br/>-->
<!--<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>-->
<!--<div align="center">-->
<!--    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->
<!---->



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width initial-scale=1, maxinum-scale=1" name="viewport">
    <meta content="telephone=no" name="format-detection" />
	<title>找人代付</title>
	<style type="text/css">
/**
    dark:	#424242
    orange 	#fc5e17
    blue 	#00acff
    gray 	#7b7b7b
*/

	body {
		background-color: #f4f4f4;
		margin: 0;
		padding: 0;
	}


	.dark {
		color: #424242;
	}

	.orange {
		color: #fc5e17;
	}

	.gray {
		color: #7b7b7b;
	}

	.bg-white {
		background-color: white;
	}

	.line {
		background-color: #f4f4f4;
		width: 100%;
		height: 1px
	}

	.padding {
		padding: 10px;
	}

	.padding-right {
		padding-right: 10px
	}

	.big-font{
		font-size: 18px;
	}
	.nor-font {
		font-size: 16px;
	}
	


	.explanation {
		color: #424242;
		margin-top: -20px
	}

	.explanation > ul {
		list-style-type: none;;
		padding: 0.4rem 0.8rem;
		font-size: 16px;
	}

	.explanation > ul > li {
		padding: 0.4rem 0;
	}

	.order-list {
		margin-top: -10px;
		margin-bottom: -10px

	}

	.order-list >ul {
		list-style-type: none;
		padding: 0 0.8rem;
	}

	/*分享按钮*/
	.share-btn {
		padding: 10px 20px;
	}

	.share-btn > button {
		width: 100%;
		height: 43px;
		background-color: #fc5e17;
		color: white;
		font-size: 18px;
		border: 0;
		border-radius:4px;
	}

	</style>

    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg == "get_brand_wcpay_request:ok"){
                        //alert(res.err_code+res.err_desc+res.err_msg);
                        alert('支付成功');
//                        window.location.href="http://xxxxxx";
                    }else{
                        //返回跳转到订单详情页面
                        alert('支付失败');
//                        window.location.href="http://xxxxx/index.php?wxid={$openid}";

                    }
//                    alert(res.err_code+res.err_desc+res.err_msg);
//                    alert('支付失败');
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
    <script type="text/javascript">
        //获取共享地址
        function editAddress()
        {
            WeixinJSBridge.invoke(
                'editAddress',
                <?php echo $editAddress; ?>,
                function(res){
                    var value1 = res.proviceFirstStageName;
                    var value2 = res.addressCitySecondStageName;
                    var value3 = res.addressCountiesThirdStageName;
                    var value4 = res.addressDetailInfo;
                    var tel = res.telNumber;

                    alert(value1 + value2 + value3 + value4 + ":" + tel);
                }
            );
        }

//        window.onload = function(){
//            if (typeof WeixinJSBridge == "undefined"){
//                if( document.addEventListener ){
//                    document.addEventListener('WeixinJSBridgeReady', editAddress, false);
//                }else if (document.attachEvent){
//                    document.attachEvent('WeixinJSBridgeReady', editAddress);
//                    document.attachEvent('onWeixinJSBridgeReady', editAddress);
//                }
//            }else{
//                editAddress();
//            }
//        };

    </script>
</head>


<body>
 

    <!-- 订单单头 -->
    <div class="explanation bg-white" >
    	<ul>
    		<li>
    			<span >订单号：</span><span><?php echo $res_order['temp_purchase_sn'];?></span>
    		</li>
    		<li>
    			<span >下单时间：</span><span><?php echo date('Y-m-d H:i:s',$res_order['time']);?></span>
    		</li>
    	</ul>
    </div>

    <div class="order-list bg-white">
        <ul>
        <?php
            for($i=0,$len=count($goods_data);$i<$len;$i++)
            {
                ?>
                <li >
                    <table width="100%">
                        <tr>
                            <td width="100px"><img onerror="this.src='../img/bg_image_faile.png'" src="<?php echo $goods_data[$i]['goods_thumb'];?>" style="width: 80px"></td>
                            <td>
                                <p class="dark"><?php echo $goods_data[$i]['goods_name'];?></p>
                                <p class="gray"><span><?php echo $goods_data[$i]['version'];?></span><br><span><?php echo $goods_data[$i]['goods_color'];?></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="orange" class="padding">￥<span><?php echo $goods_data[$i]['shop_price'];?></span>/<span><?php echo $goods_data[$i]['goods_unit'];?></span><div></td>
                            <td align="right" class="padding">x<span style="margin-right: 10px"><?php echo $goods_data[$i]['amount'];?></span></td>
                        </tr>
                    </table>

                    <div class="line"></div>
                </li>
                <?php
            }
        ?>
        </ul>
    </div>



	<div class="bg-white" >
    	
    		<div class="padding">
    			<span  class="dark padding-right">送货时间</span><span class="gray"><?php echo $res_order['receive_time'];?></span>
    			
    		</div>
    		<div class="line"></div>
    		<div  class="padding">
    			<span class="dark padding-right" >买家留言</span><span class="gray"><?php echo $res_order['description'];?></span>
    		</div>
    	
    </div>

    <div class="bg-white" style="margin-top: 10px">
	    <div class="padding">
	    	 <span>商品金额</span>
		    <div style="float:right"><span class="orange" ><?php echo $res_order['money'];?></span>
		    </div>
	    </div>
	    <div class="padding">
	    	 <span>运费</span>
		    <div style="float:right"><span class="orange" ><?php echo $res_order['transportation'];?></span>
		    </div>
	    </div>
	    <div class="line" style="padding: 0 10px"></div>
	    <div class="padding">
	    <span>&nbsp;</span>
		    <div style="float:right"><span >实付款：</span><span class="orange" ><?php echo sprintf("%.2f", $res_order['transportation']+$res_order['money'] - $res_order['account_money']);?></span>
		    </div>
	    </div>
   
    </div>

	
    <!-- 分享 -->
    <div class="share-btn">
    	<button onclick="callpay()"> 支付</button>
    </div>
</body>
</html>