<?php

Route::group([
    'prefix' => 'admin',
    'middleware' => ['role.admin']
], function () {
    Route::post('/login', 'AuthController@login');
    Route::get('/stats', 'HomeController@stats');
    Route::get('/logs', 'HomeController@logs');
    Route::post('/upload', 'HomeController@uploadImage');
    Route::get('/product-data', 'HomeController@productData');

    Route::get('/users', 'UserController@index');
    Route::get('/users/{user}', 'UserController@getById');
    Route::post('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@delete');
    Route::post('/users/{user}/point', 'UserController@addPoint');
    Route::post('/users/{user}/change_type_level', 'UserController@changeTypeAndLevel');
    Route::post('/users/{user}/phone_verify', 'UserController@phoneVerify');

    Route::get('/admins', 'AdminController@index');
    Route::get('/admins/all', 'AdminController@all');
    Route::get('/admins/info', 'AdminController@info');
    Route::post('/admins', 'AdminController@add');
    Route::get('/admins/{user}', 'AdminController@getById');
    Route::post('/admins/{user}', 'AdminController@update');
    Route::delete('/admins/{user}', 'AdminController@delete');
    Route::post('/change-password', 'AdminController@changePassword');

    Route::get('/robot', 'AdminController@robot');
    Route::put('/robot', 'AdminController@robot'); 


    Route::get('/category', 'AdminController@category');
    Route::put('/category', 'AdminController@category'); 


    Route::put('/seo-setting', 'SettingController@updateSeoSetting');
    Route::get('/seo-setting', 'SettingController@getSeoSetting');

    Route::get('/seolink', 'AdminController@seolink');
    Route::put('/seolink', 'AdminController@seolink'); 

    Route::get('/settings', 'SettingController@index');
    Route::post('/settings', 'SettingController@add');
    Route::get('/settings/group', 'SettingController@getByGroup');
    Route::get('/settings/all', 'SettingController@getAll');
    Route::get('/settings/{setting}/delete', 'SettingController@delete');
    Route::get('/settings/{setting}', 'SettingController@getById');
    Route::post('/settings/{setting}', 'SettingController@update');
    Route::put('/banner-setting', 'SettingController@updateBannerSetting');
    Route::get('/banner-setting', 'SettingController@getBannerSetting');
    Route::put('/settings/update-multiple', 'SettingController@updateMultiple');



    Route::resource('roles', 'RoleController');
    Route::resource('posts', 'PostController');
    Route::resource('categories', 'CategoryController');

    Route::resource('products', 'ProductController');
    Route::apiResource('subscribers', 'SubscriberController');
    Route::apiResource('brands', 'BrandController');
    Route::apiResource('tags', 'TagController');

    Route::get('product/suggest', 'ProductController@autoSuggest');
    Route::put('products/{product}/status', 'ProductController@updateStatus');
    Route::put('brands-order', 'BrandController@updateOrder');

    Route::post('subscribers/email', 'SubscriberController@sendEmailNewsletter');

    Route::get('service/option', 'ServiceController@options');
    Route::post('service/option', 'ServiceController@createOption');
    Route::put('service/option', 'ServiceController@updateOption')
        ->where('id', '[0-9]+');
    Route::delete('service/option/remove/{id}', 'ServiceController@removeOption')
        ->where('id', '[0-9]+');

    Route::get('services', 'ServiceController@index');
    Route::post('service/add', 'ServiceController@add');

    Route::get('campaign', 'CampaignController@index');
    Route::get('campaign/codes/{id}', 'CampaignController@codes');
    Route::post('campaign/create', 'CampaignController@create');
    Route::delete('campaign/code/cancel/{id}', 'CampaignController@cancelCode');
    Route::delete('campaign/cancel/{id}', 'CampaignController@cancelCampaign');

    Route::get('class_category', 'CategoryController@classCategory');
    Route::post('class_category/create', 'CategoryController@createClassCategory');
    Route::post('class_category/update', 'CategoryController@updateClassCategory');
    Route::get('class_category/detail/{id}', 'CategoryController@classCategoryDetail');

    Route::get('service/detail/{id}', 'ServiceController@detail')
        ->where('id', '[0-9]+');
    Route::delete('service/remove/{id}', 'ServiceController@remove')
        ->where('id', '[0-9]+');
    Route::get('bills', 'BillController@index');
    Route::get('bills/basic', 'BillController@getBasicData');
    Route::put('bills/update/{id}', 'BillController@update')
        ->where('id', '[0-9]+');
});