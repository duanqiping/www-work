<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">

<head>
    <title>run</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="/project/back/Public/Admin/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/project/back/Public/Admin/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/project/back/Public/Admin/vendor/linearicons/style.css">
    <link rel="stylesheet" href="/project/back/Public/Admin/vendor/chartist/css/chartist-custom.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="/project/back/Public/Admin/css/main.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="/project/back/Public/Admin/css/demo.css">


    <link rel="stylesheet" href="/project/back/Public/Admin/css/jquery.datetimepicker.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="/project/back/Public/Admin/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/project/back/Public/Admin/img/favicon.png">

    <script type="text/javascript" src="/project/back/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/project/back/Public/static/jquery-2.0.3.min.js"></script>

</head>

<body>
<!-- WRAPPER -->
<div id="wrapper">
    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="brand">
            <a href="index.html"><img src="/project/back/Public/Admin/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
        </div>
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
            </div>
            <form class="navbar-form navbar-left">
                <div class="input-group">
                    <input type="text" value="" class="form-control" placeholder="Search dashboard...">
                    <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
                </div>
            </form>
            <!--<div class="navbar-btn navbar-btn-right">-->
                <!--<a class="btn btn-success update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>登录/注册</span></a>-->
            <!--</div>-->
            <div id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/project/back/Public/Admin/img/user.png" class="img-circle" alt="Avatar"> <span><?php echo ($_SESSION['user']['name']); ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
                            <li><a href="<?php echo U('public/logout');?>"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a class="update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
    <div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <nav>
                <ul class="nav">
                    <li><a href="<?php echo U('customer/index');?>" class="active"><i class="lnr lnr-home"></i> <span>学校概述</span></a></li>
                    <li><a href="<?php echo U('customer/info');?>" class=""><i class="lnr lnr-chart-bars"></i> <span>用户管理</span></a></li>
                    <li><a href="<?php echo U('customer/score');?>" class=""><i class="lnr lnr-cog"></i> <span>成绩管理</span></a></li>
                    <li><a href="<?php echo U('customer/rank');?>" class=""><i class="lnr lnr-alarm"></i> <span>排行榜</span></a></li>

                    <li><a href="<?php echo U('contest/index');?>" class=""><i class="lnr lnr-dice"></i> <span>考试/赛事</span></a></li>

                    <li><a href="<?php echo U('customer/device');?>" class=""><i class="lnr lnr-file-empty"></i> <span>设备管理</span></a></li>

                    <!--<li>-->
                        <!--<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>设备管理</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>-->
                        <!--<div id="subPages" class="collapse ">-->
                            <!--<ul class="nav">-->
                                <!--<li><a href="#" class="">障碍报销</a></li>-->
                                <!--<li><a href="#" class="">处理中的工单</a></li>-->
                                <!--<li><a href="#" class="">已处理的工单</a></li>-->
                            <!--</ul>-->
                        <!--</div>-->
                    <!--</li>-->
                </ul>
            </nav>
        </div>
    </div>

    <!--内容-->
    
    <div class="main">
        <div class="main-title" style="margin-left: 60px">
            <h2>考试、赛事</h2>
        </div>
        <a style="margin-left: 60px" href="<?php echo U('add');?>">创建一场考试</a>

        <div style="margin-left: 60px;margin-top: 10px">
            <div style="float: left"><button onclick="contest('all')">全部赛事</button></div>
            <div style="float: left"><button onclick="contest('unfinished')">未开始的赛事</button></div>
            <div style="float: left"><button onclick="contest('finished')">已完成的赛事</button></div>
        </div>

        <!-- 数据列表 -->
        <div class="data-table table-striped">
            <table class="" style="clear:both;height:0;width:0;border-collapse:separate; border-spacing:60px 10px;">
                <thead>
                <tr>
                    <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                    <th class="">UID</th>
                    <th class="">赛事编号</th>
                    <th class="">赛事标题</th>
                    <th class="">赛事描述</th>
                    <th class="">创建时间</th>
                    <th class="">比赛开始时间</th>
                    <th class="">比赛结束时间</th>
                    <th class="">赛事规格</th>
                    <th class="">创建者</th>
                    <th class="">人员名单</th>
                </tr>
                </thead>

                <tbody>
                <?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><input class="ids" type="checkbox" name="id[]" value="<?php echo ($vo["uid"]); ?>" /></td>
                            <td><?php echo ($vo["contest_id"]); ?> </td>
                            <td><?php echo ($vo["contest_sn"]); ?></td>
                            <td><?php echo ($vo["title"]); ?></td>
                            <td><?php echo ($vo["desc"]); ?></td>
                            <td><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
                            <td><?php echo (date("Y-m-d H:i:s",$vo["begin_time"])); ?></td>
                            <td><?php echo (date("Y-m-d H:i:s",$vo["end_time"])); ?></td>
                            <td><?php echo ($vo["length"]); ?> m</td>
                            <td><?php echo ($vo["from_name"]); ?></td>
                            <!--<td><a href="#" style="color: #0000C0">人员名单</a></td>-->
                            <td><a href="<?php echo U('info',array('contest_sn'=>$vo['contest_sn']));?>" style="color: #0000C0">人员名单</a></td>
                            <!--<td><?php echo ($vo['is_show']?'正常':'禁用'); ?></td>-->
                            <!--<td><?php echo ($vo['count']); ?><a href="">查看详情</a></td>-->
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php else: ?>
                    <td colspan="11" class="text-center"> aOh! 暂时还没有内容! </td><?php endif; ?>
                </tbody>

            </table>
        </div>


    </div>

    <!--下面的需要用<?php  ?>这种形式注释-->
    <?php  ?>
    <div class="clearfix"></div>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="/project/back/Public/Admin/vendor/jquery/jquery.min.js"></script>
<script src="/project/back/Public/Admin/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/project/back/Public/Admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/project/back/Public/Admin/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<!--<script src="/project/back/Public/Admin/vendor/chartist/js/chartist.min.js"></script>-->

<!--<script src="/project/back/Public/Admin/js/vue.js"></script>-->
<!--<script src="/project/back/Public/Admin/js/test.js"></script>-->
<script>
    $(function() {
        var data, options;

        // headline charts
        data = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            series: [
                [23, 29, 24, 40, 25, 24, 35],
                [14, 25, 18, 34, 29, 38, 44],
            ]
        };

        options = {
            height: 300,
            showArea: true,
            showLine: false,
            showPoint: false,
            fullWidth: true,
            axisX: {
                showGrid: false
            },
            lineSmooth: false,
        };

//        new Chartist.Line('#headline-chart', data, options);


        // visits trend charts
        data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [{
                name: 'series-real',
                data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
            }, {
                name: 'series-projection',
                data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
            }]
        };

        options = {
            fullWidth: true,
            lineSmooth: false,
            height: "270px",
            low: 0,
            high: 'auto',
            series: {
                'series-projection': {
                    showArea: true,
                    showPoint: false,
                    showLine: false
                },
            },
            axisX: {
                showGrid: false,

            },
            axisY: {
                showGrid: false,
                onlyInteger: true,
                offset: 0,
            },
            chartPadding: {
                left: 20,
                right: 20
            }
        };

//        new Chartist.Line('#visits-trends-chart', data, options);


        // visits chart
        data = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            series: [
                [6384, 6342, 5437, 2764, 3958, 5068, 7654]
            ]
        };

        options = {
            height: 300,
            axisX: {
                showGrid: false
            },
        };

//        new Chartist.Bar('#visits-chart', data, options);


        // real-time pie chart
        var sysLoad = $('#system-load').easyPieChart({
            size: 130,
            barColor: function(percent) {
                return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
            },
            trackColor: 'rgba(245, 245, 245, 0.8)',
            scaleColor: false,
            lineWidth: 5,
            lineCap: "square",
            animate: 800
        });

//        var updateInterval = 3000; // in milliseconds

//        setInterval(function() {
//            var randomVal;
//            randomVal = getRandomInt(0, 100);
//
//            sysLoad.data('easyPieChart').update(randomVal);
//            sysLoad.find('.percent').text(randomVal);
//        }, updateInterval);
//
//        function getRandomInt(min, max) {
//            return Math.floor(Math.random() * (max - min + 1)) + min;
//        }

    });
</script>
<script type="text/javascript">
    +function(){
        var $window = $(window), $subnav = $("#subnav"), url;
        $window.resize(function(){
            $("#main").css("min-height", $window.height() - 130);
        }).resize();

        /* 左边菜单高亮 */
        url = window.location.pathname + window.location.search;
        url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
        $subnav.find("a[href='" + url + "']").parent().addClass("current");

        /* 左边菜单显示收起 */
        $("#subnav").on("click", "h3", function(){
            var $this = $(this);
            $this.find(".icon").toggleClass("icon-fold");
            $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                    prev("h3").find("i").addClass("icon-fold").end().end().hide();
        });

        $("#subnav h3 a").click(function(e){e.stopPropagation()});

        /* 头部管理员菜单 */
        $(".user-bar").mouseenter(function(){
            var userMenu = $(this).children(".user-menu ");
            userMenu.removeClass("hidden");
            clearTimeout(userMenu.data("timeout"));
        }).mouseleave(function(){
            var userMenu = $(this).children(".user-menu");
            userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
            userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
        });

        /* 表单获取焦点变色 */
        $("form").on("focus", "input", function(){
            $(this).addClass('focus');
        }).on("blur","input",function(){
            $(this).removeClass('focus');
        });
        $("form").on("focus", "textarea", function(){
            $(this).closest('label').addClass('focus');
        }).on("blur","textarea",function(){
            $(this).closest('label').removeClass('focus');
        });

        // 导航栏超出窗口高度后的模拟滚动条
        var sHeight = $(".sidebar").height();
        var subHeight  = $(".subnav").height();
        var diff = subHeight - sHeight; //250
        var sub = $(".subnav");
        if(diff > 0){
            $(window).mousewheel(function(event, delta){
                if(delta>0){
                    if(parseInt(sub.css('marginTop'))>-10){
                        sub.css('marginTop','0px');
                    }else{
                        sub.css('marginTop','+='+10);
                    }
                }else{
                    if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                        sub.css('marginTop','-'+(diff-10));
                    }else{
                        sub.css('marginTop','-='+10);
                    }
                }
            });
        }
    }();
</script>

    <script type="text/javascript">
        function contest(type)
        {
            var contestUrl = "<?php echo U('');?>"; // merchant.js 中使用
            var url = contestUrl.replace(/.html/, "");
            location.href = url+"/type/"+type;//location.href实现客户端页面的跳转
        }
    </script>

</body>

</html>