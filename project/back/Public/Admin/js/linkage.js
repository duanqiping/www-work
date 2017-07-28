//实现联动效果的js
$(document).ready(function(){
    getSection();

    $("#sectionid").change(function(){
        getCatid();
    });

    function getSection()
    {
        $.getJSON(ajaxurldept, function(data) {
            $("<option></option>?").text('--系别--').appendTo($("#sectionid"));
            $.each(data, function(i, item) {
                $("<option></option>").val(item['dept']).text(item['dept']).appendTo($("#sectionid"));
            });
            getCatid();
        });
    }
    function getCatid()
    {
        $("#catid").empty();
        $.getJSON(ajaxurlclass,  {dept:$("#sectionid").val()}, function(data) {
            $("<option></option>?").text('--班级--').appendTo($("#catid"));
            $.each(data, function(i, item) {
                $("<option></option>").val(item['class']).text(item['class']).appendTo($("#catid"));
            });
        });
    }


});

////按钮效果
//function clickRank(flag)
//{
//    alert(flag);
//}
$("#week").change( function () {
    var checkText=$("#week").find("option:selected").text();
    var url = rankUrl.replace(/.html/, "");
    checkText = checkText.replace(/圈/, "");
    location.href = url+"/flag/week/cycles/"+checkText;//location.href实现客户端页面的跳转
} );

$("#month").change( function () {
    var checkText=$("#month").find("option:selected").text();
    var url = rankUrl.replace(/.html/, "");
    checkText = checkText.replace(/圈/, "");
    location.href = url+"/flag/month/cycles/"+checkText;//location.href实现客户端页面的跳转
} );

$("#year").change( function () {
    var checkText=$("#year").find("option:selected").text();
    var url = rankUrl.replace(/.html/, "");
    checkText = checkText.replace(/圈/, "");
    location.href = url+"/flag/year/cycles/"+checkText;//location.href实现客户端页面的跳转
} );

$("#marathon").change( function () {
    var checkText=$("#marathon").find("option:selected").text();
    var url = rankUrl.replace(/.html/, "");
    if(checkText == '四分之一程马拉松'){
        checkText = 26;
    }else if(checkText == '半程马拉松'){
        checkText = 52;
    }else{
        checkText = 105;
    }

    //checkText = checkText.replace(/圈/, "");
    location.href = url+"/flag/marathon/cycles/"+checkText;//location.href实现客户端页面的跳转
} );