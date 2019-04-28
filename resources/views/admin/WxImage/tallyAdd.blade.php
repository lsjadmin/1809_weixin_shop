
<style>
    no-padding {
        padding: 0 !important;
    }
    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
        background-color:#fff;
    }

    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd;
    }
    .table-responsive {
        min-height: .01%;
        overflow-x: auto;
    }
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    div {
        display: block;
    }
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        font-weight: 400;
        overflow-x: hidden;
        overflow-y: auto;
    }
    body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
    }
    html {
        font-size: 10px;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
    }
    html {
        font-family: sans-serif;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
    }
    .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
        content: " ";
        display: table;
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .box-header:after, .box-body:after, .box-footer:after {
        clear: both;
    }
    .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
        content: " ";
        display: table;
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">添加标签 </h3>
        <div class="box-tools">
            <div class="btn-group pull-right" style="margin-right: 5px">
            <a href="/admin/mass/thelabel" class="btn btn-sm btn-default" title="列表"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;列表</span></a>
        </div>
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
<form action="http://www.project.com/admin/mass/labeldo" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">
    <div class="box-body">
    <div class="fields-group">
        <div class="form-group ">
            <label for="openid" class="col-sm-2  control-label">标签名</label>
            <div class="col-sm-8">
            <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
            <input type="text" id="openid" name="openid" value="" class="form-control openid" placeholder="输入 标签名"></div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    <input type="hidden" name="_token" value="dlaTdF3vFfKXUu1PDRyTWC373MK2IhnPY72fV1kv"><div class="col-md-2">
    </div>
    <div class="col-md-8">
    <div class="btn-group pull-right">
    <a class="btn btn-primary" id="sub" href="javascript:;">提交</a>
    </div>
    <label class="pull-right" style="margin: 5px 10px 0 0;">
    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> 继续编辑
    </label>
    <label class="pull-right" style="margin: 5px 10px 0 0;">
    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="2" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> 继续创建
    </label>
    <label class="pull-right" style="margin: 5px 10px 0 0;">
    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="3" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> 查看
    </label>
    <div class="btn-group pull-left">
    <button type="reset" class="btn btn-warning">重置</button>
    </div>
    </div>
    </div>
    <input type="hidden" name="_previous_" value="http://www.project.com/admin/userwx"><!-- /.box-footer -->
</form>
</div>
</div>
</div>
</section>
</body>
</html>
<script src="\layui\layui.js"></script>
<script src="\layui\layui.all.js"></script>

<script>
$(function(){
    layui.use('layer', function(){
    var layer = layui.layer;
        $("#sub").click(function(){
            var name =$("#openid").val();
            // console.log(name);
            $.get(
                '/admin/tally',
                {name:name},
                function(res){
                    layer.msg(res.font,{icon:res.code});
                    console.log(res);
                }
            );
        })
    })
})
</script>
