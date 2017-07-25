<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>学校管理系统 | </title>

    <!-- Bootstrap -->
    <!--<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="/project/back2/Public/Admin/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!--<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">-->
    <link href="/project/back2/Public/Admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/project/back2/Public/Admin/vendor/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="/project/back2/Public/Admin/vendor/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/project/back2/Public/Admin/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="post" action="<?php echo U('login');?>">
                    <h1>管理系统</h1>

                    <div>
                        <!--<input type="text" class="form-control" placeholder="Username" name="account" required="" />-->
                        <input type="text" class="form-control"  name="account"  />
                    </div>
                    <div>
                        <!--<input type="password" class="form-control" placeholder="Password" name="passwd" required="" />-->
                        <input type="password" class="form-control" name="passwd" />
                    </div>
                    <div>
                        <!--<a class="btn btn-default submit" href="<?php echo U('login');?>">登录</a>-->
                        <input type="submit" class="btn btn-default submit"  value="登陆">
                        <a class="reset_pass" href="#">忘记密码？</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">客服热线：400-0000-0000
                            <!--<a href="#signup" class="to_register"> Create Account </a>-->
                        </p>

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> 悦动力</h1>
                            <p>©2017 版权归上海***公司所有。</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>