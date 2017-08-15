//dom加载完成后执行的js
;$(function(){
    $("#year2 li a").click(function(){
        var year = $(this).text();
        var year2 = $('#select_year').text();

        if(!year2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_year">'+year+'年</a></li>');
        }else{
            $("#select_year").text(year+'年');
        }
    });

    $("#month2 li a").click(function(){
        var month = $(this).text();
        var month2 = $('#select_month').text();
        var week = $('#select_week').text();
        if(week){
            $('#select_week').remove();//月和周条件只能选一个
        }

        if(!month2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_month">'+month+'月</a></li>');
        }else{
            $("#select_month").text(month+'月');
        }

    });
    $("#week2 li a").click(function(){
        var week = $(this).text();
        var week2 = $('#select_week').text();

        var month = $('#select_month').text();
        if(month){
            $('#select_month').remove();//月和周条件只能选一个
        }

        if(!week2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_week">'+week+'周</a></li>');
        }else{
            $("#select_week").text(week+'周');
        }
    });
    $("#length li a").click(function(){
        var length = $(this).text();
        var length2 = $('#select_length').text();

        if(!length2){
            $("#selectCondition ul").append('<li role="presentation"><a id="select_length">'+length+'</a></li>');
        }else{
            $("#select_length").text(length);
        }
    });

    $("#selectCondition li a").click(function(){
        var condition = {};

        var year = $('#select_year').text();
        var month = $('#select_month').text();
        var week = $('#select_week').text();
        var length = $('#select_length').text();

        var reg = /[1-9][0-9]*/g;
        year = year.match(reg);
        if(year) condition.year = year[0];
        month = month.match(reg);
        if(month) condition.month = month[0];
        week = week.match(reg);
        if(week) condition.week = week[0];
        if(length) condition.length = length;

        console.log(condition);
        $.getJSON(getRank, condition, function(data) {

            $.each(data, function(i, item) {
                if(item){
                    tbody = "<tr><td>" + item["name"] + "</td><td>" + item["studentId"] + "</td><td>" + item["dept"] + "</td><td>"+ item["grade"] +
                    "</td><td>"+ item["class"] + "</td><td>" + item["time"] + "</td><td>" + item["add_time"] + "</td><td>" + (i+1) + "</td></tr>";

                    $("#rank_table  tbody").append(tbody);
                }else{
                    alert('添加失败');
                }

            });
            $(".right_col").css('min-height', $('.container.body').height());
        });
    });
});