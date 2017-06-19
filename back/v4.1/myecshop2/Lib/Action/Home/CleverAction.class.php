<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/9/1
 * Time: 16:58
 * 智能下单 控制器
 */
class CleverAction extends Action
{


    /**生成清单
     */
    public function handle()
    {
        load("@.clever");//引入自定义函数

        $flag = false;
        if($_POST)
        {
            $classfy  = $_POST["Classfy"];  //类别
            $area     = $_POST["Area"];     //总面积
            $roomN    = $_POST["RoomN"];    //室数量
            $sittingN = $_POST["SittingN"]; //厅数量
            $kitchenN = $_POST["KitchenN"]; //厨房数
            $toiletN  = $_POST["ToiletN"];  //卫生间数
            $balconyN = $_POST["BalconyN"]; //阳台数
            $deskType = $_POST["DeskType"]; //柜台样式
            $deskHight= $_POST["DeskHight"];//柜台高
            $sitArea  = $_POST["SittingArea"];//厅面积   （该参数已经弃用）
        }
        else
        {
            $flag = true;
            $put_vars = file_get_contents('php://input');//raw  json/application 提交
            $put=json_decode($put_vars,1);

            foreach ($put as $key => $value) {
                $_POST[$key]=$value;
            }

            $classfy  = $_POST["Classfy"];  //类别
            $area     = $_POST["Area"];     //总面积
            $roomN    = $_POST["RoomN"];    //室数量
            $sittingN = $_POST["SittingN"]; //厅数量
            $kitchenN = $_POST["KitchenN"]; //厨房数
            $toiletN  = $_POST["ToiletN"];  //卫生间数
            $balconyN = $_POST["BalconyN"]; //阳台数
            $deskType = $_POST["DeskType"]; //柜台样式
            $deskHight= $_POST["DeskHight"];//柜台高
            $sitArea  = $_POST["SittingArea"];//厅面积   （该参数已经弃用）
        }

//        $classfy  = $_POST["Classfy"];  //类别
//        $area     = $_POST["Area"];     //总面积
//        $roomN    = $_POST["RoomN"];    //室数量
//        $sittingN = $_POST["SittingN"]; //厅数量
//        $kitchenN = $_POST["KitchenN"]; //厨房数
//        $toiletN  = $_POST["ToiletN"];  //卫生间数
//        $balconyN = $_POST["BalconyN"]; //阳台数
//        $deskType = $_POST["DeskType"]; //柜台样式
//        $deskHight= $_POST["DeskHight"];//柜台高
//        $sitArea  = $_POST["SittingArea"];//厅面积   （该参数已经弃用）

        $other = 1;
        if($classfy == 4 || $classfy == 5) $other = isset($_POST['other'])?$_POST['other']:1;//0否 1是

        if($area) checkPostData(($area<30 || $area>300),$msg = $area<30?'房间太小了，挤到找材猫都进不来了':'面积这么大，是别墅吧',4811);
//        if($sitArea) checkPostData(($sitArea<30 || $sitArea>300),$msg = $sitArea<30?'房间太小了，挤到品材猫都进不来了':'面积这么大，是别墅吧',4811);

//        $res=array('code'=>"0",'material'=>"");
        $res=array();
        if(isset($classfy)&&isset($area)&&isset($roomN)&& isset($sittingN)&& isset($kitchenN)&&isset($toiletN)
            &&isset($balconyN)&& isset($deskType)&& isset($deskHight)&& isset($sitArea)){
            $arg = array();
            $arg["area"]     = $area;
            $arg["roomN"]    = $roomN;
            $arg["sittingN"] = $sittingN;
            $arg["kitchenN"] = $kitchenN;
            $arg["toiletN"]  = $toiletN;
            $arg["balconyN"] = $balconyN;
            $arg["deskType"] = $deskType;
            $arg["deskHeight"]= $deskHight;
            $arg["sitArea"]  = $sitArea;
//            $res["material"] = getNums($classfy,$arg);
            $res = getNums($classfy,$arg,$other);
        }

        $goods = new GoodsModel('ecs_goods',1);
        $data = $goods->cleverGoodsInfo($res);

        if($flag) printSuccess2($data);
        else printSuccess($data);

    }

    /**柜台木工
    */
    public function wood()
    {
//        $base = new BaseModel();
//        $base->is_login();

        $data = array(
            'width'=>array(
                array('id'=>'1','name'=>'单柜 宽1.2m'),
                array('id'=>'2','name'=>'双柜 宽1.2m'),
                array('id'=>'3','name'=>'单柜 宽2.4m'),
//                array('id'=>'4','name'=>'双柜 宽3~4.5m'),
            ),

//            'height'=>array('2.5m','1.2m'),
            'height'=>array(
                array('id'=>'2.5','name'=>'2.5m'),
                array('id'=>'1.2','name'=>'1.2m'),
            ),
        );

       printSuccess($data);
    }

    /**批量插入
     * goods_arr多维数组 goods_id   amount
     * area_id
     * type
    */
    public function add()
    {
        $shopcar = new ShopcarModel(1);
        $shopcar->is_login();

        $uid = $_SESSION['temp_buyers_id'];
        $area_id = isset($_POST['area_id'])?$_POST['area_id']:1;

        if(IS_POST)
        {

            if(isset($_POST['goods_arr']))
            {
                $goods_arr = $_POST['goods_arr'];
            }
            else
            {
                $goodsInfo_string = $_POST['goodsInfo'];//设计组调用该接口 会传一个 "7039_7075_7086&1_3_1" 类似的字串
                if(!$goodsInfo_string) printError('参数有误',4800);

                $goodsInfo_array = explode('@',$goodsInfo_string);

                $goods_id_string = $goodsInfo_array[0];
                $goods_amount_string = $goodsInfo_array[1];

                $goods_id_arr = explode('_',$goods_id_string);
                $goods_amount_arr = explode('_',$goods_amount_string);
                $goods_arr = array();
                for($i=0,$len=count($goods_id_arr);$i<$len;++$i)
                {
                    $goods_arr[$i]['goods_id'] = $goods_id_arr[$i];
                    $goods_arr[$i]['amount'] = $goods_amount_arr[$i];
                }
            }

            if(!$goods_arr) printError('商品信息不能为空',4800);

            $result = $shopcar->cleverAddAll($goods_arr,$uid,$area_id);

            if(!$result) printError('加入购物车失败',4682);
            else printSuccess('成功加入购物车');
        }
        else
        {
            printError('数据不能为空',4681);
        }
    }
}