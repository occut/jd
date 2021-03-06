<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微云控后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <!-- load css -->
    <link rel="stylesheet" type="text/css" href="/AdminResource/layui/css/layui.css" media="all">
    <link rel="stylesheet" type="text/css" href="/AdminResource/admin/css/login.css" media="all">
</head>
<body>
<div class="layui-canvs">
</div>
<div class="layui-layout layui-layout-login">
    <h1>
        <strong>微云控后台管理</strong>
    </h1>
    <form action="<?php echo U('Login/login');?>" method="post">
    <div class="layui-user-icon larry-login">
        <input type="text" placeholder="账号" class="login_txtbx" required="required" name="adminname"/>
    </div>
    <div class="layui-pwd-icon larry-login">
        <input type="password" placeholder="密码" class="login_txtbx" required="required"  name="adminpass"/>
    </div>
    <div class="layui-submit larry-login">
        <button type="submit" class="submit_btn">登录</button>
    </div>
    <div class="layui-login-text">
        <!--<p>© 2016-2017 Larry 版权所有</p>-->
        <p>微云控后台管理</p>
    </div>
    </form>
</div>
<script type="text/javascript" src="/AdminResource/layui/lay/dest/layui.all.js"></script>
<script type="text/javascript" src="/AdminResource/admin/js/login.js"></script>
<script type="text/javascript" src="/AdminResource/admin/js/jparticle.jquery.js"></script>
<script type="text/javascript">
    $(function(){
        $(".layui-canvs").jParticle({
            background: "#141414",
            color: "#E6E6E6"
        });
        //登录链接测试，使用时可删除
        $(".submit_btn").click(function(){
            location.href="index.html";
        });
    });

</script>
</body>
</html>