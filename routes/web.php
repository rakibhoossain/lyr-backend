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
    return \App\Models\User::all();
    return $router->app->version();
});
$router->get('/api', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('register', 'AuthController@register');
        $router->post('refresh', 'AuthController@refresh');
        $router->get('user', 'AuthController@me');
    });


    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');
});