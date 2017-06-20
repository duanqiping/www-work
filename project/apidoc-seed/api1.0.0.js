 /**
 * @api {get} home/user/getCheckCode 用户注册 获取验证码
 * @apiVersion 1.0.0

 * @apiGroup user

 *@apiParam {String} mobile 手机号
 *@apiParam {String} type type=1注册 type=2忘记密码

 * @apiSuccessExample {json} 成功返回结果:
 *"验证码发送成功"
 * @apiErrorExample {json} 失败返回结果：
 *{
 *   "msg": "手机号码不规范",
 *   "code": 0
 *}
 *
 *
 **/

