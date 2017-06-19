    function check(obj){ 
		if (obj.id=='num_1'){
			if (!obj.checked){
				$("#one").css("display","none");
				$("#two").css("display","block");
				document.getElementById('num_2').checked = true;
				$("#datatype").val("1");
			}else{
				$("#one").css("display","block");
				$("#two").css("display","none");
				document.getElementById('num_2').checked = false;
				$("#datatype").val("0");
			}
		}else{
			if (!obj.checked){
				$("#one").css("display","block");
				$("#two").css("display","none");
				document.getElementById('num_1').checked = true;
				$("#datatype").val("0");
			}else{
				$("#one").css("display","none");
				$("#two").css("display","block");
				document.getElementById('num_1').checked = false;
				$("#datatype").val("1");
			}
		}
	}
$(function(){
	//只能填数字
	$("input:text").live("keyup",function(){//^[0-9]*[1-9][0-9]*$
//		var v =/^0{1}([.]\d{1,2})?$|^[1-9]\d*([.]{1}[0-9]{1,2})?$/;
//		 if(!v.test($(this).val())){
//			 $(this).val("");
//		 }
//		if($(this).val().match(new RegExp("^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$ ")) == null){
//			$(this).val("");
//		}
	});
	
$(".door_2").live("click",function (){
     $(this).parent().remove()
}); 

$(".window_2").live("click",function (){
     $(this).parent().remove()
}); 
		
$(".btn1").click(function(){
	if(!$(".room_1").is(':visible')){
		$(".room_1").show();
	}else{
		$(".room_1").hide();
	}
});
$ ('.add_door').click (function (){
	if($(".door").length < "100"){
	   $ ('#ad').append('<div  class="door" ><div class="door_1">门</div><input class="in_1 _doorw" type="text" placeholder="宽度" /><input class="in_2 _doorh" type="text" placeholder="高度" /><div class="door_2">-</div></div>');
	}
});   

$ ('.add_window').click (function (){
	if($(".window").length < "100"	){
	   $ ('#ad2').append('<div  class="window" ><div class="window_1">窗</div><input class="in_1 _windoww" type="text" placeholder="宽度" /><input class="in_2 _windowh" type="text" placeholder="高度" /><div class="window_2">-</div></div>');
	 }
});   
         
$("#submit").click(function(){
	var homeType = $("#hometype").val();//房间类型
	var dataType = $("#datatype").val();//数据类型 0 长宽高 1周长面积
	var homeData = new Array();//房间
	var doorData = new Array();//门
	var windowData = new Array();//窗
	var res = true;
	$(".homeP"+dataType).each(function(index,element){
		if($(this).val()==""){
			res = false;
		}
		homeData.push($(this).val());
	});
	if(!res){
		alert("请填写完整的房间信息");
		return;
	}
	console.log(homeData);
	
	$(".door").each(function(){
		var door = [0,0];
		door[0] = $(this).children("._doorw").val();
		door[1] = $(this).children("._doorh").val();
		if(door[0]=="" || door[1]==""){
			return true;//跳出本次循环
		}
		doorData.push(door);
	});
	console.log(doorData);
	
	$(".window").each(function(){
		var window = [0,0];
		window[0] = $(this).children("._windoww").val();
		window[1] = $(this).children("._windowh").val();
		if(window[0]=="" || window[1]==""){
			return true;//跳出本次循环
		}
		windowData.push(window);
	});
	console.log(windowData);
	if(doorData.length<=0){
		doorData = "";
	}
	if(windowData.length<=0){
		windowData = "";
	}
	$.ajax({
		type:"post",
		dataType:"json",
		async:"false",
		url:"http://aec188.com/hcWeb/handle/getList.php",
		data:{
			HomeType:homeType,
			DataType:dataType,
			HomeData:homeData,
			DoorData:doorData,
			WindowData:windowData
		},
		success:function(data){
			//alert(JSON.stringify(data.code));
			$(".mlist").append(data.param);
			$(".plist").append(data.msg);
		},
		error:function(){
			alert("err");
		}
	});
});	
	
})