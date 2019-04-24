<?php

namespace App\Http\Controllers\Wei;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\Model\MessageModel;
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
            'appId'=>env('WX_APPID'),   //公众号的唯一标识
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
        // $b=$_GET;
        // $a=json_encode($b);
        // $MediaId=rtrim($a,',');
        $MediaId="987654321123456789";
        $token=accessToken();
        $urla="https://api.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=$MediaId";
        var_dump($urla);die;
        $voice_str=file_get_contents($urla);
        $file_name=time().mt_rand(11111,99999).'.png';
        file_put_contents("/wwwroot/1809_weixin_shop/public/wx_image/$file_name",$voice_str,FILE_APPEND);
    }
    public function scope(){
       // echo'<pre>';print_r($_GET);echo'</pre>';die;
        $code=$_GET['code'];
        //通过code换取网页授权access_token
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $response=json_decode(file_get_contents($url),true);
        //echo'<pre>';print_r($response);echo'</pre>'; 

        $access_token=$response['access_token'];
        $openid=$response['openid'];
        //拉取用户信息
        $urla='https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $res=json_decode(file_get_contents($urla),true);
        //echo'<pre>';print_r($res);echo'</pre>';die;
        
        $name=MessageModel::where(['openid'=>$res['openid']])->first();
            if($name){
                echo "欢迎回来".$res['nickname'];
            }else{
               
                $info=[
                    'openid'=>$res['openid'],
                    'nickname'=>$res['nickname'],
                    'city'=>$res['city'],
                    'province'=>$res['province'],
                    'country'=>$res['country'],
                ];
                $arr=MessageModel::insert($info);
                if($arr){
                    echo "欢迎".$res['nickname'];
                }else{
                    echo "授权失败";
                }
            }
            
    }
}
