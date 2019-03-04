<?php

namespace App\Http\Controllers;

use App\DataTables\HistoryDataTable;

class HistoryController extends Controller {
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
	 * @return \Illuminate\Http\Response
	 */
	public function index(HistoryDataTable $dataTable, $edition_ID) {
		$this->authorize('registrations.audit', Registration::class);
		return $dataTable->forRaceEdition($edition_ID)->render('races.history', ['edition_ID' => $edition_ID]);
	}
}
