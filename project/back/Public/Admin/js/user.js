/**
 * Created by Administrator on 2017/8/24.
 */
//dom加载完成后执行的js
;$(function(){

    if(school_type == 1){
        getDepts();//获取系别 (大学)
    }else{
        getGrades();//获取年级 （中学）
        getClasses();//获取班级 （中学）
    }

    $("#deptId2").change(function(){
        getGrades();//获取年级
        getClasses();//获取班级
    });

    //获取班级
    function getClasses()
    {
        $("#classId2").empty();
        $.getJSON(getClass,{"dept":$("#deptId2").val()}, function(data) {
            $.each(data, function(i, item) {
                if(item){
                    $("<option></option>").text(item).appendTo($("#classId2"));
                }
            });
        });
    }

    //获取年级
    function getGrades()
    {
        $("#gradeId2").empty();

        $.getJSON(getGrade,{"dept":$("#deptId2").val()}, function(data) {
            $.each(data, function(i, item) {
                if(item != 0 && item != null){
                    for(var j=1;j<=item;j++){
                        $("<option></option>").text(j).appendTo($("#gradeId2"));
                    }
                }
            });
        });
    }

    //获取系别
    function getDepts()
    {
        $("#deptId2").empty();

        $.getJSON(getDept, function(data) {
            $.each(data, function(i, item) {
                if(item){
                    $("<option></option>").text(item['dept_name']).appendTo($("#deptId2"));
                }
            });
        });
    }
});