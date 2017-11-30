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
<div class="layui-body"  style="left:0px">
<div class="content-wrapper" style="margin-left: 0px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           资金管理
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <br/>
                    <form class="layui-form"   action="<?php echo U('Finance/index');?>" style="margin-left: 10px">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <div class="layui-input-inline" style="">
                                    <input class="layui-input" name="skuid" value="" placeholder="skuid" >
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
                    <div class="box-body">
                        <div class="layui-tab">
                            <ul class="layui-tab-title">
                                <li class="layui-this">账目明细</li>
                            </ul>
                            <div class="layui-tab-content">
                                <div class="layui-tab-item layui-show">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                        <tr class="tng">
                                            <!--<th style = "text-align: center;"><input type="checkbox" id="" value=""></th>-->
                                            <th style = "text-align: center;">ID</th>
                                            <th style = "text-align: center;">skuid</th>
                                            <th style = "text-align: center;">放单金额</th>
                                            <th style = "text-align: center;">放单时间</th>
                                            <!--<th style = "text-align: center;">操作</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($usergroups)): $i = 0; $__LIST__ = $usergroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tnd" style = "text-align: center;">
                                                <!--<td><input type="checkbox" value="<?php echo ($vo["id"]); ?>" name="delAll"></td>-->
                                                <td><?php echo ($vo["pay_id"]); ?></td>
                                                <td><?php echo ($vo["skuid"]); ?></td>
                                                <td><?php echo ($vo["pay_money"]); ?></td>
                                                <td><?php echo ($vo["pay_time"]); ?></td>
                                                <!--<td>-->
                                                <!--<a href="<?php echo U('Shop/editAddress',array('id'=>$vo['id']));?>">编辑收获地址</a>-->
                                                <!--<a href="javascript:if(confirm('确实要删除吗?'))location='<?php echo U('Shop/deleteshop',array('id'=>$vo['id']));?>'">删除</a>-->
                                                <!--</td>-->
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="pagepadding">
                                        <div class="col-sm-5"><div aria-live="polite" role="status" id="example2_info" class="dataTables_info">共<?php echo ($count); ?>条</div></div><div class="col-sm-7"><div id="example2_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><?php echo ($page); ?></ul></div></div>
                                </div>

                            </div>

                </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<div>
<!-- /.content-wrapper -->

<!-- Content Wrapper. Contains page content -->

<!-- /.box -->
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