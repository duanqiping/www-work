 /**
 * @api {get} admin/register 设备注册
 * @apiVersion 1.0.0

 * @apiGroup master

 *@apiParam {String} account 机器编码
  *
 * @apiSuccessExample {json} 成功返回结果:
 *{
 *   "next_ms_code": "0000000",//下一个设备编码
 *   "last_ms_code": "0000002",//上一个设备编码
 *   "last_expire_time": "9",//上个设备到该设备的有效时长
 *   "stay": "10"//该设备最多停留时间
*}
 * @apiErrorExample {json} 失败返回结果：
 *{
 *   "msg": "注册失败",
 *   "code": 0
 *}
  * {
  *  "msg": "该编码已经被注册",
  *  "code": 1
*}
 **/

 /**
  * @api {post} master/add 录入成绩
  * @apiVersion 1.0.0

  * @apiGroup master

  *@apiParam {String} user_id 用户id
  *@apiParam {String} begin_time 一圈的起始时间
  *@apiParam {String} end_time 一圈的结束时间
  *@apiParam {String} time 用时
  *@apiParam {String} customer_id 客户id
  *@apiParam {String} mode 1训练 2比赛
  *@apiParam {String} flag 一次成绩的起始时间(用于标记)
  *
  * @apiSuccessExample {json} 成功返回结果:
  *{
 *   "msg": "success",
*}
  * @apiErrorExample {json} 失败返回结果：
  *{
 *   "msg": "fail",
 *   "code": 0
 *}
  **/

 /**
  * @api {get} master/getUserInfo 获取用户信息
  * @apiVersion 1.0.0

  * @apiGroup master

  *@apiParam {String} code 手环编码
  *
  * @apiSuccessExample {json} 成功返回结果:
  *{
  *  "name": "段齐平",
  *  "user_id": "1"
  *}
  * @apiErrorExample {json} 失败返回结果：
  *{
  *  "msg": "该用户尚未注册或未绑定手环",
  *  "code": 1
  *}
  **/

