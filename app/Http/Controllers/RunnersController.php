<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Controller;
use App\Runner;
use App\Services\PayUService\Exception;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RunnersController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}
	//
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function runners() {
		$countries = Country::all('country_code', 'name');
		return view('directory.runners', compact('countries'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//$runners = Runner::all();
		try {
			$runners = DB::table('runner')
				->select('runner.runner_ID', 'runner.firstname', 'runner.lastname', 'vintage', 'runner.gender', 'runner.email', 'runner.phone', 'runner.country', 'runner.club', 'runner.club_ID', 'club.clubname', 'club.clubabbr')
				->leftJoin('club', 'runner.club_ID', '=', 'club.club_ID')
				->get();
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
		}
		return response()->json(['data' => $runners]);
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
				'firstname' => 'required|string|max:50',
				'lastname' => 'required|string|max:255',
				'vintage' => 'required|numeric|min:1900',
				'gender' => ['required', 'regex:/^(male|female)$/', 'max:255'],
				'email' => 'email|nullable|max:255',
				'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
				'country' => 'string|exists:country,country_code|max:2',
				'club' => 'string|nullable|max:70',
				'club_ID' => 'numeric|exists:club,club_ID|nullable',
			));
			if ($request['club_ID'] !== '' && $request['club_ID'] !== null) {
				$request['club'] = null;
			}
			$create = Runner::create($request->all());
			Log::info('New runner was added to DB.', ['firstname' => $create->firstname, 'lastname' => $create->lastname, 'runner_ID' => $create->runner_ID]);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('New runner wasn`t added to DB.', ['firstname' => $create->firstname, 'lastname' => $create->lastname, 'runner_ID' => $create->runner_ID]);
		}
		return response()->json($create);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($runner_ID) {
		try {
			$show = Runner::find($runner_ID);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
		}
		return response()->json($show);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $runner_ID
	 * @return \Illuminate\Http\Response
	 */
	public function edit($runner_ID) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $runner_ID
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $runner_ID) {
		try {
			$this->validate($request, array(
				'firstname' => 'required|string|max:50',
				'lastname' => 'required|string|max:255',
				'vintage' => 'required|numeric|min:1900',
				'gender' => ['required', 'regex:/^(male|female)$/', 'max:255'],
				'email' => 'email|nullable|max:255',
				'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
				'country' => 'string|exists:country,country_code|max:2',
				'club' => 'string|nullable|max:70',
				'club_ID' => 'numeric|exists:club,club_ID|nullable',
			));
			if ($request['club'] == null) {
				$request['club_ID'] = null;
			}
			if ($request['club_ID'] !== '' && $request['club_ID'] !== null) {
				$request['club'] = null;
			}
			$edit = Runner::find($runner_ID)->update($request->all());
			Log::info('Runner was updated to DB.', ['runner_ID' => $runner_ID]);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Runner wasn`t updated to DB.', ['runner_ID' => $runner_ID]);
		}
		return response()->json($edit);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $runner_ID
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($runner_ID) {
		try {
			Runner::find($runner_ID)->delete();
			//Runner::find($runner_ID)->update(['deleted' => true]);
			Log::info('Runner was deleted from DB.', ['runner_ID' => $runner_ID]);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Runner wasn`t deleted from DB.', ['runner_ID' => $runner_ID]);
		}
		return response()->json(['message' => 'Runner deleted successfully', 'status' => 'success', 'done']);
	}
}
