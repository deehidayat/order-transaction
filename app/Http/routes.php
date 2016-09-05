<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['namespace' => 'App\Http\Controllers\API', 'prefix' => 'api'], function() use ($app) {
    $app->get('products', 'APIProductController@index');
    $app->get('products/{id}', 'APIProductController@show');
    $app->post('products', 'APIProductController@store');
    $app->put('products/{id}', 'APIProductController@update');
    $app->delete('products/{id}', 'APIProductController@delete');

    $app->get('coupons', 'APICouponController@index');
    $app->get('coupons/{id}', 'APICouponController@show');
    $app->post('coupons', 'APICouponController@store');
    $app->put('coupons/{id}', 'APICouponController@update');
    $app->delete('coupons/{id}', 'APICouponController@delete');

    $app->get('carts', 'APICartController@index');
    $app->post('carts', 'APICartController@store');
    $app->put('carts/{id}', 'APICartController@update');
    $app->delete('carts/{id}', 'APICartController@delete');
    $app->post('carts/placeorder', 'APICartController@placeOrder');

    $app->get('orders', 'APIOrderController@index');
    $app->get('orders/{id}', 'APIOrderController@show');
    $app->post('orders/{invoiceNo}/payment', 'APIOrderController@payment');
    $app->post('orders/{invoiceNo}/reject', 'APIOrderController@reject');
    $app->post('orders/{invoiceNo}/approve', 'APIOrderController@approve');
    $app->post('orders/{invoiceNo}/shipped', 'APIOrderController@shipped');
});
