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
Route::get('organiser', 'OrganiserController@organiser')->name('organiser.show');
Route::post('/organiser/{organiser_ID}/update/', 'OrganiserController@update')->name('organiser.update');
Route::resource('organiser-data', 'OrganiserController');
Route::get('races', 'RacesController@races');
Route::post('races-update', 'RacesController@update');
Route::resource('races-data', 'RacesController');
Route::resource('editions-data', 'EditionController');
Route::get('users', 'UsersController@users');
Route::resource('users-data', 'UsersController');

Route::post('clubs/searchclub', 'ClubsController@searchclub')->name('clubs.searchclub');

Route::get('race/information/{edition_ID}', 'InformationController@information');
//Route::pattern('edition_ID', '{0-9}+');
Route::resource('race/{edition_ID}/category', 'CategoryController', ['parameters' => [
    'edition_ID' => 'edition_ID',
]]);

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
    //        // Uses Auth Middleware
    //    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
