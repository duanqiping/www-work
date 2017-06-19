define({ "api": [
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "apidoc-seed/template/main.js",
    "group": "C__wamp_www_pcwsee_apidoc_seed_template_main_js",
    "groupTitle": "C__wamp_www_pcwsee_apidoc_seed_template_main_js",
    "name": ""
  },
  {
    "type": "post",
    "url": "v1/index/city/location",
    "title": "城市定位",
    "version": "1.0.0",
    "group": "city",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"name\": \"上海\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "city",
    "name": "PostV1IndexCityLocation"
  },
  {
    "type": "post",
    "url": "v1/index/material/budget",
    "title": "家装预算",
    "version": "1.0.0",
    "group": "material",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "HomeType",
            "description": "<p>房间类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "DataType",
            "description": "<p>数据类型</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "HomeData",
            "description": "<p>房间参数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "HomeData.length",
            "description": "<p>长</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "HomeData.width",
            "description": "<p>宽</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "HomeData.height",
            "description": "<p>高</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "DoorData",
            "description": "<p>门</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "DoorData.width",
            "description": "<p>宽</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "DoorData.height",
            "description": "<p>高</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "WindowData",
            "description": "<p>窗</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "WindowData.width",
            "description": "<p>宽</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "WindowData.height",
            "description": "<p>高</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "[\n{\n \"mid\": \"54\",\n \"name\": \"水泥\",\n \"model\": \"325#，50KG\",\n \"brand\": \"海螺\",\n \"unit\": \"包\",\n \"num\": \"352.8\",\n \"price\": \"0.560\",\n \"notice\": null,\n \"rate\": \"50.00\",\n \"url\": \"http://www.pcw365.com/ecshop2/index.php\"\n},\n]",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"手机号码有误\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "material",
    "name": "PostV1IndexMaterialBudget"
  },
  {
    "type": "post",
    "url": "v1/index/material/size",
    "title": "计算房间信息",
    "version": "1.0.0",
    "group": "material",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Area",
            "description": "<p>总面积</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "RoomN",
            "description": "<p>室</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "SittingN",
            "description": "<p>厅</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "KitchenN",
            "description": "<p>厨房</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ToiletN",
            "description": "<p>卫生间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "BalconyN",
            "description": "<p>阳台</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "[\n{\n \"HomeType\": 1,\n \"DataType\": 0,\n \"HomeData\": {\n   \"length\": 6.9,\n   \"width\": 5.1,\n   \"height\": 2.8\n },\n \"DoorData\": [\n   {\n     \"width\": 0.9,\n     \"height\": 2\n   },\n ],\n \"WindowData\": [\n   {\n     \"width\": 1,\n     \"height\": 1\n   },\n ]\n},",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "material",
    "name": "PostV1IndexMaterialSize"
  },
  {
    "type": "post",
    "url": "v1/index/pay/alisign",
    "title": "支付宝生成签名",
    "version": "1.0.0",
    "group": "pay",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ordersn",
            "description": "<p>订单号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "\"partner=\\\"2088911549097841\\\"&seller_id=\\\"hbz@pcw268.com\\\"&out_trade_no=\\\"1611231025420000015701\\\"&subject=\\\"支付宝支付\\\"&body=\\\"1\\\"&total_fee=\\\"600.00\\\"&notify_url=\\\"http://localhost/ecshop2/MobileAPI2/pcwsee/v1/index/notify/ali\\\"&service=\\\"mobile.securitypay.pay\\\"&payment_type=\\\"1\\\"&_input_charset=\\\"utf-8\\\"&it_b_pay=\\\"30m\\\"&show_url=\\\"m.alipay.com\\\"&sign=\\\"\\\"&sign_type=\\\"RSA\\\"\"",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"price_id不能为空\",\"code\":400}\n{\"msg\":\"金额不能低于0\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "pay",
    "name": "PostV1IndexPayAlisign"
  },
  {
    "type": "post",
    "url": "v1/index/pay/doOrder",
    "title": "微信统一下单",
    "version": "1.0.0",
    "group": "pay",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ordersn",
            "description": "<p>订单号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"appid\": \"wxa70cbbfc5d3c28e4\",\n\"mch_id\": \"1265189601\",\n\"nonce_str\": \"Tbvn5Vuu4nX9AoPJ\",\n\"prepay_id\": \"wx20161123133922bf5e4b7ae40485269749\",\n\"result_code\": \"SUCCESS\",\n\"return_code\": \"SUCCESS\",\n\"return_msg\": \"OK\",\n\"sign\": \"8DC4E2568AA0C200A3162FD5C82F7A80\",\n\"trade_type\": \"APP\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"price_id不能为空\",\"code\":400}\n{\"msg\":\"金额不能低于0\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "pay",
    "name": "PostV1IndexPayDoorder"
  },
  {
    "type": "post",
    "url": "v1/index/index/CheckCode",
    "title": "验证验证码",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "checkcode",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>1注册 2忘记密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "\"验证成功\"\n{msg:\"验证成功\",code:0}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"手机号码有误\",\"code\":400}\n{\"msg\":\"验证码有误\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexCheckcode"
  },
  {
    "type": "post",
    "url": "v1/index/index/feedback",
    "title": "用户反馈",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>反馈信息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "\"反馈成功\"",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"留言不能太长\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexFeedback"
  },
  {
    "type": "post",
    "url": "v1/index/index/forgetPassword",
    "title": "忘记密码",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<p>确认密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{msg:\"密码重置成功\",code:0}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"密码长度需6位以上\",\"code\":400}\n{\"msg\":\"两次密码不一致\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexForgetpassword"
  },
  {
    "type": "post",
    "url": "v1/index/index/getCheckCode",
    "title": "获取验证码",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>1注册 2忘记密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{msg:\"验证码发送成功\",code:0}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"手机号码有误\",\"code\":400}\n{\"msg\":\"用户不存在\",\"code\":401}\n{\"msg\":\"用户已注册\",\"code\":401}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexGetcheckcode"
  },
  {
    "type": "post",
    "url": "v1/index/index/login",
    "title": "登录",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>手机号码或昵称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "\"user_id\": \"440784\",\n\"user_name\": \"17701804871\",\n\"phone\": \"17701804871\",\n\"mail\": \"\",\n\"vip\": true,\n\"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNDQwNzg0IiwidGltZSI6MTQ4MDQ3NTc2OX0.JIZHWtT9cswzBQezKiXtxS8DuY76wUQg4pv7uVdwjqY\"",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n\"msg\": \"用户不存在\",\n\"code\": 401\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexLogin"
  },
  {
    "type": "post",
    "url": "v1/index/index/logout",
    "title": "推出登陆",
    "version": "1.0.0",
    "group": "user",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "\"退出成功\"",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexLogout"
  },
  {
    "type": "post",
    "url": "v1/index/index/modify",
    "title": "修改密码",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>确认密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{msg:\"密码修改成功\",code:0}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"原密码错误\",\"code\":400}\n{\"msg\":\"两次密码不一致\",\"code\":400}\n{\"msg\":\"你还未登录\",\"code\":401}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexModify"
  },
  {
    "type": "post",
    "url": "v1/index/index/modifyInfo",
    "title": "修改昵称",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>昵称</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"user_id\": \"1\",\n\"user_name\": \"齐平你好呀你\",\n\"phone\": \"17701804871\",\n\"mail\": \"\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"原密码错误\",\"code\":400}\n{\"msg\":\"昵称不能太长\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexModifyinfo"
  },
  {
    "type": "post",
    "url": "v1/index/index/reg",
    "title": "用户注册",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "checkcode",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"user_id\": \"440784\",\n\"user_name\": \"17701804871\",\n\"phone\": \"17701804871\",\n\"mail\": \"\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"手机号码有误\",\"code\":400}\n{\"msg\":\"验证码有误\",\"code\":400}\n{\"msg\":\"密码长度需6位以上\",\"code\":400}\n{\"msg\":\"用户已注册\",\"code\":401}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1IndexIndexReg"
  },
  {
    "type": "post",
    "url": "v1/index/vip/confirm",
    "title": "vip下单",
    "version": "1.0.0",
    "group": "vip",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "price_id",
            "description": "<p>price表id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "money",
            "description": "<p>订单金额</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"charge_id\": \"90394\",\n\"user_id\": \"1\",\n\"ordersn\": \"1611231332250000014228\",\n\"money\": \"600.00\",\n\"paytype\": \"15\",\n\"statu\": \"0\",\n\"name\": \"迷你家装造价VIP  12个月\",\n\"product_flag_id\": \"HOMECOST\",\n\"price_id\": \"11\",\n\"insert_time\": \"2016-11-23 13:32:25\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"msg\":\"price_id不能为空\",\"code\":400}\n{\"msg\":\"金额不能低于0\",\"code\":400}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "vip",
    "name": "PostV1IndexVipConfirm"
  },
  {
    "type": "post",
    "url": "v1/index/vip/info",
    "title": "vip选项",
    "version": "1.0.0",
    "group": "vip",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "[\n{\n \"price_id\": 2,\n \"type\": 1,\n \"money\": 98,\n \"Orig_money\": 198,\n \"desc\": \"按季度收费\",\n \"tag\": \"\"\n},\n{\n \"price_id\": 3,\n \"type\": 2,\n \"money\": 198,\n \"Orig_money\": 698,\n \"desc\": \"按年收费\",\n \"tag\": \"限时特价\"\n}\n]",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "vip",
    "name": "PostV1IndexVipInfo"
  }
] });
