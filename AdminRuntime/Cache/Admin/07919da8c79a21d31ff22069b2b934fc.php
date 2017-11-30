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
<div class="layui-body">
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
                        <form method="get" style="float: left;" action="<?php echo U('Wechat/WeExport');?>">
                            <!--<div class="box-header">-->
                                <input style="float:left;width:100px;" type="hidden" name="ids" id="ids" vallue="">
                                <input type="submit" value="导出" class="btn btn-block btn-primary" onclick="iswechat()" style="width: 100px;margin: 5px 5px;">
                            <!--</div>-->
                        </form>
                        <!--<h3 class="box-title"><a href="javascript:;" onclick="add('导出账号','<?php echo U('Wechat/WeExport',array('wei_static'=>$static));?>')"><button type="button" class="btn btn-block btn-primary">导出账号</button></a></h3>-->
                        <!--<h3 class="box-title"><a href="javascript:;" onclick="add('导入账号','<?php echo U('Wechat/Import',array('wei_static'=>$static));?>')"><button type="button" class="btn btn-block btn-primary">导入账号</button></a></h3>-->
                        <h3 class="box-title"><button class="btn btn-block btn-primary" onclick="delAll('<?php echo U('Wechat/deleteWechats');?>')">批量删除</button></h3>
                        <h3 class="box-title"><button class="btn btn-block btn-primary" onclick="delAll('<?php echo U('Wechat/state');?>','确定更新状态么')">批量更新</button></h3>

                        <h3 class="box-title">
                        <select style="width:200px;height: 40px;border: 1px solid #E6E6E6;padding-left: 10px;" name='id' id = "eq_id">
                        <?php if(is_array($alleqs)): $i = 0; $__LIST__ = $alleqs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$eqs): $mod = ($i % 2 );++$i;?><option value="<?php echo ($eqs["id"]); ?>"><?php echo ($eqs["equlist"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                       </select>
                            <input class="layui-input" id="nubmer" name="nubmer" value="" placeholder="勾选为空" style="float:left;width:80px;margin-left:10px;">
                        </h3>
                         <h3 class="box-title"><button class="btn btn-block btn-primary" onclick="bindEqis('<?php echo U('Wechat/bindeqis');?>')">绑定设备</button></h3>
                    <form class="layui-form"  style="float:right;width:1000px;" action="<?php echo U('Wechat/searchAddr');?>">
                     <input type="hidden" name='static' value=<?php echo ($id); ?>>
                     <h3 class="box-title" style="float:left;">
                        <select style="float:left;width:40px;height: 40px;border: 1px solid #E6E6E6;padding-left: 10px;" name='ids' >
                        <option value="1" >账号</option>
                        <option value="2" >地址</option>
                        <option value="3">手机号</option>
                        <option value="4">订单号</option>
                        <option value="5">订单状态</option>
                       </select>
                        </h3>
                            <input class="layui-input" name="tiao" value="" placeholder="条件" style="float:left;width:180px;margin-left:10px;">   
                    <h3 class="box-title">
                        <select style="width:40px;height: 40px;border: 1px solid #E6E6E6;padding-left: 10px;" name='we_we' >
                        <option value="we_we"></option>
                        <?php if(is_array($alleqs)): $i = 0; $__LIST__ = $alleqs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$eqs): $mod = ($i % 2 );++$i;?><option value="<?php echo ($eqs["equlist"]); ?>"><?php echo ($eqs["equlist"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                       </select>
                        </h3>
                    <h3 class="box-title">
                    <select style="float:left;width:40px;height: 40px;border: 1px solid #E6E6E6;" name='shebei'>
                            <option value="1"></option>
                            <option value="2">绑订</option>
                            <option value="3">未绑订</option>
                       </select>
                        </h3>
                   <!-- <input style="float:left;width:100px;" type="text" name="title" placeholder="请输入地址" autocomplete="off" class="layui-input">-->
                    <button style="float:right;width:100px;margin-right:20px;" class="layui-btn btn-primary" lay-submit lay-filter="formDemo">搜索</button>
                    </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover layui-table" style = "text-align: center;">
                            <thead >
                            <tr class="tng">
                                <th style = "text-align: center;"><input type="checkbox" id="dellAll" value=""></th>
                                <th style = "text-align: center;">ID</th>
                                <th style = "text-align: center;">手机号</th>
                                <th style = "text-align: center;">账号</th>
                                <th style = "text-align: center;">密码</th>
                                <!--<th style = "text-align: center;">支付密码</th>-->
                                <th style = "text-align: center;">注册时间</th>
                                <th style = "text-align: center;">IP</th>
                                <th style = "text-align: center;">近期IP</th>
                                <th style = "text-align: center;">地址</th>
                                <th style = "text-align: center;">状态</th>
                                <th style = "text-align: center;">评论</th>
                                <th style = "text-align: center;">备注</th>
                                <th style = "text-align: center;">设备</th>
                                <th style = "text-align: center;">完成设备</th>
                                <th style = "text-align: center;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($usergroups)): $i = 0; $__LIST__ = $usergroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tnd">
                                    <td><input type="checkbox" value="<?php echo ($vo["wei_id"]); ?>" name="delAll"></td>
                                    <td><?php echo ($vo["wei_id"]); ?></td>
                                    <td><?php echo ($vo["wei_number"]); ?></td>
                                    <td><?php echo ($vo["wei_name"]); ?></td>
                                    <td><?php echo ($vo["wei_password"]); ?></td>
                                    <!--<td><?php echo ($vo["pay_password"]); ?></td>-->
                                    <td><?php echo ($vo["wei_time"]); ?></td>
                                    <td><?php echo ($vo["wei_ip"]); ?></td>
                                    <td><?php echo ($vo["wei_ips"]); ?></td>
                                    <td><?php echo ($vo["wei_address"]); ?></td>
                                    <td>
                                        <?php if(($vo["wei_static"]) == "0"): ?>正常
                                            <?php elseif($vo['wei_static'] == 2): ?>登录中
                                            <?php elseif($vo['wei_static'] == 3): ?>登录成功
                                            <?php elseif($vo['wei_static'] == 4): ?>任务完成
                                            <?php elseif($vo['wei_static'] == 5): ?>任务未完成
                                            <?php else: ?>禁用<?php endif; ?></td>
                                    <td onclick="add('评论','<?php echo U('Wechat/comment',array('wei_number'=>$vo['wei_number']));?>')" style="cursor: pointer">
                                        <a href="javascript:;"><?php echo (subtext($vo["comment"],8)); ?></a>
                                    </td>
                                    <td><?php echo ($vo["wei_remarks"]); ?></td>
                                    <td><?php echo (subtext($vo["wei_equipment"],15)); ?></td>
                                    <td><?php echo (subtext($vo["we_we"],15)); ?></td>
                                    <td>
                                        <?php if(($vo["wei_static"]) == "2"): ?><a href="javascript:;" onclick="static(<?php echo ($vo['wei_id']); ?>)">
                                                正常
                                            </a><?php endif; ?>
                                        <a href="javascript:if(confirm('确实要删除吗?'))location='<?php echo U('Wechat/deleteWechat',array('wei_id'=>$vo['wei_id'],'gd'=>$groupId,'md'=>$menuId));?>'">删除</a>
                                    </td>
                                </tr>
                                <script>
                                    function static(id){
                                        console.log(id);
                                        $.ajax({
                                            url:"<?php echo U('Wechat/state');?>",
                                            type:"post",
                                            dataType: "json",
                                            data:{'ids':id},
                                            async: "false",
                                            success:function(result){
                                                if(result){
                                                    layer.msg("更新状态成功", { icon: 6 });
                                                    parent.location.reload();
                                                }else{
                                                    layer.msg("更新状态失败", { icon: 5 });
                                                }
                                            }
                                        })
                                    }
                                </script><?php endforeach; endif; else: echo "" ;endif; ?>
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
        // 搜索地址
        // function search(){
        //     var val=$(".searcharea").val();
        //     $.ajax({
        //         url:"<?php echo U('Wechat/searchAddr');?>",
        //         type:"post",
        //         dataType: "json",
        //         data:{'value':val},
        //         async: "false",
        //         success:function(result){
        //         if(result){
        //             layer.msg("更新状态成功", { icon: 6 });
        //             parent.location.reload();
        //         }else{
        //             layer.msg("更新状态失败", { icon: 5 });
        //             }
        //         }
        //     })

        // }
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
                    parent.location.reload();
                }else{
                    layer.msg("绑定设备失败", { icon: 5 });
                    }
                }
            })

        });
    }
    </script>