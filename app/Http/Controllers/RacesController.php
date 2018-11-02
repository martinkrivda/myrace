<?php

namespace App\Http\Controllers;

use App\Country;
use App\Organiser;
use App\Race;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use JavaScript;

class RacesController extends Controller {
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
	public function races() {
		try {
			$countries = Country::all('country_code', 'name');
			$organisers = Organiser::all('organiser_ID', 'orgname');
			$races = Race::all('race_ID', 'racename');
			$user = Auth::user();
			Javascript::put(['userID' => $user->id]);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not read races from DB.', ['message' => $e->getMessage()]);
		}
		return view('settings.races', compact('countries', 'organisers', 'races'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$races = DB::table('race')
				->select('race_ID', 'racename', 'race_abbr', 'location', 'race.organiser_ID', 'race.web', 'race.email', 'race.phone', 'organiser_abbr', 'orgname')
				->leftJoin('organiser', 'race.organiser_ID', '=', 'organiser.organiser_ID')
				->get();
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not read data races from DB.', ['message' => $e->getMessage()]);
		}
		return response()->json(['data' => $races]);
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
			$this->validate($request, array(
				'racename' => 'required|string|max:70',
				'location' => 'required|string|max:50',
				'organiser' => 'numeric|exists:organiser,organiser_ID|max:10',
				'race_abbr' => 'string|max:10|required|unique:race',
				'web' => 'url|nullable|max:50',
				'email' => 'email|nullable|max:100',
				'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
			));
			$create = Race::create($request->all());
			Log::info('New race was added to DB.', ['racename' => $create->racename, 'location' => $create->location, 'race_ID' => $create->race_ID]);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not store race to DB.', ['racename' => $request->racename, 'message' => $e->getMessage()]);
			return new $e->getMessage();
		}
		return response()->json($create);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($race_ID) {
		try {
			$show = Race::find($race_ID);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not show race from DB.', ['race_ID' => $race_ID, 'message' => $e->getMessage()]);
		}
		return response()->json($show);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
		if ($request['action'] == 'edit') {
			try {
				$this->validate($request, array(
					'racename' => 'required|string|max:70',
					'location' => 'required|string|max:50',
					'organiser' => 'numeric|exists:organiser,organiser_ID|max:10',
					'race_abbr' => 'string|max:10|required',
					'race_abbr' => Rule::unique('race')->ignore($request['race_ID'], 'race_ID'),
					'web' => 'url|nullable|max:50',
					'email' => 'email|nullable|max:100',
					'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
				));
				$edit = Race::find($request['race_ID'])->update($request->all());
				alert()->success('Success!', 'Race was modified successfully.');
			} catch (\Exception $e) {
				alert()->error('Error!', 'Race was modified with errors.');
				return new $e->getMessage();
			}
			return response()->json($edit);

		} elseif ($request['action'] == 'delete') {
			try {
				$delete = Race::find($request['race_ID'])->delete();
				alert()->success('Success!', 'Race was deleted successfully.');
			} catch (\Exception $e) {
				alert()->error('Error!', 'Race was modified with errors.');
				return $e->getMessage();
			} finally {
				return response()->json($delete);
			}
		} elseif ($request['action'] == 'restore') {
			echo "restore";
		}
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
