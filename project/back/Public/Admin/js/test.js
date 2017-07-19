/**
 * Created by Administrator on 2017/7/18.
 */
new Vue({
    el: '#example-7',
    data: {
        selected: 'A',
        options: [
            { text: 'One', value: 'A' },
            { text: 'Two', value: 'B' },
            { text: 'Three', value: 'C' }
        ]
    }
});
$(document).ready(function(){
    getSection();

    $("#sectionid").change(function(){
        getCatid();
    });

    function getSection()
    {
        $.getJSON("__URL__/getSection", function(data) {
            $.each(data, function(i, item) {
                $("<option></option>").val(item['user_id']).text(item['dept']).appendTo($("#sectionid"));
            });
            getCatid();
        });
    }
    function getCatid()
    {
        $("#catid").empty();
        $.getJSON("__URL__/getCatid",  {id:$("#sectionid").val()}, function(data) {
            $.each(data, function(i, item) {
                $("<option></option>").val(item['user_id']).text(item['dept']).appendTo($("#catid"));
            });

        });
    }
});