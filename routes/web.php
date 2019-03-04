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
Route::get('info', 'HomeController@index');
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
Route::resource('tags', 'TagController');

Route::post('clubs/searchclub', 'ClubsController@searchclub')->name('clubs.searchclub');
Route::post('runners/searchrunner', 'RunnersController@searchrunner')->name('runners.searchrunner');
Route::post('runners/searchrunnerid', 'RunnersController@getRunnerByID')->name('runners.searchrunnerid');
Route::post('runners/searchsimilar', 'RegistrationController@getSimilarRunnerWith')->name('registrations.getsimilarrunner');
Route::post('registrations/searchexisting', 'RegistrationController@isTooSimilarWith')->name('registrations.getsimilarregistration');
Route::post('registrations/ischangedname', 'RegistrationController@isChangedName')->name('registrations.isechangedname');

Route::get('race/information/{edition_ID}', 'InformationController@information');
//Route::pattern('edition_ID', '{0-9}+');
Route::resource('race/{edition_ID}/category', 'CategoryController', ['parameters' => [
	'edition_ID' => 'edition_ID',
]]);
Route::post('race/category-data', 'CategoryController@getCategory')->name('category.categoryid-data');
Route::post('race/categoryid-data', 'CategoryController@getCategoryByID')->name('category.category-data');
Route::resource('race/{edition_ID}/registration', 'RegistrationController', ['parameters' => [
	'edition_ID' => 'edition_ID',
]]);
Route::resource('race/{edition_ID}/regsummary', 'RegSummaryController', ['parameters' => [
	'edition_ID' => 'edition_ID',
]]);
Route::get('race/{edition_ID}/history', 'HistoryController@history', ['parameters' => ['edition_ID' => 'edition_ID']]);
//Route::post('/tags/export', 'TagController');

Route::get('/auth/google', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::group(['middleware' => 'auth'], function () {
	//    Route::get('/link1', function ()    {
	//        // Uses Auth Middleware
	//    });
	Route::post('/registration-data', 'RegistrationController@store');
	Route::put('/registration-update/{registration_ID}', 'RegistrationController@update', ['parameters' => [
		'registration_ID' => 'registration_ID',
	]]);
	Route::delete('/registration-delete/{registration_ID}', 'RegistrationController@destroy', ['parameters' => [
		'registration_ID' => 'registration_ID',
	]]);
	Route::resource('race/{edition_ID}/rfidreader', 'RfidReaderController', ['parameters' => [
		'edition_ID' => 'edition_ID',
	]]);
	Route::get('race/rfidreader/lasttag', 'RfidReaderController@getLastTag', ['parameters' => [
		'edition_ID' => 'edition_ID',
	]]);
	Route::post('rfid-data', 'RfidReaderController@store');

	Route::group(['prefix' => 'race'], function () {
		Route::group(['prefix' => '{edition_ID}'], function ($edition_ID) {

			// Payments
			Route::resource('payment', 'PaymentController');
			// Start list
			Route::resource('startlist', 'StartTimeController');
			Route::post('startlist/generatetime', 'StartTimeController@generateStartTime')->name('generatetime');
			Route::post('startlist/assigntags', 'StartTimeController@assignTags')->name('assigntags');
			Route::post('startlist/drawstartlist', 'StartTimeController@drawStartList')->name('drawstartlist');
			// History
			Route::get('history', 'HistoryController@index');
			// Results
			Route::resource('resultlist', 'ResultListController');

		});
	});

	//Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
	#adminlte_routes
});
