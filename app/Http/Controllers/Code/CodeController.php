<?php

namespace App\Http\Controllers\Code;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Model\GoodsModel;
class CodeController extends Controller
{
    //
    public function code(){
        $access_token=accessToken();
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        $msg=[
            "expire_seconds"=>604800, 
            "action_name"=>"QR_SCENE", 
            "action_info"=>["scene"=>["scene_id"=>23]]
        ];
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        //echo $data;die;
         $client=new Client();
        $response=$client->request('post',$url,[
            'body'=>$data
        ]);
        $res=$response->getBody();
        $arr=json_decode($res,true);
       // echo'<pre>';print_r($arr);echo'</pre>';
       $ticket=$arr['ticket'];
        //$ticketa=UrlEncode($ticket);
       $code_url='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
       //echo $code_url;die;
        
        return $ticket;
    }
    public function codeAdd(){
       $res=GoodsModel::where(['g_id'=>2])->first();
        return view('code.code',['res'=>$res]);
    }
}
