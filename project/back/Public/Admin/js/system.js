//dom加载完成后执行的js
;$(function(){

    //alert(school_type);

    if(school_type == 1){
        getDepts();//获取系别 (大学)
    }else{
        getGrades();//获取年级 （中学）
        getClasses();//获取班级 （中学）
    }

    $("#deptId").change(function(){
        getGrades();//获取年级
        getClasses();//获取班级
    });

    $("#customer_type").change(function(){
       var customer_type = $(this).val();

        if(customer_type == 2){
            $(".school").hide();
            $(".school input").attr("checked",false);
        }else{
            $(".school").show();
        }
    });
    //添加班级
    $("#add_class").click(function(){
        var classObj = $("#class");
        $.getJSON(addClass, {"class":classObj.val(),'dept':$("#deptId").val()}, function(data) {
            $.each(data, function(i, item) {
                if(item){
                    alert(item);
                }
            });
        });
        classObj.val('');//置空输入框
        getClasses();
    });
    //获取班级
    function getClasses()
    {
        $("#classId").empty();
        $.getJSON(getClass,{"dept":$("#deptId").val()}, function(data) {
            $.each(data, function(i, item) {
                if(item){
                    $("<option></option>").text(item).appendTo($("#classId"));
                }
            });
        });
    }
    //添加年级
    $("#add_grade").click(function(){
        var gradeObj = $("#grade");//年级 input 对象
        $.getJSON(addGrade, {"grade":gradeObj.val(),'dept':$("#deptId").val(),'school_type':school_type}, function(data) {
            $.each(data, function(i, item) {
                if(item){
                    alert(item);
                }
            });
        });
        gradeObj.val('');//置空输入框
        getGrades();
    });
    //获取年级
    function getGrades()
    {
        $("#gradeId").empty();
        $("#div_grade").hide();
        $.getJSON(getGrade,{"dept":$("#deptId").val()}, function(data) {
            $.each(data, function(i, item) {
                if(item != 0 && item != null){
                    for(var j=1;j<=item;j++){
                        $("<option></option>").text(j).appendTo($("#gradeId"));
                    }
                }else{
                    $("#div_grade").show();
                }
            });
        });
    }

    //添加系别
    $("#add_dept").click(function(){
        var deptObj = $("#dept");
        $.getJSON(addDept, {"dept":deptObj.val(),'school_type':school_type}, function(data) {
            $.each(data, function(i, item) {
                if(item){
                    alert(item);
                }
            });
        });
        deptObj.val('');//置空输入框
        getDepts();
    });
    //获取系别
    function getDepts()
    {
        $("#deptId").empty();
        $("#div_grade").hide();
        $.getJSON(getDept, function(data) {
            $.each(data, function(i, item) {
                if(item){
                    $("<option></option>").text(item['dept_name']).appendTo($("#deptId"));
                }
            });
        });
    }
});