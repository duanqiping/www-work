/**
 * Created by Administrator on 2017/7/28.
 */
$(document).ready(function(){
    getCities();

    $("#cityId").change(function(){
        getCustomer();
    });

    function getCities()
    {
        $.getJSON(ajaxurlcities, function(data) {
            $("<option></option>?").text('--城市--').appendTo($("#cityId"));
            $.each(data, function(i, item) {
                $("<option></option>").val(item['city']).text(item['city']).appendTo($("#cityId"));
            });
            getCustomer();
        });
    }
    function getCustomer()
    {
        $("#catid").empty();
        $.getJSON(ajaxurlcustomer,  {dept:$("#cityId").val()}, function(data) {
            $("<option></option>?").text('--客户--').appendTo($("#catid"));
            $.each(data, function(i, item) {
                $("<option></option>").val(item['customer']).text(item['customer']).appendTo($("#catid"));
            });
        });
    }


});