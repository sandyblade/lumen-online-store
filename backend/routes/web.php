<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

# Get File Upload
$router->get('stream/{param}', 'HomeController@stream');

$router->group(['prefix' => 'api'], function () use ($router) {

    # Check Connection
    $router->get('/ping', function () use ($router) {
        return response()->json(['status' => true, 'message' => 'Connected Established !!']);
    });

    # Authentication Section
    $router->post('auth/login', 'AuthController@login');
    $router->post('auth/register', 'AuthController@register');
    $router->get('auth/confirm/{token}', 'AuthController@confirm');
    $router->get('auth/resend/{token}', 'AuthController@resend');
    $router->post('auth/email/forgot', 'AuthController@forgot');
    $router->post('auth/email/reset/{token}', 'AuthController@reset');

    # User Profile Section
    $router->get('profile/detail', 'ProfileController@detail');
    $router->post('profile/update', 'ProfileController@update');
    $router->post('profile/password', 'ProfileController@password');
    $router->post('profile/upload', 'ProfileController@upload');
    $router->get('profile/activity', 'ProfileController@history');

    # Sending Newsletter
    $router->post('newsletter/send', 'NewsLetterController@send');

    # Primary Component
    $router->get('home/component', 'HomeController@component');

    # Home Page
    $router->get('home/page', 'HomeController@page');
    
    # Shop Page
    $router->get('shop/list', 'ShopController@list');
    $router->get('shop/filter', 'ShopController@filter');

    # Order Page
    $router->get('order/list', 'OrderController@list');
    $router->get('order/billing', 'OrderController@billing');
    $router->get('order/product', 'OrderController@product');
    $router->get('order/review/{id}', 'OrderController@listReview');
    $router->get('order/cart/{id}', 'OrderController@cart');
    $router->post('order/cart/{id}', 'OrderController@add');
    $router->delete('order/cart/{id}', 'OrderController@delete');
    $router->get('order/wishlist/{id}', 'OrderController@wishlist');
    $router->get('order/detail/{id}', 'OrderController@detail');
    $router->get('order/cancel', 'OrderController@cancel');
    $router->post('order/review/{id}', 'OrderController@review');
    $router->post('order/checkout/{id}', 'OrderController@checkout');

});
