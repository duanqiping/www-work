 /**
 * @api {get} admin/register 设备注册
 * @apiVersion 1.0.0

 * @apiGroup deviceMs

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


