/**
 * @api {post} v1/index/city/location 城市定位
 * @apiVersion 1.0.0

 * @apiGroup city

 * @apiSuccessExample {json} 成功返回结果-
 *{
 * "name": "上海"
 *}
 **/

/**
 * @api {post} v1/index/material/size 计算房间信息
 * @apiVersion 1.0.0

 * @apiGroup  material
 * @apiParam {String} Area 总面积
 * @apiParam {String} RoomN 室
 * @apiParam {String} SittingN 厅
 * @apiParam {String} KitchenN 厨房
 * @apiParam {String} ToiletN 卫生间
 * @apiParam {String} BalconyN 阳台

 * @apiSuccessExample {json} 成功返回结果-
 *[
 *{
 *  "HomeType": 1,
 *  "DataType": 0,
 *  "HomeData": {
 *    "length": 6.9,
 *    "width": 5.1,
 *    "height": 2.8
 *  },
 *  "DoorData": [
 *    {
 *      "width": 0.9,
 *      "height": 2
 *    },
 *  ],
 *  "WindowData": [
 *    {
 *      "width": 1,
 *      "height": 1
 *    },
 *  ]
 * },
 **/


/**
 * @api {post} v1/index/material/budget 家装预算
 * @apiVersion 1.0.0

 * @apiGroup  material
 * @apiParam {String} HomeType 房间类型
 * @apiParam {String} DataType 数据类型
 * @apiParam {Object} HomeData 房间参数
 * @apiParam {String} HomeData.length 长
 * @apiParam {String} HomeData.width 宽
 * @apiParam {String} HomeData.height 高
 * @apiParam {Object} DoorData 门
 * @apiParam {String} DoorData.width 宽
 * @apiParam {String} DoorData.height 高
 *
 * @apiParam {Object} WindowData 窗
 * @apiParam {String} WindowData.width 宽
 * @apiParam {String} WindowData.height 高
 *
 * @apiSuccessExample {json} 成功返回结果-
 *[
 *{
 *  "mid": "54",
 *  "name": "水泥",
 *  "model": "325#，50KG",
 *  "brand": "海螺",
 *  "unit": "包",
 *  "num": "352.8",
 *  "price": "0.560",
 *  "notice": null,
 *  "rate": "50.00",
 *  "url": "http://www.pcw365.com/ecshop2/index.php"
 *},
 * ]

 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"手机号码有误","code":400}
 **/

/**
 * @api {post} v1/index/index/getCheckCode 获取验证码
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} phone 手机号码
 * @apiParam {String} type 1注册 2忘记密码

 * @apiSuccessExample {json} 成功返回结果-
 *{msg:"验证码发送成功",code:0}

 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"手机号码有误","code":400}
 *{"msg":"用户不存在","code":401}
 *{"msg":"用户已注册","code":401}
 **/

/**
 * @api {post} v1/index/index/CheckCode 验证验证码
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} phone 手机号码
 * @apiParam {String} checkcode 验证码
 * @apiParam {String} type 1注册 2忘记密码
 *
 * @apiSuccessExample {json} 成功返回结果-
 *"验证成功"
 *{msg:"验证成功",code:0}

 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"手机号码有误","code":400}
 *{"msg":"验证码有误","code":400}
 **/

/**
 * @api {post} v1/index/index/reg 用户注册
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} phone 手机号码
 * @apiParam {String} checkcode 验证码
 * @apiParam {String} password 密码

 * @apiSuccessExample {json} 成功返回结果-
 *{
 * "user_id": "440784",
 * "user_name": "17701804871",
 * "phone": "17701804871",
 * "mail": ""
 *}

 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"手机号码有误","code":400}
 *{"msg":"验证码有误","code":400}
 *{"msg":"密码长度需6位以上","code":400}
 * {"msg":"用户已注册","code":401}
 **/

/**
 * @api {post} v1/index/index/forgetPassword 忘记密码
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} phone 手机号码
 * @apiParam {String} password 密码
 * @apiParam {String} confirm_password 确认密码

 * @apiSuccessExample {json} 成功返回结果-
 * {msg:"密码重置成功",code:0}

 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"密码长度需6位以上","code":400}
 * {"msg":"两次密码不一致","code":400}
 **/

/**
 * @api {post} v1/index/index/login 登录
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} name 手机号码或昵称
 * @apiParam {String} password 密码

 * @apiSuccessExample {json} 成功返回结果-
 *"user_id": "440784",
 * "user_name": "17701804871",
 * "phone": "17701804871",
 * "mail": "",
 * "vip": true,
 * "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNDQwNzg0IiwidGltZSI6MTQ4MDQ3NTc2OX0.JIZHWtT9cswzBQezKiXtxS8DuY76wUQg4pv7uVdwjqY"

 * @apiErrorExample {json} 失败返回结果：
 *{
 * "msg": "用户不存在",
 * "code": 401
 *}
 **/

/**
 * @api {post} v1/index/index/logout 推出登陆
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiSuccessExample {json} 成功返回结果-
 *"退出成功"
 **/

/**
 * @api {post} v1/index/index/modify 修改密码
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} old_password 密码
 * @apiParam {String} new_password 确认密码

 * @apiSuccessExample {json} 成功返回结果-
 * {msg:"密码修改成功",code:0}

 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"原密码错误","code":400}
 * {"msg":"两次密码不一致","code":400}
 * {"msg":"你还未登录","code":401}
 **/

/**
 * @api {post} v1/index/index/modifyInfo 修改昵称
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} user_name 昵称

 * @apiSuccessExample {json} 成功返回结果-
 * {
 * "user_id": "1",
 * "user_name": "齐平你好呀你",
 * "phone": "17701804871",
 * "mail": ""
 *}

 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"原密码错误","code":400}
 * {"msg":"昵称不能太长","code":400}
 **/

/**
 * @api {post} v1/index/index/feedback 用户反馈
 * @apiVersion 1.0.0

 * @apiGroup user
 * @apiParam {String} msg 反馈信息

 * @apiSuccessExample {json} 成功返回结果-
 * "反馈成功"
 * @apiErrorExample {json} 失败返回结果：
 *{"msg":"留言不能太长","code":400}
 **/

/**
 * @api {post} v1/index/vip/info vip选项
 * @apiVersion 1.0.0

 * @apiGroup vip

 * @apiSuccessExample {json} 成功返回结果-
 * [
 *{
 *  "price_id": 2,
 *  "type": 1,
 *  "money": 98,
 *  "Orig_money": 198,
 *  "desc": "按季度收费",
 *  "tag": ""
 *},
 *{
 *  "price_id": 3,
 *  "type": 2,
 *  "money": 198,
 *  "Orig_money": 698,
 *  "desc": "按年收费",
 *  "tag": "限时特价"
 *}
 *]
 **/

/**
 * @api {post} v1/index/vip/confirm vip下单
 * @apiVersion 1.0.0

 * @apiGroup vip
 * @apiParam {String} price_id price表id号
 * @apiParam {String} money 订单金额

 * @apiSuccessExample {json} 成功返回结果-
 * {
 * "charge_id": "90394",
 * "user_id": "1",
 * "ordersn": "1611231332250000014228",
 * "money": "600.00",
 * "paytype": "15",
 * "statu": "0",
 * "name": "迷你家装造价VIP  12个月",
 * "product_flag_id": "HOMECOST",
 * "price_id": "11",
 * "insert_time": "2016-11-23 13:32:25"
 *}
 *@apiErrorExample {json} 失败返回结果：
 *{"msg":"price_id不能为空","code":400}
 * {"msg":"金额不能低于0","code":400}
 **/

/**
 * @api {post} v1/index/pay/alisign 支付宝生成签名
 * @apiVersion 1.0.0

 * @apiGroup pay
 * @apiParam {String} ordersn 订单号

 * @apiSuccessExample {json} 成功返回结果-
 * "partner=\"2088911549097841\"&seller_id=\"hbz@pcw268.com\"&out_trade_no=\"1611231025420000015701\"&subject=\"支付宝支付\"&body=\"1\"&total_fee=\"600.00\"&notify_url=\"http://localhost/ecshop2/MobileAPI2/pcwsee/v1/index/notify/ali\"&service=\"mobile.securitypay.pay\"&payment_type=\"1\"&_input_charset=\"utf-8\"&it_b_pay=\"30m\"&show_url=\"m.alipay.com\"&sign=\"\"&sign_type=\"RSA\""
 *@apiErrorExample {json} 失败返回结果：
 *{"msg":"price_id不能为空","code":400}
 * {"msg":"金额不能低于0","code":400}
 **/

/**
 * @api {post} v1/index/pay/doOrder 微信统一下单
 * @apiVersion 1.0.0

 * @apiGroup pay
 * @apiParam {String} ordersn 订单号

 * @apiSuccessExample {json} 成功返回结果-
 * {
 * "appid": "wxa70cbbfc5d3c28e4",
 * "mch_id": "1265189601",
 * "nonce_str": "Tbvn5Vuu4nX9AoPJ",
 * "prepay_id": "wx20161123133922bf5e4b7ae40485269749",
 * "result_code": "SUCCESS",
 * "return_code": "SUCCESS",
 * "return_msg": "OK",
 * "sign": "8DC4E2568AA0C200A3162FD5C82F7A80",
 * "trade_type": "APP"
 *}
 *@apiErrorExample {json} 失败返回结果：
 *{"msg":"price_id不能为空","code":400}
 * {"msg":"金额不能低于0","code":400}
 **/