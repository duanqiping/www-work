<?php
/**
 * Created by PhpStorm.
 * User: duanqiping
 * Date: 2016/11/29
 * Time: 9:34
 */
class PcwAction extends Action
{
    /** 获取供应商信息*/
    public function info()
    {
        $goods_id = $_POST['goods_id'];
        $database_type = $_POST['database_type']?$_POST['database_type']:1;

        checkPostData(!$goods_id,'商品id有误',4800);
        if($database_type == 2)
        {
            $sql = "select pu.user_id,pu.telephone,pu.img,pu.address,pu.pcy_companyname,pu.pcy_company_person,pu.qq,pu.weixinid,pu.pcy_company_cashtype,pu.pcy_company_sellinfo from ".
                "pcwb2bs.b2b_user pu left join pcwb2bs.b2b_pcy_goods pg on pu.user_id=pg.suppliers_id where pg.goods_id='$goods_id' ";

            $model = new Model();
            $res = $model->query($sql);
            $res = $res[0];

            if(!$res) printError('未能查询到供应商信息',4800);
            else
            {
                $res['img'] = b2bImgDeal($res['img']);
                if($res['pcy_company_cashtype'] == 'ONLY_CASH') $res['pcy_company_cashtype'] = '仅现结支付';
                else if($res['pcy_company_cashtype'] == 'CASH_AND_COD') $res['pcy_company_cashtype'] = '现结及货到付款';
                else $res['pcy_company_cashtype'] = false;
            }
        }
        else
        {
            $res['user_id'] = '1024';
            $res['telephone'] = '4006002063';
            $res['pcy_companyname'] = '上海晓材科技有限公司';
            $res['pcy_company_person'] = '上海晓材科技有限公司';
        }

        printSuccess($res);
    }

    /** 供应商详情*/
    public function detail()
    {
        $suppliers_id = $_POST['cat_id'];
        checkPostData(!$suppliers_id,'供应商id有误',4800);

        $database_type = 2;

        load("@.pcw");
        $goodsModel = new GoodsModel('b2b_pcy_goods',$database_type);
        $sql = "select user_id,sp_vip,sp_rank,shop_sn,img,access_time,name,telephone,img,salt,sex,email,address,pcy_companyname,pcy_company_person,qq,weixinid,pcy_company_area,pcy_company_cashtype,pcy_company_sellinfo,receive_time,global_trans_desc from pcwb2bs.b2b_user WHERE user_id='$suppliers_id'";
        $res = $goodsModel->query($sql);
        $res = $res[0];

        $res['pcy_company_desc'] = $res['pcy_company_sellinfo'];
        $res['img'] = b2bImgDeal($res['img']);
        $res['pcy_company_cashtype'] = b2bPayMethodToChina($res['pcy_company_cashtype']);

        //推荐产品
        $goodsinfo = $goodsModel->suppliersGoodsRecommend($database_type,$suppliers_id);
        $res['goodsInfo'] = $goodsinfo;

        printSuccess($res);
    }
}