<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
   
<body>
        <button id="btn1">选择照片</button>
        <script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
        <script src="/js/jquery/jquery-3.1.1.min.js"></script>
        <script>
            wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId:"{{$jsconfig['appId']}}", // 必填，公众号的唯一标识
            timestamp:"{{$jsconfig['timestamp']}}" , // 必填，生成签名的时间戳
            nonceStr: "{{$jsconfig['nonceStr']}}", // 必填，生成签名的随机串
            signature: "{{$jsconfig['signature']}}",// 必填，签名
            jsApiList: ['chooseImage','uploadImage'] // 必填，需要使用的JS接口列表
        });
            wx.ready(function(){
               $("#btn1").click(function(){
                   alert('1');
               })
            })
        </script>
</body>
</html>