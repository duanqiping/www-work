
    /**
 * @api {post} v3.1/myecshop2/center/order/comment 评价
 * @apiVersion 3.1.0

 * @apiGroup user_center
 * @apiParam {String} temp_purchase_id 订单id号
 * @apiParam {String} content 评价内容
 * @apiParam {String} trans_grade 物流评分
 * @apiParam {String} goods_grade 商品评分
 * @apiParam {String} service_grade 服务评分

 * @apiSuccessExample {json} 成功返回结果-
*{"success":"true","data":"评价成功"}

* @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"评价失败","code":"4921"}}
  *{"success":"false","error":{"msg":"评分只能是1到5分","code":"4162"}}
 **/

    /**
 * @api {post} v3.1/myecshop2/center/push/add 消息推送把用户手机信息入库
 * @apiVersion 3.1.0

 * @apiGroup push
 * @apiParam {String} device 手机类型(1指的是安卓,2指的是ios)
 * @apiParam {String} push_id 实际上就是channel_id

 * @apiSuccessExample {json} 成功返回结果-
*{"success":"true","data":{"msg":"用户手机信息入库成功"}}

 **/

     /**
 * @api {post} v3.1/myecshop2/center/push/show 消息列表
 * @apiVersion 3.1.0

 * @apiGroup push

 * @apiParam {String} device 设备类型(1:安卓 2:ios)

 * @apiSuccessExample {json} 成功返回结果-
 *type说明  1文本  2网页  3订单  4other
 *{
 * "success": "true",
 * "data": [
 *   {
 *     "message_id": "37",
 *     "title": "test",
 *     "content": "just test",
 *     "extend": "大胆贼人",
 *     "time": "4",
 *     "type": "1"
 *   },
 *   {
 *     "message_id": "36",
 *     "title": "找材猫",
 *     "content": "你好",
 *     "extend": "https://www.baidu.com",
 *     "time": "2",
 *     "type": "2"
 *   }
 * ]
*}

 **/

    /**
 * @api {post} v3.1/myecshop2/center/order/state 查询几种订单状态的数目
 * @apiVersion 3.1.0

 * @apiGroup user_center

 * @apiSuccessExample {json} 成功返回结果-
 *num1:待付款	num2:待发货	 num3:待收货	num4:退款
 *{"success":"true","data":{"num1":"0","num2":"3","num3":"0","num4":"0"}}

 **/

   /**
 * @api {post} v3.1/myecshop2/bank/create 创建支付订单
 * @apiVersion 3.1.0

 * @apiGroup bank
 * @apiParam {String} [save_code] 安全码
 * @apiParam {String} [valid_time] 有效时间
 * @apiParam {String} order_sn 订单号
 * @apiParam {String} temp_bankcard_id 银行列表id号

 * @apiSuccessExample {json} 成功返回结果-
*{
*  "success": "true",
*  "data": "1",
*  "cache": "AFxXUwZNA2FQZgVrBzwGMA00WmtQZAVtUWdVPgFhB2MAOAFlCDwDY1NhAh0NNgUxDDZUYV9vAG5UagJuAWJUNgA7VzAGNwNkUGEFbAdKBjgNPVppUG4FaVFgVWgBNAd/AG4BMQg6A2VTeAJpDWEFZwwzVHlfYABuVGYCbwF8VDQAaldiBjYDN1AzBRoHOAYwDTRabFBnBWxRZlU6AWAHYQA8AWYIPwNl"
*}

 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"该订单已完成","code":"4911"}}

 **/

      /**
 * @api {post} v3.1/myecshop2/bank/supportList 麦网支持的银行卡列表
 * @apiVersion 3.1.0

 * @apiGroup bank


 * @apiSuccessExample {json} 成功返回结果-
 *{
 * "success": "true",
 * "data": {
 *   "储蓄卡": [
 *     {
 *       "bankName": "兴业银行",
 *       "bankCardType": "DR",
 *       "bankCode": "CIB",
 *       "url": "http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/CIB.png"
 *     },
 *     {
 *       "bankName": "中国银行",
 *       "bankCardType": "DR",
 *       "bankCode": "BOC",
 *       "url": "http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/BOCB2C.png"
 *     }
 *   ],
 *   "信用卡": [
 *     {
 *       "bankName": "东亚银行",
 *       "bankCardType": "CR",
 *       "bankCode": "HKBEA",
 *       "url": "http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/.png"
 *     },
 *     {
 *       "bankName": "南昌银行",
 *       "bankCardType": "CR",
 *       "bankCode": "NCC",
 *       "url": "http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/.png"
 *     }
 *   ]
 *  } 
*}	
 **/

    /**
 * @api {post} v3.1/myecshop2/bank/confirm 确认支付
 * @apiVersion 3.1.0

 * @apiGroup bank
 * @apiParam {String} code 验证码
 * @apiParam {String} cache h5需要传这个参数

 * @apiSuccessExample {json} 成功返回结果-
 *{"success":"true","data":"支付成功"}

 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"手机验证码有误[输入的验证码有误]","code":"4911"}}

 **/

   /**
 * @api {post} v3.1/myecshop2/bank/create 创建支付订单
 * @apiVersion 3.1.0

 * @apiGroup bank
 * @apiParam {String} [save_code] 安全码
 * @apiParam {String} [valid_time] 有效时间
 * @apiParam {String} order_sn 订单号
 * @apiParam {String} temp_bankcard_id 银行列表id号

 * @apiSuccessExample {json} 成功返回结果-
*{
*  "success": "true",
*  "data": "1",
*  "cache": "AFxXUwZNA2FQZgVrBzwGMA00WmtQZAVtUWdVPgFhB2MAOAFlCDwDY1NhAh0NNgUxDDZUYV9vAG5UagJuAWJUNgA7VzAGNwNkUGEFbAdKBjgNPVppUG4FaVFgVWgBNAd/AG4BMQg6A2VTeAJpDWEFZwwzVHlfYABuVGYCbwF8VDQAaldiBjYDN1AzBRoHOAYwDTRabFBnBWxRZlU6AWAHYQA8AWYIPwNl"
*}

 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"该订单已完成","code":"4911"}}

 **/


   /**
 * @api {post} v3.1/myecshop2/bank/update1 修改信息
 * @apiVersion 3.1.0

 * @apiGroup bank
 * @apiParam {String} user_name 用户名
 * @apiParam {String} user_mobile 用户手机号
 * @apiParam {String} user_card 用户身份证号

 * @apiSuccessExample {json} 成功返回结果-
 *{"success":"true","data":"修改成功"}

 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"身份证号不规范","code":"4809"}}
 *{"success":"false","error":{"msg":"姓名中不能含有数字","code":"4148"}}
 *{"success":"false","error":{"msg":"手机号码不规范","code":"4108"}}
 **/



  /**
 * @api {post} v3.1/myecshop2/bank/add 添加银行卡快捷支付
 * @apiVersion 3.1.0

 * @apiGroup bank
 * @apiParam {String} bank_no 银行卡号

 * @apiSuccessExample {json} 成功返回结果-
 *{
 * "success": "true",
 * "data": {
 *   "bank_name": "中国银行",
 *   "bank_type": "0",
 *   "bank_code": "621785",
 *   "bank_no": "6217850800013783038",
 *   "temp_buyers_id": "1769",
 *   "card_type": "借记卡"
 * }
*}
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"该卡号信息暂未录入","code":"4145"}}
 *
 **/

  /**
 * @api {post} v3.1/myecshop2/bank/info 填写信息
 * @apiVersion 3.1.0

 * @apiGroup bank
 * @apiParam {String} bank_no 银行卡号
 * @apiParam {String} user_name 姓名
 * @apiParam {String} user_card 身份证号
 * @apiParam {String} user_mobile 绑定手机号

 * @apiSuccessExample {json} 成功返回结果-
 *{
 * {"success":"true","data":"开通成功"}

 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"开通失败","code":"4910"}}
 *
 **/

   /**
 * @api {post} v3.1/myecshop2/bank/delete 删除银行卡
 * @apiVersion 3.1.0

 * @apiGroup bank
 * @apiParam {String} temp_bankcard_id 表记录id号


 * @apiSuccessExample {json} 成功返回结果-
 
 * {"success":"true","data":"删除成功"}
 * {"success":"true","data":"解绑签约成功"}

 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"删除失败","code":"4911"}}
 *{"success":"false","error":{"msg":"解除签约失败","code":"4911"}}

 *
 **/

    /**
 * @api {post} v3.1/myecshop2/bank/show 银行卡列表
 * @apiVersion 3.1.0
 * @apiGroup bank
 * @apiSuccessExample {json} 成功返回结果-
 *{
 * "success": "true",
 * "data": [
 *   {
 *     "temp_bankcard_id": "13",
 *     "bank_name": "中信银行",
 *     "bank_type": "0",
 *     "bind_mobile": "186 **** 5257",
 *     "bank_no": "**** **** **** 5990"
 *	   "card_type": "贷记卡"
 *	   "bank_sign": "358971"
 *   },
 *   {
 *     "temp_bankcard_id": "14",
 *     "bank_name": "中信银行",
 *     "bank_type": "0",
 *     "bind_mobile": "186 **** 5257",
 *     "bank_no": "**** **** **** 5990"
 *     "card_type": "贷记卡"
 *	   "bank_sign": "358973"
 *   }
 * ]
*}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/city/location 定位城市
 * @apiVersion 3.1.0

 * @apiGroup City and Bonus

 *

 * @apiSuccessExample {json} 成功返回结果-
 *{"success":"true","data":{"goods_area_id":"0","goods_area":"局域网","goods_table":""}}
 *
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/city/show 城市列表
 * @apiVersion 3.1.0

 * @apiGroup City and Bonus

 *
 * @apiSuccessExample {json} 成功返回结果:
 *{
*  "success": "true",
*  "data": [
*    {
*      "goods_area_id": "1",
*      "goods_area": "上海",
*      "goods_table": "ecs_goods"
*    },
*    {
*      "goods_area_id": "2",
*      "goods_area": "南京",
*      "goods_table": "ecs_goods_nj"
*    }
*  ]
*}
 *
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/city/search 搜索接口
 * @apiVersion 3.1.0

 * @apiGroup City and Bonus

 *
 * @apiParam {String} name  输入的搜索条件
 * @apiParam {String} goods_table 城市对应商品表
 * @apiParam {String} page 分页
 * @apiParam {String} pageSize 一页记录数
 * @apiParam {String} type=1 1对应辅材，2对应主材


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":[]}  （搜索结果为空！）

*{
*  "success": "true",
*  "data": [
*    {
*      "goods_name_id": "1",
*      "goods_id": "1911",
*      "goods_cat_id": "109",
*      "goods_name": "锯条12345",
*      "goods_unit": "根",
*      "shop_price": "4.50",
*      "goods_color": "默认",
*      "color": {
*        "color_name": "默认",
*        "color_id": "8"
*      },
*      "brand": {
*        "brand_name": "全部品牌",
*        "brand_id": "40"
*      },
*      "version": {
*        "version_name": "标准",
*        "version_id": "1003"
*      },
*      "goods_img": "http://192.168.1.194/ecshop2/Guest/"
*    }
*  ]
*}
 *
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/city/select 城市选择接口
 * @apiVersion 3.1.0

 * @apiGroup City and Bonus

 *
 * @apiParam {String} goods_area_id 城市ID


 * @apiSuccessExample {json} 成功返回结果:
 *（取默认城市上海  未登录）
*{"success":"true","data":{"goods_area_id":"1","city":"上海","goods_table":"ecs_goods"}}
*
*（取本地城市   未登录）
*{"success":"true","data":{"goods_area_id":"2","city":"南京","goods_table":"ecs_goods_nj"}}

*（已登陆）
*{"success":"true","data":{"goods_area_id":"1","city":"上海","goods_table":"ecs_goods"}}
 *
 *
 **/

/**
 * @api {post} v3.1/myecshop2/city/support 支持的城市地址
 * @apiVersion 3.1.0

 * @apiGroup City and Bonus

 * @apiSuccessExample {json} 成功返回结果:
* {
*   "success": "true",
*   "data": [
*     {
*       "id": "1",
*       "name": "北京市",
*       "children": [
*         {
*           "id": "3357",
*           "name": "北京市",
*           "children": [
*             {
*               "id": "2",
*               "name": "东城区"
*             },
*             {
*               "id": "3",
*               "name": "西城区"
*             }
*        ]
*     }
*     {
*      "id": "37",
*      "name": "河北省",
*      "children": [
*        {
*          "id": "38",
*          "name": "石家庄市",
*          "children": [
*            {
*              "id": "39",
*              "name": "长安区"
*            }
*          ]
*        }
*      }
   *
   *
   **/

 /**
 * @api {post} v3.1/myecshop2/bonus/recharge 余额接口
 * @apiVersion 3.1.0

 * @apiGroup City and Bonus

 * @apiParam {String} [temp_purchase_id] 订单id号

 *
 * @apiSuccessExample {json} 成功返回结果:
*{
*  "success": "true",
*  "data": {
*    "temp_account_id": "1259",
*    "temp_buyers_id": "3097",
*    "total": "0.00",
*    "switch": "true",
*    "quick_pay": "true"
*    "cod_pay": "false" 
*  }
*}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/bonus/show 红包列表接口
 * @apiVersion 3.1.0

 * @apiGroup City and Bonus

 *
 * @apiParam {String} goods_area_id 城市ID


 * @apiSuccessExample {json} 成功返回结果:
 *（取默认城市上海  未登录）
*{
*  "success": "true",
*  "data": {
*    "num": "3",
*    "total_money": "600",
*    "list": [
*      {
*        "order_id": "3",
*        "order_sn": "12313",
*        "user_id": "1203",
*        "order_status": "1",
*        "pay_method": "1",
*        "order_amount": "500.00",
*        "add_time": "3",
*        "bonus_id": "3",
*        "bonus_name": "邀请红包",
*        "bonus_money": "300.00",
*        "cash_id": "1"
*      },
*     ]
*   }
 *


 *
 **/

 /**
 * @api {post} v3.1/myecshop2/home/material/sub 辅材  和 二级栏目
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *
 * @apiParam {String} type=1  辅材

 * @apiSuccessExample {json} 成功返回结果:
 *{
*  "success": "true",
*  "data": [
*    {
*      "cat_id": "1",
*      "cat_name": "卫浴",
*      "cat_children": [
*        {
*          "img_url": "",
*          "cat_id": "13",
*          "cat_name": "座便器",
*          "cat_children": [
*            {
*              "cat_id": "3",
*              "cat_name": "aaa"
*            },
*            {
*              "cat_id": "4",
*              "cat_name": "bbb"
*            }
*          ]
*        }
*       ]
*     }
*    ]
*  }
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"id不能为空!","code":"4106"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/cart/cart 获取购物车列表
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *
 * @apiParam {String} goods_table 城市商品表
 * @apiParam {String} area_id 城市id号


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":[]}  购物车列表为空
*{
*  "success": "true",
*  "data": [
*    {
*      "goods_id": "821",
*      "goods_name": "皮尔萨 PPR 管子 40米起 包安装",
*      "goods_unit": "m",
*      "shop_price": "32.00",
*      "amount": "1",
*      "min_amount": "1",
*      "is_collection": "1",
*      "brand": {
*        "brand_name": "皮尔萨",
*        "brand_id": "1"
*      },
*      "version": {
*        "version_name": " D32",
*        "version_id": "1"
*      },
*      "color": {
*        "color_name": "其他",
*        "color_id": "8"
*      }
*		'type': "1"
*    },
*    {
*      "goods_id": "10",
*      "goods_name": "LED天花射灯",
*      "goods_unit": "个",
*      "shop_price": "22.50",
*      "amount": "1",
*      "is_collection": "1",
*      "brand": {
*        "brand_name": "美的",
*        "brand_id": "10"
*      },
*      "version": {
*        "version_name": "MSD01-D04X-30D/30/G/J03",
*        "version_id": "10"
*      },
*      "color": {
*        "color_name": null,
*        "color_id": "0"
*      }
*		"type":  "1"
*    }
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/home/index/goodsdetail 商品详情
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *	@apiParam {String} type type=1对应辅材，type=2对应尾货
 * @apiParam {String}  goods_id 商品id号

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":[]}

*（is_collection=1 收藏  is_collection=0未收藏）

*{
*  "success": "true",
*  "data": [
*    {
*      "goods_id": "10",
*      "goods_name": "LED天花射灯",
*      "goods_unit": "个",
*      "shop_price": "22.50",
*      "goods_img": "http://192.168.1.194/v3.1/myecshop2/Guest/upload/15-07-14 09-42-21125.jpg",
*      "goods_color": null,
*      "is_collection": "1",
*      "min_amount": "1",
*      "type": "1",
*	"imgs": [],

*      "color": {
*        "color_name": null,
*        "color_id": "0"
*      },
*      "brand": {
*        "brand_name": "美的",
*        "brand_id": "10"
*      },
*      "version": {
*        "version_name": "MSD01-D04X-30D/30/G/J03",
*        "version_id": "10"
*      }
*    },
*    {
*      "goods_id": "830",
*      "goods_name": "西门子(品宜)一位10A联体 二三极插座",
*      "goods_unit": "个",
*      "shop_price": "7.10",
*      "goods_img": "http://192.168.1.194/v3.1/myecshop2/Guest/upload/15-08-14 04-24-0317.jpg",
*      "goods_color": "白",
*      "is_collection": "0",
*      "color": {
*        "color_name": "白",
*        "color_id": "4"
*      },
*      "brand": {
*        "brand_name": "西门子",
*        "brand_id": "10"
*      },
*      "version": {
*        "version_name": "5UB06153NC01",
*        "version_id": "10"
*      }
*    }
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你没输入goods_id!","code":"4801"}}
 **/


 /**
 * @api {post} v3.1/myecshop2/home/material/brandlist2 商品列表
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *	@apiParam {String} type type=1对应辅材，type=2对应尾货
 * @apiParam {String} goods_category_id 二级分类ID号(和下面的参数ID 只传其中一个就行)
 * @apiParam {String} brand_id 品牌ID号
 * @apiParam {String} page=页码（默认值1）
 * @apiParam {String} pageSize=每页商品数(默认值10)


 * @apiSuccessExample {json} 成功返回结果:
 *或者 当传入值 为brand_id时

*{
*  "success": "true",
*  "data": [
*    {
*      "goods_id": "2",
*      "goods_cat_id": "91",
*      "goods_name": "LED天花射灯",
*      "goods_unit": "个",
*      "shop_price": "20.00",
*      "is_collection": "0",
* 	   "goods_img": "http://192.168.1.28/pcwstore/Guest/upload/wy/1.png",
*      "cat": {
*        "cat_name": "开关",
*        "cat_id": "91"
*      },
*      "version": {
*        "version_name": "MSD01-D02X-30D/57/W/J01",
*        "version_id": null
*      },
*      "brand": {
*        "brand_name": "美的商照",
*        "brand_id": "2"
*      }
*		"type": "1"
*    }
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"id不能为空!","code":"4106"}}
 *
 **/



 /**
 * @api {post} v3.1/myecshop2/home/cart/collect 收藏
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *
 * @apiParam {String} goods_id 商品的Id号
 * @apiParam {String} act （del 取消收藏动作  act=add 加入收藏动作）
 * @apiParam {String} type type=1对应辅材 type=2对应尾货

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","message":"收藏成功！"}
 *{"success":"true","message":"取消收藏成功！"}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *{"success":"false","error":{"msg":"goods_id不能为空","code":"4120"}}
 *{"success":"false","error":{"msg":"取消收藏失败！","code":"4903"}}
 *{"success":"false","error":{"msg":"提交动作act的值只能为del或者add","code":"4120"}}

 *{"success":"false","error":{"msg":"act不能为空","code":"4120"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/cart/show 收藏夹列表
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *
 * @apiParam {String} page 页码
 * @apiParam {String} pageSize 每页商品数

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":[]}   收藏夹列表为空

*{
*  "success": "true",
*  "data": [
*    {
*      "goods_id": "21",
*      "goods_name": "凤铝789推拉窗",
*      "goods_unit": "平方",
*      "shop_price": "270.00",
*      "color": {
*        "color_id": "0",
*        "color_name": ""
*      },
*      "version": {
*        "version_id": "0",
*        "version_name": "5mm单玻"
*      },
*      "brand": {
*        "brand_id": "2",
*        "brand_name": "凤铝"
*      }
*		"type": "1",
*    },
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/cart/clean 清空收藏夹
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","message":"成功清空收藏夹！"}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *{"success":"false","error":{"msg":"清空收藏夹失败！","code":"4903"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/cart/add 加入购物车
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *
 * @apiParam {String} amount 商品数量
 * @apiParam {String} goods_id 商品ID号
 * @apiParam {String} type type=1对应辅材 type=2对应尾货


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","message":"加入购物车成功"}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
*{"success":"false","error":{"msg":"amount不能为空","code":"4120"}}
*{"success":"false","error":{"msg":"加入购物车失败！","code":"4902"}}
 **/


 /**
 * @api {post} v3.1/myecshop2/home/cart/delete 删除购物车中商品
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *
 * @apiParam {String} shop_car_id 购物车ID号

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","message":"删除购物车商品成功"}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"goods_id不能为空","code":"4120"}}
*{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
*{"success":"false","error":{"msg":"删除购物车商品失败","code":"4902"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/cart/update 修改购物车
 * @apiVersion 3.1.0

 * @apiGroup Goods

 *
 * @apiParam {String} amount 商品数量
 * @apiParam {String} shop_car_id 购物车ID号

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","message":"修改购物车成功"}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
{"success":"false","error":{"msg":"amount不能为空","code":"4120"}}
{"success":"false","error":{"msg":"goods_id不能为空","code":"4120"}}
{"success":"false","error":{"msg":"修改购物车失败！","code":"4902"}}
{"success":"false","error":{"msg":"修改购物车失败！","code":"4904"}}

 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/order/confirm 确认订单
 * @apiVersion 3.1.0

 * @apiGroup Order

 *
 * @apiParam {Object} goods 商品
 * @apiParam {String} goods.shop_car_id 购物车ID号
 * @apiParam {String} goods.goods_id  商品ID号
 * @apiParam {String} goods.goods_amount  商品数量
 * @apiParam {String} goods.type=1  type=1辅材，type=2主材

 * @apiParam {String} temp_buyers_address_id 地址ID号
 * @apiParam {String} description 备注
 * @apiParam {String} transportation 物流费用
 * @apiParam {String} receive_time 送货时间
 * @apiParam {String} use_balance 使用余额支付:使用true,不使用false

 * @apiSuccessExample {json} 成功返回结果:
 *{
*  "success": "true",
*  "data": {
*    "temp_purchase_id": "711",
*    "temp_purchase_sn": "1509171431590012036234",
*    "time": "1442471519",
*    "money": "199.40",
*    "transportation": "0.00",
*    "method": "0",
*    "state": "1",
*    "receive_time": "ss",
*    "description": "ss",
*    "actually_money": "0.00",
*    "addressinfo": {
*      "name": "aa",
*      "address": "dd",
*      "mobile": "18621715257"
*    },
*    "goods": [
*      {
*        "amount": "10",
*        "description": "西门子(远景)双接线柱音响 插座",
*        "goods_id": "2315",
*        "goods_name": "西门子(远景)双接线柱音响 插座",
*        "shop_price": "19.94",
*        "goods_unit": "个",
*        "brand": {
*          "brand_name": "西门子"
*        },
*        "version": {
*          "version_name": "5TG01171CC1"
*        },
*        "cat": {
*          "cat_id": "92"
*        }
*      }
*     ]
*   }
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/home/order/payFor 找好友代付款
 * @apiVersion 3.1.0
 * @apiGroup Order

 *
 * @apiParam {String} temp_purchase_id 订单ID
 * @apiParam {String} mobile 代付人手机号
 
 * @apiSuccessExample {json} 成功返回结果:
 * {"success":"true","data":{"msg":"请求成功,等待好友付款"}}
 
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你好友得先注册成会员,才能进行代付款","code":"4153"}}
 *{"success":"false","error":{"msg":"手机号码不规范","code":"4108"}}
 *{"success":"false","error":{"msg":"请求好友代付款失败","code":"4915"}}
 *{"success":"false","error":{"msg":"你已经申请了代付款请求","code":"4156"}}
 *{"success":"false","error":{"msg":"订单必须是待付款状态","code":"4157"}}
 *
 **/
 
  /**
 * @api {post} v3.1/myecshop2/home/order/cancel 取消代付订单
 * @apiVersion 3.1.0
 * @apiGroup Order

 *
 * @apiParam {String} temp_purchase_id 订单ID
 
 * @apiSuccessExample {json} 成功返回结果:
 * {"success":"true","data":{"msg":"取消成功"}}
 
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"取消失败","code":"4919"}}
 *
 **/

   /**
 * @api {post} v3.1/myecshop2/home/order/payFor 找人待付款
 * @apiVersion 3.1.0
 * @apiGroup Order

 *
 * @apiParam {String} temp_purchase_id 订单ID
  * @apiParam {String} mobile  手机号

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"请求成功,等待好友付款"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你好友得先注册成会员,才能进行代付款","code":"4128"}}
 *
 **/

  /**
 * @api {post} v3.1/myecshop2/home/order/remind 买家提醒卖家发货
 * @apiVersion 3.1.0
 * @apiGroup Order

 *
 * @apiParam {String} act remind #提交动作
 * @apiParam {String} temp_purchase_id 订单ID

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"提醒卖家发货成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"提醒卖家发货失败","code":"4128"}}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/home/order/pay 货到付款接口
 * @apiVersion 3.1.0

 * @apiGroup Order

 *
 * @apiParam {String} temp_purchase_id 订单ID号

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","msg":"订单状态更新成功！"}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
*{"success":"false","error":{"msg":"订单状态更新失败！","code":"4904"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/order/detail 订单详情
 * @apiVersion 3.1.0

 * @apiGroup Order

 *
 * @apiParam {String} temp_purchase_id 订单ID号

 * @apiSuccessExample {json} 成功返回结果:
 *（注意： 当订单已经付款时，会返回付款参数：method）
*{"success":"true","data":[]}（数据为空）


*{
*  "success": "true",
*  "data": {
*    "temp_purchase_id": "710",
*    "temp_purchase_sn": "1509171348390012032981",
*    "time": "1442468919",
*    "money": "189.50",
*    "mobile": "18621715257",
*    "state": "1",
*    "method": "0",
*    "description": "ss",
*    "receive_time": "ss",
*    "finish_time": null,
*    "transportation": "0.00",
*    "actually_money": "0.00",
*    "buyersinfo": {
*      "temp_buyers_id": "254",
*      "mobile": "13323814501",
*      "nick": "河南市政总局"
*    },
*    "payer_id": "3473",
*    "payuserinfo": {	 
*        "temp_buyers_id": "3473",      	
*        "mobile": "18621715257",
*      	 "nick": "18621715257"
*    },
*    "addressinfo": {
*      "id": "1245",
*      "name": "aa",
*      "address": "dd",
*      "mobile": "18621715257"
*    },
*     "goods": [
*        {
*          "goods_name": "金牛暗阀",
*          "goods_unit": "个",
*          "area_id": "2",
*          "goods_color": "灰",
*          "goods_id": "9428",
*          "amount": "100",
*          "shop_price": "60.00",
*          "color": {
*            "color_name": "灰"
*          },
*          "version": {
*            "version_name": "20 灰"
*          },
*          "brand": {
*            "brand_name": "管件"
*          },
*          "type": "1"
*        }
*      ]
*  }
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/order/orderList 订单列表
 * @apiVersion 3.1.0

 * @apiGroup Order

 *
 * @apiParam {String} act orderlist #提交动作
 * @apiParam {String} state 订单状态码（1-7)
 * @apiParam {String} page 页码（从1开始）
 * @apiParam {String} pageSize 每页订单数目

 * @apiSuccessExample {json} 成功返回结果:
 *无数据返回：数据为空：{"success":"true","data":[]}
 *pay_id默认是-1 如果找人代付款pay_id将会更新成代付款的user_id


*{
*  "success": "true",
*  "data": [
*    {
*      "temp_purchase_id": "385",
*      "temp_purchase_sn": "1508201643160007421282",
*      "buyersinfo": {
*        "temp_buyers_id": "742",
*        "nick": ""
*      },
*      "suppliersinfo": {
*        "temp_buyers_id": "0",
*        "nick": ""
*      },
*      "time": "1440060196",
*      "money": "42.25",
*      "transportation": "20.00",
*      "method": "0",
*      "state": "1",
*      "receive_time": "mingtian",
*      "is_comment": "0";
*      "comet": "nihao",
*      "payuserinfo": {
*        "temp_buyers_id": "3473",
*        "temp_buyers_mobile": "18621715257",
*        "nick": "18621715257"
*      },
*      "addressinfo": {
*        "temp_buyers_address_id": "0",
*        "name": "lisi",
*        "address": "123",
*        "mobile": "18621715257"
*      },
*      "goods": [
*      {
*        "amount": "3",
*        "goods_unit": "箱",
*        "shop_price": "123.00",
*        "description": "95M每箱，申江牌的",
*        "goods_name": "",
*        "goods_id": "1910",
*        "area_id": "1",
*        "goods_color": "白色",
*        "color": {
*          "color_name": "白色"
*        },
*        "brand": {
*          "brand_name": ""
*        },
*        "version": {
*          "version_name": "多芯铜线电线 白色"
*        },
*        "cat": {
*          "cat_id": "1"
*        },
*        "type": "1"
*      }
*    ]
*    }
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/home/order/click 按钮操作
 * @apiVersion 3.1.0

 * @apiGroup Order

 *
 * @apiParam {String} act click #提交动作
 * @apiParam {String} temp_purchase_id 订单ID
 * @apiParam {String} state 状态码（买家取消订单0；买家申请退款：5；买家取消退款：2；买家收货：4）

  * @apiParam {String} is_back 商品是否回购物车（0否, 1是 is_back字段只有取消订单接口需要传）


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"订单状态已经修改成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
*{"success":"false","error":{"msg":"抱歉，你的付款方式为货到付款","code":"4800"}}
 *
 **/


  /**
 * @api {post} v3.1/myecshop2/home/order/judge2 去结算接口
 * @apiVersion 3.1.0

 * @apiGroup Order

 *

 * @apiParam {String} area_id 城市id
 * @apiParam {String} type 商品类型
   
* @apiParam {Object} goods_arr 商品
* @apiParam {String} goods_arr.goods_id  商品ID号
* @apiParam {String} goods_arr.amount  商品数量

 * @apiSuccessExample {json} 成功返回结果:
 *{
 * "success": "true",
 * "data": {
 *   "price": "288",
 *   "receive_time": "当天下单第二天到货",
 * }
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"辅材总价不能少于288","code":"4808"}}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/home/bonus/acc 收支明细(钱包明细)
 * @apiVersion 3.1.0
 * @apiGroup Order

 *
 * @apiParam {String} type 0 查看全部，1 查看收入 2查看支出
 * @apiParam {String} page 页码
 * @apiParam {String} pageSize 每页显示几条

 * @apiSuccessExample {json} 成功返回结果:
 *{
*  "success": "true",
*  "data": [
*    {
*      "id": "3",
*      "time": "3",
*      "sn": "12313",
*      "name": "邀请红包",
*      "money": "+500.00",
*      "type": "0"
*    },
*    {
*      "id": "2",
*      "time": "2",
*      "sn": "0002",
*      "name": "现金券",
*      "money": "+100.00",
*      "type": "0"
*    },
*   ]
* }
 *

 **/

 /**
 * @api {post} v3.1/myecshop2/home/other/version 版本接口
 * @apiVersion 3.1.0

 * @apiGroup other

 *
 * @apiSuccessExample {json} 成功返回结果:
 *{
*  "success": "true",
*  "data": {
*    "versionName": "1.2",
*    "versionCode": "103",
*    "desc": "有新版本更新",
*    "force":1,
*    "url": "http://www.aec188.com/askprice/download/PcwStore.apk"
*  }
*}
 *
 **/

  /**
 * @api {post} v3.1/myecshop2/home/other/desc 价格限制说明
 * @apiVersion 3.1.0

 * @apiGroup other

 * @apiParam {String} area_id 城市id号

 *
 * @apiSuccessExample {json} 成功返回结果:
 *{
 * "success": "true",
 * "data": {
 *   "desc_f": "满288.00才可下单",
 *   "desc_z": "满1000.00才可下单"
 * }
*}
 *
 **/

    /**
     * @api {post} v3.1/myecshop2/home/index/transportation 运费价格和描述
     * @apiVersion 3.1.0

     * @apiGroup other

     * @apiParam {String} area_id 城市id号
     * @apiParam {String} type 商品类型
     * @apiParam {String} temp_buyers_address_id 地址id
     *
     * @apiParam {Object} goods_arr 商品
     * @apiParam {String} goods_arr.goods_id  商品ID号
     * @apiParam {String} goods_arr.amount  商品数量
     *
     * @apiSuccessExample {json} 成功返回结果:
     *{
     *  "success": "true",
     *  "data": {
     *    "transportation_price": "250",
     *    "transportation_desc": "运费说明"
     *  }
     *}
     *
     **/


 /**
 * @api {post} v3.1/myecshop2/user/index/getCheckCode 获取验证码
 * @apiVersion 3.1.0

 * @apiGroup User

 *
 * @apiParam {String} mobile 手机号码1
 * @apiParam {String} type 1或者2(1获取注册验证码,2获取忘记密码验证码)

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"验证码发送成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"type必须存在","code":"4800"}}
 *{"success":"false","error":{"msg":"type必须为1或2","code":"4800"}}
 *{"success":"false","error":{"msg":"手机号必须存在","code":"4800"}}
 *{"success":"false","error":{"msg":"手机号格式不正确","code":"4800"}}
 *{"success":"false","error":{"msg":"用户已注册","code":"4102"}}
 *{"success":"false","error":{"msg":"用户不存在","code":"4116"}}
 *{"success":"false","error":{"msg":"时间间隔太小，请1分钟后再申请","code":"4103"}}
 *{"success":"false","error":{"msg":"短信今天已经发了6次，请明天再申请","code":"4104"}}
 *{"success":"false","error":{"msg":"数据来源有误！请从本站提交！","code":"4104"}}
 *{"success":"false","error":{"msg":"检验验证码失败","code":"4900"}}
 *{"success":"false","error":{"msg":"验证码发送失败","code":"4108"}}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/user/index/checkCode 校验验证码
 * @apiVersion 3.1.0

 * @apiGroup User

 *
 * @apiParam {String} mobile 手机号码
 * @apiParam {String} checkcode 验证码
 * @apiParam {String} type 1或者2(1获取注册验证码,2获取忘记密码验证码)

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"验证码校验通过"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"type必须存在","code":"4800"}}
 *{"success":"false","error":{"msg":"type必须为1或2","code":"4800"}}
 *{"success":"false","error":{"msg":"手机号必须存在","code":"4800"}}
 *{"success":"false","error":{"msg":"手机号格式不正确","code":"4800"}}
 *{"success":"false","error":{"msg":"用户已注册","code":"4102"}}
 *{"success":"false","error":{"msg":"用户不存在","code":"4116"}}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/user/index/invitation 开始注册
 * @apiVersion 3.1.0

 * @apiGroup User

 *
 * @apiParam {String} mobile 手机号码
 * @apiParam {String} invitation 邀请码

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"验证码发送成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：

*{"success":"false","error":{"msg":"邀请码长度必须是8位","code":"4800"}}
*{"success":"false","error":{"msg":"邀请码不存在！","code":"4800"}}
*{"success":"false","error":{"msg":"邀请码首位不能为0","code":"4800"}}
*{"success":"false","error":{"msg":"邀请码不能为空！","code":"4800"}}
*{"success":"false","error":{"msg":"手机号码不规范","code":"4801"}}
*{"success":"false","error":{"msg":"用户已注册","code":"4801"}}
 *
 **/

 /**
 * @api {post}  v3.1/myecshop2/user/index/forgetPassword 忘记密码
 * @apiVersion 3.1.0

 * @apiGroup User

 * @apiParam {String} temp_buyers_password 密码
 * @apiParam {String} new_password 旧密码

 *  * @apiSuccessExample {json} 成功返回结果:
 * {"success":"true","data":{"msg":"密码修改成功"}}

 *  @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"密码不能为空","code":"4800"}}
 *{"success":"false","error":{"msg":"密码长度至少为6位","code":"4800"}}
 *{"success":"false","error":{"msg":"密码修改失败","code":"4117"}}
 **/




 /**
 * @api {post} v3.1/myecshop2/user/index/reg 注册结束
 * @apiVersion 3.1.0

 * @apiGroup User

 *
 * @apiParam {String} temp_buyers_password 密码
 * @apiParam {String} [invitation] 邀请码
 * @apiParam {String} checkcode 验证码
 * @apiParam {String} temp_buyers_mobile 手机号码

 * @apiSuccessExample {json} 成功返回结果:
*{
*  "success": "true",
*  "data": {
*    "temp_buyers_id": "1203",
*    "temp_buyers_mobile": "18621715257",
*    "nick": "18621715257",
*    "photo": "",
*    "info": "",
*    "vip": "0",
*    "area_id": "1",
*    "invitation": "44001203",
*    "city": {
*      "id": "局域网",
*      "name": "0"
*    }
*  }
*}
 * @apiErrorExample {json} 失败返回结果：
 *
*{"success":"false","error":{"msg":"用户注册失败","code":"4113"}}
*{"success":"false","error":{"msg":"密码长度至少为6位","code":"4800"}}

*{"success":"false","error":{"msg":"密码不能为空","code":"4800"}}
 *
 *
 **/






 /**
 * @api {post} v3.1/myecshop2/user/index/login 登录
 * @apiVersion 3.1.0

 * @apiGroup User

 * @apiParam {String} act login
 * @apiParam {String} temp_buyers_mobile 手机号
 * @apiParam {String} temp_buyers_password 密码

 * @apiSuccessExample {json} 成功返回结果:
 * company_id>0 表示是企业用户
 *
*{
*  "success": "true",
*  "data": {
*    "vip": "0",
*    "temp_buyers_id": "1198",
*    "temp_buyers_mobile": "18621715257",
*    "nick": "18621715257",
*    "photo": "http://192.168.1.194/ecshop2/Guest/",
*    "info": "",
*    "invitation": "10001198",
*	 "company_id"	"0",
*	"token": "Bz9cPAY0UDhabgJoUB1QZVpmADcANFNLXWpSPQBlAWMBPAZqBTkCZFBgBGw="
*  }
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *
* {"success":"false","error":{"msg":"手机号必须存在","code":"4800"}}
*{"success":"false","error":{"msg":"手机号格式不正确","code":"4800"}}
*{"success":"false","error":{"msg":"密码不能为空","code":"4800"}}
*{"success":"false","error":{"msg":"用户不存在","code":"4116"}}
*{"success":"false","error":{"msg":"用户名密码不匹配!","code":"4118"}}
 *
 **/



 /**
 * @api {post} v3.1/myecshop2/user/info/modify 修改密码
 * @apiVersion 3.1.0

 * @apiGroup User

 *
 * @apiParam {String} old_password 旧密码
 * @apiParam {String} new_password 新密码

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"密码修改成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
*{"success":"false","error":{"msg":"原密码错误","code":"4120"}}
*{"success":"false","error":{"msg":"密码修改失败","code":"4120"}}
*{"success":"false","error":{"msg":"new_password不能少于6位","code":"4120"}}
*{"success":"false","error":{"msg":"原密码不能和新密码一样","code":"4120"}}
 *
 **/ /**
 * @api {post} v3.1/myecshop2/user/index/logout 用户退出
 * @apiVersion 3.1.0

 * @apiGroup User

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"退出成功"}}
 *
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/user/info/addAddress 添加地址
 * @apiVersion 3.1.0
 * @apiGroup address

 *
 * @apiParam {String} name 名字
 * @apiParam {String} address 地址
 * @apiParam {String} mobile 手机号
 * @apiParam {String} defaultaddress=1 1已选,0没有选
  *@apiParam {String} province 省
  *@apiParam {String} city 城市名
  *@apiParam {String} district 地区
  *@apiParam {String} id 三级分类(县或区)对应的id

 * @apiSuccessExample {json} 成功返回结果:
*{
*    "success":"true",
*    "data":
*        {
*        "temp_buyers_address_id":"3",
*        "name":"zhangsan",
*        "address":"11111",
*        "province": "上海市",
*        "city": "上海市",
*        "district": "徐汇区"
*        "region_id": "1202",
*        "mobile":"15021680669",
*        "defaultaddress":"1",
*        "temp_buyers_id":"1"
*        }
*    }
*}
 *
 * @apiErrorExample {json} 失败返回结果：
*{"success":"false","error":{"msg":"用户名不能为空","code":"4800"}}
*{"success":"false","error":{"msg":"地址不能为空","code":"4800"}}
*{"success":"false","error":{"msg":"手机号码格式不正确","code":"4800"}}
*{"success":"false","error":{"msg":"添加地址最多只能添加10个","code":"4800"}}
 *
 **/
 /**
 * @api {post} v3.1/myecshop2/user/info/defaultAddress 默认地址
 * @apiVersion 3.1.0
 * @apiGroup address

 *

 * @apiSuccessExample {json} 成功返回结果:
*{
*"success":"true",
*"data":
*    [
*        {
*        "temp_buyers_address_id":"3",
*        "name":"zhangsan",
*        "defaultaddress":1,
*        "address":"shanghai",
*        "mobile":"15021680669"
*        "city": "上海市",
*        "district": "徐汇区"
*        }
*    ]
*}

 *
 **/
 /**
 * @api {post} v3.1/myecshop2/user/info/addressList 地址列表
 * @apiVersion 3.1.0
 * @apiGroup address

 *

 * @apiSuccessExample {json} 成功返回结果:
 *数据为空：{"success":"true","data":[]}
 *  不为空：{
 *  "success":"true",
 *  "data":
 *  [
 *       {
 *           "temp_buyers_address_id":"3",
 *           "name":"zhangsan",
 *           "defaultaddress":1,
 *           "address":"shanghai",
 *           "mobile":"15021680669"
 *           "province": "上海市",
 *           "city": "上海市",
 *           "district": "普陀区",
 *           "region_id": "1202"
 *          }
 *         ]
 *      }
 *

 *
 **/
 /**
 * @api {post} v3.1/myecshop2/user/info/delAddress 删除地址
 * @apiVersion 3.1.0
 * @apiGroup address

 *
 * @apiParam {String} temp_buyers_address_id 地址ID

 * @apiSuccessExample {json} 成功返回结果:
*{"success":"true","data":{"msg":"删除地址成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
*{"success":"false","error":{"msg":"删除地址失败","code":"4112"}}
 *
 **/

 /**
 * @api {post} v3.1/myecshop2/user/info/updateAddress 编辑地址
 * @apiVersion 3.1.0
 * @apiGroup address

 *
 * @apiParam {String} address_id 地址ID
 * @apiParam {String} name 名字
 * @apiParam {String} address 地址
 * @apiParam {String} mobile 手机号
  * @apiParam {String} province 省
  * @apiParam {String} city 城市名
  *@apiParam {String} district 地区
  * @apiParam {String} id 三级分类(县/区)对应的id号
 * @apiParam {String} defaultaddress=1 1默认，0没有选

 * @apiSuccessExample {json} 成功返回结果:
 * {
 *   "success": "true",
 *   "data": {
 *     "temp_buyers_address_id": "2849",
 *     "mobile": "17701804871",
 *     "address": "fasdfa2454",
 *     "name": "asdfasd",
 *     "province": "上海市",
 *     "city": "上海市",
 *     "district": "普陀区",
 *     "region_id": "1202",
 *     "defaultaddress": "1",
 *     "temp_buyers_id": "5235"
 *   }
 * }
 *
 * @apiErrorExample {json} 失败返回结果：
*{"success":"false","error":{"msg":"编辑地址失败","code":"4111"}}
*{"success":"false","error":{"msg":"用户名不能为空","code":"4800"}}
*{"success":"false","error":{"msg":"地址不能为空","code":"4800"}}
*{"success":"false","error":{"msg":"手机号码格式不正确","code":"4800"}}
 *
 **/
 /**
 * @api {post} v3.1/myecshop2/user/info/modifyInfo 修改个人资料
 * @apiVersion 3.1.0
 * @apiGroup user information

 *
 * @apiParam {String} [nick] 昵称（可空）
 * @apiParam {String} [info] 介绍（可空）
 * @apiParam {String} [ori_img] 头像（可空）（最大为10M）

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"验证码发送成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"type必须存在","code":"4800"}}
 *{"success":"false","error":{"msg":"type必须为1或2","code":"4800"}}
 *{"success":"false","error":{"msg":"手机号必须存在","code":"4800"}}
 *{"success":"false","error":{"msg":"手机号格式不正确","code":"4800"}}
 *{"success":"false","error":{"msg":"用户已注册","code":"4102"}}
 *{"success":"false","error":{"msg":"用户不存在","code":"4116"}}
 *{"success":"false","error":{"msg":"时间间隔太小，请1分钟后再申请","code":"4103"}}
 *{"success":"false","error":{"msg":"短信今天已经发了6次，请明天再申请","code":"4104"}}
 *{"success":"false","error":{"msg":"数据来源有误！请从本站提交！","code":"4104"}}
 *{"success":"false","error":{"msg":"检验验证码失败","code":"4900"}}
 *{"success":"false","error":{"msg":"验证码发送失败","code":"4108"}}
 *
 **/


 /**
 * @api {post} v3.1/myecshop2/user/info/getInfo 获取个人资料
 * @apiVersion 3.1.0

 * @apiGroup user information

 *

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":
*    {
*        "temp_buyers_id":"1",
*        "temp_buyers_mobile":"15021680669",
*        "nick":"冰","
*        "photo":"D:/wamp/www/ecshop2/Guest/upload/photo/15021680669/thumb_15021680669head.jpg",
*        "info":"helle"
*        }
*    }
 *
 * @apiErrorExample {json} 失败返回结果：
*{"success":"false","error":{"msg":"获取个人资料失败","code":"4105"}}
*{"success":"false","error":{"msg":"session过期","code":"4120"}}
 *
 **/


 /**
 * @api {post} AskPriceApi/beecloud-php/demo/webhook.php 秒支付接口
 * @apiVersion 3.1.0

 * @apiGroup pay

 *
 *
 **/

  /**
 *@api {post} ... code码及其解释

 * @apiVersion 3.1.0

 * @apiGroup code
 *@apiError 4100 修改个人资料失败
 *@apiError 4101 头像文件上传的各种错误
 *@apiError 4102 用户已注册
 *@apiError 4103 时间间隔太小，请1分钟后再申请
 *@apiError 1.4104 短信今天已经发了6次，请明天再申请
 *@apiError 2.4104 数据来源有误！请从本站提交！

 *@apiError 4105 获取个人资料失败
 *@apiError 4106 type不能为空
 *@apiError 4106 id不能为空!
 *@apiError 4107 type不能为空
 *@apiError 4108 验证码发送失败

 *@apiError 4110 用户不存在
 *@apiError 4111 编辑地址失败	
 *@apiError 4112 删除地址失败
 *@apiError 1.4113 用户不存在
 *@apiError 2.4113 用户注册失败

 *@apiError 4114 用户不存在
 *@apiError 4115 反馈问题失败
 *@apiError 4116 用户不存在 
 *@apiError 4117 密码修改失败
 *@apiError 4117 用户名密码不匹配!

 *@apiError 1.4120 原密码错误
 *@apiError 2.4120 密码修改失败
 *@apiError 3.4120 new_password不能少于6位
 *@apiError 4.4120 原密码不能和新密码一样
 *@apiError 5.4120 session过期
 *@apiError 6.4120 goods_id不能为空
 *@apiError 7.4120 提交动作act的值只能为del或者add
 *@apiError 8.4120 act不能为空
 *@apiError 9.4120 提交动作act的值只能为del或者add
 *@apiError 10.4120 amount不能为空

 
 *@apiError 4128 提醒卖家发货失败
 *@apiError 4129 用户名密码不匹配!

 *@apiError 4139 收藏好友失败

 *@apiError 4140 已经收藏过此好友


 *@apiError 1.4800 type必须存在
 *@apiError 2.4800 type必须为1或2
 *@apiError 3.4800 手机号必须存在
 *@apiError 4.4800 手机号格式不正确
 *@apiError 5.4800 邀请码不存在
 *@apiError 6.4800 密码长度至少为6位
 *@apiError 7.4800 密码不能为空
 *@apiError 8.4800 不少于15字
 *@apiError 9.4800 用户名不能为空
 *@apiError 10.4800 地址不能为空
 *@apiError 11.4800 添加地址最多只能添加10个
 *@apiError 12.4800 自己不能收藏自己
 *@apiError 13.4800 无此用户
 *@apiError 14.4800 to_id必须存在
 *@apiError 15.4800 抱歉，你的付款方式为货到付款
 

 *@apiError 1.4801 type必须为1或2 
 *@apiError 2.4801 手机号码不规范
 *@apiError 3.4801 你没输入goods_id
 *@apiError 4.4801 用户已注册

 *@apiError 4804 type值必须传，其值只能为1或2
 *@apiError 4807 参数不全或有参数为空
 *@apiError 4808 辅材总价不能少于288
 *@apiError 4809 主材总价不能少于1000


 *@apiError 4900 检验验证码失败
 *@apiError 4901 type不能为空
 *@apiError 1.4902 加入购物车失败！
 *@apiError 2.4902 删除购物车商品失败
 *@apiError 3.4902 修改购物车失败！

 *@apiError 1.4903 取消收藏失败！
 *@apiError 2.4903 清空收藏夹失败！

 *@apiError 4904 订单状态更新失败！

 *@apiError 4915 请求好友代付款失败



 
 **/

