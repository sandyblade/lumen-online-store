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

$router->group(['prefix' => 'api'], function () use ($router) {

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

});