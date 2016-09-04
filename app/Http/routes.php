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
});
