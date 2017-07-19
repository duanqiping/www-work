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
    "group": "C__wamp_www_project_back_apidoc_seed_doc_main_js",
    "groupTitle": "C__wamp_www_project_back_apidoc_seed_doc_main_js",
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
    "group": "C__wamp_www_project_back_apidoc_seed_template_main_js",
    "groupTitle": "C__wamp_www_project_back_apidoc_seed_template_main_js",
    "name": ""
  },
  {
    "type": "get",
    "url": "admin/register",
    "title": "设备注册",
    "version": "1.0.0",
    "group": "deviceMs",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "account",
            "description": "<p>机器编码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功返回结果:",
          "content": "{\n  \"next_ms_code\": \"0000000\",//下一个设备编码\n  \"last_expire_time\": \"9\",//上个设备到该设备的有效时长\n  \"stay\": \"10\"//该设备最多停留时间\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败返回结果：",
          "content": "{\n  \"msg\": \"注册失败\",\n  \"code\": 0\n}\n{\n \"msg\": \"该编码已经被注册\",\n \"code\": 1\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc-seed/api1.0.0.js",
    "groupTitle": "deviceMs",
    "name": "GetAdminRegister"
  }
] });
