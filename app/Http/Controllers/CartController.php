<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\GoodsModel;
use App\Model\CartModel;
use Illuminate\Support\Facades\Auth;
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
       // dd($res);
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
        //dd($goods);
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
}
