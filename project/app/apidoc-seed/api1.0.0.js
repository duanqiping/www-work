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

 /**
  * @api {get} v1/home/rank/location 客户地理位置信息
  * @apiVersion 1.0.0

  * @apiGroup rank

  * @apiSuccessExample {json} 成功返回结果:
  *[
  *{
  *    "customer_id": "15",
  *    "name": "维也纳酒店",
  *    "length": "400",
  *    "longitude_y": "121.5072970945",
  *    "latitude_x": "30.9051522416"
  *    "cycles": [
  *          "1",
  *          "2",
  *          "3",
  *          "4",
  *          "5"
  *      ]
  *},
  *{
  *    "customer_id": "16",
  *    "name": "东奉大酒店",
  *    "length": "200",
  *    "longitude_y": "121.5045397836",
  *    "latitude_x": "30.9080152914"
  *    *    "cycles": [
  *          "2",
  *          "4",
  *          "6",
  *          "8",
  *          "10"
  *      ]
  *}
  *]
  **/

 /**
  * @api {get} v1/home/rank/nearby 最近的一个客户
  * @apiVersion 1.0.0

  * @apiGroup rank
  *
  * @apiParam {String} latitude_x 纬度
  * @apiParam {String} longitude_y 经度

  * @apiSuccessExample {json} 成功返回结果:
  *{
  *    "customer_id": "16",
  *    "name": "东奉大酒店",
  *    "longitude_y": "121.5045397836",
  *    "latitude_x": "30.9080152914"
  *}
  **/

 /**
  * @api {get} v1/home/rank/rank 成绩排行
  * @apiVersion 1.0.0

  * @apiGroup rank
  *
  * @apiParam {String} customer_id 客户id
  * @apiParam {String} cycles 圈数
  * @apiParam {String} flag week(当周)month(当月)year(当年)
  * @apiParam {String} page 页数
  * @apiParam {String} pageSize 每页大小

  * @apiSuccessExample {json} 成功返回结果:
  *[
  *{
  *    "rank_id": "10",
  *    "user_id": "222",
  *    "customer_id": "14",
  *    "score_id": "36",
  *    "cycles": "1",
  *    "time": "222",
  *    "add_time": "1498654279"
  *},
  *{
  *    "rank_id": "8",
  *    "user_id": "111",
  *    "customer_id": "14",
  *    "score_id": "34",
  *    "cycles": "1",
  *    "time": "1231548",
  *    "add_time": "1498395075"
  *}
  *]
  **/