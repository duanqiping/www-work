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
    "group": "C__wamp_www_project_app_apidoc_seed_doc_main_js",
    "groupTitle": "C__wamp_www_project_app_apidoc_seed_doc_main_js",
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
    "group": "C__wamp_www_project_app_apidoc_seed_template_main_js",
    "groupTitle": "C__wamp_www_project_app_apidoc_seed_template_main_js",
    "name": ""
  },
  {
    "type": "get",
    "url": "v1/home/rank/location",
    "title": "客户地理位置信息",
    "version": "1.0.0",
    "group": "rank",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "[\n{\n   \"customer_id\": \"15\",\n   \"name\": \"维也纳酒店\",\n   \"longitude_y\": \"121.5072970945\",\n   \"latitude_x\": \"30.9051522416\"\n},\n{\n   \"customer_id\": \"16\",\n   \"name\": \"东奉大酒店\",\n   \"longitude_y\": \"121.5045397836\",\n   \"latitude_x\": \"30.9080152914\"\n}\n]",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "rank",
    "name": "GetV1HomeRankLocation"
  },
  {
    "type": "get",
    "url": "v1/home/rank/nearby",
    "title": "最近的一个客户",
    "version": "1.0.0",
    "group": "rank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude_x",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude_y",
            "description": "<p>经度</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n   \"customer_id\": \"16\",\n   \"name\": \"东奉大酒店\",\n   \"longitude_y\": \"121.5045397836\",\n   \"latitude_x\": \"30.9080152914\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "rank",
    "name": "GetV1HomeRankNearby"
  },
  {
    "type": "get",
    "url": "v1/home/rank/rank",
    "title": "成绩排行",
    "version": "1.0.0",
    "group": "rank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "customer_id",
            "description": "<p>客户id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "cycles",
            "description": "<p>圈数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>week(当周)month(当月)year(当年)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>页数</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页大小</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "[\n{\n   \"rank_id\": \"10\",\n   \"user_id\": \"222\",\n   \"customer_id\": \"14\",\n   \"score_id\": \"36\",\n   \"cycles\": \"1\",\n   \"time\": \"222\",\n   \"add_time\": \"1498654279\"\n},\n{\n   \"rank_id\": \"8\",\n   \"user_id\": \"111\",\n   \"customer_id\": \"14\",\n   \"score_id\": \"34\",\n   \"cycles\": \"1\",\n   \"time\": \"1231548\",\n   \"add_time\": \"1498395075\"\n}\n]",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "rank",
    "name": "GetV1HomeRankRank"
  },
  {
    "type": "get",
    "url": "v1/home/user/CheckCode",
    "title": "用户注册 校验验证码",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
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
            "field": "type",
            "description": "<p>type=1注册 type=2忘记密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "checkcode",
            "description": "<p>验证码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"msg\": \"验证码校验通过\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n \"msg\": \"手机号未获取验证码\",\n \"code\": 0\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "GetV1HomeUserCheckcode"
  },
  {
    "type": "get",
    "url": "v1/home/user/getCheckCode",
    "title": "用户注册 获取验证码",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
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
            "field": "type",
            "description": "<p>type=1注册 type=2忘记密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"msg\": \"验证码发送成功\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n  \"msg\": \"手机号码不规范\",\n  \"code\": 0\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "GetV1HomeUserGetcheckcode"
  },
  {
    "type": "get",
    "url": "v1/home/user/logout",
    "title": "退出",
    "version": "1.0.0",
    "group": "user",
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"msg\": \"退出成功\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "GetV1HomeUserLogout"
  },
  {
    "type": "post",
    "url": "v1/home/user/login",
    "title": "登陆",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
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
            "field": "passwd",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"user_id\": \"8\",\n \"is_check\": \"1\",\n \"account\": \"17701804870\",\n \"nick\": \"17701804870\",\n \"img\": \"\",\n \"email\": \"\",\n \"sex\": \"1\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n\"msg\": \"用户名密码不匹配\",\n \"code\": 1\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1HomeUserLogin"
  },
  {
    "type": "post",
    "url": "v1/home/user/modifyInfo",
    "title": "修改信息",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "nick",
            "description": "<p>昵称</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n\"user_id\": \"14\",\n\"is_check\": \"1\",\n\"account\": \"17701804876\",\n\"nick\": \"段齐平22\",\n\"img\": \"http:\\\\/\\\\/192.168.0.118\\\\/Guest\\\\/upload\\\\/photo\\\\/17701804876\\\\/17701804876head.png\",\n\"email\": \"\",\n\"sex\": \"1\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n\"msg\": \"修改个人资料失败\",\n \"code\": 1\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1HomeUserModifyinfo"
  },
  {
    "type": "post",
    "url": "v1/home/user/reg",
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
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "passwd",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sex",
            "description": "<p>1男 2女</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n \"user_id\": \"8\",\n \"is_check\": \"1\",\n \"account\": \"17701804870\",\n \"nick\": \"17701804870\",\n \"img\": \"\",\n \"email\": \"\",\n \"sex\": \"1\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n\"msg\": \"用户注册失败\",\n \"code\": 1\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1HomeUserReg"
  },
  {
    "type": "post",
    "url": "v1/home/user/uploadImg",
    "title": "上传头像",
    "version": "1.0.0",
    "group": "user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "img",
            "description": "<p>头像</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"msg\": \"http:\\\\/\\\\/192.168.0.118\\\\/Guest\\\\/upload\\\\/photo\\\\/17701804876\\\\/17701804876head.png\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n\"msg\": \"上传失败\",\n \"code\": 1\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "user",
    "name": "PostV1HomeUserUploadimg"
  }
] });
