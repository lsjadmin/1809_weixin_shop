<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\GoodsModel;
use App\Model\CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class CartController extends Controller
{
    //购物车页面
    public function index(){
        // echo "11";
       
        $wherea=[
            'u_id'=>Auth::id(),
            'session_id'=>Session::getId(),
        ];
        $res=CartModel::where($wherea)->get();
        //    print_r($res);die;
       if($res){
           $arr=$res->toArray();
         //  dd($arr);
            $goods_price=0;
            foreach($arr as $k=>$v){
                $goods_price+=$v['goods_price'];
            }
            $data=[
                'res'=>$res,
                'goods_price'=>$goods_price/100
            ];
            return view('cart.index',$data);
       }else{
        header('Refresh:3;url=/');
        die("购物车为空,将在3秒后跳转首页");
       }
        }
    //商品详情
    public function detail($goods_id=0){
         $goods_id=intval($goods_id);
            if(empty($goods_id)){
                header('Refresh:3;url=/');
                die("请选择商品,将在3秒后跳转首页");
            } 
            $res=GoodsModel::where(['g_id'=>$goods_id])->first();
            $goods_view_goods_id='goods_view_goods_id:'.$goods_id; //浏览次数的建
            $ss_sort_goods='ss_sort:goods';  //商品排序的建
            $count=Redis::incr($goods_view_goods_id); 
            $sort=Redis::Zadd($ss_sort_goods,$count,$goods_id); //有序集合排序 
           
            $resa=GoodsModel::where(['g_id'=>$goods_id])->first();
            //$ticket=$this->carcode();

            
            $access_token=accessToken();
            $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
            $msg=[
                "expire_seconds"=>604800, 
                "action_name"=>"QR_SCENE", 
                "action_info"=>["scene"=>["scene_id"=>$goods_id]]
            ];
            $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
            //echo $data;die;
            $client=new Client();
            $response=$client->request('post',$url,[
                'body'=>$data
            ]);
            $res=$response->getBody();
            $arr=json_decode($res,true);
             //echo'<pre>';print_r($arr);echo'</pre>';die;
            $ticket=$arr['ticket'];
            //echo $ticket;die;
            $code_url='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
           
                $data=[
                    'resa'=>$resa,
                    'count'=>$count,
                    'code_url'=>$code_url
                ];
                return view('cart.detail',$data);
              
         //}
          
     }
    //添加到购物车
    public function add($goods_id=0){
       // echo $goods_id;
       if(empty($goods_id)){
            header('Refresh:3;url=/catr');
            die("请选择商品,将在3秒后跳转购物车");
       }
       //判断商品是否有效
       $where=[
           'g_id'=>$goods_id
       ];
       $goods=GoodsModel::where($where)->first();
       // dd($goods);
        if($goods){
            if($goods->is_del==1){
                header('Refresh:3;url=/');
                die("请选择商品,将在3秒后跳转首页");
            }
             //添加倒购物车
            $cart_info=[
                'goods_id'=>$goods_id,
                'u_id'=>Auth::id(),
                'session_id'=>Session::getId(),
                'add_time'=>time(),
                'goods_name'=>$goods->goods_name,
                'goods_price'=>$goods->goods_price
            ];
            //dd($cart_info);
            //购物车数据入库
            $res=CartModel::insertGetId($cart_info);
            if($res){
                header('Refresh:3;url=/catr');
                die("添加成功,将在3秒后跳转购物车");
            }else{
                header('Refresh:3;url=/');
                die("添加失败,将在3秒后跳转首页");
            }
        }else{
            echo "商品不存在";
        }
       
       

    }
    //商品排序(浏览历史)
    public function sort(){
        $key='ss_sort:goods';
        // $list1=Redis::zRangeByScore($key,0,10000,['withscores'=>true]); //正序
        $list1=Redis::zRevRange($key,0,10000,true);  //倒叙
         // print_r($list2);
        foreach($list1 as $k=>$v){
            $res[]=GoodsModel::where(['g_id'=>$k])->first();
        }
        return view('cart.sort',['res'=>$res]);
    }
    //获得ticket
    public function carcode(){
      
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
       //echo $ticket;die;
        return $ticket;
    }
}
