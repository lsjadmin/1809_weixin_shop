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
    <title>获取公众号已创建的标签</title>
</head>
<body>
<div class="box-body table-responsive no-padding content">
    <table class="table table-hover">
        <thead>
            <tr>
            <th></th>
                <th>ID</th>
                <th>名称</th>
                <th>人数</th>
            </tr>
        </thead>
        <tbody>
            @foreach($arr as $v)
            <tr >
                    <td><input type="radio" id="{{$v['id']}}" class="radio"></td>
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td>{{$v['count']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <textarea name="" id="" cols="30" rows="10" class="text">
    
    </textarea>
</div>
    <input type="button" value="发送" class="button">
</body>
</html>
<script>
    $(document).on("click",".button",function(){
        var id=$("input[type='radio']:checked").attr('id');
        var text=$('.text').val();
       // console.log(text);
       // console.log(id);
        $.post(
            "/admin/Info",
            {id:id,text:text},
            function(res){
                console.log(res);
            }
        )
    })
</script>

