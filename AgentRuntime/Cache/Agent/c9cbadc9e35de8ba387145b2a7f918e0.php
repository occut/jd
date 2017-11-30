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
<!-- Content Wrapper. Contains page content -->
<div class="layui-body" style="left:0px">
  <div class="content-wrapper" style="margin-left: 0px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        编辑个人信息
        <small></small>
      </h1>
     <!--  <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i>首页</li>
        <li>信息管理</li>
        <li class="active">编辑店铺</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box">
              <div class="box-header">
                         <!--<h3 class="box-title"><a href="<?php echo U('Shop/Shops');?>"><button type="button" class="btn btn-block btn-primary">发货地址管理</button></a></h3>-->
                    </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php echo U('Profile/index');?>" enctype="multipart/form-data">
              <div class="box-body">
                 <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">用户名</label>
                    <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                        <input type="hidden" name="ag_id" value="<?php echo ($data["ag_id"]); ?>">
                        <input type="text" name="shop_name" required  lay-verify="required" placeholder="" value="<?php echo ($data["ag_name"]); ?>" autocomplete="off" class="layui-input" readonly>
                    </div>
              </div>
              <div class="layui-form-item">
                  <label class="layui-form-label" style="width:150px;">密码</label>
                  <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                      <input type="password" name="ag_pw"  lay-verify="required" placeholder="为空不修改"  autocomplete="off" class="layui-input" >
                  </div>
              </div>
                  <div class="layui-form-item">
                      <label class="layui-form-label" style="width:150px;">手机</label>
                      <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                          <input type="text" name="ag_phone" required   placeholder="" value="<?php echo ($data["ag_phone"]); ?>" autocomplete="off" class="layui-input">
                      </div>
                  </div>
            <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">邮箱</label>
                    <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                        <input type="email" name="ag_mb"   placeholder="" value="<?php echo ($data["ag_mb"]); ?>" autocomplete="off" class="layui-input">
                    </div>
             </div>
                  <div class="layui-form-item">
                      <label class="layui-form-label" style="width:150px;">QQ</label>
                      <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                          <input type="text" name="ag_qq"  placeholder="" value="<?php echo ($data["ag_qq"]); ?>" autocomplete="off" class="layui-input">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label class="layui-form-label" style="width:150px;">微信</label>
                      <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                          <input type="text" name="ag_wx"   placeholder="" value="<?php echo ($data["ag_wx"]); ?>" autocomplete="off" class="layui-input">
                      </div>
                  </div>
                    <div class="box-footer" style="margin-left: 150px">
                        <button type="submit" class="btn btn-primary" id="sub">提交</button>
                        <button type="reset" class="btn btn-primary">重置</button>
                  </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  </div>
  <!-- /.content-wrapper -->
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