<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {

    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'as' => 'admin'], function () {
    // 后台登录
    Route::match(['get', 'post'], 'login', ['as' => '/login/index', 'uses' => 'LoginController@indexAction']);
    // 后台首页
    Route::group(['as' => '/index'], function () {
        Route::get('', ['as' => '/', 'uses' => 'IndexController@indexAction']);
        Route::get('index/main', ['as' => '/main', 'uses' => 'IndexController@mainAction']);
        Route::get('index/cache', ['as' => '/cache', 'uses' => 'IndexController@cacheAction']);
        Route::match(['get', 'post'], 'index/config', ['as' => '/config', 'uses' => 'IndexController@configAction']);
        Route::match(['get', 'post'], 'index/bq', ['as' => '/bq', 'uses' => 'IndexController@bqAction']);
        Route::match(['get', 'post'], 'index/log', ['as' => '/log', 'uses' => 'IndexController@logAction']);
        Route::match(['get', 'post'], 'index/clearlog', ['as' => '/clearlog', 'uses' => 'IndexController@clearlogAction']);
        Route::match(['get', 'post'], 'index/attack', ['as' => '/attack', 'uses' => 'IndexController@attackAction']);
        Route::match(['get', 'post'], 'index/clearattack', ['as' => '/clearattack', 'uses' => 'IndexController@clearattackAction']);
    });
    // 管理员管理
    Route::group(['prefix' => 'user', 'as' => '/user'], function () {
        Route::get('index', ['as' => '/index', 'uses' => 'UserController@indexAction']);

    });
    // 权限管理
    Route::group(['prefix' => 'auth', 'as' => '/auth'], function () {
        Route::get('index', ['as' => '/index', 'uses' => 'AuthController@indexAction']);

    });
    // ip管理
    Route::group(['prefix' => 'ip', 'as' => '/ip'], function () {
        Route::get('index', ['as' => '/index', 'uses' => 'IpController@indexAction']);

    });
    // 站点管理
    Route::group(['prefix' => 'site', 'as' => '/site'], function () {
        Route::match(['get', 'post'], 'index', ['as' => '/index', 'uses' => 'SiteController@indexAction']);

    });
    // 栏目管理
    Route::group(['prefix' => 'category', 'as' => '/category'], function () {
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'CategoryController@addAction']);
        Route::match(['get', 'post'], 'edit/{id}', ['as' => '/edit', 'uses' => 'CategoryController@editAction'])
            ->where('id', '[0-9]+');
        Route::get('cache', ['as' => '/cache', 'uses' => 'CategoryController@cacheAction']);

        Route::match(['get', 'post'], '{index?}', ['as' => '/index', 'uses' => 'CategoryController@indexAction']);
    });
    // 标签管理
    Route::group(['prefix' => 'tag', 'as' => '/tag'], function () {
        Route::get('', ['as' => '/index', 'uses' => 'TagController@indexAction']);
        Route::get('index', ['as' => '/index', 'uses' => 'TagController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'TagController@addAction']);
        Route::match(['get', 'post'], 'edit/{id}', ['as' => '/edit', 'uses' => 'TagController@editAction'])
            ->where('id', '[0-9]+');
        Route::post('import', ['as' => '/import', 'uses' => 'TagController@importAction']);
        Route::get('cache/{qok?}', ['as' => '/cache', 'uses' => 'TagController@cacheAction']);

    });
    // 内链管理
    Route::group(['prefix' => 'relatedlink', 'as' => '/relatedlink'], function () {
        Route::match(['get', 'post'], '', ['as' => '/index', 'uses' => 'RelatedlinkController@indexAction']);
        Route::match(['get', 'post'], 'index', ['as' => '/index', 'uses' => 'RelatedlinkController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'RelatedlinkController@addAction']);
        Route::match(['get', 'post'], 'edit/{id}', ['as' => '/edit', 'uses' => 'RelatedlinkController@editAction'])
            ->where('id', '[0-9]+');
        Route::post('import', ['as' => '/import', 'uses' => 'RelatedlinkController@importAction']);
        Route::get('cache', ['as' => '/cache', 'uses' => 'RelatedlinkController@cacheAction']);
    });
    // 会员管理
    Route::group(['prefix' => 'member', 'as' => '/member'], function () {
        Route::get('reg', ['as' => '/reg', 'uses' => 'MemberController@regAction']);

        Route::match(['get', 'post'], 'group/{type?}', ['as' => '/group', 'uses' => 'MemberController@groupAction']);

        Route::get('config', ['as' => '/config', 'uses' => 'MemberController@configAction']);
        Route::get('pms', ['as' => '/pms', 'uses' => 'MemberController@pmsAction']);

        Route::match(['get', 'post'], '{index?}', ['as' => '/index', 'uses' => 'MemberController@indexAction']);
        Route::match(['get', 'post'], 'index/{status}', ['as' => '/index/1', 'uses' => 'MemberController@indexAction']);
    });
    // 内容管理
    Route::group(['prefix' => 'content', 'as' => '/content'], function () {
        Route::match(['get', 'post'], 'index/{catid}/{modelid}/{recycle?}', ['as' => '/index', 'uses' => 'ContentController@indexAction']);
        Route::match(['get', 'post'], 'add/{catid}/{modelid}', ['as' => '/add', 'uses' => 'ContentController@addAction']);
        Route::get('del/{catid}/{id}', ['as' => '/del', 'uses' => 'ContentController@delAction']);

        Route::match(['get', 'post'], 'verify/{catid}/{modelid}/{status?}', ['as' => '/index', 'uses' => 'ContentController@verifyAction']);

        Route::match(['get', 'post'], '{catid}/{modelid}/{recycle?}', ['as' => '/index', 'uses' => 'ContentController@indexAction']);
    });
    // 模型管理
    Route::group(['prefix' => 'model', 'as' => '/model'], function () {
        Route::match(['get', 'post'], 'index/{typeid?}', ['as' => '/index', 'uses' => 'ModelController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'ModelController@addAction']);
        Route::match(['get', 'post'], 'edit/{modelid}', ['as' => '/edit', 'uses' => 'ModelController@editAction'])
            ->where('modelid', '[0-9]+');
        Route::match(['get', 'post'], 'del/{modelid}', ['as' => '/del', 'uses' => 'ModelController@delAction'])
            ->where('modelid', '[0-9]+');
        Route::get('cache', ['as' => '/cache', 'uses' => 'ModelController@cacheAction']);
    });
    // 广告管理
    Route::group(['prefix' => 'position', 'as' => '/position'], function () {
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'PositionController@addAction']);
        Route::match(['get', 'post'], 'edit/{posid}', ['as' => '/edit', 'uses' => 'PositionController@editAction']);
        Route::match(['get', 'post'], 'del/{posid}', ['as' => '/del', 'uses' => 'PositionController@delAction']);
        Route::match(['get', 'post'], 'list/{posid}', ['as' => '/list', 'uses' => 'PositionController@listAction']);
        Route::match(['get', 'post'], 'adddata/{posid}', ['as' => '/adddata', 'uses' => 'PositionController@adddataAction']);
        Route::match(['get', 'post'], 'editdata/{posid}/{id}', ['as' => '/editdata', 'uses' => 'PositionController@editdataAction']);
        Route::get('cache', ['as' => '/cache', 'uses' => 'PositionController@cacheAction']);

        Route::match(['get', 'post'], '{index?}', ['as' => '/index', 'uses' => 'PositionController@indexAction']);
    });
});