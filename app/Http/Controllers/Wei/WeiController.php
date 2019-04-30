<?php

namespace App\Http\Controllers\Wei;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Str;
use App\Model\GoodsModel;
use App\Model\MessageModel;
use Illuminate\Support\Facades\Storage;
class WeiController extends Controller
{
    //
    public function valid(){
        echo $_GET['echostr'];
    }
    public function wxEvent(){
        //接受微信服务器推送
        $content=file_get_contents("php://input");
        $time=date("Y-m-d H:i:s");
        $str=$time . $content ."\n";
        file_put_contents("logs/wx_event.log",$str,FILE_APPEND);
         // echo 'SUCCESS';
        $data = simplexml_load_string($content);
        // var_dump($data);
        //echo 'ToUserName:'.$data->ToUserName;echo"</br>";//微信号id
        //echo 'FromUserName:'.$data->FromUserName;echo"</br>";//用户openid
        //echo 'CreateTime:'.$data->CreateTime;echo"</br>";//时间
        //echo 'Event:'.$data->Event;echo"</br>";//事件类型
       //die;
        $MsgType=$data->MsgType;
        $openid=$data->FromUserName;
       // echo $openid;die;
        $wx_id=$data->ToUserName;
        $event=$data->Event;
        $MediaId=$data->MediaId;
        $token=accessToken();
        
        //把文本存到数据库 ,图片，语音存到数据库
        if($MsgType=='text'){
            $m_text=$data->Content;
            //把文字信息存到数据库
            $m_time=$data->CreateTime;
            $message=[
                'm_text'=>$m_text,
                'm_time'=>$m_time,
                'm_openid'=>$openid
            ];
            $res=DB::table('wx_message')->insert($message);
            if($res){
               // echo "成功";
            }else{
               // echo "失败";
            }
            //echo $Content;
        }
        
        if($event=='subscribe'){
            $EventKey=$data->EventKey;
            //echo "$EventKey";die;
            $str=substr($EventKey,8);
            echo $str;
            $arr=$this->getUserInfo($openid);
            //echo'<pre>';print_r($arr);echo'</pre>';
            $info=[
                'openid'=>$openid,
                'nickname'=>$arr['nickname'],
                'eventkey'=>$str,
            ];
            $res=DB::table('wx_user_code')->insert($info);
           
           
            //dd($res);
                $name="最新商品";
                $desc="最新商品";
               
                
                $url='https://1809lianshijie.comcto.com/detail/2';
            echo '<xml>
                <ToUserName><![CDATA['.$openid.']]></ToUserName>
                <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                  <item>
                    <Title><![CDATA['.$name.']]></Title>
                    <Description><![CDATA['.$desc.']]></Description>
                    <PicUrl><![CDATA['.'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=2984185296,2196422696&fm=27&gp=0.jpg'.']]></PicUrl>
                    <Url><![CDATA['.$url.']]></Url>
                  </item>
                </Articles>
              </xml>';
            // $whereOpenid=[
            //     'openid'=>$openid
            // ];
            // $userName=DB::table('userwx')->where($whereOpenid)->first();
            // if($userName){
            //         echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
            //         <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
            //         <CreateTime>'.time().'</CreateTime>
            //         <MsgType><![CDATA[text]]></MsgType>
            //        <Content>![CDATA['.'欢迎回来'.$userName->nickname.']]</Content>
            //         </xml>
            //         ';
            // }else{
            //     $u=$this->getUserInfo($openid);
            //     $info=[
            //         'openid'=>$openid,
            //         'nickname'=>$u['nickname'],
            //         'subscribe_time'=>$u['subscribe_time']
            //     ];
            //     $res=DB::table('userwx')->insert($info);
            //     if($res){
            //         echo "ok";
            //     }else{
            //         echo "no";
            //     }
            //     echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
            //         <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
            //         <CreateTime>'.time().'</CreateTime>
            //         <MsgType><![CDATA[text]]></MsgType>
            //        <Content>![CDATA['.'欢迎关注'.$u['nickname'].']]</Content>
            //         </xml>
            //         ';
            // }
        }
       
        if($event=='SCAN'){
         
            //dd($res);
                $name="欢迎回来";
                $desc="欢迎回来";
               
                
                $url='https://1809lianshijie.comcto.com/detail/2';
               
                echo '<xml>
                    <ToUserName><![CDATA['.$openid.']]></ToUserName>
                    <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                    <CreateTime>'.time().'</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>1</ArticleCount>
                    <Articles>
                      <item>
                        <Title><![CDATA['.$name.']]></Title>
                        <Description><![CDATA['.$desc.']]></Description>
                        <PicUrl><![CDATA['.'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=2984185296,2196422696&fm=27&gp=0.jpg'.']]></PicUrl>
                        <Url><![CDATA['.$url.']]></Url>
                      </item>
                    </Articles>
                  </xml>';
           
        }
        //用户输入内容查询数据库
        $count=$data->Content;
        //echo $count;die;
            $goods=DB::table('goods')->where('goods_name','like',"%$count%")->first();
            if($goods==''){
                   // echo "aa";
                   $res=GoodsModel::inRandomOrder()->first();//随机查询数据库一条
                  // echo'<pre>';print_r($res);echo"</pre>";die;
                  $name=$res['goods_name'];
                    $g_id=$res['g_id'];
                   // echo "ok";
                   $desc="商品";
                   $url='https://1809lianshijie.comcto.com/detail/'.$g_id;
                 // echo $url;die;
                   echo '<xml>
                       <ToUserName><![CDATA['.$openid.']]></ToUserName>
                       <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                       <CreateTime>'.time().'</CreateTime>
                       <MsgType><![CDATA[news]]></MsgType>
                       <ArticleCount>1</ArticleCount>
                       <Articles>
                         <item>
                           <Title><![CDATA['.$name.']]></Title>
                           <Description><![CDATA['.$desc.']]></Description>
                           <PicUrl><![CDATA['.'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=2984185296,2196422696&fm=27&gp=0.jpg'.']]></PicUrl>
                           <Url><![CDATA['.$url.']]></Url>
                         </item>
                       </Articles>
                     </xml>';
            }else{
                $name=$goods->goods_name;
                // echo "ok";
                $desc="商品";
                $goods_id=$goods->g_id;
                $img=$goods->img;
                $url='https://1809lianshijie.comcto.com/detail/'.$goods_id;
              // echo $url;die;
                echo '<xml>
                    <ToUserName><![CDATA['.$openid.']]></ToUserName>
                    <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                    <CreateTime>'.time().'</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>1</ArticleCount>
                    <Articles>
                      <item>
                        <Title><![CDATA['.$name.']]></Title>
                        <Description><![CDATA['.$desc.']]></Description>
                        <PicUrl><![CDATA['.$img.']]></PicUrl>
                        <Url><![CDATA['.$url.']]></Url>
                      </item>
                    </Articles>
                  </xml>';
            }

    }
                                
    //获取用户信息
    public function getUserInfo($openid){
       $access_token=accessToken();
        $a='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        //echo $a;
        $data=file_get_contents($a);
        $u=json_decode($data,true);
        return $u;
    }
    //获取自定义菜单(最新福利 跳转到网络授权)
    public function createMenu(){
      $access_token=accessToken();
      // echo $access_token;die;
      $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='. $access_token;
      $post_arr=[
        "button"=>[
             [  
                "type"=>"view",
                "name"=>"最新福利",
                "url"=>"https://1809lianshijie.comcto.com/aa"
              ],
              [  
                "type"=>"view",
                "name"=>"点击签到",
                "url"=>"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxba713404af65cc0c&redirect_uri=http://1809lianshijie.comcto.com/scopea&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
              ],
            ],
        ];
        $json_str=json_encode($post_arr,JSON_UNESCAPED_UNICODE);
        //echo $json_str;
        $client = new Client;
        $response=$client->request('POST',$url,[
             'body'=>$json_str
        ]);
        $arr=$response->getBody();
        $res=json_decode($arr,true);
        dd($res);
    }

    public function scopea(){
      //echo'<pre>';print_r($_GET);echo'</pre>';die;
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
       $message=MessageModel::where(['openid'=>$res['openid']])->first();
           if($message){
               echo "欢迎您".$res['nickname'];
           }else{
               $info=[
                   'openid'=>$res['openid'],
                   'nickname'=>$res['nickname'],
                   'city'=>$res['city'],
                   'province'=>$res['province'],
                   'country'=>$res['country'],
               ];
               $arr=MessageModel::insert($info);
           }
           echo "签到成功".$res['nickname'];
           $key='wx_sign'.$res['openid'];
           Redis::LPush($key,date('Y:m:d H:i:s'));
           $recode=Redis::LRange($key,0,-1);
           echo'<pre>';print_r($recode);echo'</pre>';
           
   }
   //菜单调到这（最新福利）
   public function aa(){
     $a=urlencode('http://1809lianshijie.comcto.com/scope');
     //echo $a;die;
      $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxba713404af65cc0c&redirect_uri=$a&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
      //echo $url;
      header("Location:".$url);
    }
    
    
}
                            
