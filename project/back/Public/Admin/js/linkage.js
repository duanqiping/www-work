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


    //$("#deptId").change(function(){
    //    getGrade();
    //});
    //
    //$("#gradeId").change(function(){
    //    getClass();
    //});

    //getDept();
    //function getDept()
    //{
    //    //alert('hello');
    //    $.getJSON(ajaxurldept, function(data) {
    //        $("<option></option>?").text('系别').appendTo($("#deptId"));
    //        $.each(data, function(i, item) {
    //            $("<option></option>").val(item['dept']).text(item['dept']).appendTo($("#deptId"));
    //        });
    //        //getGrade();
    //    });
    //}
    //function getGrade()
    //{
    //    $("#gradeId").empty();
    //    $.getJSON(ajaxurlgrade,  {dept:$("#deptId").val()}, function(data) {
    //        $("<option></option>?").text('年级').appendTo($("#gradeId"));
    //        $.each(data, function(i, item) {
    //            $("<option></option>").val(item['grade']).text(item['grade']).appendTo($("#gradeId"));
    //        });
    //        getClass();
    //    });
    //}
    //
    //function getClass()
    //{
    //    $("#classId").empty();
    //    $.getJSON(ajaxurlclass,  {grade:$("#gradeId").val()}, function(data) {
    //        $("<option></option>?").text('班级').appendTo($("#classId"));
    //        $.each(data, function(i, item) {
    //            $("<option></option>").val(item['class']).text(item['class']).appendTo($("#classId"));
    //        });
    //    });
    //}


});