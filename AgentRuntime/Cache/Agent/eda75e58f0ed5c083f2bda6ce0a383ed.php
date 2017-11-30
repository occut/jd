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

                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="layui-form" action="" method="post" id="formid">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">金额</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="title" required  lay-verify="required" placeholder="请输入金额" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">操作人</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="operation" required  lay-verify="required" placeholder="操作人员" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo ($pa_id); ?>">
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn" lay-submit lay-filter="formDemo" id="charge">充值</button>
                                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                    </div>
                                </div>
                            </form>
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
<script type="text/javascript" src="<?php echo ($resource); ?>layui/layui.js"></script>
<script src="<?php echo ($resource); ?>js/script123.js"></script>
<script>
    $('#charge').click(function(){
        $.ajax({
            cache: true,
            type: "POST",
            url:"<?php echo U('Index/Import');?>",
            data:$('#formid').serialize(),// 你的formid
            async: false,
            success: function(data) {
                if(data==0){
                    alert('充值失败');
                }else{
                    alert('充值成功');
                    parent.location.href='<?php echo U("Agent/payment");?>';
                }
            }
        });
        return false;
    });
    //Demo
    //监听提交
    layui.use(['form'],function () {
        $ = layui.jquery;
        var form = layui.form();
        form.on('submit(signIn)',function (data) {

            var result = post(data.form.action,data.field);
            console.log(result);
            if(result == 1){
                layer.msg("添加成功", { icon: 6 });
                layer.closeAll('page');
                layer.alert("添加成功",{ icon: 1,skin: 'layer-ext-moon' },function(){
                    parent.location.reload();
                });
            }else{
                layer.alert("添加失败",{icon:2, skin:'layer-ext-moon' },function () {
                    location.reload();
                });
            }
            return false;
        });
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