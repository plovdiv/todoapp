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



Route::group(['middleware' => ['role:owner']], function() {
// tasks routes
    Route::get('/lists/{lists}/tasks', 'TasksController@index')->name('tasks');
    Route::post('lists/{lists}/tasks', 'TasksController@store')->name('tasks.create');
    Route::delete('/tasks/{task}', 'TasksController@destroy')->name('tasks.delete');
    Route::put('/tasks/{task}', 'TasksController@complete')->name('tasks.complete');

// lists routes
    Route::get('/', 'ListsController@index')->name('lists');
    Route::post('/lists', 'ListsController@store')->name('lists.create');
    Route::delete('/lists/{list}', 'ListsController@destroy')->name('lists.delete');
    Route::put('/lists/{list}', 'ListsController@edit')->name('lists.edit');
    Route::get('/lists/{list}/export', 'ListsController@export')->name('lists.export');
    Route::get('/lists/archived', 'ListsController@archived')->name('lists.archived');

});

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin'], 'namespace' => 'Admin'], function() {
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::delete('/lists/{list}', 'HomeController@destroy')->name('admin.list.delete');
});
/**
 * Replace Auth::routes() 
 */
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');
});
