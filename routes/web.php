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

$router->get('/', function () use ($router) {
    return response()->json([
        'message' => 'OK'
    ]);
});

$router->group(['prefix' => 'auth'], function ($router)
{
    $router->post('/register', ['uses' => 'AuthController@register']);
    $router->post('/login', ['uses' => 'AuthController@login']);
});

$router->group(['middleware' => 'authenticated'], function ($router)
{
    $router->group(['prefix' => 'company'], function ($router)
    {
        $router->get('/', ['uses' => 'CompanyController@index']);
        $router->post('/', ['uses' => 'CompanyController@create']);
        $router->put('/', ['uses' => 'CompanyController@update']);
    });

    $router->group(['prefix' => 'freelancer'], function ($router)
    {
        $router->get('/', ['uses' => 'FreelancerController@index']);
        $router->post('/', ['uses' => 'FreelancerController@create']);
        $router->put('/', ['uses' => 'FreelancerController@update']);
    });

    $router->group(['prefix' => 'post'], function ($router)
    {
        $router->get('/', ['uses' => 'PostController@index']);
        $router->get('/all', ['uses' => 'PostController@all']);
        $router->get('/{post}', ['uses' => 'PostController@detail']);
        $router->post('/', ['uses' => 'PostController@create']);
        $router->put('/{post}', ['uses' => 'PostController@update']);
        $router->delete('/{post}', ['uses' => 'PostController@delete']);
    });
});
