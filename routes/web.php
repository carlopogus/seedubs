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

Route::get('/', 'ConnectionsController@index');

Auth::routes();

Route::get('/home', 'ConnectionsController@index');

Route::get('settings/api', 'SettingsController@index')->name('settings');
Route::post('settings/api', 'SettingsController@update');

Route::get('settings/performance', 'SettingsController@performance');
Route::post('settings/performance', 'SettingsController@clearCache');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('connections', 'ConnectionsController');
    Route::get('ajax/find-companies', 'ConnectionsController@findCompanies');
    Route::get('ajax/find-agreements', 'ConnectionsController@findAgreements');
    Route::get('ajax/jira-projects', 'ConnectionsController@jiraProjects');
});


