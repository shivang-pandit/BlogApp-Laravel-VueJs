<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::any('{slug}', function () {
//     return view('welcome');
// });

Route::group([
    'prefix' => 'admin/app/tag',
    'namespace' => '\App\Http\Controllers\AdminController',
    'middleware' => 'AdminCheck.Middleware'
    ], function () {
        Route::get('',
        [
            'as' => 'index',
            'uses' => 'TagController@getAll',            
        ]);
        Route::post('create',
        [
            'as' => 'create',
            'uses' => 'TagController@create',            
        ]);
        Route::post('update',
        [
            'as' => 'update',
            'uses' => 'TagController@update',            
        ]);
        Route::delete('delete/{id}',
        [
            'as' => 'delete',
            'uses' => 'TagController@delete',            
        ]);        
});

Route::group([
    'prefix' => '/app/common',
    'namespace' => '\App\Http\Controllers',
    ], function () {
        Route::post('upload',
        [
            'as' => 'upload',
            'uses' => 'CommonController@upload',            
        ]);
        Route::post('delete_file',
        [
            'as' => 'delete_file',
            'uses' => 'CommonController@deleteFile',            
        ]);
        Route::post('upload_editor_image',
        [
            'as' => 'delete_file',
            'uses' => 'CommonController@uploadEditorImage',            
        ]);
});

Route::group([
    'prefix' => 'admin/app/category',
    'namespace' => '\App\Http\Controllers\AdminController',
    'middleware' => 'AdminCheck.Middleware'
    ], function () {
        Route::get('',
        [
            'as' => 'index',
            'uses' => 'CategoryController@getAll',            
        ]);
        Route::post('create',
        [
            'as' => 'create',
            'uses' => 'CategoryController@create',            
        ]);
        Route::post('update',
        [
            'as' => 'update',
            'uses' => 'CategoryController@update',            
        ]);
        Route::delete('delete/{id}',
        [
            'as' => 'delete',
            'uses' => 'CategoryController@delete',            
        ]);  
});

Route::group([
    'prefix' => 'admin/app/admin',
    'namespace' => '\App\Http\Controllers\AdminController',    
    ], function () {
        Route::get('',
        [
            'as' => 'index',
            'uses' => 'AdminController@getAll',            
            'middleware' => 'AdminCheck.Middleware'
        ]);
        Route::post('create',
        [
            'as' => 'create',
            'uses' => 'AdminController@create',    
            'middleware' => 'AdminCheck.Middleware'        
        ]);
        Route::post('update',
        [
            'as' => 'update',
            'uses' => 'AdminController@update',    
            'middleware' => 'AdminCheck.Middleware'        
        ]);
        Route::delete('delete/{id}',
        [
            'as' => 'delete',
            'uses' => 'AdminController@delete',    
            'middleware' => 'AdminCheck.Middleware'        
        ]);  
        Route::post('login',
        [
            'as' => 'login',
            'uses' => 'AdminController@login',            
        ]);
        Route::get('inquiries',
        [
            'as' => 'inquiries',
            'uses' => 'InquiryController@index',
            'middleware' => 'AdminCheck.Middleware'
        ]);
});

Route::group([
    'prefix' => 'admin/app/role',
    'namespace' => '\App\Http\Controllers\AdminController',
    'middleware' => 'AdminCheck.Middleware'
    ], function () {
        Route::get('',
        [
            'as' => 'index',
            'uses' => 'RoleController@getAll',            
        ]);
        Route::post('create',
        [
            'as' => 'create',
            'uses' => 'RoleController@create',            
        ]);
        Route::post('update',
        [
            'as' => 'update',
            'uses' => 'RoleController@update',            
        ]);
        Route::delete('delete/{id}',
        [
            'as' => 'delete',
            'uses' => 'RoleController@delete',            
        ]);        
        Route::post('assign_permission',
        [
            'as' => 'assignPermission',
            'uses' => 'RoleController@assignPermission',            
        ]);    
        Route::get('show/{id}',
        [
            'as' => 'show',
            'uses' => 'RoleController@show',            
        ]);      
});

Route::group([
    'prefix' => 'admin/app/blog',
    'namespace' => '\App\Http\Controllers\AdminController',
    'middleware' => 'AdminCheck.Middleware'
    ], function () {
        Route::get('',
        [
            'as' => 'index',
            'uses' => 'BlogController@getAll',            
        ]);
        Route::post('create',
        [
            'as' => 'create',
            'uses' => 'BlogController@create',            
        ]);
        Route::post('update',
        [
            'as' => 'update',
            'uses' => 'BlogController@update',            
        ]);
        Route::delete('delete/{id}',
        [
            'as' => 'delete',
            'uses' => 'BlogController@delete',            
        ]);        
        Route::post('assign_permission',
        [
            'as' => 'assignPermission',
            'uses' => 'BlogController@assignPermission',            
        ]);    
        Route::get('show/{id}',
        [
            'as' => 'show',
            'uses' => 'BlogController@show',            
        ]);      
});

//frontend routes
Route::group([
    'prefix' => 'app/category',
    'namespace' => '\App\Http\Controllers\frontController',    
    ], function () {
        Route::get('',
        [
            'as' => 'index',
            'uses' => 'CategoryController@getAll',            
        ]);        
});

Route::group([
    'prefix' => 'app/blog',
    'namespace' => '\App\Http\Controllers\frontController',    
    ], function () {
        Route::get('get_top',
        [
            'as' => 'getTop',
            'uses' => 'BlogController@getTop',            
        ]);
        Route::get('blog_detail/{id}',
        [
            'as' => 'blogDetail',
            'uses' => 'BlogController@blogDetail',            
        ]);   
        Route::get('get_all',
        [
            'as' => 'getAll',
            'uses' => 'BlogController@getAll',            
        ]);        
});
Route::post('/inquiry/create', 'frontController\InquiryController@create');
Route::get('admin/', 'AdminController\AdminController@index');
Route::get('admin/logout', 'AdminController\AdminController@logout');
Route::get('/', function () {
        return view('welcome');
});
Route::get('{slug}', 'AdminController\AdminController@index')->where('slug', '([A-z\d-\/_.]+)?'); // if no routes found then load index