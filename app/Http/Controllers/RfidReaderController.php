<?php

namespace App\Http\Controllers;

use App\RaceEdition;
use App\RfidReader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

class RfidReaderController extends Controller {

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
	public function index($edition_ID) {
		$tagsInFinish = RfidReader::distinct('EPC')->where('edition_ID', $edition_ID)->count('EPC');
		$race = RaceEdition::where('edition_ID', $edition_ID)->first();

		return view('races.rfidreader', ['edition_ID' => $edition_ID, 'tagsInFinish' => $tagsInFinish, 'race' => $race]);
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
		$rules = array(
			'gateway' => 'required|string|max:1',
			'edition_ID' => 'numeric|exists:raceedition,edition_ID',
			'rfidtag' => 'required|max:25',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		} else {
			$rfidRead = new RfidReader;
			$rfidRead->EPC = $request->rfidtag;
			$rfidRead->gateway = $request->gateway;
			$rfidRead->edition_ID = $request->edition_ID;
			$rfidRead->rfid_reader = request()->ip();
			$rfidRead->year = date('Y', time());
			$rfidRead->time = date('Y-m-d H:i:s.u', strtotime($request->time));
			$rfidRead->save();

		}
		return response()->json($rfidRead);
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $edition_ID
	 * @return \Illuminate\Http\Response
	 */
	public function getLastTag(Request $request) {
		$lastTags = array();
		try {
			$lastTags = RfidReader::where('edition_ID', $request->edition_ID)->where('gateway', $request->gateway)->orderBy('read_ID', 'DESC')->take(20)->get();
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Cannot read from DB.', ['message' => $e->getMessage()]);
			return $e->getMessage();
		}
		return response()->json($lastTags);

	}
}
