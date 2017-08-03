 /**
 * @api {get} master/register 设备注册
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
 *   "customer_id": "31",//客户id
 *   "isPoint": "1"// 0经过点 1起点
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

 /**
  * @api {get} master/getContest 获取赛事名单
  * @apiVersion 1.0.0

  * @apiGroup master

  *@apiParam {String} contest_sn 赛事编码
  *@apiParam {String} customer_id 客户id号
  *
  * @apiSuccessExample {json} 成功返回结果:
  *{
  *  "list": [
  *      {
  *          "classRoom": "航天一班",
  *          "name": "王猛",
  *          "studentId": "764676",
  *          "label": "5"
  *          "endMachine": "0000113",
  *          "length": "1500",
  *          "sex": "1",
  *          "circle": "4"
  *      },
  *      {
  *          "classRoom": "航天一班",
  *          "name": "上官云",
  *          "studentId": "764676",
  *          "label": "5",
  *          "endMachine": "0000114",
  *          "length": "1000",
  *          "sex": "2",
  *          "circle": "3"
  *      }
  *  ],
  *  "customer_id": "31",
  *  "title": "上海交通大学夏季运动会",
  *  "content": "运动与健康",
  *  "is_again": 0, //0非重考 1重考
  *}
  *}
  **/

 /**
  * @api {post} master/addContest 成绩录入(考试\赛事)
  * @apiVersion 1.0.0

  * @apiGroup master

  *@apiParam {String} user_id 用户id
  *@apiParam {String} begin_time 开始时间
  *@apiParam {String} end_time  结束时间
  *@apiParam {String} time 用时
  *@apiParam {String} customer_id 客户id号
  *@apiParam {String} mode 1考试 2赛事
  *@apiParam {String} contest_sn 赛事编码
  *@apiParam {String} is_again 是否为重考 0否 1是
  *
  * @apiSuccessExample {json} 成功返回结果:
  *{"msg":"success"}
  * @apiErrorExample {json} 失败返回结果：
  *{
  *  "msg": "该同学成绩已经存在",
  *  "code": 1
  *}
  **/

 /**
  * @api {get} master/getContestScore 获取比赛成绩
  * @apiVersion 1.0.0

  * @apiGroup master

  *@apiParam {String} customer_id 客户id号
  *@apiParam {String} contest_sn 赛事编码

  * @apiSuccessExample {json} 成功返回结果:
  *[
  *{
  *    "_id": 3,
  *    "user_id": "17",
  *    "time": 220,
  *    "sex": "2",
  *    "dept": "物理系",
  *    "grade": "1",
  *    "class": "航天一班",
  *    "name": "上官云",
  *    "studentId": "764676"
  *},
  *{
  *    "_id": 2,
  *    "user_id": "16",
  *    "time": 800,
  *    "sex": "2",
  *    "dept": "物理系",
  *    "grade": "4",
  *    "class": "航天一班",
  *    "name": "李四",
  *    "studentId": "7676"
  *}
  *]
  **/

