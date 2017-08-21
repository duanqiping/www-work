//dom加载完成后执行的js
;$(function(){
    getSection();

    $("#customer_type").change(function(){
       var customer_type = $(this).val();

        if(customer_type == 2){
            $(".school").hide();
            $(".school input").attr("checked",false);
        }else{
            $(".school").show();
        }
    });
    $("#add_dept").click(function(){
        var dept = $("#dept").val();

        $.getJSON(addDept, {"dept":dept}, function(data) {

            $.each(data, function(i, item) {
                if(item){
                    alert(item);
                }
            });
        });
        $("#dept").val('');
    });

    function getSection()
    {
        $("<option></option>").text('系别').appendTo($("#deptId"));
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