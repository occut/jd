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
                            <h3 class="box-title"><a href="<?php echo U('Wechat/purchase');?>" class="btn btn-block btn-primary">购买账号</a></h3>
                            <h3 class="box-title"><a href="">余额：<?php echo ($con['ba_balance']); ?></a></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover layui-table" style = "text-align: center;">
                                <thead >
                                <tr class="tng">
                                    <th style = "text-align: center;"><input type="checkbox" id="dellAll" value=""></th>
                                    <th style = "text-align: center;">ID</th>
                                    <th style = "text-align: center;">账号类型</th>
                                    <th style = "text-align: center;">数量</th>
                                    <th style = "text-align: center;">金额</th>
                                    <!--<th style = "text-align: center;">IP</th>-->
                                    <th style = "text-align: center;">购买时间</th>
                                    <th style = "text-align: center;">状态</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($usergroups)): $i = 0; $__LIST__ = $usergroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tnd">
                                        <td><input type="checkbox" value="<?php echo ($vo["re_id"]); ?>" name="delAll"></td>
                                        <td><?php echo ($vo["re_id"]); ?></td>
                                        <td><?php echo ($vo["re_style"]); ?></td>
                                        <td><?php echo ($vo["re_num"]); ?></td>
                                        <td><?php echo ($vo["re_mone"]); ?></td>
                                        <!--<td><?php echo ($vo["re_ip"]); ?></td>-->
                                        <td><?php echo ($vo["re_time"]); ?></td>
                                        <td>
                                            <?php if(($vo["re_static"]) == "1"): ?>购买成功
                                                <?php else: ?>购买失败<?php endif; ?></td>
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
<!-- /.content-wrapper -->
<script>
    $(document).ready(function () {
        $("#nubmer").change(function(){
            var con = $(this).val();
            console.log(con);

            $.ajax({
                url:"<?php echo U('Wechat/Nubmer');?>",
                type:"post",
                dataType: "json",
                data:{'con':con},
                async: "false",
                success:function(result){
                    if(result != 'ok'){
                        if(result == 0){
                            result = '';
                        }
                        $("#nubmer").val(result);
                        layer.msg("数据不足", { icon: 5 });
                        $(this).css("background-color","#FFFFCC");
                    }
                }
            })
        });
        var num = 1;
        var checkbox = $("input[type='checkbox'][name='delAll']");
        $('#dellAll').on('click',function () {
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
    function iswechat(){
        var checkbox = $("input[type='checkbox'][name='delAll']");
        var str = '';
        $.each(checkbox, function(i, n){
            if(checkbox[i].checked == true){
                str += checkbox[i].value+',';
            }

        });
        $("#ids").val(str);
//        alert(str)
    }
    //批量绑定设备

    function bindEqis (url,title) {
        if(title === undefined){
            title = '确定绑定么';
        }
        layer.confirm(title,function(index){
            var checkbox = $("input[type='checkbox'][name='delAll']");
            var str = [];
            $.each(checkbox, function(i, n){
                if(checkbox[i].checked == true){
                    str[i] = checkbox[i].value;

                }
            });
            var eq_id = $('#eq_id').val();
            var nubmer = $('#nubmer').val();
            // console.log(str);
            // alert(str);
            // alert(eq_id);
            $.ajax({
                url:"<?php echo U('Wechat/bindeqis');?>",
                type:"post",
                dataType: "json",
                data:{'ids':str,'id':eq_id,'nubmer':nubmer},
                async: "false",
                success:function(result){
                    if(result == 1){
                        layer.msg("绑定设备成功", { icon: 6 });
                        location.reload();
                    }else{
                        layer.msg("绑定设备失败", { icon: 5 });
                    }
                }
            })

        });
    }
</script>