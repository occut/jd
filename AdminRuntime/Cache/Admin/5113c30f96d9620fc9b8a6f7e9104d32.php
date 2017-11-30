<?php if (!defined('THINK_PATH')) exit();?><!--<!DOCTYPE html>-->
<!--<html>-->

<!--<head>-->
    <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />-->
    <!--<title>普通关键字检索</title>-->
<!DOCTYPE html>
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
    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
        }
        body,
        button,
        input,
        select,
        textarea {
            font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
        }
        p {
            width: 603px;
            padding-top: 3px;
            margin-top: 10px;
            overflow: hidden;
        }
    </style>
     <script type="text/javascript" src="<?php echo ($resource); ?>js/jquery-1.12.3.min.js"></script>
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>

</head>

<body onload="init()" style="background-color: #ecf0f5">
<div class="layui-body">
    <script>
        var searchService, markers = [];
        var init = function() {
            var center = new qq.maps.LatLng(39.916527, 116.397128);
            var map = new qq.maps.Map(document.getElementById('container'), {
                center: center,
                zoom: 13
            });

            var latlngBounds = new qq.maps.LatLngBounds();
            //设置Poi检索服务，用于本地检索、周边检索
            searchService = new qq.maps.SearchService({
                //设置搜索范围为北京
                location: "北京",
                //设置搜索页码为1
                pageIndex: 1,
                //设置每页的结果数为5
                pageCapacity: 5,
                //设置展现查询结构到infoDIV上
                panel: document.getElementById('infoDiv'),
                //设置动扩大检索区域。默认值true，会自动检索指定城市以外区域。
                autoExtend: true,
                //检索成功的回调函数
                complete: function(results) {
                    //设置回调函数参数
                    var pois = results.detail.pois;
                    for (var i = 0, l = pois.length; i < l; i++) {
                        var poi = pois[i];
                        //扩展边界范围，用来包含搜索到的Poi点
                        latlngBounds.extend(poi.latLng);
                        var marker = new qq.maps.Marker({
                            map: map,
                            position: poi.latLng
                        });

                        marker.setTitle(i + 1);

                        markers.push(marker);

                    }
                    //调整地图视野
                    map.fitBounds(latlngBounds);
                },
                //若服务请求失败，则运行以下函数
                error: function() {
                    alert("出错了。");
                }
            });

            // 点击一个地方获取经纬度
//    qq.maps.event.addListener(map, 'click', function(event) {
//        var showl=document.getElementById('showl');
//        showl.innerHTML="您点击的位置纬度为:"+event.latLng.getLat()+"经度为："+event.latLng.getLng();
//    });

        }

         //清除地图上的marker
            function clearOverlays(overlays) {
                var overlay;
                while (overlay = overlays.pop()) {
                    overlay.setMap(null);
                }
            }
            //设置搜索的范围和关键字等属性
            function searchKeyword() {
                var keyword = document.getElementById("keyword").value;
                var num = document.getElementById("shownum").value;
                clearOverlays(markers);
                //根据输入的城市设置搜索范围
                // searchService.setLocation("北京");
                //根据输入的关键字在搜索范围内检索
                // var html=$("#showl").html();
                searchService.search(keyword);
                $.ajax({
                    url:"<?php echo U('Tasks/getlocation2');?>",
                    type:"post",
                    dataType: "json",
                    data:{'keyword':keyword,'shownum':num},
                    async: "false",
                    success:function(result){
                        $("#showl").html(result['data']);
                    }
                })
            }
    </script>
    <div style="margin-top: 10px;">
        <input id="keyword" type="textbox" placeholder="请输入关键字" class="layui-input" style="width:200px;float: left">
         <input type="text" class="layui-input" placeholder="请输入数量" id="shownum" style="width:200px;float: left;margin-left:10px">
        <input type="button" value="搜索" onclick="searchKeyword()" class="layui-btn layui-btn-normal" style="float:left;margin-left: 10px;outline: none">
        <!-- <input type="submit" value="确定" onclick="uploadLocation()"> -->
        <button class="layui-btn layui-btn-normal" onclick="addtodb()">添加到地址库</button>

       
        <div class="clearfix"></div>
    </div>

    <div style="width:800px;height:300px;margin-bottom:50px;margin-top:10px" id="container"></div>
    <!--<div style='width: 500px; height: 180px' id="infoDiv"></div>-->
    <div  style="display: inline;font-size: 16px;" name="jinwei">
        <ul style="display: block;height: 200px;" id="showl">
            
        </ul>
    </div>
</div>
</body>
<script type="text/javascript">
    function addtodb(){
    var str="";
        $("#showl li").each(function(){
            var val=$(this).html();
            if(val!=""){
                str=str+","+val;
            }
        });
        $.ajax({
            url:"<?php echo U('Tasks/addto');?>",
            type:"post",
            dataType: "json",
            data:{'str':str},
            async: "false",
            success:function(result){
                if(result==1){
                layer.msg("添加成功", { icon: 6 });
                parent.location.reload();
                }else{
                layer.msg("添加失败", { icon: 5 });
                }
            }

        })
    }
</script>
<!--</html>-->
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