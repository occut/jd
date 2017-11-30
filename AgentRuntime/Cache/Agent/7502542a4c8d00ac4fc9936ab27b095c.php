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
<!--引用编辑器-->
<script type="text/javascript" src="<?php echo ($resource); ?>editor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="<?php echo ($resource); ?>editor/ueditor.all.js"></script>
<!--引用编辑器-->
<!-- Content Wrapper. Contains page content -->
<div class="layui-body" style="left:0;">
    <div class="content-wrapper" style = "margin-left:1px ;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                添加流量任务
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div style="margin-bottom: 20px">
                <a href="<?php echo U('Tasks/flow');?>" class="layui-btn">流量任务管理</a>
            </div>
            <form class="layui-form" method="post" action="<?php echo U('Tasks/liuliangEdit');?>">
                <input type="hidden" value="<?php echo ($result["liuliang_id"]); ?>" name="liuliang_id">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">SkuId</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="text" name="skuid" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo ($result["sku"]); ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">关键词</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="text" name="keyword" required  lay-verify="required" placeholder="此处只填写搜索商品关键词,如:电饭锅" autocomplete="off" class="layui-input" value="<?php echo ($result["keyword"]); ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">端口类型</label>
                    <div class="layui-input-inline" style="width:300px;">
                        <select  name="port_type" lay-verify="required">
                            <option value="1" <?php if($result["port"] == 1): ?>selected<?php endif; ?>>无限流量</option>
                            <option value="2"<?php if($result["port"] == 2): ?>selected<?php endif; ?>>PC流量</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">发布数量</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="number" name="report_num" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input" min="1" id="report_num" value="<?php echo ($result["fabushuliang"]); ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">店铺名</label>
                    <div class="layui-input-inline" style="width:300px;">
                        <select  name="shop" lay-verify="required">
                            <?php if(is_array($shops)): $i = 0; $__LIST__ = $shops;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($result["shop"] == $vo.id): ?>selected<?php endif; ?>><?php echo ($vo["shop_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">执行时间</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input class="layui-input" name="doTime" placeholder="执行时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($result["excute"]); ?>">
                </div>
                 <!--<div class="layui-input-inline">-->
                     <!--<input class="layui-input" name="time[end]" placeholder="截止日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">-->
               <!--</div>-->
            </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;" id="showmoney">总费用结算:</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;" >
                        <input type="text"  placeholder="" autocomplete="off" class="layui-input" name="allMoney" readonly id="allMoney" value="<?php echo ($result["cost"]); ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo" id="sub">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>

        </section>
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
<script src="/AdminResource/admin/plugin/layui/layui.js"></script>
<script src="/AdminResource/admin/plugin/layui/lay/modules/laydate.js"></script>
<script>
</script>
<script>
    $('#report_num').bind('input propertychange', function() {
        var benjing=parseInt($("#report_num").val())*0.3;
        $('#allMoney').val(Math.round(parseFloat(benjing)));
    });
    //Demo
    layui.use('form', function(){
        var form = layui.form();
        form.on('radio(transfer)', function(data){
            if (data.value==1){
                var wuliu=parseInt($("#order_num").val())*2.5;
                $("#wuliu").val(wuliu);
            }else{
                var wuliu=0;
                $("#wuliu").val(wuliu);
            }
        });
        form.on('radio(pay)', function(data){
            console.log(data.elem); //得到radio原始DOM对象
            console.log(data.value); //被点击的radio的value值
            if (data.value==1){
                $("#tips").css('display','none');
                $("#tips1").css('display','block');
                $('#order_money').bind('input propertychange', function() {
                    var val=parseFloat($(this).val());
                    if (val<=200){
                        $("#tips1").val(10);
                    }else if(val>200 && val<=500){
                        $("#tips1").val(11);
                    }else if(val>500 && val<=1000){
                        $("#tips1").val(13);
                    }else if(val>1000 && val<=1500){
                        $("#tips1").val(15);
                    }else if(val>1500 && val<=2000){
                        $("#tips1").val(17);
                    }else if(val>2000 && val<=2500){
                        $("#tips1").val(19);
                    }else if(val>2500 && val<=3000){
                        $("#tips1").val(21);
                    }else{
                        $("#tips1").val(val*0.008);
                    }
                    var dingdan=parseInt($("#order_num").val());
                    var jinge=parseFloat($("#tips1").val());
                    $("#yonjing").val(dingdan*jinge);
                });

            }else{
                $("#tips").css('display','block');
                $("#tips1").css('display','none');
                $("#yonjing").val(parseInt($("#order_num").val())*9);
            }
        });

        form.on('select(province)', function(data){
//            console.log(data.elem); //得到select原始DOM对象
            var id = data.value; //得到被选中的值
//            console.log(data.othis); //得到美化后的DOM对象
            // alert(id);
            $.ajax({
                url:"<?php echo U('Tasks/city');?>",
                type:"post",
                dataType: "json",
                data:{'configId':id },
                async: "false",
                success:function(result){
                    // alert(123);
                    // alert(result.value);
                    $("#listAllConfigs").empty();
                    $("#listAllConfigs").append("<select style='display:block'   name='cityId' lay-verify='required'  class='layui-input'>"+result.value+"</select>");
                }

            })

        });
        form.render();
    });
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
    });
</script>