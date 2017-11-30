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

    <script type="text/javascript" src="/AdminResource/js/jquery-1.12.3.min.js"></script>
    <script src="/AdminResource/admin/plugin/layui/layui.js"></script>
    <script src="/AdminResource/admin/plugin/layui/layui.all.js"></script>
</head>
<body>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<style type="text/css">
    html,body{
        width:100%;
        height:100%;
    }
    *{
        margin:0px;
        padding:0px;
    }
    body, button, input, select, textarea {
        font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
    }
    p{
        width:603px;
        padding-top:3px;
        overflow:hidden;
    }
    .btn{
        width:142px;
    }
    #container{
        min-width:600px;
        min-height:767px;
    }
</style>
<!--主体内容-->
<div class="layui-body">
    <div class="content-wrapper" style = "margin-left:1px ;">
        <div class="layui-field-box">
            <!--<form method="post" action="<?php echo U('Index/searchAddr');?>" style="margin-bottom: 10px">-->
            <!--<input type="text" class="layui-input pull-left" style="width: 200px" name="addr">-->
            <!--<input type="button" class="btn layui-btn-success pull-left" value="搜索" style="outline: none;margin-left: 10px" onclick="addrSearch()">-->
            <div class="clearfix"></div>
            <!--</form>-->
            <!--   定义地图显示容器   -->
            <div id="container"></div>
            <input type="hidden" value="<?php echo ($LngLat['result']['location']['lng']); ?>" id="lng">
            <input type="hidden" value="<?php echo ($LngLat['result']['location']['lat']); ?>" id="lat">
        </div>
        <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
        <script>
            window.onload = function(){
                var lng=parseFloat(document.getElementById("lng").value);
                var lat=parseFloat(document.getElementById("lat").value);
//直接加载地图
                //初始化地图函数  自定义函数名init
                function init() {
                    //定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
                    var map = new qq.maps.Map(document.getElementById("container"), {

                        center: new qq.maps.LatLng(lat,lng),      // 地图的中心地理坐标。
                        zoom:8                                                 // 地图的中心地理坐标。
                    });
                }
                //调用初始化函数地图
                init();
            }
        </script>
        <!--底部信息-->
<div class="layui-footer">
    <!--<p style="line-height:44px;text-align:center;">Copyright &copy; 2012-2016 微云控云控管理系统</p>-->
    <p style="line-height:44px;text-align:center;">tom工作室(QQ群:516472075)</p>
</div>
<!--个性化设置-->
<div class="individuation animated flipOutY layui-hide">
    <ul>
        <li><i class="fa fa-cog" style="padding-right:5px"></i>个性化</li>
    </ul>
    <div class="explain">
        <small>从这里进行系统设置和主题预览</small>
    </div>
    <div class="setting-title">设置</div>
    <!--<div class="setting-item layui-form">-->
        <!--<span>侧边导航</span>-->
        <!--<input type="checkbox" lay-skin="switch" lay-filter="sidenav" lay-text="ON|OFF" checked>-->
    <!--</div>-->
    <!--<div class="setting-item layui-form">-->
    <!--<span>管家提醒</span>-->
    <!--<input type="checkbox" lay-skin="switch" lay-filter="steward" lay-text="ON|OFF" checked>-->
    <!--</div>-->
    <div class="setting-title">主题</div>
    <div class="setting-item skin skin-default" data-skin="skin-default">
        <span>低调优雅</span>
    </div>
    <div class="setting-item skin skin-deepblue" data-skin="skin-deepblue">
        <span>蓝色梦幻</span>
    </div>
    <div class="setting-item skin skin-pink" data-skin="skin-pink">
        <span>姹紫嫣红</span>
    </div>
    <div class="setting-item skin skin-green" data-skin="skin-green">
        <span>一碧千里</span>
    </div>
</div>
</div>
<!-- layui.js -->
<script type="text/javascript" src="/AdminResource/js/jquery-1.12.3.min.js"></script>
<script src="/AdminResource/admin/plugin/layui/layui.js"></script>
<script src="/AdminResource/admin/plugin/layui/layui.all.js"></script>
<script src="/AdminResource/admin/plugin/layui/lay/modules/laydate.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<!--<script type="text/javascript" src="/AdminResource/js/main.js"></script>-->

<script src="/AdminResource/js/script123.js"></script>

<script type="text/javascript" src="/AdminResource/adminhome/component/treeTable/jquery.treetable.js"></script>
<script>


</script>
<!-- layui规范化用法 -->
<script type="text/javascript">
    layui.config({
        base: '<?php echo ($resource); ?>admin/js/'
    }).use('main');
</script>
</body>
</html>