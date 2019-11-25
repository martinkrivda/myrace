<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Registration;
use App\Split;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class SplitController extends BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
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
			'bibNumber' => 'required|numeric|max:5',
			'time' => 'required|date',

		]);

		if ($validator->fails()) {
			return $this->sendError('Validation Error.', $validator->errors());
		}

		try {
			$runner = Registration::leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')->where('registration.edition_ID', $request->competition)->where('registration.bib_nr', $request->bibNumber)->select('registration_ID', 'starttimems', 'registration.bib_nr', 'stime', 'registration.category_ID')->first();
		} catch (\Exception $e) {
			Log::error('Problem with database', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		if (!$runner) {
			return $this->sendError('No runner with this bib number.');
		}

		if ($runner->stime == null) {
			$category = Category::find($runner->category_ID);
			if ($category->starttime != null) {
				$runner->stime = $category->starttime;
			} else {
				$race = RaceEdition::find($request->competition);
				$runner->stime = date('Y-m-d H:i:s', strtotime("$race->date $race->firststart"));
			}
		}
		if ($request->time < $runner->stime) {
			Log::warning('Split time is before start.', ['runner' => $runner->registration_ID, 'time' => $request->time]);
			return $this->sendError('Split time is before the start');
		}
		try {
			$split = new Split;
			$split->gateway = $request->gateway;
			$split->registration_ID = $runner->registration_ID;
			$split->splittimems = strtotime($request->time) - strtotime($runner->stime);
			$split->save();
		} catch (\Exception $e) {
			Log::error('Problem with writing split to database.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		return $this->sendResponse($split->toArray(), 'Split created successfully.');
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
}
