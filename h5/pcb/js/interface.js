var WebJSBridge = (function(obj) {
	obj.getToken = function() {
		//alert(1);
		console.log(arguments);
	};
	obj.openProductList = function() {
		// alert("请下载找材猫客户端");
		window.location.href = "http://b2b.pcw365.com/"

	};

	return obj;
})(WebJSBridge || {});