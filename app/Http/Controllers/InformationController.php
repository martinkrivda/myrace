<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class InformationController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  int  $edition_ID
	 * @return \Illuminate\Http\Response
	 */
	public function information($edition_ID) {
		$raceinfo = DB::table('raceedition')
			->select('raceedition.edition_ID', 'raceedition.editionname', 'race.race_abbr', 'raceedition.edition_nr', 'raceedition.date', 'raceedition.location', 'raceedition.firststart', 'eventoffice', 'organiser.orgname', 'competition', 'gps', 'raceedition.web', 'race.email', 'eventdirector', 'mainreferee', 'entriesmanager', 'jury1', 'jury2', 'jury3', 'cancelled', 'cancelreason')
			->leftJoin('race', 'raceedition.race_ID', '=', 'race.race_ID')
			->leftJoin('organiser', 'race.organiser_ID', '=', 'organiser.organiser_ID')
			->where('raceedition.edition_ID', $edition_ID)->first();
		$categories = DB::table('category')
			->select('categoryname', 'length', 'climb', 'entryfee', 'currency', 'birthfrom', 'birthto')
			->where('category.edition_ID', $edition_ID)
			->get();
		return view('races.information')->with('raceinfo', $raceinfo)->with('categories', $categories);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
