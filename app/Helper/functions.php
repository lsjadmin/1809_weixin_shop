<?php
    use Illuminate\Support\Facades\Redis;
    //获取accesstoken
    function accessToken(){
        $key="access_token";
        $access_token=Redis::get($key);
        if($access_token){
            return $access_token;
        }else{
            $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET');
            $response=json_decode(file_get_contents($url),true);
            if(isset($response['access_token'])){
                Redis::set($key,$response['access_token']);
                Redis::expire($key,3600);
                return $response['access_token'];
            }else{
                return false;
            }
            //return $response;
        }
       
    }
    //获取jsapi ticket（）
    function ticket(){
        $access_token=accessToken();
        $key="ticket";
        $ticket=Redis::get($key);
        if($ticket){
            return $ticket;
        }else{
            $url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi";
            $responsea=json_decode(file_get_contents($url),true);
            // return $responsea;
             if(isset($responsea['ticket'])){
                Redis::set($key,$responsea['ticket']);
                Redis::expire($key,3600);
                return $responsea['ticket'];
             }else{
                return false;
             }
        }
       
    }

?>