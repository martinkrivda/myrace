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
//Route::post('/modal_newrunner', 'RunnersController@modal_addrunner');
//Route::post('/modal_editrunner', 'RunnersController@modal_edit');
//Route::post('/do_editrunner/{id}', 'RunnersController@do_edit');
//Route::post('/runners/delete','RunnersController@destroy');

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
    //        // Uses Auth Middleware
    //    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
