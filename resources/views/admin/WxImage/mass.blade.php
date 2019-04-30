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
    <title>群发</title>
</head>
<body>
<div class="box-body table-responsive no-padding content">
    <table class="table table-hover">
        <tr>
            
            <td>id</td>
            <td>openID</td>
            <td>用户名</td>
        </tr>
        @foreach($userInfo as $k=>$v)
        <tr>
            <td><input type="checkbox" class="box" openid="{{$v->openid}}"></td>
            <td>{{$v->user_id}}</td>
            <td>{{$v->openid}}</td>
            <td>{{$v->nickname}}</td>
        </tr>
        @endforeach
    </table>
    <input type="button" id="sub"  class="btn btn-primary"value="确认">
</div>
<select name="" id="_select">
    <option value="">请选择要选择的标签</option>
    @foreach($arr as $v)
        <option value="{{$v['id']}}">{{$v['name']}}</option>
    @endforeach
</select>
</body>
</html>
<script src="\layui\layui.js"></script>
<script src="\layui\layui.all.js"></script>
<script>
$(function(){
    layui.use('layer', function(){
    var layer = layui.layer;
    $("#sub").click(function(){
        var box=$(this).parents('div').find("input[class='box']");
        var openid="";
        box.each(function(index){
            if($(this).prop("checked")==true){
                openid+=$(this).attr("openid")+',';
            }
        })
        openid=openid.substr(0,openid.length-1);
       // console.log(openid);
        var label=$('#_select').val();
        // console.log(label);
        $.post(
            '/admin/make',
            {openid:openid,label:label},
            function(res){
                layer.msg(res.font,{icon:res.code});
                console.log(res);
            }
        );
    })
})
})

</script>
