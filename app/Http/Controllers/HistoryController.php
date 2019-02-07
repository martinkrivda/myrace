<?php

namespace App\Http\Controllers;

class HistoryController extends Controller {
	//
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function history() {
		return view('races.registration.history');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($edition_ID) {
		try {
			$history = DB::table('history')
				->where('edition_ID', $edition_ID)
				->get();
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
		}
		return response()->json(['data' => $history]);
	}
}
