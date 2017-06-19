<?php
/**
 * Created by PhpStorm.
 * User: duanqp
 * Date: 2016/3/1
 * Time: 11:52
 */

class OrderAction extends Action
{
    //商品评价
    public function comment()
    {
        //post temp_purchase_id,content

        $data['order_id'] = $arr['temp_purchase_id'] = $_POST['temp_purchase_id'];
        $num[0] = $data['trans_grade'] = $_POST['trans_grade'];
        $num[1] = $data['goods_grade'] = $_POST['goods_grade'];
        $num[2] = $data['service_grade'] = $_POST['service_grade'];

        for($i=0; $i<count($num); $i++)
        {
            if (!in_array($num[$i], array(1,2,3,4,5))) {
                $response = array('success' => 'false', 'error' => array('msg'=>'评分只能是1到5分','code'=>'4162'));
                $response = ch_json_encode($response);
                exit($response);
            }
        }

        is_empty($arr);

        if(isset($_POST['content']))
        {
            $data['content'] = $arr['content'] = $_POST['content'];//评价内容可以为空
        }

        $commentModel = new BaseModel('CommentMobile');
        $commentModel->is_login();

        $data['time'] = time();
        $data['user_id'] = $_SESSION['temp_buyers_id'];

        $sql = 'update ecs_temp_purchase set is_comment=1 where temp_purchase_id='.$_POST['temp_purchase_id'];
        $b = $commentModel->execute($sql);//更新订单的评价状态

        if($commentModel->add($data)  && $b)
        {
            $response = array('success' => 'true', 'data' => '评价成功');
            $response = ch_json_encode($response);
            exit($response);
        }else
        {
            $response = array('success' => 'false', 'error' => array('msg'=>'评价失败','code'=>'4920'));
            $response = ch_json_encode($response);
            exit($response);
        }

    }

    //查询几种订单状态的数目
    public function state()
    {
        $temppurchase = new TempPurchaseModel(1);
        $temppurchase -> is_login();//判断是否登录

        $user_id = $_SESSION['temp_buyers_id'];

        $temppurchase->cleanOrder($user_id);//找材猫

        $sql_e11 = "SELECT COUNT(*) AS tp_count FROM ecs_temp_purchase WHERE ( is_delete = 0 ) AND ( payer_id='$user_id' or buyers_id='$user_id' ) AND ( state = '1' ) LIMIT 1 ";
        $sql_e12 = "SELECT COUNT(*) AS tp_count FROM pcwb2bs.b2b_pcy_purchase WHERE ( is_delete = 0 ) AND ( buyers_id='$user_id' ) AND ( state = '1' ) LIMIT 1 ";

        $sql_e21 = "SELECT COUNT(*) AS tp_count FROM ecs_temp_purchase WHERE ( is_delete = 0 ) AND (buyers_id='$user_id' ) AND ( state = '2' ) LIMIT 1 ";
        $sql_e22 = "SELECT COUNT(*) AS tp_count FROM pcwb2bs.b2b_pcy_purchase WHERE ( is_delete = 0 ) AND ( buyers_id='$user_id' ) AND ( state = '2' ) LIMIT 1 ";

        $sql_e31 = "SELECT COUNT(*) AS tp_count FROM ecs_temp_purchase WHERE ( is_delete = 0 ) AND ( buyers_id='$user_id' ) AND ( state = '3' ) LIMIT 1 ";
        $sql_e32 = "SELECT COUNT(*) AS tp_count FROM pcwb2bs.b2b_pcy_purchase WHERE ( is_delete = 0 ) AND ( buyers_id='$user_id' ) AND ( state = '3' ) LIMIT 1 ";

        $sql_e51 = "SELECT COUNT(*) AS tp_count FROM ecs_temp_purchase WHERE ( is_delete = 0 ) AND ( buyers_id='$user_id' ) AND ( state in (5,6) ) LIMIT 1 ";
        $sql_e52 = "SELECT COUNT(*) AS tp_count FROM pcwb2bs.b2b_pcy_purchase WHERE ( is_delete = 0 ) AND ( buyers_id='$user_id' ) AND ( state in(5,6) ) LIMIT 1 ";

        $res_e11 = $temppurchase->query($sql_e11);
        $res_e12 = $temppurchase->query($sql_e12);

        $res_e21 = $temppurchase->query($sql_e21);
        $res_e22 = $temppurchase->query($sql_e22);

        $res_e31 = $temppurchase->query($sql_e31);
        $res_e32 = $temppurchase->query($sql_e32);

        $res_e51 = $temppurchase->query($sql_e51);
        $res_e52 = $temppurchase->query($sql_e52);

        $data['num1'] = $res_e11[0]['tp_count']+$res_e12[0]['tp_count'];//待付款
        $data['num2'] = $res_e21[0]['tp_count']+$res_e22[0]['tp_count'];//待发货
        $data['num3'] = $res_e31[0]['tp_count']+$res_e32[0]['tp_count'];//待收货
        $data['num4'] = $res_e51[0]['tp_count']+$res_e52[0]['tp_count'];//退款

        $response = array('success' => 'true', 'data' => $data);
        $response = ch_json_encode($response);
        exit($response);


    }
} 