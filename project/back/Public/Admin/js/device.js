/**
 * Created by Administrator on 2017/7/28.
 */

//省份--》城市--》类型--》客户
$(document).ready(function(){

    getCities();
    customerLoad();

    $("#typeId").change(function(){
        getCustomer();
    });

    //城市动态变化
    function getCities()
    {

        $.getJSON(ajaxurlcities,{province:$("#provinceId2").val()}, function(data) {
            if(city){
                $("<option></option>?").text(city).appendTo($("#cityId"));
            }else{
                $("<option></option>?").text('城市').appendTo($("#cityId"));
            }

            //$("<option></option>?").text($("#cityId").val()).appendTo($("#cityId"));
            $.each(data, function(i, item) {
                $("<option></option>").val(item['city']).text(item['city']).appendTo($("#cityId"));
            });
            //getCustomer();
        });
    }

    //客户动态变化
    function getCustomer()
    {
        $("#customerId").empty();

        $.getJSON(ajaxurlcustomer, {type:$("#typeId").val()}, function(data) {
            $("<option></option>?").text('客户').appendTo($("#customerId"));
            $.each(data, function(i, item) {
                $("<option></option>").val(item['name']).text(item['name']).appendTo($("#customerId"));
            });
        });
    }

    //客户加载变化
    function customerLoad()
    {
        if(customer_name){
            $("<option></option>?").text(customer_name).appendTo($("#customerId"));
        }else{
            $("<option></option>?").text('客户').appendTo($("#customerId"));
        }
    }

    $("#customerId").change(function(){
        var city = $('#cityId').val();//为获取agent_id (id是不变的)
        var type = $('#typeId').val();//类型
        var name = $('#customerId').val();//客户名 通过此可以获取到客户id(id是不变的)

        var url = indexUrl.replace(/.html/, "");

        location.href = url+"/city/"+city+"/type/"+type+"/name/"+name;//location.href实现客户端页面的跳转
    });

    $("#addDevice").click(function(){
        var DeviceNum=prompt("请输入设备的个数");

        //alert(addDeviceUrl);
        //alert(customer_id);

        $.getJSON(addDeviceUrl, {customer_id:customer_id,agent_id:agent_id,DeviceNum:DeviceNum}, function(data) {

            $.each(data, function(i, item) {

                if(item){
                    var city = $('#cityId').val();//为获取agent_id (id是不变的)
                    var type = $('#typeId').val();//类型
                    var name = $('#customerId').val();//客户名 通过此可以获取到客户id(id是不变的)

                    var url = indexUrl.replace(/.html/, "");

                    location.href = url+"/city/"+city+"/type/"+type+"/name/"+name;//location.href实现客户端页面的跳转
                }else{
                    alert('添加失败');
                }

                //$("<option></option>").val(item['name']).text(item['name']).appendTo($("#customerId"));
            });
        });
    });

});