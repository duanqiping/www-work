//实现联动效果的js
$(document).ready(function(){

    $("#deptId").change(function(){
        url = returnUrl();
        location.href = url;//location.href实现客户端页面的跳转
    });
    $("#gradeId").change(function(){
        url = returnUrl();
        location.href = url;//location.href实现客户端页面的跳转
    });
    $("#classId").change(function(){
        url = returnUrl();
        location.href = url;//location.href实现客户端页面的跳转
    });
    $("#sexId").change(function(){
        url = returnUrl();
        location.href = url;//location.href实现客户端页面的跳转
    });

    function returnUrl()
    {
        var Dept=$("#deptId").find("option:selected").text();
        var Grade=$("#gradeId").find("option:selected").text();
        var Class=$("#classId").find("option:selected").text();
        var Sex=$("#sexId").find("option:selected").text();

        var url = indexurl.replace(/.html/, "");

        if(Dept != '系别' && Dept != '不限'){
            url = url+"/dept/"+Dept;
        }
        if(Grade != '年级' && Grade != '不限'){
            url = url+"/grade/"+Grade;
        }
        if(Class != '班级' && Class != '不限' ){
            url = url+"/class/"+Class;
        }
        if(Sex != '性别' && Sex != '不限'){
            url = url+"/sex/"+Sex;
        }
        url = url.replace(/\s/g,"");//去除文章中间空格

        return url;
    }

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
});