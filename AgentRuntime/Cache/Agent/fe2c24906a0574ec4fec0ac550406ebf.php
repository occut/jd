<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="<?php echo ($resource); ?>admin/plugin/layui/css/layui.css" rel="stylesheet" />
    <title>显示评论</title>
</head>
<body>
<br/>
<form class="layui-form "  method="post" action="<?php echo U('Wechat/editComment');?>">
    <div class="layui-form-item layui-form-text">
        <div class="layui-input-block" style="margin:5px;">
        <textarea name="comment" style="width: 100%;height: 400px;border:1px solid #E6E6E6;"><?php echo ($data); ?></textarea>
        </div>
        <input type="hidden" name="wei_number" value="<?php echo ($number); ?>">
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button  class="layui-btn btn-submit logSubmit" id="signIn" lay-submit lay-filter="signIn">
                提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script type="text/javascript" src="<?php echo ($resource); ?>layui/layui.js"></script>
<script src="<?php echo ($resource); ?>js/script123.js"></script>


<script>

    //Demo
        //监听提交
    layui.use(['form'],function () {
        $ = layui.jquery;

        $("#signIn").click(function(data){
            var url = $('.layui-form').attr("action");
            var data = $('.layui-form').serialize();
            layer.msg("添加成功", { icon: 6 });
            $.ajax( {
                url: url,
                type: "post",
                data:data,
                async: false,
                success: function(data){
                    console.log(data);
                    if(data == 1){
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
                }
            });
            return false;
            });
    });
</script>

</body>
</html>