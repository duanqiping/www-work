$(document).ready(function(){
    getSection();

    $("#sectionid").change(function(){
        getCatid();
    });

    function getSection()
    {
        //$.getJSON("{:U('getSection')}", function(data) {
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
        //$.getJSON("{:U('getCatid')}",  {dept:$("#sectionid").val()}, function(data) {
        $.getJSON(ajaxurlclass,  {dept:$("#sectionid").val()}, function(data) {
            $("<option></option>?").text('--班级--').appendTo($("#catid"));
            $.each(data, function(i, item) {
                $("<option></option>").val(item['class']).text(item['class']).appendTo($("#catid"));
            });
        });
    }


});
