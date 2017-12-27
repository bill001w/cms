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

Route::get('/test', function () {
    return view('welcome');
});

Route::group(['namespace' => 'front', 'as' => 'front'], function () {
    Route::group(['as' => '/index/'], function () {
        Route::get('', ['as' => '', 'uses' => 'IndexController@indexAction']);
    });
});


// 后台登录
Route::match(['get', 'post'], 'admin/login', ['as' => 'admin/login/index', 'uses' => 'admin\LoginController@indexAction']);
Route::get('admin/login/logout', ['as' => 'admin/login/logout', 'uses' => 'admin\LoginController@logoutAction']);

Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'as' => 'admin', 'middleware' => ['admin.check']], function () {
    // 首页和系统管理
    Route::group(['as' => '/index/'], function () {
        Route::get('', ['as' => '', 'uses' => 'IndexController@indexAction']);
        Route::get('index', ['as' => '', 'uses' => 'IndexController@indexAction']);
        Route::get('index/main', ['as' => 'main', 'uses' => 'IndexController@mainAction']);
        Route::get('index/cache', ['as' => 'cache', 'uses' => 'IndexController@cacheAction']);
        Route::match(['get', 'post'], 'index/config', ['as' => '/config', 'uses' => 'IndexController@configAction']);
        Route::match(['get', 'post'], 'index/log', ['as' => '/log', 'uses' => 'IndexController@logAction']);
        Route::match(['get', 'post'], 'index/clearlog', ['as' => '/clearlog', 'uses' => 'IndexController@clearlogAction']);
        Route::match(['get', 'post'], 'index/attack', ['as' => '/attack', 'uses' => 'IndexController@attackAction']);
        Route::match(['get', 'post'], 'index/clearattack', ['as' => '/clearattack', 'uses' => 'IndexController@clearattackAction']);
    });
    // 管理员管理
    Route::group(['prefix' => 'user', 'as' => '/user'], function () {
        Route::get('', ['as' => '/index', 'uses' => 'UserController@indexAction']);
        Route::get('index', ['as' => '/index', 'uses' => 'UserController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'UserController@addAction']);
        Route::match(['get', 'post'], 'edit/{uid}', ['as' => '/edit', 'uses' => 'UserController@editAction']);
        Route::match(['get', 'post'], 'ajaxedit', ['as' => '/ajaxedit', 'uses' => 'UserController@ajaxeditAction']);    // 最顶部个人资料修改
        Route::get('del/{uid}', ['as' => '/del', 'uses' => 'UserController@delAction']);
    });
    // 权限管理
    Route::group(['prefix' => 'auth', 'as' => '/auth'], function () {
        Route::get('', ['as' => '/index', 'uses' => 'RoleController@indexAction']);
        Route::get('index', ['as' => '/index', 'uses' => 'RoleController@indexAction']);
        Route::match(['get', 'post'], 'list/{roleid}', ['as' => '/list', 'uses' => 'RoleController@listAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/list', 'uses' => 'RoleController@addAction']);
        Route::match(['get', 'post'], 'edit/{roleid}', ['as' => '/edit', 'uses' => 'RoleController@editAction']);
        Route::match(['get', 'post'], 'del/{roleid}', ['as' => '/del', 'uses' => 'RoleController@delAction']);
        Route::get('cache', ['as' => '/cache', 'uses' => 'RoleController@cacheAction']);
    });
    // ip管理
    Route::group(['prefix' => 'ip', 'as' => '/ip'], function () {
        Route::match(['get', 'post'], '', ['as' => '/index', 'uses' => 'IpController@indexAction']);
        Route::match(['get', 'post'], 'index', ['as' => '/index', 'uses' => 'IpController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'IpController@addAction']);
        Route::get('cache', ['as' => '/cache', 'uses' => 'IpController@cacheAction']);
    });
    // 栏目管理
    Route::group(['prefix' => 'category', 'as' => '/category'], function () {
        Route::match(['get', 'post'], '', ['as' => '/index', 'uses' => 'CategoryController@indexAction']);
        Route::match(['get', 'post'], '/index', ['as' => '/index', 'uses' => 'CategoryController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'CategoryController@addAction']);
        Route::match(['get', 'post'], 'edit/{catid}', ['as' => '/edit', 'uses' => 'CategoryController@editAction'])
            ->where('id', '[0-9]+');
        Route::match(['get', 'post'], 'del/{catid}', ['as' => '/del', 'uses' => 'CategoryController@delAction'])
            ->where('id', '[0-9]+');
        Route::get('cache', ['as' => '/cache', 'uses' => 'CategoryController@cacheAction']);

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
    // 附件管理
    Route::group(['prefix' => 'attachment', 'as' => '/attachment'], function () {
        Route::match(['get', 'post'], '', ['as' => '/index', 'uses' => 'AttachmentController@indexAction']);
        Route::match(['get', 'post'], 'index', ['as' => '/index', 'uses' => 'AttachmentController@indexAction']);
        Route::get('del/{name}', ['as' => '/del', 'uses' => 'AttachmentController@delAction']);
    });
    // 广告管理
    Route::group(['prefix' => 'position', 'as' => '/position'], function () {
        Route::match(['get', 'post'], '', ['as' => '/index', 'uses' => 'PositionController@indexAction']);
        Route::match(['get', 'post'], 'index', ['as' => '/index', 'uses' => 'PositionController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'PositionController@addAction']);
        Route::match(['get', 'post'], 'edit/{posid}', ['as' => '/edit', 'uses' => 'PositionController@editAction']);
        Route::match(['get', 'post'], 'del/{posid}', ['as' => '/del', 'uses' => 'PositionController@delAction']);
        Route::match(['get', 'post'], 'list/{posid}', ['as' => '/list', 'uses' => 'PositionController@listAction']);
        Route::match(['get', 'post'], 'adddata/{posid}', ['as' => '/adddata', 'uses' => 'PositionController@adddataAction']);
        Route::match(['get', 'post'], 'ajaxloadinfo', ['as' => '/ajaxloadinfo', 'uses' => 'PositionController@ajaxloadinfoAction']);
        Route::match(['get', 'post'], 'editdata/{posid}/{id}', ['as' => '/editdata', 'uses' => 'PositionController@editdataAction']);
        Route::get('cache', ['as' => '/cache', 'uses' => 'PositionController@cacheAction']);
    });
    // 标签管理
    Route::group(['prefix' => 'tag', 'as' => '/tag'], function () {
        Route::match(['get', 'post'], '', ['as' => '/index', 'uses' => 'TagController@indexAction']);
        Route::match(['get', 'post'], 'index', ['as' => '/index', 'uses' => 'TagController@indexAction']);
        Route::match(['get', 'post'], 'add', ['as' => '/add', 'uses' => 'TagController@addAction']);
        Route::match(['get', 'post'], 'edit/{id}', ['as' => '/edit', 'uses' => 'TagController@editAction'])
            ->where('id', '[0-9]+');
        Route::match(['get', 'post'], 'del/{id}', ['as' => '/del', 'uses' => 'TagController@delAction'])
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
        Route::match(['get', 'post'], 'del/{id}', ['as' => '/del', 'uses' => 'RelatedlinkController@delAction'])
            ->where('id', '[0-9]+');
        Route::post('import', ['as' => '/import', 'uses' => 'RelatedlinkController@importAction']);
        Route::get('cache', ['as' => '/cache', 'uses' => 'RelatedlinkController@cacheAction']);
    });
    // 内容管理
    Route::group(['prefix' => 'content', 'as' => '/content'], function () {
        Route::match(['get', 'post'], 'index/{catid}/{recycle?}', ['as' => '/index', 'uses' => 'ContentController@indexAction']);
        Route::match(['get', 'post'], 'add/{catid}', ['as' => '/add', 'uses' => 'ContentController@addAction']);
        Route::get('del/{catid}/{id}', ['as' => '/del', 'uses' => 'ContentController@delAction']);

        Route::match(['get', 'post'], 'verify/{catid}/{status?}', ['as' => '/index', 'uses' => 'ContentController@verifyAction']);

        Route::match(['get', 'post'], '{catid}/{recycle?}', ['as' => '/index', 'uses' => 'ContentController@indexAction']);
        Route::get('cache', ['as' => '/cache', 'uses' => 'ContentController@cacheAction']);
    });
    // 会员管理
    Route::group(['prefix' => 'member', 'as' => '/member'], function () {
        Route::match(['get', 'post'], 'index/{status?}', ['as' => '/index/1', 'uses' => 'MemberController@indexAction']);
        Route::match(['get', 'post'], 'reg', ['as' => '/reg', 'uses' => 'MemberController@regAction']);
        Route::match(['get', 'post'], 'edit/{id}', ['as' => '/edit', 'uses' => 'MemberController@editAction']);
        Route::get('del/{id}', ['as' => '/del', 'uses' => 'MemberController@delAction']);
        Route::match(['get', 'post'], 'group/{type?}', ['as' => '/group', 'uses' => 'MemberController@groupAction']);
        Route::match(['get', 'post'], 'config', ['as' => '/config', 'uses' => 'MemberController@configAction']);
        Route::get('pms', ['as' => '/pms', 'uses' => 'MemberController@pmsAction']);    // todo pms
        Route::post('ajaxemail', ['as' => '/ajaxemail', 'uses' => 'MemberController@ajaxemailAction']);
        Route::post('ajaxusername', ['as' => '/ajaxusername', 'uses' => 'MemberController@ajaxusernameAction']);
    });
});

