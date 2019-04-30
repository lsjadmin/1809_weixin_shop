<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>标签展示</title>
</head>
<script src="/js/jquery/jquery-3.1.1.min.js"></script>
<body>
    <table border="1">
            <tr>
                <td>请选择</td>
                <td>id</td>
                <td>标签名称</td>
                <td>人数</td>
               
            </tr>
            @foreach($arr as $k=>$v)
            <tr>
                <td><input type="radio" id="{{$v['id']}}" class="radio"></td>
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td>{{$v['count']}}</td>
            </tr>
            @endforeach
    </table>
    <div>
        <textarea name="" id="" cols="30" rows="10" class="text">
        
        
        </textarea>
    </div>
    <input type="button" value="请发送" class="button">
</body>
</html>
<script>
    $(function(){
            $(document).on("click",".button",function(){
                var tag_id=$("input[type='radio']:checked").attr('id');
                //console.log(tag_id);
                var text=$('.text').val();
                //console.log(text);
                    $.post(
                        "/info",
                        {tag_id:tag_id,text:text},
                        function(res){
                            console.log(res);
                        }
                    )
            })
    })
</script>