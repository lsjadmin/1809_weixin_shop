<?php

namespace App\Http\Controllers\Wei;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
class JssdkController extends Controller
{
    //
    public function Jssdktest(){
        //生成签名
        $nonceStr=Str::random(10);
        $ticket=ticket();  
        //dd($ticket);   
        $timestamp=time();
        $current_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];
        //echo($current_url);
        $string1 = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$current_url";
        $sign= sha1($string1);
        $jsconfig=[
            'appId'=>env('WX_APPID'),    //公众号的唯一标识
            'timestamp'=>$timestamp,   //生成签名的时间戳
            'nonceStr'=> $nonceStr,     //生成签名的随机串
            'signature'=> $sign,   //签名
        ];
        $data=[
            'jsconfig'=>$jsconfig
        ];
        //dd($data);
          return view('wei.Jssdktest',$data);   
    }
    public function getimg(){
        //echo'<pre>';print_r($_GET);echo'</pre>';
        $b=$_GET;
        $a=json_encode($b);
        $MediaId=rtrim($a,',');
        $token=accessToken();
        $urla="https://api.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=$MediaId";
        $voice_str=file_get_contents($urla);
        $file_name=time().mt_rand(11111,99999).'png';
        file_put_contents("/wwwroot/1809_weixin_shop/public/wx_image/$file_name",$voice_str,FILE_APPEND);


    }
}
