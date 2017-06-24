 /**
 * @api {get} v1/home/user/getCheckCode 用户注册 获取验证码
 * @apiVersion 1.0.0

 * @apiGroup user

 *@apiParam {String} mobile 手机号
 *@apiParam {String} type type=1注册 type=2忘记密码

 * @apiSuccessExample {json} 成功返回结果:
 *{
 *   "msg": "验证码发送成功"
 *}
 * @apiErrorExample {json} 失败返回结果：
 *{
 *   "msg": "手机号码不规范",
 *   "code": 0
 *}
 **/

 /**
  * @api {get} v1/home/user/CheckCode 用户注册 校验验证码
  * @apiVersion 1.0.0

  * @apiGroup user

  *@apiParam {String} mobile 手机号
  *@apiParam {String} type type=1注册 type=2忘记密码
  *@apiParam {String} checkcode 验证码

  * @apiSuccessExample {json} 成功返回结果:
  *{
 *   "msg": "验证码校验通过"
 *}
  * @apiErrorExample {json} 失败返回结果：
  *{
  *  "msg": "手机号未获取验证码",
  *  "code": 0
  *}
  **/

 /**
  * @api {post} v1/home/user/reg 用户注册
  * @apiVersion 1.0.0

  * @apiGroup user

  *@apiParam {String} mobile 手机号
  *@apiParam {String} passwd 密码
  *@apiParam {String} sex 1男 2女

  * @apiSuccessExample {json} 成功返回结果:
  *{
  *  "user_id": "8",
  *  "is_check": "1",
  *  "account": "17701804870",
  *  "nick": "17701804870",
  *  "img": "",
  *  "email": "",
  *  "sex": "1"
*}
  * @apiErrorExample {json} 失败返回结果：
  *{
  * "msg": "用户注册失败",
  *  "code": 1
  *}
  **/

 /**
  * @api {post} v1/home/user/login 登陆
  * @apiVersion 1.0.0

  * @apiGroup user

  *@apiParam {String} mobile 手机号
  *@apiParam {String} passwd 密码

  * @apiSuccessExample {json} 成功返回结果:
  *{
  *  "user_id": "8",
  *  "is_check": "1",
  *  "account": "17701804870",
  *  "nick": "17701804870",
  *  "img": "",
  *  "email": "",
  *  "sex": "1"
*}
  * @apiErrorExample {json} 失败返回结果：
  *{
  * "msg": "用户名密码不匹配",
  *  "code": 1
  *}
  **/

 /**
  * @api {get} v1/home/user/logout 退出
  * @apiVersion 1.0.0
  * @apiGroup user
  * @apiSuccessExample {json} 成功返回结果:
  *{
 *   "msg": "退出成功"
*}
  **/

 /**
  * @api {post} v1/home/user/uploadImg 上传头像
  * @apiVersion 1.0.0

  * @apiGroup user

  *@apiParam {file} img 头像

  * @apiSuccessExample {json} 成功返回结果:
  *{
  *   "msg": "http:\\/\\/192.168.0.118\\/Guest\\/upload\\/photo\\/17701804876\\/17701804876head.png"
 *}
  * @apiErrorExample {json} 失败返回结果：
  *{
  * "msg": "上传失败",
  *  "code": 1
  *}
  **/

 /**
  * @api {post} v1/home/user/modifyInfo 修改信息
  * @apiVersion 1.0.0

  * @apiGroup user

  *@apiParam {string} nick 昵称

  * @apiSuccessExample {json} 成功返回结果:
  *{
   * "user_id": "14",
   * "is_check": "1",
   * "account": "17701804876",
   * "nick": "段齐平22",
   * "img": "http:\\/\\/192.168.0.118\\/Guest\\/upload\\/photo\\/17701804876\\/17701804876head.png",
   * "email": "",
   * "sex": "1"
*}
  * @apiErrorExample {json} 失败返回结果：
  *{
  * "msg": "修改个人资料失败",
  *  "code": 1
  *}
  **/