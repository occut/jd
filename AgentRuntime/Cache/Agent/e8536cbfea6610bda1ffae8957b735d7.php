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

<div class="layui-body" style="left: 0px">
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
                            <a href="<?php echo U('Tasks/Single');?>" class="layui-btn ">做单任务审核</a>
                            <a href="<?php echo U('Tasks/flow');?>" class="layui-btn ">流量任务审核</a>
                            <h3 class="box-title layui-btn"><button class="btn layui-btn " onclick="delAll('<?php echo U('Tasks/deletesTasks');?>')">批量删除</button></h3>

                            <br/>
                            <hr/>
                            <form action="<?php echo U('Tasks/Single');?>"  class="layui-form">
                                <div class="layui-form-item">
                                    <div class="layui-inline">
                                        <div class="layui-input-inline" style="width: 200px;">
                                            <select name="status" lay-verify="">
                                                <option value="">请选择付款状态</option>
                                                <option value="0">未支付</option>
                                                <option value="1">已支付</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--<div class="layui-inline">-->
                                    <!--<div class="layui-input-inline" style="width: 200px;">-->
                                    <!--<select name="type" lay-verify="">-->
                                    <!--<option value="0">添加时间</option>-->
                                    <!--<option value="1">未支付</option>-->
                                    <!--<option value="2">已支付</option>-->
                                    <!--</select>-->
                                    <!--</div>-->
                                    <!--</div>-->
                                    <!--<div class="layui-inline">-->
                                    <!--<div class="layui-input-inline" style="width: 200px;">-->
                                    <!--<input type="text" name="keyword" value="" placeholder="请输入关键字..." class="form-control form-boxed">-->
                                    <!--</div>-->
                                    <!--</div>-->
                                    <div class="layui-inline">
                                        <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                                            <input class="layui-input" name="start" placeholder="添加时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                                        </div>
                                        <div class="layui-form-mid">-</div>
                                        <div class="layui-input-inline">
                                            <input class="layui-input" name="end" placeholder="截止日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
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
                                <tr class="tng" >
                                    <th style = "width:5%;text-align: center;"><input type="checkbox" id="dellAll" value=""></th>
                                    <th style="text-align: center;">ID</th>
                                    <th style="text-align: center;">关键词</th>
                                    <th style="text-align: center;">店铺名</th>
                                    <th style="text-align: center;">下单量</th>
                                    <th style="text-align: center;">付款金额</th>
                                    <th style="text-align: center;">佣金</th>
                                    <th style="text-align: center;">物流</th>
                                    <th style="text-align: center;">总费用</th>
                                    <th style="text-align: center;">下单端口</th>
                                    <th style="text-align: center;">结算方式</th>
                                    <th style="text-align: center;">添加时间</th>
                                    <th style="text-align: center;">执行时间</th>
                                    <th style="text-align: center;">状态</th>
                                    <th style="text-align: center;">是否结算</th>
                                    <th style="text-align: center;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($tasks)): $i = 0; $__LIST__ = $tasks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tnd">
                                        <td style="text-align: center;"><input type="checkbox" id="<?php echo ($vo["task_id"]); ?>" value="<?php echo ($vo["task_id"]); ?>" name="delAll"></td>
                                        <td style="text-align: center;"><span><?php echo ($vo["task_id"]); ?></span></td>
                                        <td style="text-align: center;"><span><?php echo ($vo["keyword"]); ?></span></td>
                                        <td style="text-align: center;"><span><?php echo ($vo["shop_name"]); ?></span></td>
                                        <td style="text-align: center;"><span><?php echo ($vo["order_num"]); ?></span></td>
                                        <td style="text-align: center;"><span><?php echo ($vo["order_money"]); ?></span></td>
                                        <td style="text-align: center;"><span><?php echo ($vo["yongjing"]); ?></span></td>
                                        <!--<td style="text-align: center;"><?php if(($vo["status"]) == "0"): ?><a href="#" name="0" onclick="ishide(this,<?php echo ($vo["task_id"]); ?>)">开始任务</a><?php else: ?><a href="#" name="1" onclick="ishide(this,<?php echo ($vo["task_id"]); ?>)" style="color: red">关闭任务</a><?php endif; ?></td>-->
                                        <td style="text-align: center;"><?php if( $vo["transfe"] == 0): ?>无物流<?php else: ?>空包<?php endif; ?></td>
                                        <td style="text-align: center;"><?php echo ($vo["allmoney"]); ?></td>
                                        <td style="text-align: center;">
                                            <?php if($vo["task_type"] == 1): ?>电脑单
                                                <?php else: ?>
                                                手机单<?php endif; ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php if($vo["payway"] == 0): ?>预付
                                                <?php else: ?>
                                                垫付<?php endif; ?>
                                        </td>
                                        <td style="text-align: center;"><?php echo ($vo["addtasktime"]); ?></td>
                                        <td style="text-align: center;"><?php echo ($vo["dotime"]); ?></td>
                                        <td style="text-align: center;" id="examine" >
                                            <a href="javascript:if(confirm('确实?')) location='<?php echo U('Tasks/Taskaudit',array('id'=>$vo['task_id']));?>'">
                                                <?php if($vo['status'] == 1): ?>已审核
                                                    <?php else: ?>
                                                     未审核<?php endif; ?>
                                            </a>

                                        </td>
                                        <td style="text-align: center;">
                                            <?php if($vo["payWay"] == 0): ?>已结算
                                                <?php else: ?>
                                                未结算<?php endif; ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <a  href="<?php echo U('Tasks/edittimeTasks',array('task_id'=>$vo['task_id']));?>" style="display: <?php if($vo["status"] == 1): ?>none<?php else: ?>block<?php endif; ?>">编辑</a>
                                            <a  href="javascript:if(confirm('确实要删除吗?')) location='<?php echo U('Tasks/deletetimeTasks',array('task_id'=>$vo['task_id']));?>'" style="display: <?php if($vo["status"] == 1): ?>none<?php else: ?>block<?php endif; ?>">删除</a>
                                            <a href="javascript:void(0)" style="display: <?php if($vo["status"] == 0): ?>none<?php else: ?>block<?php endif; ?>">审核已通过,不可进行操作</a>
                                        </td>
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
    $(".input").change(function(data){
        var id = $(this).attr('data-node_id');
        var value = $(this).val();
        $.ajax({
            url:"<?php echo U('Tasks/ip');?>",
            type:"post",
            dataType: "json",
            data:{'time_id':id ,'ip':value },
            async: "false",
            success:function(result){
                if(result == 1){
                    layer.msg("更新经纬度成功", { icon: 6 });
                    parent.location.reload();
                }
                if(result == 2){
                    layer.msg("更新经纬度失败", { icon: 5 });
                }
                if(result == 3){
                    layer.msg("当前任务已过期", { icon: 5 });
                }
            }
        })
    })
</script>
<script>
    $(document).ready(function () {
        var num = 1;
        var checkbox = $("input[type='checkbox'][name='delAll']");
        $('#dellAll').on('click',function () {
//                alert(123);
            if (num%2){
                $.each(checkbox, function(i, n){
                    checkbox[i].checked = true;
                });
            }else{
                $.each(checkbox, function(i, n){
                    checkbox[i].checked = false;
                });
            }
            num++;
        });
        $('.selectRule').on('click',function () {
            var classname = $(this).children(".layui-form-checkbox")[0].className;
            var classArr = classname.split(' ');
            var checkbox = $(this).next('td').find("input[type='checkbox']");
            if($.inArray('layui-form-checked',classArr) >= 0){
                $.each(checkbox,function (i,n) {
                    checkbox[i].checked = true;
                });
                $(this).next('td').find(".layui-form-checkbox").addClass('layui-form-checked');
            }else{
                $.each(checkbox,function (i,n) {
                    checkbox[i].checked = false;
                });
                $(this).next('td').find(".layui-form-checkbox").removeClass('layui-form-checked');
            }
        });

    });
</script>

<script>
    $(document).ready(function () {
        var num = 1;
        var checkbox = $("input[type='checkbox'][name='delAll']");
        $('#dellAll').on('click',function () {
//                alert(123);
            if (num%2){
                $.each(checkbox, function(i, n){
                    checkbox[i].checked = true;
                });
            }else{
                $.each(checkbox, function(i, n){
                    checkbox[i].checked = false;
                });
            }
            num++;
        });
        $('.selectRule').on('click',function () {
            var classname = $(this).children(".layui-form-checkbox")[0].className;
            var classArr = classname.split(' ');
            var checkbox = $(this).next('td').find("input[type='checkbox']");
            if($.inArray('layui-form-checked',classArr) >= 0){
                $.each(checkbox,function (i,n) {
                    checkbox[i].checked = true;
                });
                $(this).next('td').find(".layui-form-checkbox").addClass('layui-form-checked');
            }else{
                $.each(checkbox,function (i,n) {
                    checkbox[i].checked = false;
                });
                $(this).next('td').find(".layui-form-checkbox").removeClass('layui-form-checked');
            }
        });

    });

</script>

<script>
    function ishide(id){

        console.log(id);

        $.ajax({
            url:"<?php echo U('Tasks/Taskaudit');?>",
            type:"post",
            dataType: "json",
            data:{'id':id },
            async: "false",
            success:function(result){
                if(result == 1){
                    layer.msg("更新状态成功", { icon: 6 });
                    location.reload();
                }
                if(result == 2){
                    layer.msg("更新状态失败", { icon: 5 });
                }
                if(result == 3){
                    layer.msg("当前任务已过期", { icon: 5 });
                }
            }
        })
    }
    function isstate(obj,aid){
        var b= $(obj).html();
        console.log(aid);
        var c = 0;
        $.ajax({
            url:"<?php echo U('Article/isHidden');?>",
            type:"post",
            dataType: "json",
            data:{'articleid':aid ,'ishidden':c },
            async: "false",
            success:function(ishiddens){
                layer.alert("重启中",{ icon: 1,skin: 'layer-ext-moon' },function(){
                    location.reload();
                });
//                if(b=="开始任务"){
//                    $(obj).html('关闭任务');
//                    $(obj).css('color','red');
//                }
                if(b=="关闭任务"){
                    $(obj).html('开始任务');
                    $(obj).css('color','#3c8dbc');
                }
            }

        })

    }

</script>