<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CartModel;
use App\Model\OrderModel;
class GoodsController extends Controller
{
    //删除
    public function del(){
       // echo 2;'</hr>';
       $arr=OrderModel::all()->toArray();
      // echo'<pre>';print_r($res);echo'</pre>';
      foreach($arr as $k=>$v){
            if(time()-$v['add_time']>1800&& $v['pay_time']==0){
                $res=OrderModel::where(['o_id'=>$v['o_id']])->update(['is_up'=>1]);
            }
      }
    }
   
}
