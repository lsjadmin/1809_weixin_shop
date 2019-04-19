<?php

namespace App\Http\Controllers\Order;

use App\Model\OrderModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Model\CartModel;
use App\Model\OrderDetailModel;

class OrderController extends Controller
{
    //订单
    public function create(){
        //计算订单的金额
        $wherea=[
            'u_id'=>Auth::id(),
            'session_id'=>Session::getId(),
        ];
        $arr=CartModel::where($wherea)->get()->toArray();
       // dd($res);
       if($arr){
          
         //  dd($arr);
            $goods_price=0;
            foreach($arr as $k=>$v){
                $goods_price+=$v['goods_price'];
               
            }
          //  dd($goods_price);
        }
        //添加订单表
        $order_info=[
            'u_id'=>Auth::id(),
            'order_sn'=>OrderModel::ordersn(Auth::id()),
            'order_amount'=>$goods_price,
            'add_time'=>time(),
        ];
        // dd($order_info);
        //写入订单表
       $oid = OrderModel::insertGetId($order_info);   
       //添加订单详情表
       foreach($arr as $k=>$v){
        $detail=[
            'o_id'=>$oid,
            'goods_name'=>$v['goods_name'],
            'goods_price'=>$v['goods_price'],
            'u_id'=>Auth::id(),
            'goods_id'=>$v['goods_id']
        ];
       // dd($detail);
       //写入订单详情表
        $deail=OrderDetailModel::insertGetId($detail);
       }
       header('Refresh:3;url=/order/list');
       echo "生成订单成功";
      
    }
    //订单展示
    public function list(){
        $where=[
            'is_status'=>0,
            'u_id'=>Auth::id()
        ];
        $orderInfo=OrderModel::where($where)->get()->toArray();
        //dd($orderInfo);
       $data=[
           'orderInfo'=>$orderInfo
       ];
        return view('order.list',$data);
    }
    //状态
    public function status(){
        $o_id = intval($_GET['o_id']);    // 订单id
       // echo $o_id;
        $pay_time=time();
        //修改pay_time
        $res=OrderModel::where(['o_id'=>$o_id])->update(['pay_time'=>$pay_time,'is_status'=>1]);
        $orderInfo=OrderModel::where(['o_id'=>$o_id])->first();
        $respon=[];
        if($orderInfo){
            if($orderInfo->pay_time>0){      //已支付
                $respon = [
                    'status'    => 0,       // 0 已支付
                    'msg'       => 'ok'
                ];
            }
        }else{
            die("订单不存在");
        }
        die(json_encode($respon));
    }

}
