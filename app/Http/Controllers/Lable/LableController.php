<?php

namespace App\Http\Controllers\Lable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LableController extends Controller
{
    //
    public function lable(){
       // echo "ok";die;
        $a=urlencode('http://1809lianshijie.comcto.com/scope');
        //echo $a;die;
         $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxba713404af65cc0c&redirect_uri=$a&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
         echo $url;die;
         header("Location:".$url);
    }
}
