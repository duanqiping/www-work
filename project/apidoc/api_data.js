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
    "group": "C__wamp_www_project_apidoc_seed_doc_main_js",
    "groupTitle": "C__wamp_www_project_apidoc_seed_doc_main_js",
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
    "group": "C__wamp_www_project_apidoc_seed_template_main_js",
    "groupTitle": "C__wamp_www_project_apidoc_seed_template_main_js",
    "name": ""
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
  }
] });
