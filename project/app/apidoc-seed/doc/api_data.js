define({ "api": [
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p> "
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./apidoc/main.js",
    "group": "C__Users_qiping_Desktop_apidoc_seed_apidoc_main_js",
    "groupTitle": "C__Users_qiping_Desktop_apidoc_seed_apidoc_main_js",
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
            "description": "<p>No type.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p> "
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./doc/main.js",
    "group": "C__Users_qiping_Desktop_apidoc_seed_doc_main_js",
    "groupTitle": "C__Users_qiping_Desktop_apidoc_seed_doc_main_js",
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
            "description": "<p>No type.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p> "
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./template/main.js",
    "group": "C__Users_qiping_Desktop_apidoc_seed_template_main_js",
    "groupTitle": "C__Users_qiping_Desktop_apidoc_seed_template_main_js",
    "name": ""
  },
  {
    "type": "post",
    "url": "AskPriceApi/invitation.php",
    "title": "注册",
    "version": "1.1.3",
    "name": "__",
    "group": "User",
    "permission": [
      {
        "name": "everyone"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>1或者2</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "msg",
            "description": "<p>temp_buyers_password 密码</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4113",
            "description": "<p>用户注册失败</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4800",
            "description": "<p>密码长度至少为6位</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4801",
            "description": "<p>密码不能为空</p> "
          }
        ]
      }
    },
    "filename": "./api_user/api1.1.3.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://12seds1.40.239.22/pcwstore/AskPriceApi/invitation.php"
      }
    ]
  },
  {
    "type": "post",
    "url": "AskPriceApi/login.php",
    "title": "登录",
    "version": "1.1.5",
    "name": "_____",
    "group": "User",
    "permission": [
      {
        "name": "everyone"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "act",
            "defaultValue": "login",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "temp_buyers_mobile",
            "description": "<p>手机号</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "msg",
            "description": "<p>true</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4800",
            "description": "<p>手机号必须存在</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4801",
            "description": "<p>手机号格式不正确</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4802",
            "description": "<p>密码不能为空</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4803",
            "description": "<p>用户不存在</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4804",
            "description": "<p>用户名密码不匹配!</p> "
          }
        ]
      }
    },
    "filename": "./api_user/api1.1.5.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://12seds1.40.239.22/pcwstore/AskPriceApi/login.php"
      }
    ]
  },
  {
    "type": "post",
    "url": "AskPriceApi/forgetpassword.php",
    "title": "忘记密码",
    "version": "1.1.4",
    "name": "_____",
    "group": "User",
    "permission": [
      {
        "name": "everyone"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "temp_buyers_password",
            "description": "<p>密码</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "new_password",
            "description": "<p>旧密码</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "msg",
            "description": "<p>密码修改成功</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4800",
            "description": "<p>密码不能为空</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4801",
            "description": "<p>密码长度至少为6位</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4803",
            "description": "<p>密码修改失败</p> "
          }
        ]
      }
    },
    "filename": "./api_user/api1.1.4.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://12seds1.40.239.22/pcwstore/AskPriceApi/forgetpassword.php"
      }
    ]
  },
  {
    "type": "post",
    "url": "AskPriceApi/invitation.php",
    "title": "验证邀请码",
    "version": "1.1.2",
    "name": "_____",
    "group": "User",
    "permission": [
      {
        "name": "everyone"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "invitation",
            "description": "<p>邀请码</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "msg",
            "description": "<p>邀请码正确</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4800",
            "description": "<p>邀请码不存在</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4801",
            "description": "<p>手机号码不规范</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4802",
            "description": "<p>用户已注册</p> "
          }
        ]
      }
    },
    "filename": "./api_user/api1.1.2.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://12seds1.40.239.22/pcwstore/AskPriceApi/invitation.php"
      }
    ]
  },
  {
    "type": "post",
    "url": "AskPriceApi/GetCheckCode.php",
    "title": "获取验证码",
    "version": "1.1.1",
    "name": "_____",
    "group": "User",
    "permission": [
      {
        "name": "everyone"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>1或者2</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "msg",
            "description": "<p>&quot;验证码发送成功</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4800",
            "description": "<p>type必须存在</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4801",
            "description": "<p>type必须为1或2</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4802",
            "description": "<p>手机号必须存在</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4803",
            "description": "<p>手机号格式不正确</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4804",
            "description": "<p>用户已注册</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4805",
            "description": "<p>用户不存在</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4806",
            "description": "<p>时间间隔太小，请1分钟后再申请</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4807",
            "description": "<p>短信今天已经发了6次，请明天再申请</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4808",
            "description": "<p>数据来源有误！请从本站提交！</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4809",
            "description": "<p>&quot;检验验证码失败</p> "
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "4810",
            "description": "<p>验证码发送失败</p> "
          }
        ]
      }
    },
    "filename": "./api_user/api1.1.1.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://12seds1.40.239.22/pcwstore/AskPriceApi/GetCheckCode.php"
      }
    ]
  }
] });