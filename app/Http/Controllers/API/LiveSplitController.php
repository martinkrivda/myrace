<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\RfidReader;
use Illuminate\Http\Request;
use Validator;

class LiveSplitController extends BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$this->authorize('results.view', RfidReader::class);
		$liveSplit = RfidReader::where('edition_ID', $request->competition)->get();
		return $this->sendResponse($liveSplit->toArray(), 'Live splits retrieved successfully.');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$input = $request->all();
		$validator = Validator::make($input, [
			'competition' => 'numeric|exists:raceedition,edition_ID',
			'gateway' => 'required|string|max:6',
			'rfidtag' => 'required|max:25',
			'time' => 'required|date',

		]);

		if ($validator->fails()) {
			return $this->sendError('Validation Error.', $validator->errors());
		}

		$liveSplit = new RfidReader;
		$liveSplit->edition_ID = $request->competition;
		$liveSplit->gateway = $request->gateway;
		$liveSplit->rfid_reader = request()->ip();
		$liveSplit->EPC = $request->rfidtag;
		$liveSplit->time = $request->time;
		$liveSplit->year = date('Y', time());
		$liveSplit->save();

		return $this->sendResponse($liveSplit->toArray(), 'Split created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$liveSplit = RfidReader::find($id);
		if (is_null($liveSplit)) {
			return $this->sendError('Live Split not found.');
		}
		return $this->sendResponse($liveSplit->toArray(), 'Live split retrieved successfully.');
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
