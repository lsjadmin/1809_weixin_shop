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
    $router->resource('userInfo', UserController::class);
    $router->resource('wxuserInfo', UserwxController::class);
});
