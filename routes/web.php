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
//订单
Route::get('/order/create', 'Order\OrderController@create');
Route::get('/order/list', 'Order\OrderController@list');
Route::get('/order/status', 'Order\OrderController@status');
//支付


//微信支付
Route::get('text','Wei\WeiPayController@text');
Route::post('notify','Wei\WeiPayController@notify');
Route::get('success','Wei\WeiPayController@success');


