//dom加载完成后执行的js
;$(function(){
    getDepts();//获取系别

    $("#deptId").change(function(){
        getGrades();//获取年级
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
    });
    function getDepts()
    {
        $("#div_grade").hide();
        $.getJSON(getDept, function(data) {

            $.each(data, function(i, item) {
                if(item){
                    //$("<option></option>").val(item['dept_name']).text(item['dept_name']).appendTo($("#deptId"));
                    $("<option></option>").text(item['dept_name']).appendTo($("#deptId"));
                }
            });
        });
    }
});