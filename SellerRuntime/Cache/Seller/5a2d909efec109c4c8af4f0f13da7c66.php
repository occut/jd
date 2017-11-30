<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>微云控后台管理</title>
    <!-- layui.css -->
    <link href="/AdminResource/admin/plugin/layui/css/layui.css" rel="stylesheet" />
    <!-- font-awesome.css -->
    <link href="/AdminResource/admin/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- animate.css -->
    <link href="/AdminResource/admin/css/animate.min.css" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="/AdminResource/css/main.css" rel="stylesheet" />
    <link href="/AdminResource/css/index_style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/AdminResource/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/AdminResource/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/zTree/css/zTreeStyle/zTreeStyle.css">

    <!--<script type="text/javascript" src="/AdminResource/js/jquery-1.12.3.min.js"></script>-->
    <!--<script src="/AdminResource/admin/plugin/layui/layui.js"></script>-->
    <!--<script src="/AdminResource/admin/plugin/layui/layui.all.js"></script>-->
</head>
<body>
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
            <form class="layui-form" method="post" action="#" id="formid">
                <input type="hidden" value="<?php echo ($result["task_id"]); ?>" name="task_id">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">SkuId</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="text" name="skuid" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input" id="skuid"  value="<?php echo ($result["skuid"]); ?>">
                    </div>
                </div>
                <!--<div class="layui-form-item">-->
                    <!--<label class="layui-form-label" style="width:150px;">商品</label>-->
                    <!--<div class="layui-input-inline" style="width:300px;margin-left:0px;">-->
                        <!--<input type="text" name="product" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo ($result["task_name"]); ?>">-->
                    <!--</div>-->
                <!--</div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">件数</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="number" name="num" required  lay-verify="required" placeholder="下单商品件数" autocomplete="off" class="layui-input" id="num" value="<?php echo ($result["num"]); ?>">
                    </div>
                    <div class="layui-form-mid layui-word-aux">单个账号一次购买的商品件数</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">关键词</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="text" name="keyword" required  lay-verify="required" placeholder="此处只填写搜索商品关键词,如:电饭锅" id="keyword" autocomplete="off" class="layui-input" value="<?php echo ($result["keyword"]); ?>">
                    </div>
                </div>
                <!--<div class="layui-form-item">-->
                    <!--<label class="layui-form-label" style="width:150px;">所在页</label>-->
                    <!--<div class="layui-input-inline" style="width:300px;margin-left:0px;">-->
                        <!--<input type="number" name="page" required  lay-verify="required" placeholder="入口地址未搜索页时,请填写商品所在页数" autocomplete="off" class="layui-input" value="<?php echo ($result["page"]); ?>">-->
                    <!--</div>-->
                <!--</div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">描述</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <textarea id="des" type="text" name="description" required  lay-verify="required" placeholder="搜索时是否需要筛选条件：如，卡价格，卡地区，如没有无需填写" autocomplete="off" class="layui-input"><?php echo ($result["description"]); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">订单数量</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input  type="number" name="order_num" required  lay-verify="required" placeholder="购物车订单需要重复做的次数" autocomplete="off" class="layui-input order" min="1" id="order_num" value="<?php echo ($result["order_num"]); ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">任务类型</label>
                    <div class="layui-input-inline" style="width:300px;">
                        <select  name="task_type" lay-verify="required" id="task_type">
                            <option value="1" <?php if($result["task_type"] == 1): ?>selected<?php endif; ?>>电脑单</option>
                            <option value="2" <?php if($result["task_type"] == 2): ?>selected<?php endif; ?>>手机单</option>
                            <option value="3" <?php if($result["task_type"] == 3): ?>selected<?php endif; ?>> 手Q单</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">店铺名</label>
                    <div class="layui-input-inline" style="width:300px;">
                        <select  name="shop" lay-verify="required" id="shop">
                            <?php if(is_array($shop)): $i = 0; $__LIST__ = $shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($result["shop"] == $vo.id): ?>selected<?php endif; ?>><?php echo ($vo["shop_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">是否物流</label>
                    <div class="layui-input-block">
                        <input type="radio" name="transfer" class="transfer" value="0" title="不需要物流" checked lay-filter="transfer" <?php if($result["transfer"] == 0): ?>checked<?php endif; ?>>
                        <input type="radio" name="transfer" class="transfer" value="1" title="需要物流(顺丰物流2.5金币)" lay-filter="transfer" <?php if($result["transfer"] == 1): ?>checked<?php endif; ?>>
                    </div>
                    <div class="layui-input-inline transfer pull-left" style="width:300px;margin-left:0px;" id="transfer">
                        物流合计:<span n="<?php if($result["transfer"] == 1): ?>需要物流 <?php else: ?>不需要物流<?php endif; ?>"></span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">订单金额</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="text" name="order_money"  placeholder="每笔订单实际付款的金额" autocomplete="off" class="layui-input order" id="order_money"  value="<?php echo ($result["order_money"]); ?>">
                    </div>
                    <br/>
                    <div class="layui-input-block order_money" style="width:300px;margin-left:0px;color: red;" >
                        货款合计:<span></span>
                    </div>
                </div>
                <!--<div class="layui-form-item">-->
                    <!--<label class="layui-form-label"  style="width:150px;">是否收藏</label>-->
                    <!--<div class="layui-input-block">-->
                        <!--<input type="radio" name="likes" value="0" title="收藏" <?php if($result["likes"] == 0): ?>checked<?php endif; ?>>-->
                        <!--<input type="radio" name="likes" value="1" title="非收藏" <?php if($result["likes"] == 1): ?>checked<?php endif; ?>>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">范围选择</label>
                    <div class="layui-input-inline" style="width:200px;margin-left:0px;">
                        <input class="layui-input" name="doTime" placeholder="执行时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" id="doTime" value="<?php echo ($result["dotime"]); ?>">
                    </div>
                    <!--<div class="layui-input-inline">-->
                    <!--<input class="layui-input" name="time[end]" placeholder="截止日" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">-->
                    <!--</div>-->
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">买家备注</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;">
                        <input type="text" id="buyer_mark" name="buyer_mark"  placeholder="下单时候需要备注什么或者留言" autocomplete="off" class="layui-input" value="<?php echo ($result["buyer_mark"]); ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"  style="width:150px;">结算方式</label>
                    <div class="layui-input-block" id="payWay">
                        <input type="radio" name="payWay" value="0" title="预付" lay-filter="pay" checked class="payWay" <?php if($result["payway"] == 0): ?>checked<?php endif; ?>>
                        <input type="radio" name="payWay" value="1" title="垫付" lay-filter="pay" class="payWay" <?php if($result["payway"] == 1): ?>checked<?php endif; ?>>
                    </div>
                    <div class="layui-input-block">
                        <i>预付：商家自行充值金币付款，佣金统一9元</i>
                    </div>
                    <div class="layui-input-block">
                        <i style="padding-left: 40px;">垫付：则是由平台先代付，商家隔天在打款，具体佣金联系对接人</i>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:150px;">单笔/佣金</label>
                    <div class="layui-input-inline" style="width:300px;margin-left:0px;" id="yongjing">
                        <input type="text" name="yongjing"  placeholder="" autocomplete="off" class="layui-input" readonly  id="tips1" value="<?php echo ($result["yongjing"]); ?>">
                    </div>
                    <div class="layui-input-block yongjing" style="width:300px;margin-left:0px;color: red;" >
                        佣金合计:<span n="<?php if($result["payWay"] == 1): ?>垫付 <?php else: ?>预付<?php endif; ?>"></span>
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
<script type="text/javascript" src="/AdminResource/js/jquery-1.12.3.min.js"></script>
<script src="/AdminResource/admin/plugin/layui/layui.js"></script>
<script src="/AdminResource/admin/plugin/layui/layui.all.js"></script>
<script src="/AdminResource/admin/plugin/layui/lay/modules/laydate.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<!--<script type="text/javascript" src="/AdminResource/js/main.js"></script>-->

<script src="/AdminResource/js/script123.js"></script>

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
    $('#sub').click(function(){
//        var mymessage=confirm("");
//        if(mymessage==true) {
        var skuid=$("#skuid").val();
        var num=$("#num").val();
        var keyword=$("#keyword").val();
        var des=$("#des").val();
        var order_num=$("#order_num").val();
        var task_type=$("#task_type").val();
        var type="";
        if (task_type==1){
            type="电脑单";
        }else if (task_type==2){
            type="手机单";
        }else{
            type="手Q单";
        }
        var order_money=$("#order_money").val();
        var shop=$("#shop").val();
        var transfer=$("#transfer span").text();
        var trans=$("#transfer span").attr('n');
        var wl=0;
//        if (transfer==0){
//            trans="不需要物流";
//            wl=0;
//        }else{
//            trans="需要物流";
//            wl=2.5;
//        }
        var doTime=$("#doTime").val();
        var buyer_mark=$("#buyer_mark").val();
        var payWay=$(".payWay").val();
        var pay=$(".yongjing span").attr('n');
//        if (payWay==0){
//            pay="预付";
//        }else{
//            pay="垫付";
//        }
        var tips1=$("#tips1").val();

        var yongj=parseFloat($("#tips1").val());

        var sum=parseFloat(order_num)*parseFloat(order_money)+parseFloat(order_num)*parseFloat(yongj)+parseFloat(transfer);
        var wuh=$(".transfer span").text();
        var  huoh=$(".order_money span").text();
        var yongh=$(".yongjing span").text();
        layer.open({
            type: 1
            ,area: ['600px', '400px']
            ,offset: 't' //具体配置参考：offset参数项
            ,content: '<table style="font-size: 16px;"><tr><td width="100" style="padding-left: 10px">skuid:</td><td width="100">'+skuid+'</td></tr><tr><td width="100" style="padding-left: 10px">件数:</td><td width="100">'+num+'</td></tr><tr><td width="100" style="padding-left: 10px">关键词:</td><td width="100">'+keyword+'</td></tr><tr><td width="100" style="padding-left: 10px">描述:</td><td width="100">'+des+'</td></tr><tr><td width="100" style="padding-left: 10px">订单数量:</td><td width="100">'+order_num+'</td></tr><tr><td width="100" style="padding-left: 10px">任务类型:</td><td width="100">'+type+'</td></tr><tr><td width="100" style="padding-left: 10px">订单金额:</td><td width="100">'+order_money+'</td></tr><tr><td width="100" style="padding-left: 10px">是否物流:</td><td width="100">'+trans+'</td></tr><tr><td width="100" style="padding-left: 10px">执行时间:</td><td width="100">'+doTime+'</td></tr><tr><td width="100" style="padding-left: 10px">买家备注:</td><td width="100">'+buyer_mark+'</td></tr><tr><td width="100" style="padding-left: 10px">结算方式:</td><td width="100">'+pay+'</td></tr><tr><td width="100" style="padding-left: 10px">单笔/佣金:</td><td width="100">'+tips1+'</td></tr><tr><td width="100" style="padding-left: 10px;color:red">物流合计:</td><td width="100">'+wuh+'</td></tr><tr><td width="100" style="padding-left: 10px;color:red">佣金合计:</td><td width="100">'+yongh+'</td></tr><tr><td width="100" style="padding-left: 10px;color:red">货款合计:</td><td width="100">'+huoh+'</td></tr><tr><td width="100" style="padding-left: 10px">合计:</td><td width="100">'+parseFloat(sum)+'</td></tr></table>'
            ,btn:['确认', '取消']
            ,btnAlign: 'c' //按钮居中
            ,shade: 0 //不显示遮罩
            ,yes: function(){
                $.ajax({
                    cache: true,
                    type: "POST",
                    url: '<?php echo U("Tasks/edittimeTasks");?>',
                    data: $('#formid').serialize(),// 你的formid
                    async: false,
                    success: function (data) {
                        if (data == 0) {
                            alert('余额不足，请充值');
                        } else if (data == 1){
                            alert('修改成功');
                            window.location.href='<?php echo U("Tasks/listTasks");?>';
//                            window.history.back()
                        }else{
                            alert('修改失败');
                        }
                    }
                });
            }
        });

        return false;
    });
    $(function () {
        //    总货款
        $('.order').bind('input propertychange', function() {
            var orderNum=$("#order_num").val();
            var orderMoney=$("#order_money").val();
            var benjing=parseInt(orderNum)*parseFloat(orderMoney);
            $('.order_money span').text(benjing);
        });
    })

</script>
<script>
    //Demo
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
<script type="text/javascript">
    layui.use('form', function(){
        var form = layui.form;

        form.on('radio(transfer)', function(data){
            //有物流
            if (data.value==1){
                var wuliu=parseInt($("#order_num").val())*2.5;
                $(".transfer span").text(wuliu);
                $(".transfer span").attr('n','需要物流');
            }else{
                var wuliu=0;
                $(".transfer span").text(0);
                $(".transfer span").attr('n','不需要物流');
            }
        });
        $('.order').bind('input propertychange', function() {
            var orderNum=parseFloat($("#order_num").val());
            var val=parseFloat($('#order_money').val());
            form.on('radio(pay)', function(data){
                if (data.value==1){
                    if (val<=200){
                        $(".yongjing span").text(10*orderNum);
                        $("#tips1").val(10);
                    }else if(val>200 && val<=500){
                        $(".yongjing span").text(11*orderNum);
                        $("#tips1").val(11);
                    }else if(val>500 && val<=1000){
                        $(".yongjing span").text(13*orderNum);
                        $("#tips1").val(13);
                    }else if(val>1000 && val<=1500){
                        $(".yongjing span").text(15*orderNum);
                        $("#tips1").val(15);
                    }else if(val>1500 && val<=2000){
                        $(".yongjing span").text(17*orderNum);
                        $("#tips1").val(17);
                    }else if(val>2000 && val<=2500){
                        $(".yongjing span").text(19*orderNum);
                        $("#tips1").val(19);
                    }else if(val>2500 && val<=3000){
                        $(".yongjing span").text(21*orderNum);
                        $("#tips1").val(21);
                    }else{
                        $(".yongjing span").text(val*0.008*orderNum);
                        $("#tips1").val(val*0.008);
                    }
                    $(".yongjing span").attr('n','垫付');
                }else{
                    $(".yongjing span").text(9*orderNum);
                    $("#tips1").val(9);
                    $(".yongjing span").attr('n','预付');
                }
            });
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
    });
</script>