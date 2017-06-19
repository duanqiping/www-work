<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/11/11
 * Time: 10:01
 */

namespace Index\Controller;
use Common\Controller\BaseController;
use Think\Controller;

class MaterialController extends BaseController
{
    /** 家装预算
     * HomeType 房间类型
     * DataType 数据类型
     * HomeData[length] 长  HomeData[width] 宽  HomeData[height] 高 ( 房间参数)
     * DoorData[0][width] DoorData[0][height](门 多维 参数)
     * WindowData[0][width] WindowData[0][height] (窗 多维 参数)
     */
    public function budget()
    {
        vendor('HcWeb.handle.getList');

        if($_POST['list']) $_POST = $_POST['list'];//ios 那边传的数据是一个 key 数组的形式

        $data = budget($_POST);
       
        if(!$data) sendError('参数有误',400);
        else sendSuccess($data);
    }

    public function budgets() {
        vendor('HcWeb.handle.getList');
        sendSuccess(budgets(size($_POST)));
    }

    /**计算 门窗信息
    */
    public function size()
    {
        vendor('HcWeb.handle.getList');
        sendSuccess(size($_POST));
    }

    /**
     */
    public function test()
    {
        $string = '7039_7075_7086&1_1_1';
        $array = explode('&',$string);
        $goods_string = $array[0];
        $nums_string = $array[1];

        $goods_arr = explode('_',$goods_string);
        $goods_nums = explode('_',$nums_string);
        var_dump($goods_arr);
        var_dump($goods_nums);
    }
}