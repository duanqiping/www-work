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
    "url": "home/user/getCheckCode",
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
          "content": "\"验证码发送成功\"",
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
    "name": "GetHomeUserGetcheckcode"
  }
] });
