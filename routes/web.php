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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth:web'], function ()
{
    //All routes are protected. only loginusercan access
    Route::get('tasks/excel','TaskController@getListExcel');
    Route::get('tasks','TaskController@getList');
    Route::get('tasks/create','TaskController@getCreateTask');
    Route::post('tasks/create','TaskController@postCreateTask');

    Route::get('tasks/{id}','TaskController@getViewTask');
    Route::delete('tasks/{id}','TaskController@postDelete');
    Route::get('profile','ProfileController@getProfileView');
    Route::post('profile','ProfileController@postProfile');

    Route::get('tasks/{id}/pdf','TaskController@getViewTaskPdf');

    
    
});


