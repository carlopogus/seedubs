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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('admin/settings', 'SettingsController@index')->name('settings');

Route::post('admin/settings', 'SettingsController@update');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('connections', 'ConnectionsController');
    Route::get('find-companies', 'ConnectionsController@findCompanies');
    Route::get('find-agreements', 'ConnectionsController@findAgreements');
});

