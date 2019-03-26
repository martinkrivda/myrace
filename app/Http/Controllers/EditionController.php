<?php

namespace App\Http\Controllers;

use App\RaceEdition;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

class EditionController extends Controller {
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
	public function index() {
		try {
			$raceeditions = DB::table('raceedition')
				->leftJoin('race', 'raceedition.race_ID', '=', 'race.race_ID')
				->leftJoin('organiser', 'race.organiser_ID', '=', 'organiser.organiser_ID')
				->get();
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not read race edition from DB.', ['message' => $e->getMessage()]);
			$raceeditions = $e->getMessage();
		}

		return response()->json(['data' => $raceeditions]);
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
		try {
			$rules = array(
				'editionname' => 'required|string|max:70',
				'edition_nr' => 'required|numeric|max:9999|min:1',
				'race' => 'numeric|exists:race,race_ID',
				'date' => 'date|required',
				'firststart' => 'required|date_format:H:i',
				'location' => 'required|string|max:50',
				'gps' => 'required|string|max:50|regex:/^(\-?\d+(\.\d+)?)N?,\s*(\-?\d+(\.\d+)?)E?$/',
				'eventoffice' => 'date|required',
				'web' => 'url|nullable|max:50',
				'entrydate1' => 'date|before:eventoffice|nullable',
				'competition' => 'string|nullable|max:155',
				'eventdirector' => 'nullable|string|max:50',
				'mainreferee' => 'nullable|string|max:50',
				'entriesmanager' => 'nullable|string|max:50',
				'jury1' => 'nullable|string|max:50',
				'jury2' => 'nullable|string|max:50',
				'jury3' => 'nullable|string|max:50',
			);
			$validator = Validator::make(Input::all(), $rules);
			// process the login
			if ($validator->fails()) {
				return response()->json($validator->errors(), 422);
			} else {
				$user = Auth::user();
				$create = RaceEdition::create($request->all());
				Log::info('New race edition was added to DB.', ['editionname' => $create->editionname, 'date' => $create->date, 'edition_ID' => $create->edition_ID]);
			}
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not store race edition to DB.', ['editionname' => $request->editionname, 'edition_ID' => $request->edition_ID, 'message' => $e->getMessage()]);
			$create = $e->getMessage();
		}

		return response()->json($create);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($edition_ID) {
		$show = RaceEdition::find($edition_ID);
		return response()->json($show);
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
	public function update(Request $request, $edition_ID) {
		$rules = array(
			'editionname' => 'required|string|max:70',
			'edition_nr' => 'required|numeric|max:9999|min:1',
			'race' => 'numeric|exists:race,race_ID',
			'date' => 'date|required',
			'firststart' => 'required|date_format:H:i',
			'location' => 'required|string|max:50',
			'gps' => 'required|string|max:50|regex:/^(\-?\d+(\.\d+)?)N?,\s*(\-?\d+(\.\d+)?)E?$/',
			'eventoffice' => 'date|required',
			'web' => 'url|nullable|max:50',
			'entrydate1' => 'date|before:eventoffice|nullable',
			'competition' => 'string|nullable|max:155',
			'eventdirector' => 'nullable|string|max:50',
			'mainreferee' => 'nullable|string|max:50',
			'entriesmanager' => 'nullable|string|max:50',
			'jury1' => 'nullable|string|max:50',
			'jury2' => 'nullable|string|max:50',
			'jury3' => 'nullable|string|max:50',
		);
		$validator = Validator::make(Input::all(), $rules);
		// process the login
		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		} else {
			try {
				$edit = RaceEdition::find($edition_ID)->update($request->all());
				$user = Auth::user();
				Log::info('Edition was updated from DB.', ['edition_ID' => $edition_ID, 'user' => [$user->lastname, $user->lastname], 'user_ID' => $user->id]);
			} catch (\Exception $e) {
				alert()->error('Error!', $e->getMessage());
				Log::error('Can not update race edition to DB.', ['editionname' => $request->editionname, 'edition_ID' => $request->edition_ID, 'message' => $e->getMessage()]);
				$edit = $e->getMessage();
			}
		}
		return response()->json($edit);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($edition_ID) {
		$user = Auth::user();
		RaceEdition::find($edition_ID)->delete();
		//Runner::find($runner_ID)->update(['deleted' => true]);
		Log::info('Edition was deleted from DB.', ['edition_ID' => $edition_ID, 'user' => [$user->lastname, $user->lastname], 'user_ID' => $user->id]);
		return response()->json(['message' => 'Edition deleted successfully', 'status' => 'success', 'done']);
	}
}
