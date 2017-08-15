//dom加载完成后执行的js
;$(function(){
    $("#year2 li a").click(function(){
        $('#select_single').remove();

        var year = $(this).text();
        var year2 = $('#select_year').text();

        if(!year2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_year" style="color: red">'+year+'年</a></li>');
        }else{
            $("#select_year").text(year+'年');
        }
    });

    $("#month2 li a").click(function(){
        $('#select_single').remove();

        var month = $(this).text();
        var month2 = $('#select_month').text();
        var week = $('#select_week').text();
        if(week){
            $('#select_week').remove();//月和周条件只能选一个
        }

        if(!month2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_month" style="color: red">'+month+'月</a></li>');
        }else{
            $("#select_month").text(month+'月');
        }

    });
    $("#week2 li a").click(function(){
        $('#select_single').remove();

        var week = $(this).text();
        var week2 = $('#select_week').text();

        var month = $('#select_month').text();
        if(month){
            $('#select_month').remove();//月和周条件只能选一个
        }

        if(!week2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_week" style="color: red">'+week+'周</a></li>');
        }else{
            $("#select_week").text(week+'周');
        }
    });
    $("#length li a").click(function(){
        $('#select_single').remove();

        var length = $(this).text();
        var length2 = $('#select_length').text();

        if(!length2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_length" style="color: red">'+length+'</a></li>');
        }else{
            $("#select_length").text(length);
        }
    });
    $("#single2 li a").click(function(){

        $('#select_year').remove();
        $('#select_month').remove();
        $('#select_week').remove();
        $('#select_length').remove();

        var single = $(this).text();
        var single2 = $('#select_single').text();

        if(!single2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_single" style="color: red">'+single+'</a></li>');
        }else{
        }
    })

    //点击搜索
    $("#selectCondition li a").click(function(){
        var condition = {};//参数自定义

        var single = $('#select_single').text();//获取周历史最佳
        if(single)
        {
            condition.single = single;
        }
        else
        {
            var year = $('#select_year').text();//获取所选年份
            var month = $('#select_month').text();//获取所选月份
            var week = $('#select_week').text();//获取所选周份
            var length = $('#select_length').text();//获取所选长度

            var reg = /[1-9][0-9]*/g;//取出数字正则
            year = year.match(reg);
            if(year) condition.year = year[0];
            month = month.match(reg);
            if(month) condition.month = month[0];
            week = week.match(reg);
            if(week) condition.week = week[0];
            if(length) condition.length = length;
        }

        console.log(condition);
        $.getJSON(getRank, condition, function(data) {

            $("#rank_table  tbody tr").remove();//移除之前的内容

            $.each(data, function(i, item) {
                if(item){
                    tbody = "<tr><td>" + item["name"] + "</td><td>" + item["studentId"] + "</td><td>" + item["dept"] + "</td><td>"+ item["grade"] +
                    "</td><td>"+ item["class"] + "</td><td>" + item["time"] + "</td><td>" + item["add_time"] + "</td><td>" + (i+1) + "</td></tr>";

                    $("#rank_table  tbody").append(tbody);
                }
            });

            if(data == ''){
                nothing = '<tr><td colspan="11" class="text-center"> aOh! 暂时还没有内容!  </td></tr>';
                $("#rank_table  tbody").append(nothing);
            }

            $(".right_col").css('min-height', $('.container.body').height());//重新加载样式
        });
    });
});