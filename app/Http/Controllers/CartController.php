<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\GoodsModel;
use App\Model\CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
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

            
            $url='https://1809lianshijie.comcto.com/detail/'.$goods_id;
           
                $data=[
                    'resa'=>$resa,
                    'count'=>$count,
                    'url'=>$url,
                    'jsconfig'=>$this->Jssdktest(),
                    'goods_id'=>$goods_id
                ];
                // $a=$this->Jssdktest();
                // dd($a);die;
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
   //分享
    function Jssdktest(){
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
            'current_url'=>$current_url
        ];
        return $jsconfig;
        
    }
}
