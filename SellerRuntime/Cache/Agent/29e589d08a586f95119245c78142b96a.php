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
                        <h3 style="float: left;margin:10px 10px;"><button class="btn layui-btn box-title" onclick="delAll('<?php echo U('Shop/shopsreceipt');?>','确定收货么？')">批量收货</button></h3>
                        <form method="get" style="float: left;" action="<?php echo U('Shop/exportshop');?>">
                            <div class="box-header">
                                <input style="float:left;width:0px;" type="hidden" name="ids" id="ids" vallue="">
                                <input type="submit" value="账号导出" class="btn layui-btn box-title" onclick="iswechat()" style="margin-left: 0px;font-size: 14px;">
                            </div>
                        </form>
                        <input type="submit" value="批量评论" class="btn layui-btn box-title" onclick="comments('评论')"  style=" float: left;margin:10px 0px;font-size: 14px;">
                        <form method="post" style="float: left;" action="<?php echo U('Shop/Importshop');?>" enctype="multipart/form-data">
                            <div class="box-header">
                                <input style="float: left;"  type="file" name="ex"  >
                                <input type="submit" value="文件导入" class="btn layui-btn box-title" onclick="iswechat()" style="margin-left: 0px;font-size: 14px;float: left;">
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
                                <input type="submit" value="查询" class="btn layui-btn box-title" style="width: 60px;margin-left:10px;font-size: 14px;">
                            </div>
                        </form>
                        <input type="submit" value="一键收货" id="receipt" class="btn layui-btn box-title" style="float: left;font-size: 14px;margin-top: 10px;">
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
                                    <!--<th style = "text-align: center;">密码</th>-->
                                    <th style = "text-align: center;">注册时间</th>
                                    <th style = "text-align: center;">IP</th>
                                    <th style = "text-align: center;">地址</th>
                                    <th style = "text-align: center;">状态</th>
                                    <th style = "text-align: center;">订单号</th>
                                    <th style = "text-align: center;">金额</th>
                                    <th style = "text-align: center;">下单时间</th>
                                    <!--<th style = "text-align: center;">收货时间</th>-->
                                    <th style = "text-align: center;">收货评语</th>
                                    <th style = "text-align: center;">多久评价</th>
                                    <th style = "text-align: center;">追评评语</th>
                                    <th style = "text-align: center;">追评时间</th>
                                    <th style = "text-align: center;">备注</th>
                                    <th style = "text-align: center;">店铺名</th>
                                    <th style = "text-align: center;">收货时间</th>
                                    <th style = "text-align: center;">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($content)): $i = 0; $__LIST__ = $content;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$as): $mod = ($i % 2 );++$i;?><tr class="tnd" style = "text-align: center;">
                                    <td style = "text-align: center;"><input type="checkbox" value="<?php echo ($as["wei_id"]); ?>" name="delAll"></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_id"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_number"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_name"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_time"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_ip"]); ?></td>
                                    <td style = "text-align: center;"><?php echo (subtext($as["wei_address"],8)); ?></td>
                                    <td style = "text-align: center;">
                                        <?php if(($as["wei_static"]) == "0"): ?>正常
                                            <?php elseif($as['wei_static'] == 2): ?>登录中
                                            <?php elseif($as['wei_static'] == 3): ?>登录成功
                                            <?php elseif($as['wei_static'] == 4): ?>任务完成
                                            <?php elseif($as['wei_static'] == 5): ?>任务未完成
                                            <?php else: ?>禁用<?php endif; ?></td>

                                    </td>
                                    <td style = "text-align: center;"><?php echo (subtext($as["we_order"],10)); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["wei_gold"]); ?></td>
                                    <td style = "text-align: center;"><?php echo ($as["bought_time"]); ?></td>
                                     <td onclick="add('评论','<?php echo U('Wechat/comment',array('wei_id'=>$as['wei_id']));?>')" style="cursor: pointer">
                                        <a href="javascript:;"><?php echo (subtext($as["comment"],8)); ?></a>
                                    </td>
                                    <td style = "text-align: center;"  ><?php echo ($as["longs"]); ?></td>
                                    <td style = "text-align: center;"  ><?php echo ($as["ratings"]); ?></td>
                                    <td style = "text-align: center;"  ><?php echo ($as["ratings_time"]); ?></td>
                                    <td style = "text-align: center;" onclick="ishide('确定收货么？',this,<?php echo ($as["wei_id"]); ?>)"><?php echo ($as["wei_remarks"]); ?></td>
                                    <td style = "text-align: center;" id="sn" ><?php echo ($as["shop_name"]); ?></td>
                                    <td style = "text-align: center;" ><?php echo ($as["receipt_time"]); ?></td>
                                    <td style = "text-align: center;">
                                        <a href="javascript:if(confirm('确实要删除吗?'))location='<?php echo U('Wechat/deleteWechat',array('wei_id'=>$as['wei_id'],'gd'=>$groupId,'md'=>$menuId));?>'">删除</a>
                                    </td>
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