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
                        <!-- /.box-header -->
                        <div class="layui-tab-item layui-show">
                            <?php if(is_array($con)): $i = 0; $__LIST__ = $con;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><table class="layui-table">
                                    <tbody>
                                    <tr>
                                        <td>SkuId </td>
                                        <td><?php echo ($vo['skuid']); ?></td>
                                        <td>件数</td>
                                        <td><?php echo ($vo['num']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>关键词</td>
                                        <td><?php echo ($vo['keyword']); ?></td>
                                        <td>描述</td>
                                        <td><?php echo ($vo['description']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>订单数量</td>
                                        <td><?php echo ($vo['order_num']); ?></td>
                                        <td>任务类型</td>
                                        <td>
                                            <?php if($vo["task_type"] == 1): ?>电脑单<?php else: ?>手机单<?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>订单金额</td>
                                        <td><?php echo ($vo['order_money']); ?></td>
                                        <td>店铺名</td>
                                        <td><?php echo ($vo['shop_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>是否物流</td>
                                        <td>
                                            <?php if($vo["transfer"] == 1): ?>需要物流<?php else: ?>不需要物流<?php endif; ?>
                                        </td>
                                        <td>时间</td>
                                        <td><?php echo ($vo['addtasktime']); ?></td>
                                    </tr>
                                    <tr>
                                    <td>买家备注</td>
                                    <td><?php echo ($vo['buyer_mark']); ?></td>
                                    <td>结算方式</td>
                                    <td>
                                        <?php if($vo["payway"] == 1): ?>垫付<?php else: ?>预付<?php endif; ?>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td>佣金</td>
                                        <td><?php echo ($vo['yongjing']); ?></td>

                                    </tr>
                                    </tbody>
                                </table><?php endforeach; endif; else: echo "" ;endif; ?>
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