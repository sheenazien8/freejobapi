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
    $router->get('/auth', function (\Illuminate\Http\Request $request) {
        $token = $request->header('Authorization');
        $token = explode('Bearer ', $token)[1];
        return response()->json([
            'token' => $token
        ]);
    });
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
        $router->post('/', [
            'uses' => 'PostController@create',
            'middleware' => 'checkrole'
        ]);
        $router->put('/{post}', [
            'uses' => 'PostController@update',
            'middleware' => 'checkrole'
        ]);
        $router->put('/{post}/status/', [
            'uses' => 'PostController@updateStatus',
            'middleware' => 'checkrole'
        ]);
        $router->delete('/{post}', [
            'uses' => 'PostController@delete',
            'middleware' => 'checkrole'
        ]);
    });

    $router->group(['prefix' => 'apply'], function ($router)
    {
        $router->get('/', ['uses' => 'ApplyController@index']);
        $router->put('/{post}/{apply}', [
            'uses' => 'ApplyController@update',
            'middleware' => 'checkfreelancer'
        ]);
        $router->post('/{post}', [
            'uses' => 'ApplyController@create',
            'middleware' => 'checkfreelancer'
        ]);
        $router->delete('/{post}', [
            'uses' => 'ApplyController@delete',
            'middleware' => 'checkfreelancer'
        ]);
    });

    $router->group(['prefix' => 'experience'], function ($router)
    {
        $router->get('/', ['uses' => 'ExperienceController@index']);
        $router->post('/', ['uses' => 'ExperienceController@create']);
        $router->put('/{experience}', ['uses' => 'ExperienceController@update']);
        $router->delete('/{experience}', ['uses' => 'ExperienceController@delete']);
    });
});
