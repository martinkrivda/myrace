<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
	//    Route::resource('task', 'TasksController');

	//Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
	#adminlte_api_routes
});
Route::middleware('auth:api')->group(function () {
	Route::group(['prefix' => 'race'], function () {
		Route::group(['prefix' => '{edition_ID}'], function ($edition_ID) {

		});
	});
	Route::resource('livesplit', 'API\LiveSplitController');
});
