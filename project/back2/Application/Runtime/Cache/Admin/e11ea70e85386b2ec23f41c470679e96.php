<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>悦动力管理系统 | </title>

    <!-- Bootstrap -->
    <link href="/project/back2/Public/Admin/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/project/back2/Public/Admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/project/back2/Public/Admin/vendor/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/project/back2/Public/Admin/vendor/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/project/back2/Public/Admin/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/project/back2/Public/Admin/vendor/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/project/back2/Public/Admin/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/project/back2/Public/Admin/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
<div class="main_container">
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>悦动力</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="/project/back2/Public/Admin/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <h2>上海大学</h2>
                <span>广东省/深圳市</span>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>设备功能菜单</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> 概览 </a>
                        <!--<ul class="nav child_menu">
                          <li><a href="index.html">Dashboard</a></li>
                        </ul>-->
                    </li>
                    <li><a><i class="fa fa-desktop"></i> 设备管理 <span class="fa fa-chevron-down"></span></a>
                    </li>
                    <li><a><i class="fa fa-user"></i> 用户管理 <span class="fa fa-chevron-down"></span></a>
                    </li>
                    <li><a><i class="fa fa-edit"></i> 考核/赛事 <span class="fa fa-chevron-down"></span></a>
                    </li>
                    <li><a><i class="fa fa-table"></i> 成绩管理 <span class="fa fa-chevron-down"></span></a>
                    </li>
                    <li><a><i class="fa fa-bar-chart-o"></i> 排行榜 <span class="fa fa-chevron-down"></span></a>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>高级功能菜单</h3>
                <ul class="nav side-menu">

                    <li><a><i class="fa fa-clone"></i>广告管理 <span class="fa fa-chevron-down"></span></a>
                    </li>
                    <li><a><i class="fa fa-sitemap"></i> 代理商 <span class="fa fa-chevron-down"></span></a>

                    </li>
                    <li><a><i class="fa fa-windows"></i> 系统管理 <span class="fa fa-chevron-down"></span></a>
                    </li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="设置">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="全部功能">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="最小化">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="退出系统" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="/project/back2/Public/Admin/images/img.jpg" alt="">代老师
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="javascript:;"> 设置</a></li>
                        <li>
                            <a href="javascript:;">
                                <span class="badge bg-red pull-right">50%</span>
                                <span>个人资料</span>
                            </a>
                        </li>
                        <li><a href="javascript:;">帮助</a></li>
                        <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> 退出系统</a></li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">6</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                                <span class="image"><img src="/project/back2/Public/Admin/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>官方通告</span>
                          <span class="time">3分钟前</span>
                        </span>
                        <span class="message">
                          	国庆期间城市马拉松赛事临近，请各单位做好准备工作...
                        </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="/project/back2/Public/Admin/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>上海大学</span>
                          <span class="time">2小时前</span>
                        </span>
                        <span class="message">
                          大屏幕好像卡住了，学生跑过没有反应，广告也没动了，怎么回事...
                        </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="/project/back2/Public/Admin/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>深圳大学</span>
                          <span class="time">3小时前</span>
                        </span>
                        <span class="message">
                          学生踢球砸中主机屏幕了，之后黑屏，指示灯是亮着的，但是屏幕不亮...
                        </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="/project/back2/Public/Admin/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>哈尔滨大学</span>
                          <span class="time">5小时前</span>
                        </span>
                        <span class="message">
                          下雪冻坏了开不了机...
                        </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>查看更多信息</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->

<!-- page content -->
<div class="right_col" role="main">
<!-- top tiles -->
<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> 累积用户</span>
        <div class="count">250000</div>
        <span class="count_bottom"><i class="green">4% </i> 全国占比</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> 单圈纪录</span>
        <div class="count">23.503</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> 提升比例</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> 本周活跃人数</span>
        <div class="count green">2,500</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> 本场环比指数</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> 本周累计算圈数</span>
        <div class="count">13,567</div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> 本场环比指数</span>
    </div>
    <!--<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
        <!--<span class="count_top"><i class="fa fa-user"></i> 主机数量</span>-->
        <!--<div class="count">2,315</div>-->
        <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> 月度环比指数</span>-->
    <!--</div>-->
    <!--<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
        <!--<span class="count_top"><i class="fa fa-user"></i> 手环数量</span>-->
        <!--<div class="count">7,325</div>-->
        <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> 月度环比指数</span>-->
    <!--</div>-->
</div>
<!-- /top tiles -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">

            <div class="row x_title">
                <div class="col-md-6">
                    <h3>运动量统计 <small>运动时间和人数对比全国均值</small></h3>
                </div>
                <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
                <div id="chart_plot_01" class="demo-placeholder"></div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                <div class="x_title">
                    <h2>运动者水平</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                        <p>专业运动员水平</p>
                        <div class="">
                            <div class="progress progress_sm" style="width: 76%;">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>优秀运动爱好者</p>
                        <div class="">
                            <div class="progress progress_sm" style="width: 76%;">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                        <p>普通运动量</p>
                        <div class="">
                            <div class="progress progress_sm" style="width: 76%;">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>重在参与</p>
                        <div class="">
                            <div class="progress progress_sm" style="width: 76%;">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="clearfix"></div>
        </div>
    </div>

</div>
<br />




</div>
<!-- /page content -->

<!-- footer content -->
<footer>
    <div class="pull-right">
        电科第五十研究所提供技术支持 <a href="http://www..com/" target="_blank" title="跑道设备">赛道设备</a> - 最终版权归属 <a href="http://www..com/" title="跑到设备" target="_blank">某某公司</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<script src="/project/back2/Public/Admin/vendor/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/project/back2/Public/Admin/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/project/back2/Public/Admin/vendor/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/project/back2/Public/Admin/vendor/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="/project/back2/Public/Admin/vendor/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="/project/back2/Public/Admin/vendor/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="/project/back2/Public/Admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="/project/back2/Public/Admin/vendor/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="/project/back2/Public/Admin/vendor/skycons/skycons.js"></script>
<!-- Flot -->
<script src="/project/back2/Public/Admin/vendor/Flot/jquery.flot.js"></script>
<script src="/project/back2/Public/Admin/vendor/Flot/jquery.flot.pie.js"></script>
<script src="/project/back2/Public/Admin/vendor/Flot/jquery.flot.time.js"></script>
<script src="/project/back2/Public/Admin/vendor/Flot/jquery.flot.stack.js"></script>
<script src="/project/back2/Public/Admin/vendor/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/project/back2/Public/Admin/vendor/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="/project/back2/Public/Admin/vendor/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="/project/back2/Public/Admin/vendor/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/project/back2/Public/Admin/vendor/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="/project/back2/Public/Admin/vendor/jqvmap/dist/jquery.vmap.js"></script>
<script src="/project/back2/Public/Admin/vendor/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="/project/back2/Public/Admin/vendor/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="/project/back2/Public/Admin/vendor/moment/min/moment.min.js"></script>
<script src="/project/back2/Public/Admin/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts -->
<script src="/project/back2/Public/Admin/js/custom.min.js"></script>

<!--*********************************-->

<script src="/project/back2/Public/Admin/vendor/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- easy-pie-chart -->
<script src="/project/back2/Public/Admin/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

<!--*******************************-->
</body>
</html>