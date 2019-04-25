<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class OrderModel extends Model
{
    //
    protected $table="order";
    public $timestamps = false;
    protected $primaryKey="o_id";

    //生成订单号
    public static function ordersn($u_id){
        $order_sn='1809a_';
        $str=time().rand(1111,9999).Str::random(16);
        $order_sn.=substr(md5($str),5,16);
       return $order_sn;
    }
    //添加订单
    
}
