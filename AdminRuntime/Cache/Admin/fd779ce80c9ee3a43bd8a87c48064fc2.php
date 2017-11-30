<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>微云控后台管理</title>
    <!-- layui.css -->
    <link href="<?php echo ($resource); ?>admin/plugin/layui/css/layui.css" rel="stylesheet" />
    <!-- font-awesome.css -->
    <link href="<?php echo ($resource); ?>admin/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <!-- animate.css -->
    <link href="<?php echo ($resource); ?>admin/css/animate.min.css" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="<?php echo ($resource); ?>admin/css/main.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo ($resource); ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ($resource); ?>dist/css/AdminLTE.min.css">
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--顶部-->
    <div class="layui-header">
        <div class="ht-console">
            <div class="layui-main">
                <!--<a href="#" class="logo" style = "font-size: 24px; padding-top:5px;"><b>后台管理</b>v1.3</a>-->
                <!--<a href="#" class="logo" style = "font-size: 24px; padding-top:5px;">tom工作室(QQ群:516472075)</a>-->
            </div>
        </div>
        <!-- 顶部右侧菜单 -->
        <ul class="layui-nav top_menu">
            <li class="layui-nav-item" pc>
                <a href="javascript:;">
                    <!--<img src="images/face.jpg" class="layui-circle" width="35" height="35">-->
                    <cite>
                        <span>当前账户：</span>
                        <span class="hidden-xs"><?php echo (session('adminName')); ?></span>
                    </cite>
                </a>
                <dl class="layui-nav-child">
                    <dd> <a href="<?php echo U('Admin/listAdmins',array('gd'=>4,'md'=>67));?>">管理员</a></dd>
                    <dd> <a href="<?php echo U('Admin/listRoles',array('gd'=>4,'md'=>68));?>">角色</a></dd>
                    <dd>  <a href="<?php echo U('Admin/listModules',array('gd'=>4,'md'=>69));?>">模块</a></dd>
                    <dd> <a href="<?php echo U('Admin/editPassword',array('gd'=>4,'md'=>70));?>" >改密</a></dd>
                    <dd><a href="<?php echo U('Login/logout');?>" >退出</a></dd>
                </dl>
            </li>
            <li class="ht-nav-item layui-nav-item">
                <a href="javascript:;" id="individuation"><i class="fa fa-tasks fa-fw" style="padding-right:5px;"></i>个性化</a>
            </li>

        </ul>

    </div>
<!--侧边导航-->
<div class="layui-side">
    <section class="sidebar">
        <ul class="sidebar-menu layui-nav layui-nav-tree" lay-filter="test">
            <!--Start 进行循环，获得分组-->
            <?php if(is_array($menuGroup)): $i = 0; $__LIST__ = $menuGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="treeview layui-nav-item">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span><?php echo ($vo["group_name"]); ?></span>
                    </a>
                    <ul class="treeview-menu layui-nav-child"<?php if(($vo["group_id"]) == $_SESSION['groupid']): ?>style="display:block"<?php endif; ?>>
                    <?php if(is_array($adminMenu)): $i = 0; $__LIST__ = $adminMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><!--如果父菜单和子菜单相等-->
                        <?php if(($vo["group_id"]) == $voo["group_id"]): if(is_array($moduleurl)): $i = 0; $__LIST__ = $moduleurl;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mo): $mod = ($i % 2 );++$i; if(($voo["menu_url"]) == $mo): ?><li <?php if(($voo["menu_id"]) == $_SESSION['menuid']): ?>class="active"<?php endif; ?>><a href="<?php echo U($voo['menu_url'],array('gd'=>$voo['group_id'],'md'=>$voo['menu_id']));?>"><i class="fa fa-circle-o"></i> <?php echo ($voo["menu_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
        <!--END 进行循环，获得分组-->
        </ul>
    </section>
</div>
<!--收起导航-->
<div class="layui-side-hide layui-bg-cyan">
    <i class="fa fa-long-arrow-left fa-fw"></i>收起导航
</div>
<div class="layui-body" >
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
                <div class="col-xs-12" style="margin-right:0px; ">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"><a href="<?php echo U('Agent/balance');?>" class="btn btn-block btn-primary">金币充值</a></h3>
                            <br/>
                            <hr/>
                            <form class="layui-form"   action="<?php echo U('Index/selectpayment');?>">
                                <div class="layui-form-item">

                                    <div class="layui-inline">
                                        <div class="layui-input-inline" style="">
                                            <input class="layui-input" name="tiao" value="" placeholder="订单号" >
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <div class="layui-input-inline" style="width: 200px;">
                                            <input type="text" id="startTime" name="startTime"  placeholder="开始时间" class="form-control form-boxed">
                                        </div>
                                        <div class="layui-form-mid">-</div>
                                        <div class="layui-input-inline" style="width: 200px;">
                                            <input type="text" id="endTime" name="endTime"  placeholder="结束时间" class="form-control form-boxed">
                                        </div>
                                    </div>
                                    <div class="layui-inline">
                                        <div class="form-cont">
                                            <div class="layui-input-inline">
                                                <input type="submit" class="layui-btn" value="搜索" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover layui-table" style = "text-align: center;">
                                <thead >
                                <tr class="tng">
                                    <!--<th style = "text-align: center;"><input type="checkbox" id="dellAll" value=""></th>-->
                                    <th style = "text-align: center;">ID</th>
                                    <th style = "text-align: center;">二级代理用户名</th>
                                    <th style = "text-align: center;">订单号</th>
                                    <th style = "text-align: center;">钻石充值量</th>
                                    <th style = "text-align: center;">充值途径</th>
                                    <th style = "text-align: center;">备注信息</th>
                                    <th style = "text-align: center;">申请时间</th>
                                    <th style = "text-align: center;">状态</th>
                                    <th style = "text-align: center;">操作人</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($usergroups)): $i = 0; $__LIST__ = $usergroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tnd">
                                        <!--<td><input type="checkbox" value="<?php echo ($vo["pa_id"]); ?>" name="delAll"></td>-->
                                        <td><?php echo ($vo["pa_id"]); ?></td>
                                        <td><?php echo selectagent($vo['ag_id'])['ag_name'];?></td>
                                        <td><?php echo ($vo["pa_name"]); ?></td>
                                        <td><?php echo ($vo["ba_mone"]); ?></td>
                                        <td><?php echo ($vo["ba_channel"]); ?></td>
                                        <td><?php echo ($vo["ba_remarks"]); ?></td>
                                        <td><?php echo ($vo["pa_time"]); ?></td>
                                        <td onclick="add('金额','<?php echo U('Agent/Import',array('pa_id'=>$vo['pa_id']));?>')">
                                            <?php if(($vo["pa_static"]) == "0"): ?>正常
                                                <?php elseif($vo['pa_static'] == 1): ?>未完成<?php endif; ?>
                                        </td>
                                        <td><?php echo ($vo["pa_operator"]); ?></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                            <div class="pagepadding">
                                <div class="col-sm-5"><div aria-live="polite" role="status" id="example2_info" class="dataTables_info">共<?php echo ($count); ?>条</div></div><div class="col-sm-7"><div id="example2_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><?php echo ($page); ?></ul></div></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
<!--底部信息-->
<div class="layui-footer">
    <!--<p style="line-height:44px;text-align:center;">Copyright &copy; 2012-2016 微云控云控管理系统</p>-->
    <p style="line-height:44px;text-align:center;">微云控后台管理</p>
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
    <div class="setting-item layui-form">
        <span>侧边导航</span>
        <input type="checkbox" lay-skin="switch" lay-filter="sidenav" lay-text="ON|OFF" checked>
    </div>
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
<script src="<?php echo ($resource); ?>js/script123.js"></script>
<script src="<?php echo ($resource); ?>plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="<?php echo ($resource); ?>dist/js/app.min.js"></script>
<script src="<?php echo ($resource); ?>bootstrap/js/bootstrap.min.js"></script>
<script>
//    $(function () {
//        $("#example1").DataTable();
//        $('#example2').DataTable({
//            "paging": true,
//            "lengthChange": false,
//            "searching": false,
//            "ordering": true,
//            "info": true,
//            "autoWidth": false
//        });
//    });

//    $('.some_class').datetimepicker();

</script>
<!-- layui规范化用法 -->
<script type="text/javascript">
    layui.config({
        base: '<?php echo ($resource); ?>admin/js/'
    }).use('main');
</script>
</body>
</html>
<script>
    //        时间选择Start
    layui.use('laydate', function(){
    var laydate = layui.laydate;

    //执行一个laydate实例
    laydate.render({
    elem: '#startTime' //指定元素
    });
    laydate.render({
    elem: '#endTime' //指定元素
    });
    });
    //        时间选择Over
</script>