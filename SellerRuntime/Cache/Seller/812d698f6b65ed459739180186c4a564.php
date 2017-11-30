<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>微云控后台管理</title>
    <!-- layui.css -->
    <link href="/AdminResource/admin/plugin/layui/css/layui.css" rel="stylesheet" />
    <!-- font-awesome.css -->
    <link href="/AdminResource/admin/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- animate.css -->
    <link href="/AdminResource/admin/css/animate.min.css" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="/AdminResource/css/main.css" rel="stylesheet" />
    <link href="/AdminResource/css/index_style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/AdminResource/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/AdminResource/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/zTree/css/zTreeStyle/zTreeStyle.css">

    <!--<script type="text/javascript" src="/AdminResource/js/jquery-1.12.3.min.js"></script>-->
    <!--<script src="/AdminResource/admin/plugin/layui/layui.js"></script>-->
    <!--<script src="/AdminResource/admin/plugin/layui/layui.all.js"></script>-->
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>示例登陆页</title>
    <style>
        .header{
            margin:0 auto;
            width:100%;
            height:640px;
            background-color:#000;
            position:relative;
        }
        .header canvas {
            width:100%;height:auto/*默认全屏显示 可自己设置高度640px*/;
            display:inline-block;vertical-align:baseline
            position:absolute;
            z-index:-1;
        }
        .header .canvaszz{  /*用来解决视频右键菜单，用于视频上面的遮罩层*/
            width:100%;
            background-image: url(/AdminResource/adminhome/images//wallpapers/in_top_bj.jpg);
            height:640px;
            position:absolute;
            z-index:10;
            filter:alpha(opacity=40);
            -moz-opacity:0.4;
            -khtml-opacity: 0.4;
            opacity: 0.4;
        }

        .audio{
            /*设置音乐显示位置*/
            width:45px;
            position:fixed;top:65px;left:94%;
            z-index:100;
            filter:alpha(opacity=30);
            -moz-opacity:0.3;
            -khtml-opacity: 0.3;
            opacity: 0.3;
        }
        .header .top_logo{
            background-image: url(img/top_logo.png);
            margin:0 auto;
            width:750px;
            height:200px;
            position:absolute;
            z-index:30;
            top:10px;
            left: 50%;
            margin-left: -390px;
        }

        .header .nav{
            width:804px;
            height:auto;
            position:absolute;
            z-index:30;
            top:420px;
            left: 50%;
            margin-left: -400px;
        }
        .header .nav a.gv {
            text-decoration:none;
            background:url(img/nav_gv.png) repeat 0px 0px;
            width: 130px;
            height: 43px;
            display: block;
            text-align:center;		/*水平居中*/
            line-height:43px;  /*上下居中*/
            cursor:pointer;
            float:left;/*左浮动*/
            margin:8px 2px 8px 2px;
            font:18px/43px 'microsoft yahei'; color:#066197;
        }
        .header .nav a.gv span {
            display: none;

        }
        .header .nav a.gv:hover {
            background: url(img/nav_gv.png) repeat 0px -43px;
            color:#1d7eb8;
            -webkit-box-shadow: 0 0 6px #1d7eb8;
            transition-duration: 0.5s;
        }

        .header	.topcn {
            width: 980px;
            top: 200px;
            left: 50%;
            margin-left: -490px;
            position: absolute;
            z-index: 20;

        }
        #demo {
            background: url(/AdminResource/adminhome/images//wallpapers/in_top_bj.jpg) no-repeat fixed;
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
            position: fixed;
            z-index: -1;
            top: 0;
            left: 0;
        }

        #win10-login-box {
            width: 300px;
            overflow: hidden;
            margin: 0 auto;
        }

        .win10-login-box-square {
            text-align: left;
            width: 105px;
            margin: 0 auto;
            border-radius: 50%;
            background-color: darkgray;
            position: relative;
            overflow: hidden;
        }

        .win10-login-box-square::after {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .win10-login-box-square img {
            position: absolute !important;
            width: 100%;
            height: 100%;
        }

        input {
            width: 90%;
            display: block;
            border: 0;
            margin: 0 auto;
            line-height: 36px;
            font-size: 20px;
            padding: 0 1em;
            border-radius: 5px;
            margin-bottom: 11px;
        }

        .login-username, .login-password {
            width: 91%;
            font-size: 13px;
            color: #999;
        }

        .login-password {
            width: calc(91% - 54px);
            -webkit-border-radius: 2px 0 0 2px;
            -moz-border-radius: 2px 0 0 2px;
            border-radius: 5px 0 0 5px;
            /*margin: 0px;*/
            margin-left:14px;
            float: left;
        }

        .login-submit {
            margin: 0px;
            float: left;
            -webkit-border-radius: 0 5px 5px 0;
            -moz-border-radius: 0 5px 5px 0;
            border-radius: 0 5px 5px 0;
            background-color: #009688;
            width: 54px;
            display: inline-block;
            height: 36px;
            line-height: 36px;
            padding: 0 auto;
            color: #fff;
            white-space: nowrap;
            text-align: center;
            font-size: 14px;
            border: none;
            cursor: pointer;
            opacity: .9;
            filter: alpha(opacity=90);

        }
    </style>
</head>
<body>
<div class="header" id="demo">
    <div class="topcn" style="font:20px/18px 'microsoft yahei'; color:#0FF;text-align:center;">
        <div id="win10-login">
            <!--<div style="height: 10%;min-height: 120px"></div>-->
            <div id="win10-login-box">
            <div class="win10-login-box-square">
            <!--<img src="/AdminResource/adminhome/images//avatar.png" class="content"/>-->
            <img src="" class="img" width=""/>
            </div>
            <p style="font-size: 24px;color: white;text-align: center">游客</p>
            <form target="_self"  action="<?php echo U('Login/login');?>" method="post">
            <!--&lt;!&ndash;用户名&ndash;&gt;-->
            <input type="text" placeholder="请输入登录名" name="adminname" class="login-username">
            <!--&lt;!&ndash;密码&ndash;&gt;-->
            <input type="password" placeholder="请输入密码" name="adminpass" class="login-password">
            <!--&lt;!&ndash;登陆按钮&ndash;&gt;-->
            <input type="submit"  value="登录" id="btn-login" class="login-submit"/>
            </form>
            </div>
            </div>
                    </div>

                <div class="canvaszz"> </div>
                <canvas id="canvas">

                </canvas>

            </div>
            <!--<div id="win10-login">-->
    <!--<div style="height: 10%;min-height: 120px"></div>-->
    <!--<div id="win10-login-box">-->
        <!--<div class="win10-login-box-square">-->
            <!--&lt;!&ndash;<img src="/AdminResource/adminhome/images//avatar.png" class="content"/>&ndash;&gt;-->
            <!--<img src="" class="content"/>-->
        <!--</div>-->
        <!--<p style="font-size: 24px;color: white;text-align: center">游客</p>-->
        <!--<form target="_self"  action="<?php echo U('Login/login');?>" method="post">-->
            <!--&lt;!&ndash;用户名&ndash;&gt;-->
            <!--<input type="text" placeholder="请输入登录名" name="adminname" class="login-username">-->
            <!--&lt;!&ndash;密码&ndash;&gt;-->
            <!--<input type="password" placeholder="请输入密码" name="adminpass" class="login-password">-->
            <!--&lt;!&ndash;登陆按钮&ndash;&gt;-->
            <!--<input type="submit"  value="登录" id="btn-login" class="login-submit"/>-->
        <!--</form>-->
    <!--</div>-->
<!--</div>-->
</body>
</html>
<script>
    $(function(){
//监听换头像事件
        $('.login-username').bind('input propertychange', function() {
            var name=$(this).val();
            $.ajax({
                url:"<?php echo U('Login/getPic');?>",
                type:"post",
                dataType: "json",
                data:{'name':name},
                async: "false",
                success:function( result){
                    if(result.name==""){
                        $(".img").attr('src','/AdminResource/adminhome/images//avatar.png');
                    }else{
                        $(".img").attr('src',result.path+result.name);

                    }

                }

            })
        });
    });


    "use strict";
    var canvas = document.getElementById('canvas'),
        ctx = canvas.getContext('2d'),
        w = canvas.width = window.innerWidth,
        h = canvas.height = window.innerHeight,

        hue = 217,
        stars = [],
        count = 0,
        maxStars = 1300;//星星数量

    var canvas2 = document.createElement('canvas'),
        ctx2 = canvas2.getContext('2d');
    canvas2.width = 100;
    canvas2.height = 100;
    var half = canvas2.width / 2,
        gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
    gradient2.addColorStop(0.025, '#CCC');
    gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
    gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
    gradient2.addColorStop(1, 'transparent');

    ctx2.fillStyle = gradient2;
    ctx2.beginPath();
    ctx2.arc(half, half, half, 0, Math.PI * 2);
    ctx2.fill();

    // End cache

    function random(min, max) {
        if (arguments.length < 2) {
            max = min;
            min = 0;
        }

        if (min > max) {
            var hold = max;
            max = min;
            min = hold;
        }

        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function maxOrbit(x, y) {
        var max = Math.max(x, y),
            diameter = Math.round(Math.sqrt(max * max + max * max));
        return diameter / 2;
        //星星移动范围，值越大范围越小，
    }

    var Star = function() {

        this.orbitRadius = random(maxOrbit(w, h));
        this.radius = random(60, this.orbitRadius) / 8;
        //星星大小
        this.orbitX = w / 2;
        this.orbitY = h / 2;
        this.timePassed = random(0, maxStars);
        this.speed = random(this.orbitRadius) / 50000;
        //星星移动速度
        this.alpha = random(2, 10) / 10;

        count++;
        stars[count] = this;
    }

    Star.prototype.draw = function() {
        var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
            y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
            twinkle = random(10);

        if (twinkle === 1 && this.alpha > 0) {
            this.alpha -= 0.05;
        } else if (twinkle === 2 && this.alpha < 1) {
            this.alpha += 0.05;
        }

        ctx.globalAlpha = this.alpha;
        ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
        this.timePassed += this.speed;
    }

    for (var i = 0; i < maxStars; i++) {
        new Star();
    }

    function animation() {
        ctx.globalCompositeOperation = 'source-over';
        ctx.globalAlpha = 0.5; //尾巴
        ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 2)';
        ctx.fillRect(0, 0, w, h)

        ctx.globalCompositeOperation = 'lighter';
        for (var i = 1, l = stars.length; i < l; i++) {
            stars[i].draw();
        };

        window.requestAnimationFrame(animation);
    }

    animation();
</script>