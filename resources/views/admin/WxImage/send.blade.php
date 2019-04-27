<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
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
<body>
<div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <thead>
            <tr>
                <th> </th>
                <th>id</th>
                <th>openid</th>
                <th>微信名称</th>
                <th>操作</th>
            </tr>
            </thead>
                @foreach($arr as $k=>$v)
            <tbody>
                 <tr >                                 
                    <td >
                    <input type="checkbox" openid="{{$v->openid}}" class="check"/>
                    </td>
                    <td > {{$v->user_id}} </td>
                     <td >{{$v->openid}} </td>  
                     <td >{{$v->nickname}} </td>  
                    <td >
                    <a href="/admin/wxmessage/21">
                            <i class="fa fa-eye"></i>
                    </a><a href="/admin/wxmessage/21/edit">
                            <i class="fa fa-edit"></i>
                     </a><a href="javascript:void(0);" data-id="21" class="grid-row-delete">
                            <i class="fa fa-trash"></i>
                    </a>
                     </tr>               
               </tbody>             
                    @endforeach
        </table>
        <div class="box-body table-responsive no-padding">
        请选择发送类型：<select name="" id="" class="table table-hover">
                    <option value="">文字</option>
                    <option value="">图片</option>
                    <option value="">语音</option>
               </select>
        请选择发送的文字：
                <textarea name="" class="text" cols="30" rows="10"></textarea>
                <input type="button" value="发送" class="button">
        </div>
    </div>
</form>
</body>
</html>
<script src="/js/jquery/jquery-3.1.1.min.js"></script>
<script>
    $(function(){
      
        $(document).on("click",".button",function(){
            var check=$(this).parents('div').find("input[class='check']");
           // console.log(check);
            var openid='';
            check.each(function(index){
                if($(this).prop("checked")==true){
                      openid+=$(this).attr("openid")+',';  
                 }
            })
            openid=openid.substr(0,openid.length-1);
            //console.log(openid);
            var text=$('.text').val();
                $.get(
                    '/admin/sendTo',
                    {openid:openid,text:text},
                    function(res){
                   console.log(res);
                    }
                )
        })

        
    })
</script>