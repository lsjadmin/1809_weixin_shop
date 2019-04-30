<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>标签添加</title>
    <script src="/js/jquery/jquery-3.1.1.min.js"></script>
</head>
<body>
        <input type="text" name="a" id="a">
        <input type="button" value="添加标签" id="sub">
</body>
</html>
<script>
    $(function(){
        $("#sub").click(function(){
            var name =$("#a").val();
            // console.log(name);
            $.get(
                '/tally',
                {name:name},
                function(res){
                    console.log(res);
                }
            );
        })
    })

</script>
