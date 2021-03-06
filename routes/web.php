<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//购物车
Route::get('/catr', 'CartController@index');
Route::get('/add/{goods_id?}', 'CartController@add');
Route::get('/detail/{goods_id?}', 'CartController@detail'); //商品详情
Route::get('/sort', 'CartController@sort'); //商品排序

//订单
Route::get('/order/create', 'Order\OrderController@create');
Route::get('/order/list', 'Order\OrderController@list');
Route::get('/order/status', 'Order\OrderController@status');
//支付

//微信支付
Route::get('text','Wei\WeiPayController@text');
Route::post('notify','Wei\WeiPayController@notify');
Route::get('success','Wei\WeiPayController@success');


//jssdk
Route::get('jssdk','Wei\JssdkController@Jssdktest');
Route::get('getimg','Wei\JssdkController@getimg');
Route::get('scope','Wei\JssdkController@scope'); 
Route::get('tallyAdd','Wei\JssdkController@tallyAdd');//添加标签视图
Route::get('tally','Wei\JssdkController@tally');//标签接口
Route::get('tallylist','Wei\JssdkController@tallylist');//标签展示
Route::get('mass','Wei\JssdkController@mass');//把用户 标签 在视图展示出来(视图)
Route::any('make','Wei\JssdkController@make');//给用户添加标签（执行  接口）
Route::any('info','Wei\JssdkController@info');//标签群发接口
Route::any('aa','Wei\JssdkController@aa');
//定时任务
Route::get('del','Goods\GoodsController@del');
//微信首次接入
Route::get('valid','Wei\WeiController@valid');
Route::any('valid','Wei\WeiController@wxEvent');
Route::get('success_toke','Wei\WeiController@success_toke');
Route::get('test','Wei\WeiController@test');
Route::get('createMenu','Wei\WeiController@createMenu');
Route::get('scopea','Wei\WeiController@scopea');
Route::get('aa','Wei\WeiController@aa');//最新福利授权的代码
//测试
Route::get('a','Wei\WeiController@a');
//二维码
Route::get('code','Code\CodeController@code');
Route::get('codeAdd','Code\CodeController@codeAdd');
//标签
Route::get('lable','Lable\LableController@lable');


