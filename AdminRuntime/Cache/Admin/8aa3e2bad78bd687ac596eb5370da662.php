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
<div class="content-wrapper" style="margin-left: 0px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            店铺查询
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div>
                        <h3 style="float: left;margin:10px 10px;"><button class="btn layui-btn box-title" onclick="delAll('<?php echo U('Shop/shopsreceipt');?>','确定收货么？')">收货</button></h3>
                        <form method="get" style="float: left;" action="<?php echo U('Shop/exportshop');?>">
                            <div class="box-header">
                                <input style="float:left;width:0px;" type="hidden" name="ids" id="ids" vallue="">
                                <input type="submit" value="导出" class="btn layui-btn box-title" onclick="iswechat()" style="width: 60px;margin-left: 0px;font-size: 14px;">
                            </div>
                        </form>
                        <input type="submit" value="评论" class="btn layui-btn box-title" onclick="comments('评论')"  style=" float: left;width: 60px;margin:10px 0px;font-size: 14px;">
                        <form method="post" style="float: left;" action="<?php echo U('Shop/Importshop');?>" enctype="multipart/form-data">
                            <div class="box-header">
                                <input style="float: left;"  type="file" name="ex"  >
                                <input type="submit" value="导入" class="btn layui-btn box-title" onclick="iswechat()" style="width: 60px;margin-left: 0px;font-size: 14px;float: left;">
                            </div>
                        </form>
                        <div>
                        <form method="get" style="float: left;" action="<?php echo U('Shop/shopSearch');?>">
                            <div class="box-header"style="float:left">
                                <select style="width:200px;height: 40px;border: 1px solid #E6E6E6;padding-left: 10px;" name='id' id="name" class="pull-left selectShop">
                                    <?php if(is_array($allShops)): $i = 0; $__LIST__ = $allShops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shopname): $mod = ($i % 2 );++$i;?><option value="<?php echo ($shopname["id"]); ?>" <?php if($id == $shopname['id']): ?>selected<?php endif; ?> ><?php echo ($shopname["shop_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <input class="layui-input" name="start" id="start" value="<?php echo session('timestart');?>" placeholder="开始日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" style="float:left;width:140px;margin-left:10px;">
                                <input class="layui-input" name="end" id="end" value="<?php echo session('timeend');?>" placeholder="截止日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" style="float:left;width:140px;margin-left:10px;">
                            </div>
                       
                            <div class="box-header" style="float:left">
                                <select style="width:80px;height: 40px;border: 1px solid #E6E6E6;padding-left: 10px;" name='ids' class="pull-left selectShop">
                                        <option value="1" <?php if(1 == session('wei_ids')): ?>selected<?php endif; ?>>账号</option>
                                        <option value="2" <?php if(2 == session('wei_ids')): ?>selected<?php endif; ?>>地址</option>
                                        <option value="3" <?php if(3 == session('wei_ids')): ?>selected<?php endif; ?>>手机号</option>
                                        <option value="4" <?php if(4 == session('wei_ids')): ?>selected<?php endif; ?>>订单号</option>
                                        <option value="5" <?php if(5 == session('wei_ids')): ?>selected<?php endif; ?>>订单状态</option>
                                </select>
                                <input class="layui-input" name="tiao" value="" placeholder="条件" style="float:left;width:140px;margin-left:10px;">
                                <select style="width:80px;height: 40px;border: 1px solid #E6E6E6;margin-left: 10px;" name='we_logistics' class="pull-left selectShop">
                                    <option value="1" <?php if(1 == session('we_logistics')): ?>selected<?php endif; ?>>物流</option>
                                    <option value="2" <?php if(2 == session('we_logistics')): ?>selected<?php endif; ?>>空包</option>
                                    <option value="3" <?php if(3 == session('we_logistics')): ?>selected<?php endif; ?>>非空包</option>

                                </select>

                                <!--<input class="layui-input" name="time[end]" value="<?php echo session('timeend');?>" placeholder="截止日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" style="float:left;width:140px;margin-left:10px;">-->
                                <input type="submit" value="查询" class="btn layui-btn box-title" style="width: 60px;margin-left:10px;font-size: 14px;">
                            </div>
                        </form>
                        <input type="submit" value="一键收货" id="receipt" class="btn layui-btn box-title" style="float: left;font-size: 14px;margin-top: 10px;">
                            <input class="layui-input" id="number" value="" placeholder="数量" style="float: left;font-size: 14px;margin-top: 10px; width: 80px;margin: 10px 5px;">
                            <input type="submit" value="选择收货笔数" id="pens" class="btn layui-btn box-title" style="float: left;font-size: 14px;margin-top: 10px;margin: 10px 5px;">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr class="tng">
                                     <th style = "text-align: center;"><input type="checkbox" id="dellAll" value=""></th>
                                     <th style = "text-align: center;">ID</th>
                                    <th style = "text-align: center;">手机号</th>
                                    <th style = "text-align: center;">账号</th>
                                    <th style = "text-align: center;">密码</th>
                                    <th style = "text-align: center;">IP</th>
                                    <th style = "text-align: center;">近期IP</th>
                                    <th style = "text-align: center;">地址</th>
                                    <th style = "text-align: center;">状态</th>
                                    <th style = "text-align: center;">订单号</th>
                                    <th style = "text-align: center;">物流单号</th>
                                    <th style = "text-align: center;">SKU</th>
                                    <th style = "text-align: center;">关键词</th>
                                    <th style = "text-align: center;">金额</th>
                                    <th style = "text-align: center;">下单时间</th>
                                    <th style = "text-align: center;">下单端口</th>
                                    <th style = "text-align: center;">收货评语</th>
                                    <th style = "text-align: center;">物流</th>
                                    <th style = "text-align: center;">任务进度</th>
                                    <th style = "text-align: center;">店铺名</th>
                                    <th style = "text-align: center;">收货时间</th>
                                    <th style = "text-align: center;">操作</th>
                                    <th style = "text-align: center;">完成设备</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($content)): $i = 0; $__LIST__ = $content;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$as): $mod = ($i % 2 );++$i;?><tr class="tnd" style = "text-align: center;">
                                    <td style = "text-align: center;"><input type="checkbox" value="<?php echo ($as["wei_id"]); ?>" name="delAll"></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_id"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_number"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_name"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_password"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_ip"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_ips"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_address"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_static"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["we_order"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["we_SKU"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["we_word"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["we_SKU"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_gold"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["bought_time"]); ?></td>
                                    <td ></td>
                                    <td onclick="add('评论','<?php echo U('Wechat/comment',array('wei_id'=>$as['wei_id']));?>')" style="cursor: pointer">
                                        <a href="javascript:;"><?php echo (subtext($as["comment"],8)); ?></a>
                                    </td>
                                    <td style = "text-align: center;"  ><?php echo ($as["we_port"]); ?></td>
                                    <td style = "text-align: center;" onclick="ishide('确定收货么？',this,<?php echo ($as["wei_id"]); ?>)"><?php echo ($as["wei_remarks"]); ?></td>
                                    <td style = "text-align: center;" id="sn" ><?php echo ($as["shop_name"]); ?></td>
                                    <td style = "text-align: center;" ><?php echo ($as["receipt_time"]); ?></td>
                                    <td style = "text-align: center;">
                                        <a href="javascript:if(confirm('确实要删除吗?'))location='<?php echo U('Wechat/deleteWechat',array('wei_id'=>$as['wei_id'],'gd'=>$groupId,'md'=>$menuId));?>'">删除</a>
                                    </td>
                                    <td style = "text-align: center;"><?php echo ($as["we_we"]); ?></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                     <div class="pagepadding">               
                <div class="col-sm-5"><div aria-live="polite" role="status" id="example2_info" class="dataTables_info">共<?php echo ($all); ?>条</div></div><div class="col-sm-7"><div id="example2_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><?php echo ($shoppage); ?></ul></div></div>
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
</div>
</div>
<script src="<?php echo ($resource); ?>admin/plugin/layui/layui.js"></script>
<script type="text/javascript">
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        var start = {
            min: laydate.now()
            ,max: '2099-06-16 23:59:59'
            ,istoday: false
            ,choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            min: laydate.now()
            ,max: '2099-06-16 23:59:59'
            ,istoday: false
            ,choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        document.getElementById('LAY_demorange_s').onclick = function(){
            start.elem = this;
            laydate(start);
            console.log(start);
        }
        document.getElementById('LAY_demorange_e').onclick = function(){
            end.elem = this
            laydate(end);
        }
    });
    function comments(title,w,h){
        var checkbox = $("input[type='checkbox'][name='delAll']");
        var str = '';
        $.each(checkbox, function(i, n){
            if(checkbox[i].checked == true){
                str += checkbox[i].value+',';
            }
        });
        url = "<?php echo U('Wechat/comment');?>"+"?wei_id="+str;
        x_admin_show(title,url,w,h)
    }
    function iswechat(){
        var checkbox = $("input[type='checkbox'][name='delAll']");
        var str = '';
        $.each(checkbox, function(i, n){
            if(checkbox[i].checked == true){
                str += checkbox[i].value+',';
            }
        });
        $("#ids").val(str);
    }
    function ishide(title,obj,id){
        if(title === undefined){
            title = '确认要删除吗？';
        }
        layer.confirm(title,function(index){
            var result =  post("<?php echo U('Shop/shopsreceipt');?>",{'ids':id});
            console.log(result == 1);
            if (result == 1){
                layer.msg("成功",{icon: 1,time:1000},function(){
                    $(obj).html('收货');
                    window.location.reload();
                });
            }else{
                layer.msg("失败",{icon: 5,time:1000});
            }
        });

    }
    $("#receipt").click(function(){
        var name = $('#name').val();
        var start = $('#start').val();
        var end = $('#end').val();
        $.ajax({
            url:"<?php echo U('Shop/Receipt');?>",
            type:"post",
            dataType: "json",
            data:{'name':name,'start':start,'end':end},
            async: "false",
            success:function(result){
                if(result == '1'){
                    layer.msg("一键收货成功", { icon: 6 });
                    parent.location.reload();
                }else if(result == '2'){
                    layer.msg("没有账号", { icon: 5 });
                }else if(result == '4'){
                    layer.msg("请选择参数", { icon: 5 });
                }else{
                    layer.msg("账号数据不足10", { icon: 5 });
                }
            }
        })
    });
    //收货笔数
    $("#pens").click(function(){
        var name = $('#name').val();
        var start = $('#start').val();
        var end = $('#end').val();
        var number = $('#number').val();
        $.ajax({
            url:"<?php echo U('Shop/NumberOfPens');?>",
            type:"post",
            dataType: "json",
            data:{'name':name,'start':start,'end':end,'number':number},
            async: "false",
            success:function(result){
                console.log(result);
                if(result == '1'){
                    layer.msg("一键收货成功", { icon: 6 });
                    location.reload();
                }else if(result == '2'){
                    layer.msg("没有账号", { icon: 5 });
                }else if(result == '4'){
                    layer.msg("请选择参数", { icon: 5 });
                }else{
                    layer.msg("账号数据不足10", { icon: 5 });
                }
            }
        })
    });
</script>
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