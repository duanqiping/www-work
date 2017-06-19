 /**
 * @api {post} myecshop2/city/location 1.定位城市
 * @apiVersion 1.2.0

 * @apiGroup City and Bonus

 *

 * @apiSuccessExample {json} 成功返回结果-
 *{"success":"true","data":{"goods_area_id":"0","goods_area":"局域网","goods_table":""}}
 *
 *
 **/

 /**
 * @api {post} myecshop2/city/show 2.城市列表
 * @apiVersion 1.2.0

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
 * @api {post} myecshop2/city/search 3.搜索接口
 * @apiVersion 1.2.0

 * @apiGroup City and Bonus

 *
 * @apiParam {String} name  输入的搜索条件
 * @apiParam {String} goods_table 城市对应商品表
 * @apiParam {String} page 分页
 * @apiParam {String} pageSize 一页记录数


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
 * @api {post} myecshop2/city/select 4.城市选择接口
 * @apiVersion 1.2.0

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
 * @api {post} myecshop2/bonus/recharge 5.余额接口
 * @apiVersion 1.2.0

 * @apiGroup City and Bonus

 *
 * @apiSuccessExample {json} 成功返回结果:
 *{
*  "success": "true",
*  "data": {
*    "temp_account_id": "69",
*    "temp_buyers_id": "1203",
*    "total": "0.00"
*  }
*}
 *
 **/

 /**
 * @api {post} myecshop2/bonus/show 6.红包列表接口
 * @apiVersion 1.2.0

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
 * @api {post} myecshop2/home/material/sub 1.辅材  和 二级栏目
 * @apiVersion 1.2.0

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
 * @api {post} myecshop2/home/cart/cart 10.获取购物车列表
 * @apiVersion 1.2.0

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
*    }
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/

 /**
 * @api {post} myecshop2/home/index/goodsdetail 2.商品详情
 * @apiVersion 1.2.0

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
*      "goods_img": "http://192.168.1.194/myecshop2/Guest/upload/15-07-14 09-42-21125.jpg",
*      "goods_color": null,
*      "is_collection": "1",
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
*      "goods_img": "http://192.168.1.194/myecshop2/Guest/upload/15-08-14 04-24-0317.jpg",
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
 * @api {post} myecshop2/home/material/brandlist2 3.商品列表
 * @apiVersion 1.2.0

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
*    }
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"id不能为空!","code":"4106"}}
 *
 **/



 /**
 * @api {post} myecshop2/home/cart/collect 4.收藏
 * @apiVersion 1.2.0

 * @apiGroup Goods

 *
 * @apiParam {String} goods_id 商品的Id号
 * @apiParam {String} act （del 取消收藏动作  act=add 加入收藏动作）

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
 * @api {post} myecshop2/home/cart/show 5.收藏夹列表
 * @apiVersion 1.2.0

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
*    },
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/


 /**
 * @api {post} myecshop2/home/cart/clean 6.清空收藏夹
 * @apiVersion 1.2.0

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
 * @api {post} myecshop2/home/cart/add 7.加入购物车
 * @apiVersion 1.2.0

 * @apiGroup Goods

 *
 * @apiParam {String} amount 商品数量
 * @apiParam {String} goods_id 商品ID号


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","message":"加入购物车成功"}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
*{"success":"false","error":{"msg":"amount不能为空","code":"4120"}}
*{"success":"false","error":{"msg":"加入购物车失败！","code":"4902"}}
 **/


 /**
 * @api {post} myecshop2/home/cart/delete 8.删除购物车中商品
 * @apiVersion 1.2.0

 * @apiGroup Goods

 *
 * @apiParam {String} goods_id 商品ID号


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
 * @api {post} myecshop2/home/cart/update 9.修改购物车
 * @apiVersion 1.2.0

 * @apiGroup Goods

 *
 * @apiParam {String} amount 商品数量
 * @apiParam {String} goods_id 商品ID号


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
 * @api {post} myecshop2/home/order/confirm 1.确认订单
 * @apiVersion 1.2.0

 * @apiGroup Order

 *
 * @apiParam {Object} goods 商品
 * @apiParam {String} goods.goods_id  商品ID号
 * @apiParam {String} goods.goods_num  商品数量
 * @apiParam {String} name 收货人姓名
 * @apiParam {String} mobile 手机号码
 * @apiParam {String} address 详细地址
 * @apiParam {String} description 备注
 * @apiParam {String} transportation 物流费用
 * @apiParam {String} receive_time 送货时间

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
 * @api {post} AskPriceApi/flow.php1 10.提现信息
 * @apiVersion 1.2.0
 * @apiGroup Order

 *
 * @apiParam {String} act payment #提交动作
 * @apiParam {String} page 页码
 * @apiParam {String} pageSize 每页显示条数


 *
 **/ /**
 * @api {post} AskPriceApi/flow.php2 11.买家提醒卖家发货
 * @apiVersion 1.2.0
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
 * @api {post} AskPriceApi/flow.php2 11.买家提醒卖家发货
 * @apiVersion 1.2.0
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
 * @api {post} AskPriceApi/flow.php3 12.网银列表
 * @apiVersion 1.2.0
 * @apiGroup Order

 *
 * @apiParam {String} act banklist
 * @apiSuccessExample {json} 成功返回结果:
 *{
*    "success": "true",
*    "data": [
*        {
*            "bank_id": "ICBCB2C",
*            "bank_name": "中国工商银行",
*            "bank_icon": "http://192.168.1.61/ecshop2/AskPriceApi/data/images/bank_icon/ICBCB2C.png"
*        },
*        {
*            "bank_id": "ABC",
*            "bank_name": "中国农业银行",
*            "bank_icon": "http://192.168.1.61/ecshop2/AskPriceApi/data/images/bank_icon/ABC.png"
*        },
*       ]
*    }
 *

 *
 **/
 /**
 * @api {post} myecshop2/home/order/pay 2.货到付款接口
 * @apiVersion 1.2.0

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
 * @api {post} myecshop2/home/order/detail4 3.订单详情
 * @apiVersion 1.2.0

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
*      "temp_buyers_id": "1203",
*      "nick": "18621715257"
*    },
*    "addressinfo": {
*      "name": "aa",
*      "address": "dd",
*      "mobile": "18621715257"
*    },
*    "goods": [
*      {
*        "amount": "10",
*        "description": "西门子(远景)一位电话插座 RJ11",
*        "goods_id": "2314",
*        "goods_name": "西门子(远景)一位电话插座 RJ11",
*        "shop_price": "18.95",
*        "goods_unit": "个",
*        "brand": {
*          "brand_name": "西门子"
*        },
*        "version": {
*          "version_name": "5TG01201CC1"
*        },
*        "cat": {
*          "cat_id": "92"
*        }
*      }
*    ]
*  }
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/


 /**
 * @api {post} myecshop2/home/order/detail4 3.订单详情
 * @apiVersion 1.2.0

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
*      "temp_buyers_id": "1203",
*      "nick": "18621715257"
*    },
*    "addressinfo": {
*      "name": "aa",
*      "address": "dd",
*      "mobile": "18621715257"
*    },
*    "goods": [
*      {
*        "amount": "10",
*        "description": "西门子(远景)一位电话插座 RJ11",
*        "goods_id": "2314",
*        "goods_name": "西门子(远景)一位电话插座 RJ11",
*        "shop_price": "18.95",
*        "goods_unit": "个",
*        "brand": {
*          "brand_name": "西门子"
*        },
*        "version": {
*          "version_name": "5TG01201CC1"
*        },
*        "cat": {
*          "cat_id": "92"
*        }
*      }
*    ]
*  }
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/


 /**
 * @api {post} AskPriceApi/flow.php5 4.订单列表
 * @apiVersion 1.2.0

 * @apiGroup Order

 *
 * @apiParam {String} act orderlist #提交动作
 * @apiParam {String} state 订单状态码（1-7)
 * @apiParam {String} page 页码（从1开始）
 * @apiParam {String} pageSize 每页订单数目

 * @apiSuccessExample {json} 成功返回结果:
 *无数据返回：数据为空：{"success":"true","data":[]}


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
*      "comet": "nihao",
*      "addressinfo": {
*        "temp_buyers_address_id": "0",
*        "name": "lisi",
*        "address": "123",
*        "mobile": "18621715257"
*      },
*      "goods": [
*        {
*          "goods_name": "100竖向龙骨",
*          "goods_unit": "米",
*          "goods_id": "813",
*          "amount": "3",
*          "shop_price": "5.35",
*          "version": {
*            "version_name": "QC100*45*0.6"
*          },
*          "brand": {
*            "brand_name": "新雅"
*          }
*        }
*        }
*      ]
*    }
*  ]
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/


 /**
 * @api {post} AskPriceApi/flow.php6 5.按钮操作
 * @apiVersion 1.2.0

 * @apiGroup Order

 *
 * @apiParam {String} act click #提交动作
 * @apiParam {String} temp_purchase_id 订单ID
 * @apiParam {String} state 状态码（买家取消订单0；买家申请退款：5；买家取消退款：2；买家收货：4）

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"订单状态已经修改成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
*{"success":"false","error":{"msg":"抱歉，你的付款方式为货到付款","code":"4800"}}
 *
 **/


 /**
 * @api {post} myecshop2/home/order/judge 6.返回最低金额和物流费用
 * @apiVersion 1.2.0

 * @apiGroup Order

 *
 * @apiParam {String} price 结算费用

 * @apiSuccessExample {json} 成功返回结果:
 *{
*  "success": "true",
*  "data": {
*    "price": "500",
*    "transportation": "0",
*    "explain": "满1000免运费，仅限上海"
*  }
*}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"你还没有登录","code":"4120"}}
 *
 **/

 /**
 * @api {post} AskPriceApi/flow.php7 7.收支明细
 * @apiVersion 1.2.0
 * @apiGroup Order

 *
 * @apiParam {String} act acc #提交动作
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
 * @api {post} AskPriceApi/flow.php8 8.账户余额
 * @apiVersion 1.2.0
 * @apiGroup Order

 *
 * @apiParam {String} act accmoney#提交动作

 * @apiSuccessExample {json} 成功返回结果:
 *无数据返回：数据为空：{"success":"true","data":[]}
*{"success":"true","data":{"total":"账户余额"}}
 *

 **/
  /**
 * @api {post} AskPriceApi/flow.php9 9.申请提现
 * @apiVersion 1.2.0
 * @apiGroup Order

 *
 * @apiParam {String} act application #提交动作
 * @apiParam {String} company 公司信息
 * @apiParam {String} money 提现金额
 * @apiParam {String} person 开户名
 * @apiParam {String} alipay 账号

 *
 *

 **/

 /**
 * @api {post} myecshop2/other/version 1.版本接口
 * @apiVersion 1.2.0

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
 * @api {post} AskPriceApi/GetCheckCode.php 1.获取验证码
 * @apiVersion 1.2.0

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
 * @api {post} AskPriceApi/invitation.php 2.验证邀请码
 * @apiVersion 1.2.0

 * @apiGroup User

 *
 * @apiParam {String} mobile 手机号码
 * @apiParam {String} invitation    邀请 码

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
 * @api {post} AskPriceApi/reg.php 3.注册
 * @apiVersion 1.2.0

 * @apiGroup User

 *
 * @apiParam {String} temp_buyers_password 密码
 * @apiParam {String} [invitation] 邀请码
 *  * @apiParam {String} checkcode 验证码
 *   * @apiParam {String} temp_buyers_mobile 手机号码

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
 * @api {post} AskPriceApi/forgetpassword.php 4.忘记密码
 * @apiVersion 1.2.0

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
 * @api {post} AskPriceApi/reg.php 3.注册
 * @apiVersion 1.2.0

 * @apiGroup User

 *
 * @apiParam {String} temp_buyers_password 密码
 * @apiParam {String} [invitation] 邀请码
 *  * @apiParam {String} checkcode 验证码
 *   * @apiParam {String} temp_buyers_mobile 手机号码

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
 * @api {post} AskPriceApi/login.php 5.登录
 * @apiVersion 1.2.0

 * @apiGroup User

 * @apiParam {String} act login
 * @apiParam {String} temp_buyers_mobile 手机号
 * @apiParam {String} temp_buyers_password 密码

 * @apiSuccessExample {json} 成功返回结果:
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
*    "city": {
*      "id": "0",
*      "name": "局域网"
*    }
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
 * @api {post} AskPriceApi/UpdatePassword.php 6.修改密码
 * @apiVersion 1.2.0

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
 * @api {post} AskPriceApi/logout.php 7.用户退出
 * @apiVersion 1.2.0

 * @apiGroup User

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"退出成功"}}
 *
 *
 **/
 /**
 * @api {post} AskPriceApi/AddCollection.php 8.添加收藏
 * @apiVersion 1.2.0

 * @apiGroup User

 *
 * @apiParam {String} to_id 被收藏用户ID


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"收藏好友成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"自己不能收藏自己","code":"4800"}}
*{"success":"false","error":{"msg":"已经收藏过此好友","code":"4140"}}
*{"success":"false","error":{"msg":"无此用户","code":"4800"}}
*{"success":"false","error":{"msg":"收藏好友失败","code":"4139"}}
*{"success":"false","error":{"msg":"to_id必须存在","code":"4800"}}
 *
 **/


 /**
 * @api {post} AskPriceApi/AddCollection.php 8.添加收藏
 * @apiVersion 1.2.0

 * @apiGroup User

 *
 * @apiParam {String} to_id 被收藏用户ID


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"收藏好友成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"自己不能收藏自己","code":"4800"}}
*{"success":"false","error":{"msg":"已经收藏过此好友","code":"4140"}}
*{"success":"false","error":{"msg":"无此用户","code":"4800"}}
*{"success":"false","error":{"msg":"收藏好友失败","code":"4139"}}
*{"success":"false","error":{"msg":"to_id必须存在","code":"4800"}}
 *
 **/


 /**
 * @api {post} AskPriceApi/CollectionList.php 9.我的收藏列表
 * @apiVersion 1.2.0

 * @apiGroup User


 * @apiSuccessExample {json} 成功返回结果:
 *无数据返回：数据为空：{"success":"true","data":[]}
*{
*    "success": "true",
*    "data": [
*        {
*            "to_id": "2",
*            "temp_buyers_mobile": "13262936502",
*            "nick": "busfhf",
*            "photo": "http://192.168.1.61/ecshop2/Guest/upload/photo/13262936502/13262936502head.jpg",
*            "info": "Hi符"
*        },
*        {
*            "to_id": "3",
*            "temp_buyers_mobile": "18721559023",
*            "nick": "Coffee",
*            "photo": "http://192.168.1.61/ecshop2/Guest/",
*            "info": ""
*        }
*      ]
*   }
 *
 *
 **/


 /**
 * @api {post} AskPriceApi/addaddress.php 1.添加地址
 * @apiVersion 1.2.0
 * @apiGroup address

 *
 * @apiParam {String} name 名字
 * @apiParam {String} address 地址
 * @apiParam {String} mobile 手机号
 * @apiParam {String} defaultaddress=1 1已选,0没有选

 * @apiSuccessExample {json} 成功返回结果:
*{
*    "success":"true",
*    "data":
*        {
*        "temp_buyers_address_id":"3",
*        "name":"zhangsan",
*        "address":"11111",
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
 * @api {post} AskPriceApi/defaultaddress.php 2.默认地址
 * @apiVersion 1.2.0
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
*        }
*    ]
*}

 *
 **/
 /**
 * @api {post} AskPriceApi/addresslist.php 3.地址列表地址信息详情
 * @apiVersion 1.2.0
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
 *          }
 *         ]
 *      }
 *

 *
 **/
 /**
 * @api {post} AskPriceApi/deladdress.php 4.删除地址
 * @apiVersion 1.2.0
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
 * @api {post} AskPriceApi/upaddress.php 5.编辑地址
 * @apiVersion 1.2.0
 * @apiGroup address

 *
 * @apiParam {String} address_id 地址ID
 * @apiParam {String} name 名字
 * @apiParam {String} address 地址
 * @apiParam {String} mobile 手机号
 * @apiParam {String} defaultaddress=1 1默认，0没有选

 * @apiSuccessExample {json} 成功返回结果:
*{
*   "success":"true",
*    "data":
*        {
*        "name":"zhangsan",
*        "address":"11111",
*        "mobile":"15021680669",
*        "defaultaddress":"1",
*        "temp_buyers_id":"1"
*        }
*    }
 *
 * @apiErrorExample {json} 失败返回结果：
*{"success":"false","error":{"msg":"编辑地址失败","code":"4111"}}
*{"success":"false","error":{"msg":"用户名不能为空","code":"4800"}}
*{"success":"false","error":{"msg":"地址不能为空","code":"4800"}}
*{"success":"false","error":{"msg":"手机号码格式不正确","code":"4800"}}
 *
 **/
 /**
 * @api {post} AskPriceApi/ModifyPersonal.php 1.修改个人资料
 * @apiVersion 1.2.0
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
 * @api {post} AskPriceApi/GetPersonal.php 2.获取个人资料
 * @apiVersion 1.2.0

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
 * @api {post} AskPriceApi/question.php 3.问题反馈
 * @apiVersion 1.2.0

 * @apiGroup user information

 *
 * @apiParam {String} content 反馈


 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":{"msg":"反馈问题成功"}}
 *
 * @apiErrorExample {json} 失败返回结果：
 *{"success":"false","error":{"msg":"反馈问题失败","code":"4115"}}
*{"success":"false","error":{"msg":"session过期","code":"4120"}}
*{"success":"false","error":{"msg":"不少于15字","code":"4800"}}
 *
 **/


 /**
 * @api {post} AskPriceApi/GetUserInfo.php 4.通过用户名获取用户信息
 * @apiVersion 1.2.0

 * @apiGroup user information

 *
 * @apiParam {String} temp_buyers_mobile 手机号

 * @apiSuccessExample {json} 成功返回结果:
 *{"success":"true","data":
*    {
*        "temp_buyers_id":"1",
*        "temp_buyers_mobile":"15021680669",
*        "nick":"冰","
*        "photo":"D:/wamp/www/ecshop2/Guest/upload/photo/15021680669/thumb_15021680669head.jpg",
*        "info":"helle"
*    }
*}
 *
 * {"success":"false","error":{"msg":"手机号必须存在","code":"4800"}}
*{"success":"false","error":{"msg":"手机号格式不正确","code":"4800"}}
 *
 **/


 /**
 * @api {post} AskPriceApi/upfile.php 5.上传一张图片或文件
 * @apiVersion 1.2.0

 * @apiGroup user information

 *
 * @apiParam {String} ori_img 上传文件

 * @apiSuccessExample {json} 成功返回结果:
*{
*  "success": "true",
*  "data": {
*    "img_url": "http://192.168.1.61/ecshop2/Guest/upload/MOB/4dxz5k.jpg",
*    "thumb_url": "http://192.168.1.61/ecshop2/Guest/upload/MOB/thumb_4dxz5k.jpg"
*  }
*}

 *
 **/


 /**
 * @api {post} AskPriceApi/lookup.php 6.模糊查询
 * @apiVersion 1.2.0

 * @apiGroup user information

 *
 * @apiParam {String} mobile  手机号码任意位数
 * @apiParam {String} page 页码
* @apiParam {String} limit 显示条数
*
 * @apiSuccessExample {json} 成功返回结果:
*无数据返回：数据为空：{"success":"true","data":[]}
*{
*  "success": "true",
*  "data": [
*    {
*      "temp_buyers_id": "2",
*      "temp_buyers_mobile": "13262936502",
*      "nick": "fgghghh",
*      "temp_buyers_password": "e10adc3949ba59abbe56e057f20f883e",
*      "photo": "upload/photo/13262936502/13262936502head.jpg",
*      "info": "Hi符"
*    },
*    {
*      "temp_buyers_id": "3",
*      "temp_buyers_mobile": "18721559023",
*      "nick": "Coffee",
*      "temp_buyers_password": "96e79218965eb72c92a549dd5a330112",
*      "photo": "",
*      "info": ""
*    },
*   ]
*   }

 *

 *
 **/


 /**
 * @api {post} AskPriceApi/upfile.php 5.上传一张图片或文件
 * @apiVersion 1.2.0

 * @apiGroup user information

 *
 * @apiParam {String} ori_img 上传文件

 * @apiSuccessExample {json} 成功返回结果:
*{
*  "success": "true",
*  "data": {
*    "img_url": "http://192.168.1.61/ecshop2/Guest/upload/MOB/4dxz5k.jpg",
*    "thumb_url": "http://192.168.1.61/ecshop2/Guest/upload/MOB/thumb_4dxz5k.jpg"
*  }
*}

 *
 **/

  /**
 *@api {post} ... code码及其解释

 * @apiVersion 1.2.0

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


 *@apiError 4900 检验验证码失败
 *@apiError 4901 type不能为空
 *@apiError 1.4902 加入购物车失败！
 *@apiError 2.4902 删除购物车商品失败
 *@apiError 3.4902 修改购物车失败！

 *@apiError 1.4903 取消收藏失败！
 *@apiError 2.4903 清空收藏夹失败！

 *@apiError 4904 订单状态更新失败！


 
 **/

