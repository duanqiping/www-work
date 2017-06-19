<?php
/**
 * Created by PhpStorm.
 * User: qiping
 * Date: 2016/7/26
 * Time: 10:11
 */
function returnSearchTop()
{
    return $array1 = array(
        'D16'=>array(
            'D16',
            //'D16 PVC管材/管件',
//                'D16 PPR管材/管件',
            'D16 电线管/管件'),
        'D20'=>array(
            'D20',
//                'D20 PVC管材/管件',
            'D20 PPR管材/管件',
            'D20 电线管/管件'),
        'D25'=>array(
            'D25',
//                'D25 PVC管材/管件',
            'D25 PPR管材/管件',
            'D25 电线管/管件'),
        'D32'=>array(
            'D32',
//                'D32 PVC管材/管件',
            'D32 PPR管材/管件',
            'D32 电线管/管件'),
        'D40'=>array(
            'D40',
            'D40 PVC排水管材/管件',
            'D40 PPR管材/管件',
            'D40 电线管/管件'),
        'D50'=>array(
            'D50',
            'D50 PVC排水管材/管件',
            'D50 PPR管材/管件',
            'D50 电线管/管件'),
        'D75'=>array(
            'D75',
            'D75 PVC排水管材/管件',
            'D75 PPR管材/管件'),
        'D90'=>array(
            'D90',
            'D90 PVC排水管材/管件',
            'D90 PPR管材/管件'),
        'D110'=>array(
            'D110',
            'D110 PVC排水管材/管件',
            'D110 PPR管材/管件'),
        'D160'=>array(
            'D160',
            'D160 PVC排水管材/管件',
            'D160 PPR管材/管件')
    );
}

function returnSearchNext()
{
    return $pointArray = array(

//            'D16 PVC管材/管件'=>array(58),
//            'D16 PPR管材/管件'=>array(290),
        'D16 电线管/管件'=>array(147,253,297,296,65,294),


//            'D20 PVC管材/管件'=>array(58),
        'D20 PPR管材/管件'=>array(290,291,226,227),
        'D20 电线管/管件'=>array(147,253,297,296,65,294),


//            'D25 PVC管材/管件'=>array(58,219,288,289),
        'D25 PPR管材/管件'=>array(290,291,226,227),
        'D25 电线管/管件'=>array(147,253,297,296,65,294),


//            'D32 PVC管材/管件'=>array(58,219,288,289),
        'D32 PPR管材/管件'=>array(290,291,226,227),
        'D32 电线管/管件'=>array(147,253,297,296,65,294),


        'D40 PVC排水管材/管件'=>array(58,219,288,289),
        'D40 PPR管材/管件'=>array(290,291,226,227),
        'D40 电线管/管件'=>array(147,253,297,296,65,294),


        'D50 PVC排水管材/管件'=>array(58,219,288,289),
        'D50 PPR管材/管件'=>array(290,291,226,227),
        'D50 电线管/管件'=>array(147,253,297,296,65,294),


        'D75 PVC排水管材/管件'=>array(58,219,288,289,227),
        'D75 PPR管材/管件'=>array(290.291,226),


        'D90 PVC管材/管件'=>array(58,219,288,289,227),
        'D90 PPR管材/管件'=>array(290.291,226),

        'D110 PVC排水管材/管件'=>array(58,219,288,289,227),
        'D110 PPR管材/管件'=>array(290.291,226),

        'D160 PVC排水管材/管件'=>array(58,219,288,289,227),
        'D160 PPR管材/管件'=>array(290.291,226)
    );
}

//指定搜索关键字  brand_ids 处理
function returnBrandIds($pointArray,$name)
{
    $b = in_array($pointArray[$name],$pointArray);//一维数组下标

    if($b === false)
    {
        $where_brand_ids = '';
    }
    else
    {
        $where_brand_ids = '(';
        for($i=0,$len=count($pointArray[$name]);$i<$len;$i++)
        {
            if($i == $len-1) $where_brand_ids .= $pointArray[$name][$i].')';
            else $where_brand_ids .= $pointArray[$name][$i].',';
        }
    }

    return $where_brand_ids;
}