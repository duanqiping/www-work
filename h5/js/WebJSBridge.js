/*!
 *   2015.9.21 SenPng
 */

var WebJSBridge = (function(obj) {

    /**
     * 分享
     * @param  {string} title
     * @param  {string} content
     * @param  {string} url
     * @param  {string} icon
     */
    obj.share = function(title, content, url, icon) {
        console.log(arguments);
    };

    /**
     * 充值
     * @param  {string} money
     */
    obj.recharge = function(money) {
        console.log(arguments);
    };

    obj.recharge2 = function(money, method) {
        console.log(arguments);
    };

    obj.openAppStore = function(identifier) {
        console.log(arguments);
    };

    return obj;
})(WebJSBridge || {});