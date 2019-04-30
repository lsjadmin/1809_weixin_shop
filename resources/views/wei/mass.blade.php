<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script src="/js/jquery/jquery-3.1.1.min.js"></script>
<body>
<div>
<table border="1">
        <tr>
          <td>请选择</td>
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
    <select name="" id="a">
    <option value="">请选择要选择的标签</option>
    @foreach($arr as $v)
        <option value="{{$v['id']}}">{{$v['name']}}</option>
    @endforeach
    </select>
    <input type="button" id="sub" value="确认">
 </div>

</body>
</html>
<script>
 $(function(){
    $("#sub").click(function(){
        var box=$(this).parents('div').find("input[class='box']");
       // console.log(box);
        var openid="";
        box.each(function(index){
            if($(this).prop("checked")==true){
                openid+=$(this).attr("openid")+',';
            }
        })
        openid=openid.substr(0,openid.length-1);
       // console.log(openid);
        var select=$("#a").val();
        //console.log(select);
        $.post(
            '/make',
            {openid:openid,select:select},
            function(res){
                console.log(res);
            }
        );
    })
 })
</script>