<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('goodsInfo', GoodsController::class);
    $router->resource('orderInfo', OrderController::class);

    $router->resource('wxmessage', WxImageController::class);
    $router->any('/addImage', 'WxImageController@addImage');
    $router->any('/add', 'WxImageController@add');
    $router->any('/send', 'WxImageController@send');
    $router->any('/sendTo', 'WxImageController@sendTo');
    $router->any('/tally', 'WxImageController@tally'); //标签执行
    $router->any('/tallyAdd', 'WxImageController@tallyAdd'); //标签添加视图
    $router->any('/tallyList', 'WxImageController@tallyList');//标签展示视图
    $router->any('/make', 'WxImageController@make');//给标签批量添加
    $router->any('/mass', 'WxImageController@mass');//给用户添加标签
});
