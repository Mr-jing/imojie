<?php

$api = app('Dingo\Api\Routing\Router');
$api->group([
    'version' => 'v1',
    'namespace' => 'Imojie\Http\ApiControllers',
    'middleware' => ['oauth']], function ($api) {

    $api->get('topic', [
        'as' => 'topic.index',
        'uses' => 'TopicController@index',
    ]);

    $api->post('topic', [
        'as' => 'topic.store',
        'uses' => 'TopicController@store',
    ]);

    $api->match(['put', 'patch'], 'topic/{topic}', [
        'as' => 'topic.update',
        'uses' => 'TopicController@update',
    ]);

    $api->delete('topic/{topic}', [
        'as' => 'topic.destroy',
        'uses' => 'TopicController@destroy',
    ]);

    $api->get('user/me', ['middleware' => ['oauth'],
        'uses' => 'UserController@me',
    ]);

    $api->post('reply', [
        'as' => 'reply.store',
        'uses' => 'ReplyController@store',
    ]);

    $api->delete('reply/{reply}', [
        'as' => 'reply.destroy',
        'uses' => 'ReplyController@destroy',
    ]);
});

$api->group([
    'version' => 'v1',
    'namespace' => 'Imojie\Http\ApiControllers'], function ($api) {

    $api->post('login', [
        'as' => 'login',
        'uses' => 'UserController@login',
    ]);

    $api->post('oauth/access_token', ['as' => 'access_token', function () {
        return \Authorizer::issueAccessToken();
    }]);

    $api->post('oauth/refresh_token', ['as' => 'refresh_token', function () {
        $input = [
            'grant_type' => 'refresh_token',
            'refresh_token' => \Request::input('refresh_token', ''),
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
        ];
        \Request::replace($input);
        return \Authorizer::issueAccessToken();
    }]);
});


// 首页
Route::get('/', function () {
    return view('page.index');
});

Route::post('oauth/access_token', function () {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('testOAuth', [
    'middleware' => ['oauth', 'oauth-client'],
    'uses' => 'TestController@testOAuth'
]);

// 注册
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/registered', 'Auth\AuthController@getRegistered');
Route::get('auth/activation', 'Auth\AuthController@getActivation');
Route::post('auth/activation', 'Auth\AuthController@postActivation');

// 登录
Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::post('auth/logout', 'Auth\AuthController@postLogout');

// 第三方登录
Route::get('oauth/{provider}', array(
    'as' => 'oauth', 'uses' => 'Auth\AuthController@oauth'
))->where('provider', 'qq|weibo');
Route::get('oauth/{provider}/callback', array(
    'uses' => 'Auth\AuthController@callback'
))->where('provider', 'qq|weibo');

// 第三方登录账号绑定
Route::get('auth/bind', 'Auth\AuthController@getBind');
Route::post('auth/bind', 'Auth\AuthController@postBind');

// 发送密码重置邮件
Route::get('auth/forgot', 'Auth\PasswordController@getEmail');
Route::post('auth/forgot', 'Auth\PasswordController@postEmail');

// 重置密码
Route::get('auth/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('auth/reset', 'Auth\PasswordController@postReset');


// 用户主页
Route::get('/home', 'UserController@home');
Route::get('/u/{username}', 'UserController@index');

// 用户设置
Route::get('user/settings/info', 'UserController@edit');
Route::post('user/settings/info', 'UserController@update');
Route::get('user/settings/email', 'UserController@getEmail');
Route::post('user/settings/email', 'UserController@postEmail');
Route::get('user/settings/password', 'UserController@getPassword');
Route::post('user/settings/password', 'UserController@postPassword');
Route::get('user/settings/oauth', 'UserController@getOauth');
Route::post('user/settings/oauth', 'UserController@postOauth');

// 贴子相关
Route::resource('topic', 'TopicController', [
    'except' => ['store', 'update', 'destroy']
]);
