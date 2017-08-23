//dom加载完成后执行的js
;$(function(){
    getDepts();//获取系别

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
        //var grade = $("#grade").val();
        //alert($("#class").val());

        $.getJSON(addClass, {"class":$("#class").val(),'dept':$("#deptId").val()}, function(data) {

            $.each(data, function(i, item) {
                if(item){
                    alert(item);
                }
            });
        });
        $("#class").val('');//置空输入框
        getClasses();
    });
    //获取班级
    function getClasses()
    {
        $("#classId").empty();
        //$("#div_grade").hide();
        $.getJSON(getClass,{"dept":$("#deptId").val()}, function(data) {

            $.each(data, function(i, item) {

                if(item){
                    $("<option></option>").text(item).appendTo($("#classId"));
                }else{
                    //$("#div_grade").show();
                }
            });
        });
    }

    $("#add_grade").click(function(){
        //var grade = $("#grade").val();

        $.getJSON(addGrade, {"grade":$("#grade").val(),'dept':$("#deptId").val()}, function(data) {

            $.each(data, function(i, item) {
                if(item){
                    alert(item);
                }
            });
        });
        $("#grade").val('');//置空输入框
        getGrades()();
    });

    function getGrades()
    {
        $("#gradeId").empty();
        $("#div_grade").hide();
        $.getJSON(getGrade,{"dept":$("#deptId").val()}, function(data) {

            $.each(data, function(i, item) {

                if(item != 0){
                    for(var j=1;j<=item;j++){
                        $("<option></option>").text(j).appendTo($("#gradeId"));
                    }
                }else{
                    $("#div_grade").show();
                }
            });
        });
    }

    $("#add_dept").click(function(){
        var dept = $("#dept").val();

        $.getJSON(addDept, {"dept":dept}, function(data) {

            $.each(data, function(i, item) {
                if(item){
                    alert(item);
                }
            });
        });
        $("#dept").val('');//置空输入框
        getDepts();
    });
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