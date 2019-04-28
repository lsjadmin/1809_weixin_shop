<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <td>id</td>
            <td>名称</td>
            <td>价格</td>
            <td>num</td>
        </tr>
        <tr>
            <td>{{$res->g_id}}</td>
            <td>{{$res->goods_name}}</td>
            <td>{{$res->goods_price}}</td>
            <td>{{$res->num}}</td>
        </tr>

    </table>
</body>
</html>