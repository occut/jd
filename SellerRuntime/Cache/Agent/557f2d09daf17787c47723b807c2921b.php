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
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
</script>
<!--引用编辑器-->
<!-- Content Wrapper. Contains page content -->
<div class="layui-body" style="left:0;">
    <div class="content-wrapper" style = "margin-left:1px ;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                编辑任务
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div style="margin-bottom: 20px">
                <a href="<?php echo U('Tasks/listTasks');?>" class="layui-btn ">任务管理</a>
            </div>
            <form class="layui-form" method="post" action="<?php echo U('Tasks/edittimeTasks');?>">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">任务名称</label>
                    <div class="layui-input-inline" style="width:400px;margin-left:0px;">
                        <input type="hidden" name="time_id" value="<?php echo ($tasks["time_id"]); ?>">
                        <input type="text" name="title" required  lay-verify="required" placeholder="请输入任务名称" value="<?php echo ($tasks["time_title"]); ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">设备分组</label>
                    <div class="layui-input-block" style="width:400px;margin-left:150px;">
                        <select  name="tasksgroupid" lay-verify="required">

                            <?php if(is_array($tasksgroup)): $i = 0; $__LIST__ = $tasksgroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tasksgroup): $mod = ($i % 2 );++$i;?><option value="<?php echo ($tasksgroup["group_id"]); ?>" <?php if(($tasksgroup['group_name'] == $tasks['group_name'])): ?>selected<?php endif; ?>><?php echo ($tasksgroup["group_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <!-- 地址Start -->
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">地址</label>
                    <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                        <select name="provinceId" lay-verify="required" lay-filter="province" class="layui-input">
                            <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pr): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pr["id"]); ?>" name="<?php echo ($pr["id"]); ?>" <?php if($id['pr_id'] == $pr['id']): ?>selected<?php endif; ?>><?php echo ($pr["province"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:200px;margin-left:0px;" id="listAllConfigs">
                        <!--<div class="form-group" id="listAllConfigs"></div>-->
                        <select name="cityId" lay-verify="required" lay-filter="province" class="layui-input">
                            <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ct): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ct["id"]); ?>" name="<?php echo ($ct["id"]); ?>" <?php if($id['ci_id'] == $ct['id']): ?>selected<?php endif; ?>><?php echo ($ct["city"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <!-- 地址Over -->
                <!--<div class="layui-form-item">-->
                <!--<label class="layui-form-label" style="width:150px;">网站地址URL</label>-->
                <!--<div class="layui-input-inline" style="width:400px;margin-left:0px;">-->
                <!--<input type="text" name="url" value="<?php echo ($tasks["time_url"]); ?>" required  lay-verify="required" placeholder="请输入网站地址URL" autocomplete="off" class="layui-input">-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="layui-form-item">-->
                <!--<label class="layui-form-label" style="width:150px;">经纬度</label>-->
                <!--<div class="layui-input-inline" style="width:400px;margin-left:0px;">-->
                <!--<input type="text" name="ip" value="<?php echo ($tasks["time_ip"]); ?>" required  lay-verify="required" placeholder="请输入网站地址URL" autocomplete="off" class="layui-input">-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="layui-form-item">-->
                <!--<label class="layui-form-label" style="width:150px;">范围选择</label>-->
                <!--<div class="layui-input-inline" style="width:200px;margin-left:0px;">-->
                <!--<input class="layui-input" name="time[start]" value="<?php echo ($tasks["time_starttime"]); ?>"  placeholder="开始日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">-->
                <!--&lt;!&ndash;<input class="layui-input" name="time[]" placeholder="开始日" id="LAY_demorange_s">&ndash;&gt;-->
                <!--</div>-->
                <!--<div class="layui-input-inline">-->
                <!--<input class="layui-input" name="time[end]" value="<?php echo ($tasks["time_endtime"]); ?>" placeholder="截止日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">-->
                <!--&lt;!&ndash;<input class="layui-input" name="time[]" placeholder="截止日" id="LAY_demorange_e">&ndash;&gt;-->
                <!--</div>-->
                <!--</div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">预设流量</label>
                    <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                        <input type="text" name="flow" value="<?php echo ($tasks["time_flow"]); ?>" required  lay-verify="required" placeholder="预设流量" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">下单量</div>
                </div>

                <!--<div class="layui-form-item">-->
                <!--<label class="layui-form-label" style="width:150px;">用户操作次数</label>-->
                <!--<div class="layui-input-inline" style="width:200px;margin-left:0px;">-->
                <!--<input type="text" name="frequency" value="<?php echo ($tasks["time_frequency"]); ?>" required  lay-verify="required" placeholder="用户操作次数" autocomplete="off" class="layui-input">-->
                <!--</div>-->
                <!--<div class="layui-form-mid layui-word-aux">辅助文字</div>-->
                <!--</div>-->
                <!--<div class="layui-form-item">-->
                <!--<label class="layui-form-label" style="width:150px;">用户操作停留时间</label>-->
                <!--<div class="layui-input-inline" style="width:200px;margin-left:0px;">-->
                <!--<input type="text" name="stop" value="<?php echo ($tasks["time_stop"]); ?>" required  lay-verify="required" placeholder="用户操作停留时间" autocomplete="off" class="layui-input">-->
                <!--</div>-->
                <!--<div class="layui-form-mid layui-word-aux">单位：秒</div>-->
                <!--</div>-->
                <!--<div class="layui-form-item">-->
                <!--<label class="layui-form-label" style="width:150px;">用户操作行为</label>-->
                <!--<div class="layui-input-inline" style="width:200px;margin-left:0px;">-->
                <!--<input type="text" name="behavior" value="<?php echo ($tasks["time_behavior"]); ?>" required  lay-verify="required" placeholder="用户操作行为" autocomplete="off" class="layui-input">-->
                <!--</div>-->
                <!--</div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">任务状态</label>
                    <div class="layui-input-block"  style="width:200px;margin-left:150px;">
                        <input type="radio" name="time_status" value="0" title="开启"  <?php if($tasks['time_status'] == 0) echo "checked"; ?>>
                        <input type="radio" name="time_status" value="1" title="关闭" <?php if($tasks['time_status'] == 1) echo "checked"; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
            <script src="<?php echo ($resource); ?>layui/layui.js"></script>
            <script src="<?php echo ($resource); ?>layui/lay/modules/laydate.js"></script>
            <script>

                //Demo
                layui.use('form', function(){
                    var form = layui.form();

                    //监听提交
                    form.on('submit(formDemo)', function(data){
                        layer.msg(JSON.stringify(data.field));
                        return false;
                    });
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
            </script>
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
<script type="text/javascript">
    layui.use('form', function(){
        var form = layui.form();

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
    });
</script>