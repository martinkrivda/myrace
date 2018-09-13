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
Route::get('runners', 'RunnersController@runners');
Route::resource('runners-data', 'RunnersController');
Route::get('clubs', 'ClubsController@clubs');
Route::resource('clubs-data', 'ClubsController');

Route::post('clubs/searchclub', 'ClubsController@searchclub')->name('clubs.searchclub');

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
    //        // Uses Auth Middleware
    //    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
