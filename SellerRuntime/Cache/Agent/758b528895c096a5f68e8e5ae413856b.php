<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>微云控后台管理</title>
    <!-- layui.css -->
    <link href="<?php echo ($resource); ?>admin/plugin/layui/css/layui.css" rel="stylesheet" />
    <!-- font-awesome.css -->
    <link href="<?php echo ($resource); ?>admin/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- animate.css -->
    <link href="<?php echo ($resource); ?>admin/css/animate.min.css" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="<?php echo ($resource); ?>css/main.css" rel="stylesheet" />
    <link href="<?php echo ($resource); ?>css/index_style.css" rel="stylesheet" type="text/css">
    <!--<script type="text/javascript" src="<?php echo ($resource); ?>js/jquery-1.12.3.min.js"></script>-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <!--<script type="text/javascript" src="<?php echo ($resource); ?>js/main.js"></script>-->

    <link rel="stylesheet" href="<?php echo ($resource); ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ($resource); ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/zTree/css/zTreeStyle/zTreeStyle.css">
</head>
<body>

<div class="layui-body" style="left: 0;">
    <div class="content-wrapper" style = "margin-left:1px ;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo ($value); ?>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <a href="javascript:history.back();" class="layui-btn ">返回</a>

                        </div>
                        <!-- /.box-header -->
                        <div class="layui-tab-item layui-show">
                            <table class="layui-table">
                                <tbody>
                                <tr>
                                    <td>店铺名 </td>
                                    <td><?php echo ($con['ad_shopname']); ?></td>
                                    <td>寄件人</td>
                                    <td><?php echo ($con['ad_name']); ?></td>
                                </tr>
                                <tr>
                                    <td>地区</td>
                                    <td><?php echo ($con['ad_region']); ?></td>
                                    <td>详细地址</td>
                                    <td><?php echo ($con['ad_address']); ?></td>
                                </tr>
                                <tr>
                                    <td>电话</td>
                                    <td><?php echo ($con['ad_dianh']); ?></td>
                                    <td>手机</td>
                                    <td><?php echo ($con['ad_phone']); ?></td>
                                </tr>
                                <tr>
                                    <td>注册时间</td>
                                    <td><?php echo ($con['ad_time']); ?></td>
                                    <td>登录时间</td>
                                    <td><?php echo ($con['ad_ltime']); ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            <br>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </section>         <!-- /.row -->
    </div>

    <!-- /.content -->
</div>
</div>
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

<script src="<?php echo ($resource); ?>admin/plugin/layui/layui.js"></script>
<script src="<?php echo ($resource); ?>layui/layui.js"></script>
<script src="<?php echo ($resource); ?>layui/layui.all.js"></script>
<script src="<?php echo ($resource); ?>js/script123.js"></script>

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