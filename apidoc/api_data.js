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
    "filename": "apidoc-seed/doc/main.js",
    "group": "C__wamp_www_apidoc_seed_doc_main_js",
    "groupTitle": "C__wamp_www_apidoc_seed_doc_main_js",
    "name": ""
  },
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
    "group": "C__wamp_www_apidoc_seed_template_main_js",
    "groupTitle": "C__wamp_www_apidoc_seed_template_main_js",
    "name": ""
  },
  {
    "type": "post",
    "url": "myecshop2/bonus/recharge",
    "title": "5.余额接口",
    "version": "1.2.0",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_account_id\": \"69\",\n   \"temp_buyers_id\": \"1203\",\n   \"total\": \"0.00\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostMyecshop2BonusRecharge"
  },
  {
    "type": "post",
    "url": "myecshop2/bonus/show",
    "title": "6.红包列表接口",
    "version": "1.2.0",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_area_id",
            "description": "<p>城市ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（取默认城市上海  未登录）\n{\n \"success\": \"true\",\n \"data\": {\n   \"num\": \"3\",\n   \"total_money\": \"600\",\n   \"list\": [\n     {\n       \"order_id\": \"3\",\n       \"order_sn\": \"12313\",\n       \"user_id\": \"1203\",\n       \"order_status\": \"1\",\n       \"pay_method\": \"1\",\n       \"order_amount\": \"500.00\",\n       \"add_time\": \"3\",\n       \"bonus_id\": \"3\",\n       \"bonus_name\": \"邀请红包\",\n       \"bonus_money\": \"300.00\",\n       \"cash_id\": \"1\"\n     },\n    ]\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostMyecshop2BonusShow"
  },
  {
    "type": "post",
    "url": "myecshop2/city/location",
    "title": "1.定位城市",
    "version": "1.2.0",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"goods_area_id\":\"0\",\"goods_area\":\"局域网\",\"goods_table\":\"\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostMyecshop2CityLocation"
  },
  {
    "type": "post",
    "url": "myecshop2/city/search",
    "title": "3.搜索接口",
    "version": "1.2.0",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>输入的搜索条件</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_table",
            "description": "<p>城市对应商品表</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>分页</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>一页记录数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}  （搜索结果为空！）\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_name_id\": \"1\",\n     \"goods_id\": \"1911\",\n     \"goods_cat_id\": \"109\",\n     \"goods_name\": \"锯条12345\",\n     \"goods_unit\": \"根\",\n     \"shop_price\": \"4.50\",\n     \"goods_color\": \"默认\",\n     \"color\": {\n       \"color_name\": \"默认\",\n       \"color_id\": \"8\"\n     },\n     \"brand\": {\n       \"brand_name\": \"全部品牌\",\n       \"brand_id\": \"40\"\n     },\n     \"version\": {\n       \"version_name\": \"标准\",\n       \"version_id\": \"1003\"\n     },\n     \"goods_img\": \"http://192.168.1.194/ecshop2/Guest/\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostMyecshop2CitySearch"
  },
  {
    "type": "post",
    "url": "myecshop2/city/select",
    "title": "4.城市选择接口",
    "version": "1.2.0",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_area_id",
            "description": "<p>城市ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（取默认城市上海  未登录）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"1\",\"city\":\"上海\",\"goods_table\":\"ecs_goods\"}}\n\n（取本地城市   未登录）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"2\",\"city\":\"南京\",\"goods_table\":\"ecs_goods_nj\"}}\n（已登陆）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"1\",\"city\":\"上海\",\"goods_table\":\"ecs_goods\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostMyecshop2CitySelect"
  },
  {
    "type": "post",
    "url": "myecshop2/city/show",
    "title": "2.城市列表",
    "version": "1.2.0",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_area_id\": \"1\",\n     \"goods_area\": \"上海\",\n     \"goods_table\": \"ecs_goods\"\n   },\n   {\n     \"goods_area_id\": \"2\",\n     \"goods_area\": \"南京\",\n     \"goods_table\": \"ecs_goods_nj\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostMyecshop2CityShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bonus/recharge",
    "title": "余额接口",
    "version": "3.1.1",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "temp_purchase_id",
            "description": "<p>订单id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_account_id\": \"1259\",\n   \"temp_buyers_id\": \"3097\",\n   \"total\": \"0.00\",\n   \"switch\": \"true\",\n   \"quick_pay\": \"true\"\n   \"cod_pay\": \"false\" \n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2BonusRecharge"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bonus/recharge",
    "title": "余额接口",
    "version": "3.1.0",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "temp_purchase_id",
            "description": "<p>订单id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_account_id\": \"1259\",\n   \"temp_buyers_id\": \"3097\",\n   \"total\": \"0.00\",\n   \"switch\": \"true\",\n   \"quick_pay\": \"true\"\n   \"cod_pay\": \"false\" \n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2BonusRecharge"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bonus/show",
    "title": "红包列表接口",
    "version": "3.1.1",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_area_id",
            "description": "<p>城市ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（取默认城市上海  未登录）\n{\n \"success\": \"true\",\n \"data\": {\n   \"num\": \"3\",\n   \"total_money\": \"600\",\n   \"list\": [\n     {\n       \"order_id\": \"3\",\n       \"order_sn\": \"12313\",\n       \"user_id\": \"1203\",\n       \"order_status\": \"1\",\n       \"pay_method\": \"1\",\n       \"order_amount\": \"500.00\",\n       \"add_time\": \"3\",\n       \"bonus_id\": \"3\",\n       \"bonus_name\": \"邀请红包\",\n       \"bonus_money\": \"300.00\",\n       \"cash_id\": \"1\"\n     },\n    ]\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2BonusShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bonus/show",
    "title": "红包列表接口",
    "version": "3.1.0",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_area_id",
            "description": "<p>城市ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（取默认城市上海  未登录）\n{\n \"success\": \"true\",\n \"data\": {\n   \"num\": \"3\",\n   \"total_money\": \"600\",\n   \"list\": [\n     {\n       \"order_id\": \"3\",\n       \"order_sn\": \"12313\",\n       \"user_id\": \"1203\",\n       \"order_status\": \"1\",\n       \"pay_method\": \"1\",\n       \"order_amount\": \"500.00\",\n       \"add_time\": \"3\",\n       \"bonus_id\": \"3\",\n       \"bonus_name\": \"邀请红包\",\n       \"bonus_money\": \"300.00\",\n       \"cash_id\": \"1\"\n     },\n    ]\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2BonusShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/location",
    "title": "定位城市",
    "version": "3.1.1",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"goods_area_id\":\"0\",\"goods_area\":\"局域网\",\"goods_table\":\"\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CityLocation"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/location",
    "title": "定位城市",
    "version": "3.1.0",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"goods_area_id\":\"0\",\"goods_area\":\"局域网\",\"goods_table\":\"\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CityLocation"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/search",
    "title": "搜索接口",
    "version": "3.1.1",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>输入的搜索条件</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_table",
            "description": "<p>城市对应商品表</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>分页</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>一页记录数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "defaultValue": "1",
            "description": "<p>1对应辅材，2对应主材</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}  （搜索结果为空！）\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_name_id\": \"1\",\n     \"goods_id\": \"1911\",\n     \"goods_cat_id\": \"109\",\n     \"goods_name\": \"锯条12345\",\n     \"goods_unit\": \"根\",\n     \"shop_price\": \"4.50\",\n     \"goods_color\": \"默认\",\n     \"color\": {\n       \"color_name\": \"默认\",\n       \"color_id\": \"8\"\n     },\n     \"brand\": {\n       \"brand_name\": \"全部品牌\",\n       \"brand_id\": \"40\"\n     },\n     \"version\": {\n       \"version_name\": \"标准\",\n       \"version_id\": \"1003\"\n     },\n     \"goods_img\": \"http://192.168.1.194/ecshop2/Guest/\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CitySearch"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/search",
    "title": "搜索接口",
    "version": "3.1.0",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>输入的搜索条件</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_table",
            "description": "<p>城市对应商品表</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>分页</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>一页记录数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "defaultValue": "1",
            "description": "<p>1对应辅材，2对应主材</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}  （搜索结果为空！）\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_name_id\": \"1\",\n     \"goods_id\": \"1911\",\n     \"goods_cat_id\": \"109\",\n     \"goods_name\": \"锯条12345\",\n     \"goods_unit\": \"根\",\n     \"shop_price\": \"4.50\",\n     \"goods_color\": \"默认\",\n     \"color\": {\n       \"color_name\": \"默认\",\n       \"color_id\": \"8\"\n     },\n     \"brand\": {\n       \"brand_name\": \"全部品牌\",\n       \"brand_id\": \"40\"\n     },\n     \"version\": {\n       \"version_name\": \"标准\",\n       \"version_id\": \"1003\"\n     },\n     \"goods_img\": \"http://192.168.1.194/ecshop2/Guest/\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CitySearch"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/select",
    "title": "城市选择接口",
    "version": "3.1.1",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_area_id",
            "description": "<p>城市ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（取默认城市上海  未登录）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"1\",\"city\":\"上海\",\"goods_table\":\"ecs_goods\"}}\n\n（取本地城市   未登录）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"2\",\"city\":\"南京\",\"goods_table\":\"ecs_goods_nj\"}}\n（已登陆）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"1\",\"city\":\"上海\",\"goods_table\":\"ecs_goods\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CitySelect"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/select",
    "title": "城市选择接口",
    "version": "3.1.0",
    "group": "City_and_Bonus",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_area_id",
            "description": "<p>城市ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（取默认城市上海  未登录）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"1\",\"city\":\"上海\",\"goods_table\":\"ecs_goods\"}}\n\n（取本地城市   未登录）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"2\",\"city\":\"南京\",\"goods_table\":\"ecs_goods_nj\"}}\n（已登陆）\n{\"success\":\"true\",\"data\":{\"goods_area_id\":\"1\",\"city\":\"上海\",\"goods_table\":\"ecs_goods\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CitySelect"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/show",
    "title": "城市列表",
    "version": "3.1.1",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_area_id\": \"1\",\n     \"goods_area\": \"上海\",\n     \"goods_table\": \"ecs_goods\"\n   },\n   {\n     \"goods_area_id\": \"2\",\n     \"goods_area\": \"南京\",\n     \"goods_table\": \"ecs_goods_nj\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CityShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/show",
    "title": "城市列表",
    "version": "3.1.0",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_area_id\": \"1\",\n     \"goods_area\": \"上海\",\n     \"goods_table\": \"ecs_goods\"\n   },\n   {\n     \"goods_area_id\": \"2\",\n     \"goods_area\": \"南京\",\n     \"goods_table\": \"ecs_goods_nj\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CityShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/support",
    "title": "支持的城市地址",
    "version": "3.1.1",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"success\": \"true\",\n  \"data\": [\n    {\n      \"id\": \"1\",\n      \"name\": \"北京市\",\n      \"children\": [\n        {\n          \"id\": \"3357\",\n          \"name\": \"北京市\",\n          \"children\": [\n            {\n              \"id\": \"2\",\n              \"name\": \"东城区\"\n            },\n            {\n              \"id\": \"3\",\n              \"name\": \"西城区\"\n            }\n       ]\n    }\n    {\n     \"id\": \"37\",\n     \"name\": \"河北省\",\n     \"children\": [\n       {\n         \"id\": \"38\",\n         \"name\": \"石家庄市\",\n         \"children\": [\n           {\n             \"id\": \"39\",\n             \"name\": \"长安区\"\n           }\n         ]\n       }\n     }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CitySupport"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/city/support",
    "title": "支持的城市地址",
    "version": "3.1.0",
    "group": "City_and_Bonus",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"success\": \"true\",\n  \"data\": [\n    {\n      \"id\": \"1\",\n      \"name\": \"北京市\",\n      \"children\": [\n        {\n          \"id\": \"3357\",\n          \"name\": \"北京市\",\n          \"children\": [\n            {\n              \"id\": \"2\",\n              \"name\": \"东城区\"\n            },\n            {\n              \"id\": \"3\",\n              \"name\": \"西城区\"\n            }\n       ]\n    }\n    {\n     \"id\": \"37\",\n     \"name\": \"河北省\",\n     \"children\": [\n       {\n         \"id\": \"38\",\n         \"name\": \"石家庄市\",\n         \"children\": [\n           {\n             \"id\": \"39\",\n             \"name\": \"长安区\"\n           }\n         ]\n       }\n     }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "City_and_Bonus",
    "name": "PostV31Myecshop2CitySupport"
  },
  {
    "type": "post",
    "url": "myecshop2/home/cart/add",
    "title": "7.加入购物车",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"加入购物车成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"amount不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"加入购物车失败！\",\"code\":\"4902\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeCartAdd"
  },
  {
    "type": "post",
    "url": "myecshop2/home/cart/cart",
    "title": "10.获取购物车列表",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_table",
            "description": "<p>城市商品表</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}  购物车列表为空\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"821\",\n     \"goods_name\": \"皮尔萨 PPR 管子 40米起 包安装\",\n     \"goods_unit\": \"m\",\n     \"shop_price\": \"32.00\",\n     \"amount\": \"1\",\n     \"is_collection\": \"1\",\n     \"brand\": {\n       \"brand_name\": \"皮尔萨\",\n       \"brand_id\": \"1\"\n     },\n     \"version\": {\n       \"version_name\": \" D32\",\n       \"version_id\": \"1\"\n     },\n     \"color\": {\n       \"color_name\": \"其他\",\n       \"color_id\": \"8\"\n     }\n   },\n   {\n     \"goods_id\": \"10\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"22.50\",\n     \"amount\": \"1\",\n     \"is_collection\": \"1\",\n     \"brand\": {\n       \"brand_name\": \"美的\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D04X-30D/30/G/J03\",\n       \"version_id\": \"10\"\n     },\n     \"color\": {\n       \"color_name\": null,\n       \"color_id\": \"0\"\n     }\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeCartCart"
  },
  {
    "type": "post",
    "url": "myecshop2/home/cart/clean",
    "title": "6.清空收藏夹",
    "version": "1.2.0",
    "group": "Goods",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"成功清空收藏夹！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"清空收藏夹失败！\",\"code\":\"4903\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeCartClean"
  },
  {
    "type": "post",
    "url": "myecshop2/home/cart/collect",
    "title": "4.收藏",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品的Id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>（del 取消收藏动作  act=add 加入收藏动作）</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"收藏成功！\"}\n{\"success\":\"true\",\"message\":\"取消收藏成功！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"取消收藏失败！\",\"code\":\"4903\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"提交动作act的值只能为del或者add\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"act不能为空\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeCartCollect"
  },
  {
    "type": "post",
    "url": "myecshop2/home/cart/delete",
    "title": "8.删除购物车中商品",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"删除购物车商品成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"删除购物车商品失败\",\"code\":\"4902\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeCartDelete"
  },
  {
    "type": "post",
    "url": "myecshop2/home/cart/show",
    "title": "5.收藏夹列表",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页商品数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}   收藏夹列表为空\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"21\",\n     \"goods_name\": \"凤铝789推拉窗\",\n     \"goods_unit\": \"平方\",\n     \"shop_price\": \"270.00\",\n     \"color\": {\n       \"color_id\": \"0\",\n       \"color_name\": \"\"\n     },\n     \"version\": {\n       \"version_id\": \"0\",\n       \"version_name\": \"5mm单玻\"\n     },\n     \"brand\": {\n       \"brand_id\": \"2\",\n       \"brand_name\": \"凤铝\"\n     }\n   },\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeCartShow"
  },
  {
    "type": "post",
    "url": "myecshop2/home/cart/update",
    "title": "9.修改购物车",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"修改购物车成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"amount不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"修改购物车失败！\",\"code\":\"4902\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"修改购物车失败！\",\"code\":\"4904\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeCartUpdate"
  },
  {
    "type": "post",
    "url": "myecshop2/home/index/goodsdetail",
    "title": "2.商品详情",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材，type=2对应尾货</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}\n（is_collection=1 收藏  is_collection=0未收藏）\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"10\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"22.50\",\n     \"goods_img\": \"http://192.168.1.194/myecshop2/Guest/upload/15-07-14 09-42-21125.jpg\",\n     \"goods_color\": null,\n     \"is_collection\": \"1\",\n     \"color\": {\n       \"color_name\": null,\n       \"color_id\": \"0\"\n     },\n     \"brand\": {\n       \"brand_name\": \"美的\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D04X-30D/30/G/J03\",\n       \"version_id\": \"10\"\n     }\n   },\n   {\n     \"goods_id\": \"830\",\n     \"goods_name\": \"西门子(品宜)一位10A联体 二三极插座\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"7.10\",\n     \"goods_img\": \"http://192.168.1.194/myecshop2/Guest/upload/15-08-14 04-24-0317.jpg\",\n     \"goods_color\": \"白\",\n     \"is_collection\": \"0\",\n     \"color\": {\n       \"color_name\": \"白\",\n       \"color_id\": \"4\"\n     },\n     \"brand\": {\n       \"brand_name\": \"西门子\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"5UB06153NC01\",\n       \"version_id\": \"10\"\n     }\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你没输入goods_id!\",\"code\":\"4801\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeIndexGoodsdetail"
  },
  {
    "type": "post",
    "url": "myecshop2/home/material/brandlist2",
    "title": "3.商品列表",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材，type=2对应尾货</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_category_id",
            "description": "<p>二级分类ID号(和下面的参数ID 只传其中一个就行)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "brand_id",
            "description": "<p>品牌ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "defaultValue": "页码（默认值1）",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "defaultValue": "每页商品数(默认值10)",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "或者 当传入值 为brand_id时\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"2\",\n     \"goods_cat_id\": \"91\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"20.00\",\n     \"is_collection\": \"0\",\n\t   \"goods_img\": \"http://192.168.1.28/pcwstore/Guest/upload/wy/1.png\",\n     \"cat\": {\n       \"cat_name\": \"开关\",\n       \"cat_id\": \"91\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D02X-30D/57/W/J01\",\n       \"version_id\": null\n     },\n     \"brand\": {\n       \"brand_name\": \"美的商照\",\n       \"brand_id\": \"2\"\n     }\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"id不能为空!\",\"code\":\"4106\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeMaterialBrandlist2"
  },
  {
    "type": "post",
    "url": "myecshop2/home/material/sub",
    "title": "1.辅材  和 二级栏目",
    "version": "1.2.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "defaultValue": "1",
            "description": "<p>辅材</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"cat_id\": \"1\",\n     \"cat_name\": \"卫浴\",\n     \"cat_children\": [\n       {\n         \"img_url\": \"\",\n         \"cat_id\": \"13\",\n         \"cat_name\": \"座便器\",\n         \"cat_children\": [\n           {\n             \"cat_id\": \"3\",\n             \"cat_name\": \"aaa\"\n           },\n           {\n             \"cat_id\": \"4\",\n             \"cat_name\": \"bbb\"\n           }\n         ]\n       }\n      ]\n    }\n   ]\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"id不能为空!\",\"code\":\"4106\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Goods",
    "name": "PostMyecshop2HomeMaterialSub"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/add",
    "title": "加入购物车",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材 type=2对应尾货</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"加入购物车成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"amount不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"加入购物车失败！\",\"code\":\"4902\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartAdd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/add",
    "title": "加入购物车",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材 type=2对应尾货</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"加入购物车成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"amount不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"加入购物车失败！\",\"code\":\"4902\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartAdd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/cart",
    "title": "获取购物车列表",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_table",
            "description": "<p>城市商品表</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}  购物车列表为空\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"821\",\n     \"goods_name\": \"皮尔萨 PPR 管子 40米起 包安装\",\n     \"goods_unit\": \"m\",\n     \"shop_price\": \"32.00\",\n     \"amount\": \"1\",\n     \"min_amount\": \"1\",\n     \"is_collection\": \"1\",\n     \"brand\": {\n       \"brand_name\": \"皮尔萨\",\n       \"brand_id\": \"1\"\n     },\n     \"version\": {\n       \"version_name\": \" D32\",\n       \"version_id\": \"1\"\n     },\n     \"color\": {\n       \"color_name\": \"其他\",\n       \"color_id\": \"8\"\n     }\n\t\t'type': \"1\"\n   },\n   {\n     \"goods_id\": \"10\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"22.50\",\n     \"amount\": \"1\",\n     \"is_collection\": \"1\",\n     \"brand\": {\n       \"brand_name\": \"美的\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D04X-30D/30/G/J03\",\n       \"version_id\": \"10\"\n     },\n     \"color\": {\n       \"color_name\": null,\n       \"color_id\": \"0\"\n     }\n\t\t\"type\":  \"1\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartCart"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/cart",
    "title": "获取购物车列表",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_table",
            "description": "<p>城市商品表</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}  购物车列表为空\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"821\",\n     \"goods_name\": \"皮尔萨 PPR 管子 40米起 包安装\",\n     \"goods_unit\": \"m\",\n     \"shop_price\": \"32.00\",\n     \"amount\": \"1\",\n     \"min_amount\": \"1\",\n     \"is_collection\": \"1\",\n     \"brand\": {\n       \"brand_name\": \"皮尔萨\",\n       \"brand_id\": \"1\"\n     },\n     \"version\": {\n       \"version_name\": \" D32\",\n       \"version_id\": \"1\"\n     },\n     \"color\": {\n       \"color_name\": \"其他\",\n       \"color_id\": \"8\"\n     }\n\t\t'type': \"1\"\n   },\n   {\n     \"goods_id\": \"10\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"22.50\",\n     \"amount\": \"1\",\n     \"is_collection\": \"1\",\n     \"brand\": {\n       \"brand_name\": \"美的\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D04X-30D/30/G/J03\",\n       \"version_id\": \"10\"\n     },\n     \"color\": {\n       \"color_name\": null,\n       \"color_id\": \"0\"\n     }\n\t\t\"type\":  \"1\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartCart"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/clean",
    "title": "清空收藏夹",
    "version": "3.1.1",
    "group": "Goods",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"成功清空收藏夹！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"清空收藏夹失败！\",\"code\":\"4903\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartClean"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/clean",
    "title": "清空收藏夹",
    "version": "3.1.0",
    "group": "Goods",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"成功清空收藏夹！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"清空收藏夹失败！\",\"code\":\"4903\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartClean"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/collect",
    "title": "收藏",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品的Id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>（del 取消收藏动作  act=add 加入收藏动作）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材 type=2对应尾货</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"收藏成功！\"}\n{\"success\":\"true\",\"message\":\"取消收藏成功！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"取消收藏失败！\",\"code\":\"4903\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"提交动作act的值只能为del或者add\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"act不能为空\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartCollect"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/collect",
    "title": "收藏",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品的Id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>（del 取消收藏动作  act=add 加入收藏动作）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材 type=2对应尾货</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"收藏成功！\"}\n{\"success\":\"true\",\"message\":\"取消收藏成功！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"取消收藏失败！\",\"code\":\"4903\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"提交动作act的值只能为del或者add\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"act不能为空\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartCollect"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/delete",
    "title": "删除购物车中商品",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "shop_car_id",
            "description": "<p>购物车ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"删除购物车商品成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"删除购物车商品失败\",\"code\":\"4902\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartDelete"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/delete",
    "title": "删除购物车中商品",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "shop_car_id",
            "description": "<p>购物车ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"删除购物车商品成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"删除购物车商品失败\",\"code\":\"4902\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartDelete"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/show",
    "title": "收藏夹列表",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页商品数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}   收藏夹列表为空\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"21\",\n     \"goods_name\": \"凤铝789推拉窗\",\n     \"goods_unit\": \"平方\",\n     \"shop_price\": \"270.00\",\n     \"color\": {\n       \"color_id\": \"0\",\n       \"color_name\": \"\"\n     },\n     \"version\": {\n       \"version_id\": \"0\",\n       \"version_name\": \"5mm单玻\"\n     },\n     \"brand\": {\n       \"brand_id\": \"2\",\n       \"brand_name\": \"凤铝\"\n     }\n\t\t\"type\": \"1\",\n   },\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/show",
    "title": "收藏夹列表",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页商品数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}   收藏夹列表为空\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"21\",\n     \"goods_name\": \"凤铝789推拉窗\",\n     \"goods_unit\": \"平方\",\n     \"shop_price\": \"270.00\",\n     \"color\": {\n       \"color_id\": \"0\",\n       \"color_name\": \"\"\n     },\n     \"version\": {\n       \"version_id\": \"0\",\n       \"version_name\": \"5mm单玻\"\n     },\n     \"brand\": {\n       \"brand_id\": \"2\",\n       \"brand_name\": \"凤铝\"\n     }\n\t\t\"type\": \"1\",\n   },\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/update",
    "title": "修改购物车",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "shop_car_id",
            "description": "<p>购物车ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"修改购物车成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"amount不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"修改购物车失败！\",\"code\":\"4902\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"修改购物车失败！\",\"code\":\"4904\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartUpdate"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/cart/update",
    "title": "修改购物车",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "shop_car_id",
            "description": "<p>购物车ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"message\":\"修改购物车成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"amount不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"goods_id不能为空\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"修改购物车失败！\",\"code\":\"4902\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"修改购物车失败！\",\"code\":\"4904\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeCartUpdate"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/index/goodsdetail",
    "title": "商品详情",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材，type=2对应尾货</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}\n（is_collection=1 收藏  is_collection=0未收藏）\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"10\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"22.50\",\n     \"goods_img\": \"http://192.168.1.194/v3.1/myecshop2/Guest/upload/15-07-14 09-42-21125.jpg\",\n     \"goods_color\": null,\n     \"is_collection\": \"1\",\n     \"min_amount\": \"1\",\n     \"type\": \"1\",\n\t\"imgs\": [],\n     \"color\": {\n       \"color_name\": null,\n       \"color_id\": \"0\"\n     },\n     \"brand\": {\n       \"brand_name\": \"美的\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D04X-30D/30/G/J03\",\n       \"version_id\": \"10\"\n     }\n   },\n   {\n     \"goods_id\": \"830\",\n     \"goods_name\": \"西门子(品宜)一位10A联体 二三极插座\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"7.10\",\n     \"goods_img\": \"http://192.168.1.194/v3.1/myecshop2/Guest/upload/15-08-14 04-24-0317.jpg\",\n     \"goods_color\": \"白\",\n     \"is_collection\": \"0\",\n     \"color\": {\n       \"color_name\": \"白\",\n       \"color_id\": \"4\"\n     },\n     \"brand\": {\n       \"brand_name\": \"西门子\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"5UB06153NC01\",\n       \"version_id\": \"10\"\n     }\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你没输入goods_id!\",\"code\":\"4801\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeIndexGoodsdetail"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/index/goodsdetail",
    "title": "商品详情",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材，type=2对应尾货</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_id",
            "description": "<p>商品id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":[]}\n（is_collection=1 收藏  is_collection=0未收藏）\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"10\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"22.50\",\n     \"goods_img\": \"http://192.168.1.194/v3.1/myecshop2/Guest/upload/15-07-14 09-42-21125.jpg\",\n     \"goods_color\": null,\n     \"is_collection\": \"1\",\n     \"min_amount\": \"1\",\n     \"type\": \"1\",\n\t\"imgs\": [],\n     \"color\": {\n       \"color_name\": null,\n       \"color_id\": \"0\"\n     },\n     \"brand\": {\n       \"brand_name\": \"美的\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D04X-30D/30/G/J03\",\n       \"version_id\": \"10\"\n     }\n   },\n   {\n     \"goods_id\": \"830\",\n     \"goods_name\": \"西门子(品宜)一位10A联体 二三极插座\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"7.10\",\n     \"goods_img\": \"http://192.168.1.194/v3.1/myecshop2/Guest/upload/15-08-14 04-24-0317.jpg\",\n     \"goods_color\": \"白\",\n     \"is_collection\": \"0\",\n     \"color\": {\n       \"color_name\": \"白\",\n       \"color_id\": \"4\"\n     },\n     \"brand\": {\n       \"brand_name\": \"西门子\",\n       \"brand_id\": \"10\"\n     },\n     \"version\": {\n       \"version_name\": \"5UB06153NC01\",\n       \"version_id\": \"10\"\n     }\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你没输入goods_id!\",\"code\":\"4801\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeIndexGoodsdetail"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/material/brandlist2",
    "title": "商品列表",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材，type=2对应尾货</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_category_id",
            "description": "<p>二级分类ID号(和下面的参数ID 只传其中一个就行)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "brand_id",
            "description": "<p>品牌ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "defaultValue": "页码（默认值1）",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "defaultValue": "每页商品数(默认值10)",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "或者 当传入值 为brand_id时\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"2\",\n     \"goods_cat_id\": \"91\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"20.00\",\n     \"is_collection\": \"0\",\n\t   \"goods_img\": \"http://192.168.1.28/pcwstore/Guest/upload/wy/1.png\",\n     \"cat\": {\n       \"cat_name\": \"开关\",\n       \"cat_id\": \"91\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D02X-30D/57/W/J01\",\n       \"version_id\": null\n     },\n     \"brand\": {\n       \"brand_name\": \"美的商照\",\n       \"brand_id\": \"2\"\n     }\n\t\t\"type\": \"1\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"id不能为空!\",\"code\":\"4106\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeMaterialBrandlist2"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/material/brandlist2",
    "title": "商品列表",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type=1对应辅材，type=2对应尾货</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_category_id",
            "description": "<p>二级分类ID号(和下面的参数ID 只传其中一个就行)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "brand_id",
            "description": "<p>品牌ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "defaultValue": "页码（默认值1）",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "defaultValue": "每页商品数(默认值10)",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "或者 当传入值 为brand_id时\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"goods_id\": \"2\",\n     \"goods_cat_id\": \"91\",\n     \"goods_name\": \"LED天花射灯\",\n     \"goods_unit\": \"个\",\n     \"shop_price\": \"20.00\",\n     \"is_collection\": \"0\",\n\t   \"goods_img\": \"http://192.168.1.28/pcwstore/Guest/upload/wy/1.png\",\n     \"cat\": {\n       \"cat_name\": \"开关\",\n       \"cat_id\": \"91\"\n     },\n     \"version\": {\n       \"version_name\": \"MSD01-D02X-30D/57/W/J01\",\n       \"version_id\": null\n     },\n     \"brand\": {\n       \"brand_name\": \"美的商照\",\n       \"brand_id\": \"2\"\n     }\n\t\t\"type\": \"1\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"id不能为空!\",\"code\":\"4106\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeMaterialBrandlist2"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/material/sub",
    "title": "辅材  和 二级栏目",
    "version": "3.1.1",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "defaultValue": "1",
            "description": "<p>辅材</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"cat_id\": \"1\",\n     \"cat_name\": \"卫浴\",\n     \"cat_children\": [\n       {\n         \"img_url\": \"\",\n         \"cat_id\": \"13\",\n         \"cat_name\": \"座便器\",\n         \"cat_children\": [\n           {\n             \"cat_id\": \"3\",\n             \"cat_name\": \"aaa\"\n           },\n           {\n             \"cat_id\": \"4\",\n             \"cat_name\": \"bbb\"\n           }\n         ]\n       }\n      ]\n    }\n   ]\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"id不能为空!\",\"code\":\"4106\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeMaterialSub"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/material/sub",
    "title": "辅材  和 二级栏目",
    "version": "3.1.0",
    "group": "Goods",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "defaultValue": "1",
            "description": "<p>辅材</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"cat_id\": \"1\",\n     \"cat_name\": \"卫浴\",\n     \"cat_children\": [\n       {\n         \"img_url\": \"\",\n         \"cat_id\": \"13\",\n         \"cat_name\": \"座便器\",\n         \"cat_children\": [\n           {\n             \"cat_id\": \"3\",\n             \"cat_name\": \"aaa\"\n           },\n           {\n             \"cat_id\": \"4\",\n             \"cat_name\": \"bbb\"\n           }\n         ]\n       }\n      ]\n    }\n   ]\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"id不能为空!\",\"code\":\"4106\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Goods",
    "name": "PostV31Myecshop2HomeMaterialSub"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php1",
    "title": "10.提现信息",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>payment #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页显示条数</p>"
          }
        ]
      }
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp1"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php2",
    "title": "11.买家提醒卖家发货",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>remind #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"提醒卖家发货成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"提醒卖家发货失败\",\"code\":\"4128\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp2"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php2",
    "title": "11.买家提醒卖家发货",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>remind #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"提醒卖家发货成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"提醒卖家发货失败\",\"code\":\"4128\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp2"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php3",
    "title": "12.网银列表",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>banklist</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n   \"success\": \"true\",\n   \"data\": [\n       {\n           \"bank_id\": \"ICBCB2C\",\n           \"bank_name\": \"中国工商银行\",\n           \"bank_icon\": \"http://192.168.1.61/ecshop2/AskPriceApi/data/images/bank_icon/ICBCB2C.png\"\n       },\n       {\n           \"bank_id\": \"ABC\",\n           \"bank_name\": \"中国农业银行\",\n           \"bank_icon\": \"http://192.168.1.61/ecshop2/AskPriceApi/data/images/bank_icon/ABC.png\"\n       },\n      ]\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp3"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php5",
    "title": "4.订单列表",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>orderlist #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>订单状态码（1-7)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码（从1开始）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页订单数目</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "无数据返回：数据为空：{\"success\":\"true\",\"data\":[]}\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"temp_purchase_id\": \"385\",\n     \"temp_purchase_sn\": \"1508201643160007421282\",\n     \"buyersinfo\": {\n       \"temp_buyers_id\": \"742\",\n       \"nick\": \"\"\n     },\n     \"suppliersinfo\": {\n       \"temp_buyers_id\": \"0\",\n       \"nick\": \"\"\n     },\n     \"time\": \"1440060196\",\n     \"money\": \"42.25\",\n     \"transportation\": \"20.00\",\n     \"method\": \"0\",\n     \"state\": \"1\",\n     \"receive_time\": \"mingtian\",\n     \"comet\": \"nihao\",\n     \"addressinfo\": {\n       \"temp_buyers_address_id\": \"0\",\n       \"name\": \"lisi\",\n       \"address\": \"123\",\n       \"mobile\": \"18621715257\"\n     },\n     \"goods\": [\n       {\n         \"goods_name\": \"100竖向龙骨\",\n         \"goods_unit\": \"米\",\n         \"goods_id\": \"813\",\n         \"amount\": \"3\",\n         \"shop_price\": \"5.35\",\n         \"version\": {\n           \"version_name\": \"QC100*45*0.6\"\n         },\n         \"brand\": {\n           \"brand_name\": \"新雅\"\n         }\n       }\n       }\n     ]\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp5"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php6",
    "title": "5.按钮操作",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>click #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>状态码（买家取消订单0；买家申请退款：5；买家取消退款：2；买家收货：4）</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"订单状态已经修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"抱歉，你的付款方式为货到付款\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp6"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php7",
    "title": "7.收支明细",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>acc #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>0 查看全部，1 查看收入 2查看支出</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页显示几条</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"id\": \"3\",\n     \"time\": \"3\",\n     \"sn\": \"12313\",\n     \"name\": \"邀请红包\",\n     \"money\": \"+500.00\",\n     \"type\": \"0\"\n   },\n   {\n     \"id\": \"2\",\n     \"time\": \"2\",\n     \"sn\": \"0002\",\n     \"name\": \"现金券\",\n     \"money\": \"+100.00\",\n     \"type\": \"0\"\n   },\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp7"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php8",
    "title": "8.账户余额",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>accmoney#提交动作</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "无数据返回：数据为空：{\"success\":\"true\",\"data\":[]}\n{\"success\":\"true\",\"data\":{\"total\":\"账户余额\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp8"
  },
  {
    "type": "post",
    "url": "AskPriceApi/flow.php9",
    "title": "9.申请提现",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>application #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "company",
            "description": "<p>公司信息</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "money",
            "description": "<p>提现金额</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "person",
            "description": "<p>开户名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "alipay",
            "description": "<p>账号</p>"
          }
        ]
      }
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostAskpriceapiFlowPhp9"
  },
  {
    "type": "post",
    "url": "myecshop2/home/order/confirm",
    "title": "1.确认订单",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "goods",
            "description": "<p>商品</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.goods_num",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>收货人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>详细地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>备注</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "transportation",
            "description": "<p>物流费用</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "receive_time",
            "description": "<p>送货时间</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_purchase_id\": \"711\",\n   \"temp_purchase_sn\": \"1509171431590012036234\",\n   \"time\": \"1442471519\",\n   \"money\": \"199.40\",\n   \"transportation\": \"0.00\",\n   \"method\": \"0\",\n   \"state\": \"1\",\n   \"receive_time\": \"ss\",\n   \"description\": \"ss\",\n   \"actually_money\": \"0.00\",\n   \"addressinfo\": {\n     \"name\": \"aa\",\n     \"address\": \"dd\",\n     \"mobile\": \"18621715257\"\n   },\n   \"goods\": [\n     {\n       \"amount\": \"10\",\n       \"description\": \"西门子(远景)双接线柱音响 插座\",\n       \"goods_id\": \"2315\",\n       \"goods_name\": \"西门子(远景)双接线柱音响 插座\",\n       \"shop_price\": \"19.94\",\n       \"goods_unit\": \"个\",\n       \"brand\": {\n         \"brand_name\": \"西门子\"\n       },\n       \"version\": {\n         \"version_name\": \"5TG01171CC1\"\n       },\n       \"cat\": {\n         \"cat_id\": \"92\"\n       }\n     }\n    ]\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostMyecshop2HomeOrderConfirm"
  },
  {
    "type": "post",
    "url": "myecshop2/home/order/detail4",
    "title": "3.订单详情",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（注意： 当订单已经付款时，会返回付款参数：method）\n{\"success\":\"true\",\"data\":[]}（数据为空）\n{\n \"success\": \"true\",\n \"data\": {\n   \"temp_purchase_id\": \"710\",\n   \"temp_purchase_sn\": \"1509171348390012032981\",\n   \"time\": \"1442468919\",\n   \"money\": \"189.50\",\n   \"mobile\": \"18621715257\",\n   \"state\": \"1\",\n   \"method\": \"0\",\n   \"description\": \"ss\",\n   \"receive_time\": \"ss\",\n   \"finish_time\": null,\n   \"transportation\": \"0.00\",\n   \"actually_money\": \"0.00\",\n   \"buyersinfo\": {\n     \"temp_buyers_id\": \"1203\",\n     \"nick\": \"18621715257\"\n   },\n   \"addressinfo\": {\n     \"name\": \"aa\",\n     \"address\": \"dd\",\n     \"mobile\": \"18621715257\"\n   },\n   \"goods\": [\n     {\n       \"amount\": \"10\",\n       \"description\": \"西门子(远景)一位电话插座 RJ11\",\n       \"goods_id\": \"2314\",\n       \"goods_name\": \"西门子(远景)一位电话插座 RJ11\",\n       \"shop_price\": \"18.95\",\n       \"goods_unit\": \"个\",\n       \"brand\": {\n         \"brand_name\": \"西门子\"\n       },\n       \"version\": {\n         \"version_name\": \"5TG01201CC1\"\n       },\n       \"cat\": {\n         \"cat_id\": \"92\"\n       }\n     }\n   ]\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostMyecshop2HomeOrderDetail4"
  },
  {
    "type": "post",
    "url": "myecshop2/home/order/detail4",
    "title": "3.订单详情",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（注意： 当订单已经付款时，会返回付款参数：method）\n{\"success\":\"true\",\"data\":[]}（数据为空）\n{\n \"success\": \"true\",\n \"data\": {\n   \"temp_purchase_id\": \"710\",\n   \"temp_purchase_sn\": \"1509171348390012032981\",\n   \"time\": \"1442468919\",\n   \"money\": \"189.50\",\n   \"mobile\": \"18621715257\",\n   \"state\": \"1\",\n   \"method\": \"0\",\n   \"description\": \"ss\",\n   \"receive_time\": \"ss\",\n   \"finish_time\": null,\n   \"transportation\": \"0.00\",\n   \"actually_money\": \"0.00\",\n   \"buyersinfo\": {\n     \"temp_buyers_id\": \"1203\",\n     \"nick\": \"18621715257\"\n   },\n   \"addressinfo\": {\n     \"name\": \"aa\",\n     \"address\": \"dd\",\n     \"mobile\": \"18621715257\"\n   },\n   \"goods\": [\n     {\n       \"amount\": \"10\",\n       \"description\": \"西门子(远景)一位电话插座 RJ11\",\n       \"goods_id\": \"2314\",\n       \"goods_name\": \"西门子(远景)一位电话插座 RJ11\",\n       \"shop_price\": \"18.95\",\n       \"goods_unit\": \"个\",\n       \"brand\": {\n         \"brand_name\": \"西门子\"\n       },\n       \"version\": {\n         \"version_name\": \"5TG01201CC1\"\n       },\n       \"cat\": {\n         \"cat_id\": \"92\"\n       }\n     }\n   ]\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostMyecshop2HomeOrderDetail4"
  },
  {
    "type": "post",
    "url": "myecshop2/home/order/judge",
    "title": "6.返回最低金额和物流费用",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "price",
            "description": "<p>结算费用</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"price\": \"500\",\n   \"transportation\": \"0\",\n   \"explain\": \"满1000免运费，仅限上海\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostMyecshop2HomeOrderJudge"
  },
  {
    "type": "post",
    "url": "myecshop2/home/order/pay",
    "title": "2.货到付款接口",
    "version": "1.2.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"msg\":\"订单状态更新成功！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"订单状态更新失败！\",\"code\":\"4904\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "Order",
    "name": "PostMyecshop2HomeOrderPay"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/bonus/acc",
    "title": "收支明细(钱包明细)",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>0 查看全部，1 查看收入 2查看支出</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页显示几条</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"id\": \"3\",\n     \"time\": \"3\",\n     \"sn\": \"12313\",\n     \"name\": \"邀请红包\",\n     \"money\": \"+500.00\",\n     \"type\": \"0\"\n   },\n   {\n     \"id\": \"2\",\n     \"time\": \"2\",\n     \"sn\": \"0002\",\n     \"name\": \"现金券\",\n     \"money\": \"+100.00\",\n     \"type\": \"0\"\n   },\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeBonusAcc"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/bonus/acc",
    "title": "收支明细(钱包明细)",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>0 查看全部，1 查看收入 2查看支出</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页显示几条</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"id\": \"3\",\n     \"time\": \"3\",\n     \"sn\": \"12313\",\n     \"name\": \"邀请红包\",\n     \"money\": \"+500.00\",\n     \"type\": \"0\"\n   },\n   {\n     \"id\": \"2\",\n     \"time\": \"2\",\n     \"sn\": \"0002\",\n     \"name\": \"现金券\",\n     \"money\": \"+100.00\",\n     \"type\": \"0\"\n   },\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeBonusAcc"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/cancel",
    "title": "取消代付订单",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"取消成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"取消失败\",\"code\":\"4919\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderCancel"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/cancel",
    "title": "取消代付订单",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"取消成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"取消失败\",\"code\":\"4919\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderCancel"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/click",
    "title": "按钮操作",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>click #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>状态码（买家取消订单0；买家申请退款：5；买家取消退款：2；买家收货：4）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_back",
            "description": "<p>商品是否回购物车（0否, 1是 is_back字段只有取消订单接口需要传）</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"订单状态已经修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"抱歉，你的付款方式为货到付款\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderClick"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/click",
    "title": "按钮操作",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>click #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>状态码（买家取消订单0；买家申请退款：5；买家取消退款：2；买家收货：4）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_back",
            "description": "<p>商品是否回购物车（0否, 1是 is_back字段只有取消订单接口需要传）</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"订单状态已经修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"抱歉，你的付款方式为货到付款\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderClick"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/clickAdd",
    "title": "点击补货 或取消补货 按钮",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>按钮类型 add进行补货 cancel取消补货</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"补货更新失败\",\"code\":\"5001\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"act参数有误\",\"code\":\"4453\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderClickadd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/confirm",
    "title": "确认订单",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "goods",
            "description": "<p>商品</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.shop_car_id",
            "description": "<p>购物车ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.goods_amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.type",
            "defaultValue": "1",
            "description": "<p>type=1辅材，type=2主材</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_address_id",
            "description": "<p>地址ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>备注</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "transportation",
            "description": "<p>物流费用</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "receive_time",
            "description": "<p>送货时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "use_balance",
            "description": "<p>使用余额支付:使用true,不使用false</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "temp_purchase_id",
            "description": "<p>订单id号,补货单需要</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_purchase_id\": \"711\",\n   \"temp_purchase_sn\": \"1509171431590012036234\",\n   \"time\": \"1442471519\",\n   \"money\": \"199.40\",\n   \"transportation\": \"0.00\",\n   \"method\": \"0\",\n   \"state\": \"1\",\n   \"receive_time\": \"ss\",\n   \"description\": \"ss\",\n   \"actually_money\": \"0.00\",\n   \"addressinfo\": {\n     \"name\": \"aa\",\n     \"address\": \"dd\",\n     \"mobile\": \"18621715257\"\n   },\n   \"goods\": [\n     {\n       \"amount\": \"10\",\n       \"description\": \"西门子(远景)双接线柱音响 插座\",\n       \"goods_id\": \"2315\",\n       \"goods_name\": \"西门子(远景)双接线柱音响 插座\",\n       \"shop_price\": \"19.94\",\n       \"goods_unit\": \"个\",\n       \"brand\": {\n         \"brand_name\": \"西门子\"\n       },\n       \"version\": {\n         \"version_name\": \"5TG01171CC1\"\n       },\n       \"cat\": {\n         \"cat_id\": \"92\"\n       }\n     }\n    ]\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderConfirm"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/confirm",
    "title": "确认订单",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "goods",
            "description": "<p>商品</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.shop_car_id",
            "description": "<p>购物车ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.goods_amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods.type",
            "defaultValue": "1",
            "description": "<p>type=1辅材，type=2主材</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_address_id",
            "description": "<p>地址ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>备注</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "transportation",
            "description": "<p>物流费用</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "receive_time",
            "description": "<p>送货时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "use_balance",
            "description": "<p>使用余额支付:使用true,不使用false</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_purchase_id\": \"711\",\n   \"temp_purchase_sn\": \"1509171431590012036234\",\n   \"time\": \"1442471519\",\n   \"money\": \"199.40\",\n   \"transportation\": \"0.00\",\n   \"method\": \"0\",\n   \"state\": \"1\",\n   \"receive_time\": \"ss\",\n   \"description\": \"ss\",\n   \"actually_money\": \"0.00\",\n   \"addressinfo\": {\n     \"name\": \"aa\",\n     \"address\": \"dd\",\n     \"mobile\": \"18621715257\"\n   },\n   \"goods\": [\n     {\n       \"amount\": \"10\",\n       \"description\": \"西门子(远景)双接线柱音响 插座\",\n       \"goods_id\": \"2315\",\n       \"goods_name\": \"西门子(远景)双接线柱音响 插座\",\n       \"shop_price\": \"19.94\",\n       \"goods_unit\": \"个\",\n       \"brand\": {\n         \"brand_name\": \"西门子\"\n       },\n       \"version\": {\n         \"version_name\": \"5TG01171CC1\"\n       },\n       \"cat\": {\n         \"cat_id\": \"92\"\n       }\n     }\n    ]\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderConfirm"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/detail",
    "title": "订单详情",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（注意： 当订单已经付款时，会返回付款参数：method）\n{\"success\":\"true\",\"data\":[]}（数据为空）\n is_add  0不能补货 1可以补货 2补货进行中\n{\n \"success\": \"true\",\n \"data\": {\n   \"temp_purchase_id\": \"710\",\n   \"temp_purchase_sn\": \"1509171348390012032981\",\n   \"time\": \"1442468919\",\n   \"money\": \"189.50\",\n   \"mobile\": \"18621715257\",\n   \"state\": \"1\",\n   \"method\": \"0\",\n   \"description\": \"ss\",\n   \"receive_time\": \"ss\",\n   \"finish_time\": null,\n   \"transportation\": \"0.00\",\n   \"actually_money\": \"0.00\",\n   \"replenish_state\": \"0\",\n   \"is_add\": \"0\",\n   \"buyersinfo\": {\n     \"temp_buyers_id\": \"254\",\n     \"mobile\": \"13323814501\",\n     \"nick\": \"河南市政总局\"\n   },\n   \"payer_id\": \"3473\",\n   \"payuserinfo\": {\t \n       \"temp_buyers_id\": \"3473\",      \t\n       \"mobile\": \"18621715257\",\n     \t \"nick\": \"18621715257\"\n   },\n   \"addressinfo\": {\n     \"id\": \"1245\",\n     \"name\": \"aa\",\n     \"address\": \"dd\",\n     \"mobile\": \"18621715257\"\n   },\n    \"goods\": [\n       {\n         \"goods_name\": \"金牛暗阀\",\n         \"goods_unit\": \"个\",\n         \"area_id\": \"2\",\n         \"goods_color\": \"灰\",\n         \"goods_id\": \"9428\",\n         \"amount\": \"100\",\n         \"shop_price\": \"60.00\",\n         \"color\": {\n           \"color_name\": \"灰\"\n         },\n         \"version\": {\n           \"version_name\": \"20 灰\"\n         },\n         \"brand\": {\n           \"brand_name\": \"管件\"\n         },\n         \"type\": \"1\"\n       }\n     ]\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderDetail"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/detail",
    "title": "订单详情",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "（注意： 当订单已经付款时，会返回付款参数：method）\n{\"success\":\"true\",\"data\":[]}（数据为空）\n{\n \"success\": \"true\",\n \"data\": {\n   \"temp_purchase_id\": \"710\",\n   \"temp_purchase_sn\": \"1509171348390012032981\",\n   \"time\": \"1442468919\",\n   \"money\": \"189.50\",\n   \"mobile\": \"18621715257\",\n   \"state\": \"1\",\n   \"method\": \"0\",\n   \"description\": \"ss\",\n   \"receive_time\": \"ss\",\n   \"finish_time\": null,\n   \"transportation\": \"0.00\",\n   \"actually_money\": \"0.00\",\n   \"buyersinfo\": {\n     \"temp_buyers_id\": \"254\",\n     \"mobile\": \"13323814501\",\n     \"nick\": \"河南市政总局\"\n   },\n   \"payer_id\": \"3473\",\n   \"payuserinfo\": {\t \n       \"temp_buyers_id\": \"3473\",      \t\n       \"mobile\": \"18621715257\",\n     \t \"nick\": \"18621715257\"\n   },\n   \"addressinfo\": {\n     \"id\": \"1245\",\n     \"name\": \"aa\",\n     \"address\": \"dd\",\n     \"mobile\": \"18621715257\"\n   },\n    \"goods\": [\n       {\n         \"goods_name\": \"金牛暗阀\",\n         \"goods_unit\": \"个\",\n         \"area_id\": \"2\",\n         \"goods_color\": \"灰\",\n         \"goods_id\": \"9428\",\n         \"amount\": \"100\",\n         \"shop_price\": \"60.00\",\n         \"color\": {\n           \"color_name\": \"灰\"\n         },\n         \"version\": {\n           \"version_name\": \"20 灰\"\n         },\n         \"brand\": {\n           \"brand_name\": \"管件\"\n         },\n         \"type\": \"1\"\n       }\n     ]\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderDetail"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/judge2",
    "title": "去结算接口",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>商品类型</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "goods_arr",
            "description": "<p>商品</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.amount",
            "description": "<p>商品数量</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"price\": \"288\",\n  \"receive_time\": \"当天下单第二天到货\",\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "如果有补货订单，data 将返回要补货订单的详细信息（数据可以参考订单详情）\n{\"success\":\"false\",\"error\":{\"msg\":\"辅材总价不能少于288.00\",\"code\":\"4809\",\"data\":null}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderJudge2"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/judge2",
    "title": "去结算接口",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>商品类型</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "goods_arr",
            "description": "<p>商品</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.amount",
            "description": "<p>商品数量</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"price\": \"288\",\n  \"receive_time\": \"当天下单第二天到货\",\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"辅材总价不能少于288\",\"code\":\"4808\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderJudge2"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/orderList",
    "title": "订单列表",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>orderlist #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>订单状态码（1-7)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码（从1开始）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页订单数目</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "无数据返回：数据为空：{\"success\":\"true\",\"data\":[]}\npay_id默认是-1 如果找人代付款pay_id将会更新成代付款的user_id\n\n  is_add  0不能补货 1可以补货 2补货进行中\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"temp_purchase_id\": \"385\",\n     \"temp_purchase_sn\": \"1508201643160007421282\",\n     \"buyersinfo\": {\n       \"temp_buyers_id\": \"742\",\n       \"nick\": \"\"\n     },\n     \"suppliersinfo\": {\n       \"temp_buyers_id\": \"0\",\n       \"nick\": \"\"\n     },\n     \"time\": \"1440060196\",\n     \"money\": \"42.25\",\n     \"transportation\": \"20.00\",\n     \"method\": \"0\",\n     \"state\": \"1\",\n     \"receive_time\": \"mingtian\",\n     \"is_comment\": \"0\";\n     \"comet\": \"nihao\",\n     \"description\": \"\",\n     \"is_add\": \"0\",\n     \"replenish_state\": \"1\",\n     \"payuserinfo\": {\n       \"temp_buyers_id\": \"3473\",\n       \"temp_buyers_mobile\": \"18621715257\",\n       \"nick\": \"18621715257\"\n     },\n     \"addressinfo\": {\n       \"temp_buyers_address_id\": \"0\",\n       \"name\": \"lisi\",\n       \"address\": \"123\",\n       \"mobile\": \"18621715257\"\n     },\n     \"goods\": [\n     {\n       \"amount\": \"3\",\n       \"goods_unit\": \"箱\",\n       \"shop_price\": \"123.00\",\n       \"description\": \"95M每箱，申江牌的\",\n       \"goods_name\": \"\",\n       \"goods_id\": \"1910\",\n       \"area_id\": \"1\",\n       \"goods_color\": \"白色\",\n       \"color\": {\n         \"color_name\": \"白色\"\n       },\n       \"brand\": {\n         \"brand_name\": \"\"\n       },\n       \"version\": {\n         \"version_name\": \"多芯铜线电线 白色\"\n       },\n       \"cat\": {\n         \"cat_id\": \"1\"\n       },\n       \"type\": \"1\"\n     }\n   ]\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderOrderlist"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/orderList",
    "title": "订单列表",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>orderlist #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>订单状态码（1-7)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码（从1开始）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页订单数目</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "无数据返回：数据为空：{\"success\":\"true\",\"data\":[]}\npay_id默认是-1 如果找人代付款pay_id将会更新成代付款的user_id\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"temp_purchase_id\": \"385\",\n     \"temp_purchase_sn\": \"1508201643160007421282\",\n     \"buyersinfo\": {\n       \"temp_buyers_id\": \"742\",\n       \"nick\": \"\"\n     },\n     \"suppliersinfo\": {\n       \"temp_buyers_id\": \"0\",\n       \"nick\": \"\"\n     },\n     \"time\": \"1440060196\",\n     \"money\": \"42.25\",\n     \"transportation\": \"20.00\",\n     \"method\": \"0\",\n     \"state\": \"1\",\n     \"receive_time\": \"mingtian\",\n     \"is_comment\": \"0\";\n     \"comet\": \"nihao\",\n     \"payuserinfo\": {\n       \"temp_buyers_id\": \"3473\",\n       \"temp_buyers_mobile\": \"18621715257\",\n       \"nick\": \"18621715257\"\n     },\n     \"addressinfo\": {\n       \"temp_buyers_address_id\": \"0\",\n       \"name\": \"lisi\",\n       \"address\": \"123\",\n       \"mobile\": \"18621715257\"\n     },\n     \"goods\": [\n     {\n       \"amount\": \"3\",\n       \"goods_unit\": \"箱\",\n       \"shop_price\": \"123.00\",\n       \"description\": \"95M每箱，申江牌的\",\n       \"goods_name\": \"\",\n       \"goods_id\": \"1910\",\n       \"area_id\": \"1\",\n       \"goods_color\": \"白色\",\n       \"color\": {\n         \"color_name\": \"白色\"\n       },\n       \"brand\": {\n         \"brand_name\": \"\"\n       },\n       \"version\": {\n         \"version_name\": \"多芯铜线电线 白色\"\n       },\n       \"cat\": {\n         \"cat_id\": \"1\"\n       },\n       \"type\": \"1\"\n     }\n   ]\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderOrderlist"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/pay",
    "title": "货到付款接口",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"msg\":\"订单状态更新成功！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"订单状态更新失败！\",\"code\":\"4904\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderPay"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/pay",
    "title": "货到付款接口",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"msg\":\"订单状态更新成功！\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你还没有登录\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"订单状态更新失败！\",\"code\":\"4904\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderPay"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/payFor",
    "title": "找好友代付款",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>代付人手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"请求成功,等待好友付款\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你好友得先注册成会员,才能进行代付款\",\"code\":\"4153\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码不规范\",\"code\":\"4108\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"请求好友代付款失败\",\"code\":\"4915\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"你已经申请了代付款请求\",\"code\":\"4156\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"订单必须是待付款状态\",\"code\":\"4157\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderPayfor"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/payFor",
    "title": "找人待付款",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"请求成功,等待好友付款\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你好友得先注册成会员,才能进行代付款\",\"code\":\"4128\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderPayfor"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/payFor",
    "title": "找人待付款",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"请求成功,等待好友付款\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你好友得先注册成会员,才能进行代付款\",\"code\":\"4128\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderPayfor"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/payFor",
    "title": "找好友代付款",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>代付人手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"请求成功,等待好友付款\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"你好友得先注册成会员,才能进行代付款\",\"code\":\"4153\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码不规范\",\"code\":\"4108\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"请求好友代付款失败\",\"code\":\"4915\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"你已经申请了代付款请求\",\"code\":\"4156\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"订单必须是待付款状态\",\"code\":\"4157\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderPayfor"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/remind",
    "title": "买家提醒卖家发货",
    "version": "3.1.1",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>remind #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"提醒卖家发货成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"提醒卖家发货失败\",\"code\":\"4128\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderRemind"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/order/remind",
    "title": "买家提醒卖家发货",
    "version": "3.1.0",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>remind #提交动作</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"提醒卖家发货成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"提醒卖家发货失败\",\"code\":\"4128\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "Order",
    "name": "PostV31Myecshop2HomeOrderRemind"
  },
  {
    "type": "post",
    "url": "AskPriceApi/AddCollection.php",
    "title": "8.添加收藏",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "to_id",
            "description": "<p>被收藏用户ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"收藏好友成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"自己不能收藏自己\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"已经收藏过此好友\",\"code\":\"4140\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"无此用户\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"收藏好友失败\",\"code\":\"4139\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"to_id必须存在\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiAddcollectionPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/AddCollection.php",
    "title": "8.添加收藏",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "to_id",
            "description": "<p>被收藏用户ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"收藏好友成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"自己不能收藏自己\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"已经收藏过此好友\",\"code\":\"4140\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"无此用户\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"收藏好友失败\",\"code\":\"4139\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"to_id必须存在\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiAddcollectionPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/CollectionList.php",
    "title": "9.我的收藏列表",
    "version": "1.2.0",
    "group": "User",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "无数据返回：数据为空：{\"success\":\"true\",\"data\":[]}\n{\n   \"success\": \"true\",\n   \"data\": [\n       {\n           \"to_id\": \"2\",\n           \"temp_buyers_mobile\": \"13262936502\",\n           \"nick\": \"busfhf\",\n           \"photo\": \"http://192.168.1.61/ecshop2/Guest/upload/photo/13262936502/13262936502head.jpg\",\n           \"info\": \"Hi符\"\n       },\n       {\n           \"to_id\": \"3\",\n           \"temp_buyers_mobile\": \"18721559023\",\n           \"nick\": \"Coffee\",\n           \"photo\": \"http://192.168.1.61/ecshop2/Guest/\",\n           \"info\": \"\"\n       }\n     ]\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiCollectionlistPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/forgetpassword.php",
    "title": "4.忘记密码",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>旧密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"密码修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码长度至少为6位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码修改失败\",\"code\":\"4117\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiForgetpasswordPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/GetCheckCode.php",
    "title": "1.获取验证码",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码1</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>1或者2(1获取注册验证码,2获取忘记密码验证码)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"时间间隔太小，请1分钟后再申请\",\"code\":\"4103\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"短信今天已经发了6次，请明天再申请\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"数据来源有误！请从本站提交！\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"检验验证码失败\",\"code\":\"4900\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"验证码发送失败\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiGetcheckcodePhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/invitation.php",
    "title": "2.验证邀请码",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "invitation",
            "description": "<p>邀请 码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"邀请码长度必须是8位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码不存在！\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码首位不能为0\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码不能为空！\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码不规范\",\"code\":\"4801\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4801\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiInvitationPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/login.php",
    "title": "5.登录",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>login</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "\n{\n \"success\": \"true\",\n \"data\": {\n   \"vip\": \"0\",\n   \"temp_buyers_id\": \"1198\",\n   \"temp_buyers_mobile\": \"18621715257\",\n   \"nick\": \"18621715257\",\n   \"photo\": \"http://192.168.1.194/ecshop2/Guest/\",\n   \"info\": \"\",\n   \"invitation\": \"10001198\",\n   \"city\": {\n     \"id\": \"0\",\n     \"name\": \"局域网\"\n   }\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户名密码不匹配!\",\"code\":\"4118\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiLoginPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/logout.php",
    "title": "7.用户退出",
    "version": "1.2.0",
    "group": "User",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"退出成功\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiLogoutPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/reg.php",
    "title": "3.注册",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "invitation",
            "description": "<p>邀请码</p>"
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
            "field": "temp_buyers_mobile",
            "description": "<p>手机号码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_buyers_id\": \"1203\",\n   \"temp_buyers_mobile\": \"18621715257\",\n   \"nick\": \"18621715257\",\n   \"photo\": \"\",\n   \"info\": \"\",\n   \"vip\": \"0\",\n   \"area_id\": \"1\",\n   \"invitation\": \"44001203\",\n   \"city\": {\n     \"id\": \"局域网\",\n     \"name\": \"0\"\n   }\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "\n{\"success\":\"false\",\"error\":{\"msg\":\"用户注册失败\",\"code\":\"4113\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码长度至少为6位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiRegPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/reg.php",
    "title": "3.注册",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "invitation",
            "description": "<p>邀请码</p>"
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
            "field": "temp_buyers_mobile",
            "description": "<p>手机号码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_buyers_id\": \"1203\",\n   \"temp_buyers_mobile\": \"18621715257\",\n   \"nick\": \"18621715257\",\n   \"photo\": \"\",\n   \"info\": \"\",\n   \"vip\": \"0\",\n   \"area_id\": \"1\",\n   \"invitation\": \"44001203\",\n   \"city\": {\n     \"id\": \"局域网\",\n     \"name\": \"0\"\n   }\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "\n{\"success\":\"false\",\"error\":{\"msg\":\"用户注册失败\",\"code\":\"4113\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码长度至少为6位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiRegPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/UpdatePassword.php",
    "title": "6.修改密码",
    "version": "1.2.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>旧密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>新密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"密码修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"原密码错误\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码修改失败\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"new_password不能少于6位\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"原密码不能和新密码一样\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "User",
    "name": "PostAskpriceapiUpdatepasswordPhp"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/checkCode",
    "title": "校验验证码",
    "version": "3.1.1",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
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
            "description": "<p>1或者2(1获取注册验证码,2获取忘记密码验证码)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码校验通过\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexCheckcode"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/checkCode",
    "title": "校验验证码",
    "version": "3.1.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
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
            "description": "<p>1或者2(1获取注册验证码,2获取忘记密码验证码)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码校验通过\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexCheckcode"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/forgetPassword",
    "title": "忘记密码",
    "version": "3.1.1",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>旧密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"密码修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码长度至少为6位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码修改失败\",\"code\":\"4117\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexForgetpassword"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/forgetPassword",
    "title": "忘记密码",
    "version": "3.1.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>旧密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"密码修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码长度至少为6位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码修改失败\",\"code\":\"4117\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexForgetpassword"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/getCheckCode",
    "title": "获取验证码",
    "version": "3.1.1",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码1</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>1或者2(1获取注册验证码,2获取忘记密码验证码)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"时间间隔太小，请1分钟后再申请\",\"code\":\"4103\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"短信今天已经发了6次，请明天再申请\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"数据来源有误！请从本站提交！\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"检验验证码失败\",\"code\":\"4900\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"验证码发送失败\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexGetcheckcode"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/getCheckCode",
    "title": "获取验证码",
    "version": "3.1.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码1</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>1或者2(1获取注册验证码,2获取忘记密码验证码)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"时间间隔太小，请1分钟后再申请\",\"code\":\"4103\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"短信今天已经发了6次，请明天再申请\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"数据来源有误！请从本站提交！\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"检验验证码失败\",\"code\":\"4900\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"验证码发送失败\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexGetcheckcode"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/invitation",
    "title": "开始注册",
    "version": "3.1.1",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "invitation",
            "description": "<p>邀请码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"邀请码长度必须是8位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码不存在！\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码首位不能为0\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码不能为空！\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码不规范\",\"code\":\"4801\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4801\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexInvitation"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/invitation",
    "title": "开始注册",
    "version": "3.1.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "invitation",
            "description": "<p>邀请码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"邀请码长度必须是8位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码不存在！\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码首位不能为0\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"邀请码不能为空！\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码不规范\",\"code\":\"4801\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4801\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexInvitation"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/login",
    "title": "登录",
    "version": "3.1.1",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>login</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "company_id>0 表示是企业用户\n\n{\n \"success\": \"true\",\n \"data\": {\n   \"vip\": \"0\",\n   \"temp_buyers_id\": \"1198\",\n   \"temp_buyers_mobile\": \"18621715257\",\n   \"nick\": \"18621715257\",\n   \"photo\": \"http://192.168.1.194/ecshop2/Guest/\",\n   \"info\": \"\",\n   \"invitation\": \"10001198\",\n\t \"company_id\"\t\"0\",\n\t\"token\": \"Bz9cPAY0UDhabgJoUB1QZVpmADcANFNLXWpSPQBlAWMBPAZqBTkCZFBgBGw=\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户名密码不匹配!\",\"code\":\"4118\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexLogin"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/login",
    "title": "登录",
    "version": "3.1.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "act",
            "description": "<p>login</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "company_id>0 表示是企业用户\n\n{\n \"success\": \"true\",\n \"data\": {\n   \"vip\": \"0\",\n   \"temp_buyers_id\": \"1198\",\n   \"temp_buyers_mobile\": \"18621715257\",\n   \"nick\": \"18621715257\",\n   \"photo\": \"http://192.168.1.194/ecshop2/Guest/\",\n   \"info\": \"\",\n   \"invitation\": \"10001198\",\n\t \"company_id\"\t\"0\",\n\t\"token\": \"Bz9cPAY0UDhabgJoUB1QZVpmADcANFNLXWpSPQBlAWMBPAZqBTkCZFBgBGw=\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户名密码不匹配!\",\"code\":\"4118\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexLogin"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/logout",
    "title": "用户退出",
    "version": "3.1.1",
    "group": "User",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"退出成功\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexLogout"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/logout",
    "title": "用户退出",
    "version": "3.1.0",
    "group": "User",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"退出成功\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexLogout"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/reg",
    "title": "注册结束",
    "version": "3.1.1",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "invitation",
            "description": "<p>邀请码</p>"
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
            "field": "temp_buyers_mobile",
            "description": "<p>手机号码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_buyers_id\": \"1203\",\n   \"temp_buyers_mobile\": \"18621715257\",\n   \"nick\": \"18621715257\",\n   \"photo\": \"\",\n   \"info\": \"\",\n   \"vip\": \"0\",\n   \"area_id\": \"1\",\n   \"invitation\": \"44001203\",\n   \"city\": {\n     \"id\": \"局域网\",\n     \"name\": \"0\"\n   }\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "\n{\"success\":\"false\",\"error\":{\"msg\":\"用户注册失败\",\"code\":\"4113\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码长度至少为6位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexReg"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/index/reg",
    "title": "注册结束",
    "version": "3.1.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "invitation",
            "description": "<p>邀请码</p>"
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
            "field": "temp_buyers_mobile",
            "description": "<p>手机号码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"temp_buyers_id\": \"1203\",\n   \"temp_buyers_mobile\": \"18621715257\",\n   \"nick\": \"18621715257\",\n   \"photo\": \"\",\n   \"info\": \"\",\n   \"vip\": \"0\",\n   \"area_id\": \"1\",\n   \"invitation\": \"44001203\",\n   \"city\": {\n     \"id\": \"局域网\",\n     \"name\": \"0\"\n   }\n }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "\n{\"success\":\"false\",\"error\":{\"msg\":\"用户注册失败\",\"code\":\"4113\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码长度至少为6位\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码不能为空\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserIndexReg"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/modify",
    "title": "修改密码",
    "version": "3.1.1",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>旧密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>新密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"密码修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"原密码错误\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码修改失败\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"new_password不能少于6位\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"原密码不能和新密码一样\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserInfoModify"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/modify",
    "title": "修改密码",
    "version": "3.1.0",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>旧密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>新密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"密码修改成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"原密码错误\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"密码修改失败\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"new_password不能少于6位\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"原密码不能和新密码一样\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "User",
    "name": "PostV31Myecshop2UserInfoModify"
  },
  {
    "type": "post",
    "url": "AskPriceApi/addaddress.php",
    "title": "1.添加地址",
    "version": "1.2.0",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "defaultaddress",
            "defaultValue": "1",
            "description": "<p>1已选,0没有选</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n   \"success\":\"true\",\n   \"data\":\n       {\n       \"temp_buyers_address_id\":\"3\",\n       \"name\":\"zhangsan\",\n       \"address\":\"11111\",\n       \"mobile\":\"15021680669\",\n       \"defaultaddress\":\"1\",\n       \"temp_buyers_id\":\"1\"\n       }\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"用户名不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"地址不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"添加地址最多只能添加10个\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "address",
    "name": "PostAskpriceapiAddaddressPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/addresslist.php",
    "title": "3.地址列表地址信息详情",
    "version": "1.2.0",
    "group": "address",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "数据为空：{\"success\":\"true\",\"data\":[]}\n 不为空：{\n \"success\":\"true\",\n \"data\":\n [\n      {\n          \"temp_buyers_address_id\":\"3\",\n          \"name\":\"zhangsan\",\n          \"defaultaddress\":1,\n          \"address\":\"shanghai\",\n          \"mobile\":\"15021680669\"\n         }\n        ]\n     }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "address",
    "name": "PostAskpriceapiAddresslistPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/defaultaddress.php",
    "title": "2.默认地址",
    "version": "1.2.0",
    "group": "address",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"success\":\"true\",\n\"data\":\n   [\n       {\n       \"temp_buyers_address_id\":\"3\",\n       \"name\":\"zhangsan\",\n       \"defaultaddress\":1,\n       \"address\":\"shanghai\",\n       \"mobile\":\"15021680669\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "address",
    "name": "PostAskpriceapiDefaultaddressPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/deladdress.php",
    "title": "4.删除地址",
    "version": "1.2.0",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_address_id",
            "description": "<p>地址ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"删除地址成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"删除地址失败\",\"code\":\"4112\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "address",
    "name": "PostAskpriceapiDeladdressPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/upaddress.php",
    "title": "5.编辑地址",
    "version": "1.2.0",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_id",
            "description": "<p>地址ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "defaultaddress",
            "defaultValue": "1",
            "description": "<p>1默认，0没有选</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"success\":\"true\",\n   \"data\":\n       {\n       \"name\":\"zhangsan\",\n       \"address\":\"11111\",\n       \"mobile\":\"15021680669\",\n       \"defaultaddress\":\"1\",\n       \"temp_buyers_id\":\"1\"\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"编辑地址失败\",\"code\":\"4111\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户名不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"地址不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码格式不正确\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "address",
    "name": "PostAskpriceapiUpaddressPhp"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/addAddress",
    "title": "添加地址",
    "version": "3.1.1",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "defaultaddress",
            "defaultValue": "1",
            "description": "<p>1已选,0没有选</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "province",
            "description": "<p>省</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>城市名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "district",
            "description": "<p>地区</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>三级分类(县或区)对应的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n   \"success\":\"true\",\n   \"data\":\n       {\n       \"temp_buyers_address_id\":\"3\",\n       \"name\":\"zhangsan\",\n       \"address\":\"11111\",\n       \"province\": \"上海市\",\n       \"city\": \"上海市\",\n       \"district\": \"徐汇区\"\n       \"region_id\": \"1202\",\n       \"mobile\":\"15021680669\",\n       \"defaultaddress\":\"1\",\n       \"temp_buyers_id\":\"1\"\n       }\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"用户名不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"地址不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"添加地址最多只能添加10个\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoAddaddress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/addAddress",
    "title": "添加地址",
    "version": "3.1.0",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "defaultaddress",
            "defaultValue": "1",
            "description": "<p>1已选,0没有选</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "province",
            "description": "<p>省</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>城市名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "district",
            "description": "<p>地区</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>三级分类(县或区)对应的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n   \"success\":\"true\",\n   \"data\":\n       {\n       \"temp_buyers_address_id\":\"3\",\n       \"name\":\"zhangsan\",\n       \"address\":\"11111\",\n       \"province\": \"上海市\",\n       \"city\": \"上海市\",\n       \"district\": \"徐汇区\"\n       \"region_id\": \"1202\",\n       \"mobile\":\"15021680669\",\n       \"defaultaddress\":\"1\",\n       \"temp_buyers_id\":\"1\"\n       }\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"用户名不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"地址不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"添加地址最多只能添加10个\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoAddaddress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/addressList",
    "title": "地址列表",
    "version": "3.1.1",
    "group": "address",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "数据为空：{\"success\":\"true\",\"data\":[]}\n 不为空：{\n \"success\":\"true\",\n \"data\":\n [\n      {\n          \"temp_buyers_address_id\":\"3\",\n          \"name\":\"zhangsan\",\n          \"defaultaddress\":1,\n          \"address\":\"shanghai\",\n          \"mobile\":\"15021680669\"\n          \"province\": \"上海市\",\n          \"city\": \"上海市\",\n          \"district\": \"普陀区\",\n          \"region_id\": \"1202\"\n         }\n        ]\n     }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoAddresslist"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/addressList",
    "title": "地址列表",
    "version": "3.1.0",
    "group": "address",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "数据为空：{\"success\":\"true\",\"data\":[]}\n 不为空：{\n \"success\":\"true\",\n \"data\":\n [\n      {\n          \"temp_buyers_address_id\":\"3\",\n          \"name\":\"zhangsan\",\n          \"defaultaddress\":1,\n          \"address\":\"shanghai\",\n          \"mobile\":\"15021680669\"\n          \"province\": \"上海市\",\n          \"city\": \"上海市\",\n          \"district\": \"普陀区\",\n          \"region_id\": \"1202\"\n         }\n        ]\n     }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoAddresslist"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/defaultAddress",
    "title": "默认地址",
    "version": "3.1.1",
    "group": "address",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"success\":\"true\",\n\"data\":\n   [\n       {\n       \"temp_buyers_address_id\":\"3\",\n       \"name\":\"zhangsan\",\n       \"defaultaddress\":1,\n       \"address\":\"shanghai\",\n       \"mobile\":\"15021680669\"\n       \"city\": \"上海市\",\n       \"district\": \"徐汇区\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoDefaultaddress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/defaultAddress",
    "title": "默认地址",
    "version": "3.1.0",
    "group": "address",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"success\":\"true\",\n\"data\":\n   [\n       {\n       \"temp_buyers_address_id\":\"3\",\n       \"name\":\"zhangsan\",\n       \"defaultaddress\":1,\n       \"address\":\"shanghai\",\n       \"mobile\":\"15021680669\"\n       \"city\": \"上海市\",\n       \"district\": \"徐汇区\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoDefaultaddress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/delAddress",
    "title": "删除地址",
    "version": "3.1.1",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_address_id",
            "description": "<p>地址ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"删除地址成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"删除地址失败\",\"code\":\"4112\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoDeladdress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/delAddress",
    "title": "删除地址",
    "version": "3.1.0",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_address_id",
            "description": "<p>地址ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"删除地址成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"删除地址失败\",\"code\":\"4112\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoDeladdress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/updateAddress",
    "title": "编辑地址",
    "version": "3.1.1",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_id",
            "description": "<p>地址ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "province",
            "description": "<p>省</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>城市名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "district",
            "description": "<p>地区</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>三级分类(县/区)对应的id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "defaultaddress",
            "defaultValue": "1",
            "description": "<p>1默认，0没有选</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"success\": \"true\",\n  \"data\": {\n    \"temp_buyers_address_id\": \"2849\",\n    \"mobile\": \"17701804871\",\n    \"address\": \"fasdfa2454\",\n    \"name\": \"asdfasd\",\n    \"province\": \"上海市\",\n    \"city\": \"上海市\",\n    \"district\": \"普陀区\",\n    \"region_id\": \"1202\",\n    \"defaultaddress\": \"1\",\n    \"temp_buyers_id\": \"5235\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"编辑地址失败\",\"code\":\"4111\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户名不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"地址不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码格式不正确\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoUpdateaddress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/updateAddress",
    "title": "编辑地址",
    "version": "3.1.0",
    "group": "address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_id",
            "description": "<p>地址ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "province",
            "description": "<p>省</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>城市名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "district",
            "description": "<p>地区</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>三级分类(县/区)对应的id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "defaultaddress",
            "defaultValue": "1",
            "description": "<p>1默认，0没有选</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"success\": \"true\",\n  \"data\": {\n    \"temp_buyers_address_id\": \"2849\",\n    \"mobile\": \"17701804871\",\n    \"address\": \"fasdfa2454\",\n    \"name\": \"asdfasd\",\n    \"province\": \"上海市\",\n    \"city\": \"上海市\",\n    \"district\": \"普陀区\",\n    \"region_id\": \"1202\",\n    \"defaultaddress\": \"1\",\n    \"temp_buyers_id\": \"5235\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"编辑地址失败\",\"code\":\"4111\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户名不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"地址不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码格式不正确\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "address",
    "name": "PostV31Myecshop2UserInfoUpdateaddress"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/add",
    "title": "添加银行卡快捷支付",
    "version": "3.1.1",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bank_no",
            "description": "<p>银行卡号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"bank_name\": \"中国银行\",\n  \"bank_type\": \"0\",\n  \"bank_code\": \"621785\",\n  \"bank_no\": \"6217850800013783038\",\n  \"temp_buyers_id\": \"1769\",\n  \"card_type\": \"借记卡\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"该卡号信息暂未录入\",\"code\":\"4145\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankAdd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/add",
    "title": "添加银行卡快捷支付",
    "version": "3.1.0",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bank_no",
            "description": "<p>银行卡号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"bank_name\": \"中国银行\",\n  \"bank_type\": \"0\",\n  \"bank_code\": \"621785\",\n  \"bank_no\": \"6217850800013783038\",\n  \"temp_buyers_id\": \"1769\",\n  \"card_type\": \"借记卡\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"该卡号信息暂未录入\",\"code\":\"4145\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankAdd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/confirm",
    "title": "确认支付",
    "version": "3.1.1",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "cache",
            "description": "<p>h5需要传这个参数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"支付成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"手机验证码有误[输入的验证码有误]\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankConfirm"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/confirm",
    "title": "确认支付",
    "version": "3.1.0",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "cache",
            "description": "<p>h5需要传这个参数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"支付成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"手机验证码有误[输入的验证码有误]\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankConfirm"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/create",
    "title": "创建支付订单",
    "version": "3.1.1",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "save_code",
            "description": "<p>安全码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "valid_time",
            "description": "<p>有效时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_bankcard_id",
            "description": "<p>银行列表id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n \"success\": \"true\",\n \"data\": \"1\",\n \"cache\": \"AFxXUwZNA2FQZgVrBzwGMA00WmtQZAVtUWdVPgFhB2MAOAFlCDwDY1NhAh0NNgUxDDZUYV9vAG5UagJuAWJUNgA7VzAGNwNkUGEFbAdKBjgNPVppUG4FaVFgVWgBNAd/AG4BMQg6A2VTeAJpDWEFZwwzVHlfYABuVGYCbwF8VDQAaldiBjYDN1AzBRoHOAYwDTRabFBnBWxRZlU6AWAHYQA8AWYIPwNl\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"该订单已完成\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankCreate"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/create",
    "title": "创建支付订单",
    "version": "3.1.1",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "save_code",
            "description": "<p>安全码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "valid_time",
            "description": "<p>有效时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_bankcard_id",
            "description": "<p>银行列表id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n \"success\": \"true\",\n \"data\": \"1\",\n \"cache\": \"AFxXUwZNA2FQZgVrBzwGMA00WmtQZAVtUWdVPgFhB2MAOAFlCDwDY1NhAh0NNgUxDDZUYV9vAG5UagJuAWJUNgA7VzAGNwNkUGEFbAdKBjgNPVppUG4FaVFgVWgBNAd/AG4BMQg6A2VTeAJpDWEFZwwzVHlfYABuVGYCbwF8VDQAaldiBjYDN1AzBRoHOAYwDTRabFBnBWxRZlU6AWAHYQA8AWYIPwNl\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"该订单已完成\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankCreate"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/create",
    "title": "创建支付订单",
    "version": "3.1.0",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "save_code",
            "description": "<p>安全码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "valid_time",
            "description": "<p>有效时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_bankcard_id",
            "description": "<p>银行列表id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n \"success\": \"true\",\n \"data\": \"1\",\n \"cache\": \"AFxXUwZNA2FQZgVrBzwGMA00WmtQZAVtUWdVPgFhB2MAOAFlCDwDY1NhAh0NNgUxDDZUYV9vAG5UagJuAWJUNgA7VzAGNwNkUGEFbAdKBjgNPVppUG4FaVFgVWgBNAd/AG4BMQg6A2VTeAJpDWEFZwwzVHlfYABuVGYCbwF8VDQAaldiBjYDN1AzBRoHOAYwDTRabFBnBWxRZlU6AWAHYQA8AWYIPwNl\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"该订单已完成\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankCreate"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/create",
    "title": "创建支付订单",
    "version": "3.1.0",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "save_code",
            "description": "<p>安全码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "valid_time",
            "description": "<p>有效时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_bankcard_id",
            "description": "<p>银行列表id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n \"success\": \"true\",\n \"data\": \"1\",\n \"cache\": \"AFxXUwZNA2FQZgVrBzwGMA00WmtQZAVtUWdVPgFhB2MAOAFlCDwDY1NhAh0NNgUxDDZUYV9vAG5UagJuAWJUNgA7VzAGNwNkUGEFbAdKBjgNPVppUG4FaVFgVWgBNAd/AG4BMQg6A2VTeAJpDWEFZwwzVHlfYABuVGYCbwF8VDQAaldiBjYDN1AzBRoHOAYwDTRabFBnBWxRZlU6AWAHYQA8AWYIPwNl\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"该订单已完成\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankCreate"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/delete",
    "title": "删除银行卡",
    "version": "3.1.1",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_bankcard_id",
            "description": "<p>表记录id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"删除成功\"}\n{\"success\":\"true\",\"data\":\"解绑签约成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"删除失败\",\"code\":\"4911\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"解除签约失败\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankDelete"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/delete",
    "title": "删除银行卡",
    "version": "3.1.0",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_bankcard_id",
            "description": "<p>表记录id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"删除成功\"}\n{\"success\":\"true\",\"data\":\"解绑签约成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"删除失败\",\"code\":\"4911\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"解除签约失败\",\"code\":\"4911\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankDelete"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/info",
    "title": "填写信息",
    "version": "3.1.1",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bank_no",
            "description": "<p>银行卡号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_card",
            "description": "<p>身份证号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_mobile",
            "description": "<p>绑定手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n{\"success\":\"true\",\"data\":\"开通成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"开通失败\",\"code\":\"4910\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankInfo"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/info",
    "title": "填写信息",
    "version": "3.1.0",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bank_no",
            "description": "<p>银行卡号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_card",
            "description": "<p>身份证号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_mobile",
            "description": "<p>绑定手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n{\"success\":\"true\",\"data\":\"开通成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"开通失败\",\"code\":\"4910\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankInfo"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/show",
    "title": "银行卡列表",
    "version": "3.1.1",
    "group": "bank",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"success\": \"true\",\n\"data\": [\n  {\n    \"temp_bankcard_id\": \"13\",\n    \"bank_name\": \"中信银行\",\n    \"bank_type\": \"0\",\n    \"bind_mobile\": \"186 **** 5257\",\n    \"bank_no\": \"**** **** **** 5990\"\n\t   \"card_type\": \"贷记卡\"\n\t   \"bank_sign\": \"358971\"\n  },\n  {\n    \"temp_bankcard_id\": \"14\",\n    \"bank_name\": \"中信银行\",\n    \"bank_type\": \"0\",\n    \"bind_mobile\": \"186 **** 5257\",\n    \"bank_no\": \"**** **** **** 5990\"\n    \"card_type\": \"贷记卡\"\n\t   \"bank_sign\": \"358973\"\n  }\n]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/show",
    "title": "银行卡列表",
    "version": "3.1.0",
    "group": "bank",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"success\": \"true\",\n\"data\": [\n  {\n    \"temp_bankcard_id\": \"13\",\n    \"bank_name\": \"中信银行\",\n    \"bank_type\": \"0\",\n    \"bind_mobile\": \"186 **** 5257\",\n    \"bank_no\": \"**** **** **** 5990\"\n\t   \"card_type\": \"贷记卡\"\n\t   \"bank_sign\": \"358971\"\n  },\n  {\n    \"temp_bankcard_id\": \"14\",\n    \"bank_name\": \"中信银行\",\n    \"bank_type\": \"0\",\n    \"bind_mobile\": \"186 **** 5257\",\n    \"bank_no\": \"**** **** **** 5990\"\n    \"card_type\": \"贷记卡\"\n\t   \"bank_sign\": \"358973\"\n  }\n]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/supportList",
    "title": "麦网支持的银行卡列表",
    "version": "3.1.1",
    "group": "bank",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"储蓄卡\": [\n    {\n      \"bankName\": \"兴业银行\",\n      \"bankCardType\": \"DR\",\n      \"bankCode\": \"CIB\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/CIB.png\"\n    },\n    {\n      \"bankName\": \"中国银行\",\n      \"bankCardType\": \"DR\",\n      \"bankCode\": \"BOC\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/BOCB2C.png\"\n    }\n  ],\n  \"信用卡\": [\n    {\n      \"bankName\": \"东亚银行\",\n      \"bankCardType\": \"CR\",\n      \"bankCode\": \"HKBEA\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/.png\"\n    },\n    {\n      \"bankName\": \"南昌银行\",\n      \"bankCardType\": \"CR\",\n      \"bankCode\": \"NCC\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/.png\"\n    }\n  ]\n } \n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankSupportlist"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/supportList",
    "title": "麦网支持的银行卡列表",
    "version": "3.1.0",
    "group": "bank",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"储蓄卡\": [\n    {\n      \"bankName\": \"兴业银行\",\n      \"bankCardType\": \"DR\",\n      \"bankCode\": \"CIB\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/CIB.png\"\n    },\n    {\n      \"bankName\": \"中国银行\",\n      \"bankCardType\": \"DR\",\n      \"bankCode\": \"BOC\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/BOCB2C.png\"\n    }\n  ],\n  \"信用卡\": [\n    {\n      \"bankName\": \"东亚银行\",\n      \"bankCardType\": \"CR\",\n      \"bankCode\": \"HKBEA\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/.png\"\n    },\n    {\n      \"bankName\": \"南昌银行\",\n      \"bankCardType\": \"CR\",\n      \"bankCode\": \"NCC\",\n      \"url\": \"http://192.168.1.28/pcwstore/v3.1/myecshop2/Public/bank_icon/.png\"\n    }\n  ]\n } \n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankSupportlist"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/update1",
    "title": "修改信息",
    "version": "3.1.1",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_mobile",
            "description": "<p>用户手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_card",
            "description": "<p>用户身份证号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"修改成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"身份证号不规范\",\"code\":\"4809\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"姓名中不能含有数字\",\"code\":\"4148\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码不规范\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankUpdate1"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/bank/update1",
    "title": "修改信息",
    "version": "3.1.0",
    "group": "bank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_mobile",
            "description": "<p>用户手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_card",
            "description": "<p>用户身份证号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"修改成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"身份证号不规范\",\"code\":\"4809\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"姓名中不能含有数字\",\"code\":\"4148\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号码不规范\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "bank",
    "name": "PostV31Myecshop2BankUpdate1"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/clever/add",
    "title": "批量加入购物车",
    "version": "3.1.1",
    "group": "clever",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "goods_arr",
            "description": "<p>商品对象</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.goods_id",
            "description": "<p>商品id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.amount",
            "description": "<p>商品数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>1辅材 2主材</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"成功加入购物车\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"加入购物车失败\",\"code\":\"4921\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "clever",
    "name": "PostV31Myecshop2HomeCleverAdd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/clever/handle",
    "title": "生成材料清单",
    "version": "3.1.1",
    "group": "clever",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Classfy",
            "description": "<p>施工类型</p>"
          },
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
            "description": "<p>室数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "SittingN",
            "description": "<p>厅数量</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "KitchenN",
            "description": "<p>厨房数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ToiletN",
            "description": "<p>卫生间数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "BalconyN",
            "description": "<p>阳台数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "DeskType",
            "description": "<p>柜台样式</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "DeskHight",
            "description": "<p>柜台高</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "SittingArea",
            "description": "<p>厅面积</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\n\"success\": \"true\",\n\"data\": [\n  {\n    \"goods_id\": \"8171\",\n    \"goods_name\": \"普通 木方（白松条）\",\n    \"goods_unit\": \"根\",\n    \"shop_price\": \"9.8\",\n    \"goods_thumb\": \"http://121.40.239.22/ecshop2/customer/upload/SH/middle/15-11-18%2003-43-45166727_original.png\",\n    \"goods_img\": \"http://121.40.239.22/ecshop2/customer/upload/SH/original/15-11-18%2003-43-4516.png\",\n    \"min_amount\": \"1\",\n    \"goods_cat_id\": \"136\",\n    \"amount\": \"0\",\n    \"type\": \"1\",\n    \"area_id\": \"1\",\n    \"color\": {\n      \"color_id\": \"460\",\n      \"color_name\": \"2.2*3.8*370cm\"\n    },\n    \"cat\": {\n      \"cat_id\": \"136\"\n    },\n    \"version\": {\n      \"version_name\": \"多规格可选\",\n      \"version_id\": \"4772\"\n    },\n    \"brand\": {\n      \"brand_name\": \"木方\",\n      \"brand_id\": \"174\"\n    }\n  },\n  {\n    \"goods_id\": \"8202\",\n    \"goods_name\": \"普通 细木工板\",\n    \"goods_unit\": \"张\",\n    \"shop_price\": \"163.9\",\n    \"goods_thumb\": \"http://121.40.239.22/ecshop2/customer/upload/SH/middle/15-11-19%2009-38-08166753_original.jpg\",\n    \"goods_img\": \"http://121.40.239.22/ecshop2/customer/upload/SH/original/15-11-19%2009-38-0816.jpg\",\n    \"min_amount\": \"1\",\n    \"goods_cat_id\": \"136\",\n    \"amount\": \"1\",\n    \"type\": \"1\",\n    \"area_id\": \"1\",\n    \"color\": {\n      \"color_id\": \"3067\",\n      \"color_name\": \"柳桉/1220*2440*17\"\n    },\n    \"cat\": {\n      \"cat_id\": \"136\"\n    },\n    \"version\": {\n      \"version_name\": \"E0\",\n      \"version_id\": \"4638\"\n    },\n    \"brand\": {\n      \"brand_name\": \"木工板\",\n      \"brand_id\": \"173\"\n    }\n  }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "clever",
    "name": "PostV31Myecshop2HomeCleverHandle"
  },
  {
    "type": "post",
    "url": "...",
    "title": "code码及其解释",
    "version": "3.1.1",
    "group": "code",
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4100",
            "description": "<p>修改个人资料失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4101",
            "description": "<p>头像文件上传的各种错误</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4102",
            "description": "<p>用户已注册</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4103",
            "description": "<p>时间间隔太小，请1分钟后再申请</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4104",
            "description": "<p>短信今天已经发了6次，请明天再申请</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4104",
            "description": "<p>数据来源有误！请从本站提交！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4105",
            "description": "<p>获取个人资料失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4106",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4107",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4108",
            "description": "<p>验证码发送失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4110",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4111",
            "description": "<p>编辑地址失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4112",
            "description": "<p>删除地址失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4113",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4113",
            "description": "<p>用户注册失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4114",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4115",
            "description": "<p>反馈问题失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4116",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4117",
            "description": "<p>密码修改失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4120",
            "description": "<p>原密码错误</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4120",
            "description": "<p>密码修改失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4120",
            "description": "<p>new_password不能少于6位</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4120",
            "description": "<p>原密码不能和新密码一样</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "5.4120",
            "description": "<p>session过期</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "6.4120",
            "description": "<p>goods_id不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "7.4120",
            "description": "<p>提交动作act的值只能为del或者add</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "8.4120",
            "description": "<p>act不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "9.4120",
            "description": "<p>提交动作act的值只能为del或者add</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "10.4120",
            "description": "<p>amount不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4128",
            "description": "<p>提醒卖家发货失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4129",
            "description": "<p>用户名密码不匹配!</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4139",
            "description": "<p>收藏好友失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4140",
            "description": "<p>已经收藏过此好友</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4800",
            "description": "<p>type必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4800",
            "description": "<p>type必须为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4800",
            "description": "<p>手机号必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4800",
            "description": "<p>手机号格式不正确</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "5.4800",
            "description": "<p>邀请码不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "6.4800",
            "description": "<p>密码长度至少为6位</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "7.4800",
            "description": "<p>密码不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "8.4800",
            "description": "<p>不少于15字</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "9.4800",
            "description": "<p>用户名不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "10.4800",
            "description": "<p>地址不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "11.4800",
            "description": "<p>添加地址最多只能添加10个</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "12.4800",
            "description": "<p>自己不能收藏自己</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "13.4800",
            "description": "<p>无此用户</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "14.4800",
            "description": "<p>to_id必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "15.4800",
            "description": "<p>抱歉，你的付款方式为货到付款</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4801",
            "description": "<p>type必须为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4801",
            "description": "<p>手机号码不规范</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4801",
            "description": "<p>你没输入goods_id</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4801",
            "description": "<p>用户已注册</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4804",
            "description": "<p>type值必须传，其值只能为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4807",
            "description": "<p>参数不全或有参数为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4808",
            "description": "<p>辅材总价不能少于288</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4809",
            "description": "<p>主材总价不能少于1000</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4900",
            "description": "<p>检验验证码失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4901",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4902",
            "description": "<p>加入购物车失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4902",
            "description": "<p>删除购物车商品失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4902",
            "description": "<p>修改购物车失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4903",
            "description": "<p>取消收藏失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4903",
            "description": "<p>清空收藏夹失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4904",
            "description": "<p>订单状态更新失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4915",
            "description": "<p>请求好友代付款失败</p>"
          }
        ]
      }
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "code",
    "name": "Post"
  },
  {
    "type": "post",
    "url": "...",
    "title": "code码及其解释",
    "version": "3.1.0",
    "group": "code",
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4100",
            "description": "<p>修改个人资料失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4101",
            "description": "<p>头像文件上传的各种错误</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4102",
            "description": "<p>用户已注册</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4103",
            "description": "<p>时间间隔太小，请1分钟后再申请</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4104",
            "description": "<p>短信今天已经发了6次，请明天再申请</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4104",
            "description": "<p>数据来源有误！请从本站提交！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4105",
            "description": "<p>获取个人资料失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4106",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4107",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4108",
            "description": "<p>验证码发送失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4110",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4111",
            "description": "<p>编辑地址失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4112",
            "description": "<p>删除地址失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4113",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4113",
            "description": "<p>用户注册失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4114",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4115",
            "description": "<p>反馈问题失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4116",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4117",
            "description": "<p>密码修改失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4120",
            "description": "<p>原密码错误</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4120",
            "description": "<p>密码修改失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4120",
            "description": "<p>new_password不能少于6位</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4120",
            "description": "<p>原密码不能和新密码一样</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "5.4120",
            "description": "<p>session过期</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "6.4120",
            "description": "<p>goods_id不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "7.4120",
            "description": "<p>提交动作act的值只能为del或者add</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "8.4120",
            "description": "<p>act不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "9.4120",
            "description": "<p>提交动作act的值只能为del或者add</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "10.4120",
            "description": "<p>amount不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4128",
            "description": "<p>提醒卖家发货失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4129",
            "description": "<p>用户名密码不匹配!</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4139",
            "description": "<p>收藏好友失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4140",
            "description": "<p>已经收藏过此好友</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4800",
            "description": "<p>type必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4800",
            "description": "<p>type必须为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4800",
            "description": "<p>手机号必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4800",
            "description": "<p>手机号格式不正确</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "5.4800",
            "description": "<p>邀请码不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "6.4800",
            "description": "<p>密码长度至少为6位</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "7.4800",
            "description": "<p>密码不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "8.4800",
            "description": "<p>不少于15字</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "9.4800",
            "description": "<p>用户名不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "10.4800",
            "description": "<p>地址不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "11.4800",
            "description": "<p>添加地址最多只能添加10个</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "12.4800",
            "description": "<p>自己不能收藏自己</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "13.4800",
            "description": "<p>无此用户</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "14.4800",
            "description": "<p>to_id必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "15.4800",
            "description": "<p>抱歉，你的付款方式为货到付款</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4801",
            "description": "<p>type必须为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4801",
            "description": "<p>手机号码不规范</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4801",
            "description": "<p>你没输入goods_id</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4801",
            "description": "<p>用户已注册</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4804",
            "description": "<p>type值必须传，其值只能为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4807",
            "description": "<p>参数不全或有参数为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4808",
            "description": "<p>辅材总价不能少于288</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4809",
            "description": "<p>主材总价不能少于1000</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4900",
            "description": "<p>检验验证码失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4901",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4902",
            "description": "<p>加入购物车失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4902",
            "description": "<p>删除购物车商品失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4902",
            "description": "<p>修改购物车失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4903",
            "description": "<p>取消收藏失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4903",
            "description": "<p>清空收藏夹失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4904",
            "description": "<p>订单状态更新失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4915",
            "description": "<p>请求好友代付款失败</p>"
          }
        ]
      }
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "code",
    "name": "Post"
  },
  {
    "type": "post",
    "url": "...",
    "title": "code码及其解释",
    "version": "1.2.0",
    "group": "code",
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4100",
            "description": "<p>修改个人资料失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4101",
            "description": "<p>头像文件上传的各种错误</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4102",
            "description": "<p>用户已注册</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4103",
            "description": "<p>时间间隔太小，请1分钟后再申请</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4104",
            "description": "<p>短信今天已经发了6次，请明天再申请</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4104",
            "description": "<p>数据来源有误！请从本站提交！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4105",
            "description": "<p>获取个人资料失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4106",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4107",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4108",
            "description": "<p>验证码发送失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4110",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4111",
            "description": "<p>编辑地址失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4112",
            "description": "<p>删除地址失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4113",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4113",
            "description": "<p>用户注册失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4114",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4115",
            "description": "<p>反馈问题失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4116",
            "description": "<p>用户不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4117",
            "description": "<p>密码修改失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4120",
            "description": "<p>原密码错误</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4120",
            "description": "<p>密码修改失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4120",
            "description": "<p>new_password不能少于6位</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4120",
            "description": "<p>原密码不能和新密码一样</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "5.4120",
            "description": "<p>session过期</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "6.4120",
            "description": "<p>goods_id不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "7.4120",
            "description": "<p>提交动作act的值只能为del或者add</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "8.4120",
            "description": "<p>act不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "9.4120",
            "description": "<p>提交动作act的值只能为del或者add</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "10.4120",
            "description": "<p>amount不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4128",
            "description": "<p>提醒卖家发货失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4129",
            "description": "<p>用户名密码不匹配!</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4139",
            "description": "<p>收藏好友失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4140",
            "description": "<p>已经收藏过此好友</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4800",
            "description": "<p>type必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4800",
            "description": "<p>type必须为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4800",
            "description": "<p>手机号必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4800",
            "description": "<p>手机号格式不正确</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "5.4800",
            "description": "<p>邀请码不存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "6.4800",
            "description": "<p>密码长度至少为6位</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "7.4800",
            "description": "<p>密码不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "8.4800",
            "description": "<p>不少于15字</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "9.4800",
            "description": "<p>用户名不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "10.4800",
            "description": "<p>地址不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "11.4800",
            "description": "<p>添加地址最多只能添加10个</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "12.4800",
            "description": "<p>自己不能收藏自己</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "13.4800",
            "description": "<p>无此用户</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "14.4800",
            "description": "<p>to_id必须存在</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "15.4800",
            "description": "<p>抱歉，你的付款方式为货到付款</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4801",
            "description": "<p>type必须为1或2</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4801",
            "description": "<p>手机号码不规范</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4801",
            "description": "<p>你没输入goods_id</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4.4801",
            "description": "<p>用户已注册</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4900",
            "description": "<p>检验验证码失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4901",
            "description": "<p>type不能为空</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4902",
            "description": "<p>加入购物车失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4902",
            "description": "<p>删除购物车商品失败</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "3.4902",
            "description": "<p>修改购物车失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "1.4903",
            "description": "<p>取消收藏失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "2.4903",
            "description": "<p>清空收藏夹失败！</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4904",
            "description": "<p>订单状态更新失败！</p>"
          }
        ]
      }
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "code",
    "name": "Post"
  },
  {
    "type": "post",
    "url": "myecshop2/other/version",
    "title": "1.版本接口",
    "version": "1.2.0",
    "group": "other",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"versionName\": \"1.2\",\n   \"versionCode\": \"103\",\n   \"desc\": \"有新版本更新\",\n   \"force\":1,\n   \"url\": \"http://www.aec188.com/askprice/download/PcwStore.apk\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "other",
    "name": "PostMyecshop2OtherVersion"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/index/transportation",
    "title": "运费价格和描述",
    "version": "3.1.1",
    "group": "other",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>商品类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_address_id",
            "description": "<p>地址id</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "goods_arr",
            "description": "<p>商品</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.amount",
            "description": "<p>商品数量</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"transportation_price\": \"250\",\n   \"transportation_desc\": \"运费说明\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "other",
    "name": "PostV31Myecshop2HomeIndexTransportation"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/index/transportation",
    "title": "运费价格和描述",
    "version": "3.1.0",
    "group": "other",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>商品类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_address_id",
            "description": "<p>地址id</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "goods_arr",
            "description": "<p>商品</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.goods_id",
            "description": "<p>商品ID号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_arr.amount",
            "description": "<p>商品数量</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"transportation_price\": \"250\",\n   \"transportation_desc\": \"运费说明\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "other",
    "name": "PostV31Myecshop2HomeIndexTransportation"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/other/desc",
    "title": "价格限制说明",
    "version": "3.1.1",
    "group": "other",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"desc_f\": \"满288.00才可下单\",\n  \"desc_z\": \"满1000.00才可下单\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "other",
    "name": "PostV31Myecshop2HomeOtherDesc"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/other/desc",
    "title": "价格限制说明",
    "version": "3.1.0",
    "group": "other",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "area_id",
            "description": "<p>城市id号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"success\": \"true\",\n\"data\": {\n  \"desc_f\": \"满288.00才可下单\",\n  \"desc_z\": \"满1000.00才可下单\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "other",
    "name": "PostV31Myecshop2HomeOtherDesc"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/other/version",
    "title": "版本接口",
    "version": "3.1.1",
    "group": "other",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"versionName\": \"1.2\",\n   \"versionCode\": \"103\",\n   \"desc\": \"有新版本更新\",\n   \"force\":1,\n   \"url\": \"http://www.aec188.com/askprice/download/PcwStore.apk\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "other",
    "name": "PostV31Myecshop2HomeOtherVersion"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/home/other/version",
    "title": "版本接口",
    "version": "3.1.0",
    "group": "other",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"versionName\": \"1.2\",\n   \"versionCode\": \"103\",\n   \"desc\": \"有新版本更新\",\n   \"force\":1,\n   \"url\": \"http://www.aec188.com/askprice/download/PcwStore.apk\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "other",
    "name": "PostV31Myecshop2HomeOtherVersion"
  },
  {
    "type": "post",
    "url": "AskPriceApi/beecloud-php/demo/webhook.php",
    "title": "秒支付接口",
    "version": "3.1.1",
    "group": "pay",
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "pay",
    "name": "PostAskpriceapiBeecloudPhpDemoWebhookPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/beecloud-php/demo/webhook.php",
    "title": "秒支付接口",
    "version": "3.1.0",
    "group": "pay",
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "pay",
    "name": "PostAskpriceapiBeecloudPhpDemoWebhookPhp"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/push/add",
    "title": "消息推送把用户手机信息入库",
    "version": "3.1.1",
    "group": "push",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device",
            "description": "<p>手机类型(1指的是安卓,2指的是ios)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "push_id",
            "description": "<p>实际上就是channel_id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"用户手机信息入库成功\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "push",
    "name": "PostV31Myecshop2CenterPushAdd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/push/add",
    "title": "消息推送把用户手机信息入库",
    "version": "3.1.0",
    "group": "push",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device",
            "description": "<p>手机类型(1指的是安卓,2指的是ios)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "push_id",
            "description": "<p>实际上就是channel_id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"用户手机信息入库成功\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "push",
    "name": "PostV31Myecshop2CenterPushAdd"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/push/one",
    "title": "消息推送到个人（注意该接口不要随意调用）",
    "version": "3.1.1",
    "group": "push",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>消息标题</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>消息内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"推送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"用户没有绑定推送\",\"code\":\"4804\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"title和content不能为空\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"推送信息入库失败\",\"code\":\"5001\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "push",
    "name": "PostV31Myecshop2CenterPushOne"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/push/push_all",
    "title": "消息推送到全部用户（注意该接口不要随意调用）",
    "version": "3.1.1",
    "group": "push",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>消息标题</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>消息内容</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"推送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"ios用户推送消息入库失败\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"安卓用户推送消息入库失败\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"title和content不能为空\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "push",
    "name": "PostV31Myecshop2CenterPushPush_all"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/push/show",
    "title": "消息列表",
    "version": "3.1.1",
    "group": "push",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device",
            "description": "<p>设备类型(1:安卓 2:ios)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "type说明  1文本  2网页  3订单  4other\n{\n\"success\": \"true\",\n\"data\": [\n  {\n    \"message_id\": \"37\",\n    \"title\": \"test\",\n    \"content\": \"just test\",\n    \"extend\": \"大胆贼人\",\n    \"time\": \"4\",\n    \"type\": \"1\"\n  },\n  {\n    \"message_id\": \"36\",\n    \"title\": \"找材猫\",\n    \"content\": \"你好\",\n    \"extend\": \"https://www.baidu.com\",\n    \"time\": \"2\",\n    \"type\": \"2\"\n  }\n]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "push",
    "name": "PostV31Myecshop2CenterPushShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/push/show",
    "title": "消息列表",
    "version": "3.1.0",
    "group": "push",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device",
            "description": "<p>设备类型(1:安卓 2:ios)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "type说明  1文本  2网页  3订单  4other\n{\n\"success\": \"true\",\n\"data\": [\n  {\n    \"message_id\": \"37\",\n    \"title\": \"test\",\n    \"content\": \"just test\",\n    \"extend\": \"大胆贼人\",\n    \"time\": \"4\",\n    \"type\": \"1\"\n  },\n  {\n    \"message_id\": \"36\",\n    \"title\": \"找材猫\",\n    \"content\": \"你好\",\n    \"extend\": \"https://www.baidu.com\",\n    \"time\": \"2\",\n    \"type\": \"2\"\n  }\n]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "push",
    "name": "PostV31Myecshop2CenterPushShow"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/push/some",
    "title": "消息推送到指定用户（指定用户是指下过单的老用户，注意该接口不要随意调用）",
    "version": "3.1.1",
    "group": "push",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>消息标题</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>消息内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>1老用户 2新用户</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"推送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"ios用户推送消息入库失败\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"安卓用户推送消息入库失败\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"title和content不能为空\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "push",
    "name": "PostV31Myecshop2CenterPushSome"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/order/comment",
    "title": "评价",
    "version": "3.1.1",
    "group": "user_center",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>评价内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "trans_grade",
            "description": "<p>物流评分</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_grade",
            "description": "<p>商品评分</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "service_grade",
            "description": "<p>服务评分</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"评价成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"评价失败\",\"code\":\"4921\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"评分只能是1到5分\",\"code\":\"4162\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "user_center",
    "name": "PostV31Myecshop2CenterOrderComment"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/order/comment",
    "title": "评价",
    "version": "3.1.0",
    "group": "user_center",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_purchase_id",
            "description": "<p>订单id号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>评价内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "trans_grade",
            "description": "<p>物流评分</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_grade",
            "description": "<p>商品评分</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "service_grade",
            "description": "<p>服务评分</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "{\"success\":\"true\",\"data\":\"评价成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"评价失败\",\"code\":\"4921\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"评分只能是1到5分\",\"code\":\"4162\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "user_center",
    "name": "PostV31Myecshop2CenterOrderComment"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/order/state",
    "title": "查询几种订单状态的数目",
    "version": "3.1.1",
    "group": "user_center",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "num1:待付款\tnum2:待发货\t num3:待收货\tnum4:退款\n{\"success\":\"true\",\"data\":{\"num1\":\"0\",\"num2\":\"3\",\"num3\":\"0\",\"num4\":\"0\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "user_center",
    "name": "PostV31Myecshop2CenterOrderState"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/center/order/state",
    "title": "查询几种订单状态的数目",
    "version": "3.1.0",
    "group": "user_center",
    "success": {
      "examples": [
        {
          "title": "成功返回结果-",
          "content": "num1:待付款\tnum2:待发货\t num3:待收货\tnum4:退款\n{\"success\":\"true\",\"data\":{\"num1\":\"0\",\"num2\":\"3\",\"num3\":\"0\",\"num4\":\"0\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "user_center",
    "name": "PostV31Myecshop2CenterOrderState"
  },
  {
    "type": "post",
    "url": "AskPriceApi/GetPersonal.php",
    "title": "2.获取个人资料",
    "version": "1.2.0",
    "group": "user_information",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":\n   {\n       \"temp_buyers_id\":\"1\",\n       \"temp_buyers_mobile\":\"15021680669\",\n       \"nick\":\"冰\",\"\n       \"photo\":\"D:/wamp/www/ecshop2/Guest/upload/photo/15021680669/thumb_15021680669head.jpg\",\n       \"info\":\"helle\"\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"获取个人资料失败\",\"code\":\"4105\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"session过期\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "user_information",
    "name": "PostAskpriceapiGetpersonalPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/GetUserInfo.php",
    "title": "4.通过用户名获取用户信息",
    "version": "1.2.0",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_buyers_mobile",
            "description": "<p>手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":\n   {\n       \"temp_buyers_id\":\"1\",\n       \"temp_buyers_mobile\":\"15021680669\",\n       \"nick\":\"冰\",\"\n       \"photo\":\"D:/wamp/www/ecshop2/Guest/upload/photo/15021680669/thumb_15021680669head.jpg\",\n       \"info\":\"helle\"\n   }\n}\n\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "user_information",
    "name": "PostAskpriceapiGetuserinfoPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/lookup.php",
    "title": "6.模糊查询",
    "version": "1.2.0",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码任意位数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>显示条数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "无数据返回：数据为空：{\"success\":\"true\",\"data\":[]}\n{\n \"success\": \"true\",\n \"data\": [\n   {\n     \"temp_buyers_id\": \"2\",\n     \"temp_buyers_mobile\": \"13262936502\",\n     \"nick\": \"fgghghh\",\n     \"temp_buyers_password\": \"e10adc3949ba59abbe56e057f20f883e\",\n     \"photo\": \"upload/photo/13262936502/13262936502head.jpg\",\n     \"info\": \"Hi符\"\n   },\n   {\n     \"temp_buyers_id\": \"3\",\n     \"temp_buyers_mobile\": \"18721559023\",\n     \"nick\": \"Coffee\",\n     \"temp_buyers_password\": \"96e79218965eb72c92a549dd5a330112\",\n     \"photo\": \"\",\n     \"info\": \"\"\n   },\n  ]\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "user_information",
    "name": "PostAskpriceapiLookupPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/ModifyPersonal.php",
    "title": "1.修改个人资料",
    "version": "1.2.0",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "nick",
            "description": "<p>昵称（可空）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "info",
            "description": "<p>介绍（可空）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "ori_img",
            "description": "<p>头像（可空）（最大为10M）</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"时间间隔太小，请1分钟后再申请\",\"code\":\"4103\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"短信今天已经发了6次，请明天再申请\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"数据来源有误！请从本站提交！\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"检验验证码失败\",\"code\":\"4900\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"验证码发送失败\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "user_information",
    "name": "PostAskpriceapiModifypersonalPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/question.php",
    "title": "3.问题反馈",
    "version": "1.2.0",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>反馈</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"反馈问题成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"反馈问题失败\",\"code\":\"4115\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"session过期\",\"code\":\"4120\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"不少于15字\",\"code\":\"4800\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "user_information",
    "name": "PostAskpriceapiQuestionPhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/upfile.php",
    "title": "5.上传一张图片或文件",
    "version": "1.2.0",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ori_img",
            "description": "<p>上传文件</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"img_url\": \"http://192.168.1.61/ecshop2/Guest/upload/MOB/4dxz5k.jpg\",\n   \"thumb_url\": \"http://192.168.1.61/ecshop2/Guest/upload/MOB/thumb_4dxz5k.jpg\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "user_information",
    "name": "PostAskpriceapiUpfilePhp"
  },
  {
    "type": "post",
    "url": "AskPriceApi/upfile.php",
    "title": "5.上传一张图片或文件",
    "version": "1.2.0",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ori_img",
            "description": "<p>上传文件</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"success\": \"true\",\n \"data\": {\n   \"img_url\": \"http://192.168.1.61/ecshop2/Guest/upload/MOB/4dxz5k.jpg\",\n   \"thumb_url\": \"http://192.168.1.61/ecshop2/Guest/upload/MOB/thumb_4dxz5k.jpg\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.2.js",
    "groupTitle": "user_information",
    "name": "PostAskpriceapiUpfilePhp"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/getInfo",
    "title": "获取个人资料",
    "version": "3.1.1",
    "group": "user_information",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":\n   {\n       \"temp_buyers_id\":\"1\",\n       \"temp_buyers_mobile\":\"15021680669\",\n       \"nick\":\"冰\",\"\n       \"photo\":\"D:/wamp/www/ecshop2/Guest/upload/photo/15021680669/thumb_15021680669head.jpg\",\n       \"info\":\"helle\"\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"获取个人资料失败\",\"code\":\"4105\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"session过期\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "user_information",
    "name": "PostV31Myecshop2UserInfoGetinfo"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/getInfo",
    "title": "获取个人资料",
    "version": "3.1.0",
    "group": "user_information",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":\n   {\n       \"temp_buyers_id\":\"1\",\n       \"temp_buyers_mobile\":\"15021680669\",\n       \"nick\":\"冰\",\"\n       \"photo\":\"D:/wamp/www/ecshop2/Guest/upload/photo/15021680669/thumb_15021680669head.jpg\",\n       \"info\":\"helle\"\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"获取个人资料失败\",\"code\":\"4105\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"session过期\",\"code\":\"4120\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "user_information",
    "name": "PostV31Myecshop2UserInfoGetinfo"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/modifyInfo",
    "title": "修改个人资料",
    "version": "3.1.1",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "nick",
            "description": "<p>昵称（可空）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "info",
            "description": "<p>介绍（可空）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "ori_img",
            "description": "<p>头像（可空）（最大为10M）</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"时间间隔太小，请1分钟后再申请\",\"code\":\"4103\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"短信今天已经发了6次，请明天再申请\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"数据来源有误！请从本站提交！\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"检验验证码失败\",\"code\":\"4900\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"验证码发送失败\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.1.js",
    "groupTitle": "user_information",
    "name": "PostV31Myecshop2UserInfoModifyinfo"
  },
  {
    "type": "post",
    "url": "v3.1/myecshop2/user/info/modifyInfo",
    "title": "修改个人资料",
    "version": "3.1.0",
    "group": "user_information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "nick",
            "description": "<p>昵称（可空）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "info",
            "description": "<p>介绍（可空）</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "ori_img",
            "description": "<p>头像（可空）（最大为10M）</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\"success\":\"true\",\"data\":{\"msg\":\"验证码发送成功\"}}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\"success\":\"false\",\"error\":{\"msg\":\"type必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"type必须为1或2\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号必须存在\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"手机号格式不正确\",\"code\":\"4800\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户已注册\",\"code\":\"4102\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"用户不存在\",\"code\":\"4116\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"时间间隔太小，请1分钟后再申请\",\"code\":\"4103\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"短信今天已经发了6次，请明天再申请\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"数据来源有误！请从本站提交！\",\"code\":\"4104\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"检验验证码失败\",\"code\":\"4900\"}}\n{\"success\":\"false\",\"error\":{\"msg\":\"验证码发送失败\",\"code\":\"4108\"}}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api3.1.0.js",
    "groupTitle": "user_information",
    "name": "PostV31Myecshop2UserInfoModifyinfo"
  }
] });
