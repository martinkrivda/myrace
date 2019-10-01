<?php

namespace App\Http\Controllers;

use App\Club;
use App\Country;
use App\Http\Controllers\Controller;
use App\Services\PayUService\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use MilanKyncl\AresAPI;

class ClubsController extends Controller {
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
	public function clubs() {
		try {
			$countries = Country::all('country_code', 'name');
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not read countries from DB.', ['message' => $e->getMessage()]);
		}
		return view('directory.clubs', compact('countries'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$clubs = Club::all();
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not read clubs from DB.', ['message' => $e->getMessage()]);
		}
		return response()->json(['data' => $clubs]);
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
				'clubname' => 'required|string|max:70',
				'clubname2' => 'nullable|string|max:50',
				'clubabbr' => 'required|string|min:3|max:10|unique:club',
				'street' => 'string|max:30|nullable',
				'city' => 'string|max:30|nullable',
				'postalcode' => 'regex:/^\d{5}$/|nullable|max:13',
				'email' => 'email|nullable|max:100',
				'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
				'taxid' => 'regex:/^\d{8}$/|nullable|max:8',
				'vatid' => ['regex:/^(CZ|SK)\d{8}$/', 'nullable', 'max:10'],
				'country' => 'string|exists:country,country_code|max:2',
				'web' => 'url|nullable|max:50',
			));
			$create = Club::create($request->all());
			$create->source = "origin";
			$create->save();
			Log::info('New club was added to DB.', ['name' => $create->clubname, 'club_ID' => $create->club_ID]);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			$create = $e->getMessage();
			Log::error('New club wasn`t added to DB.', ['name' => $request->clubname]);
		}
		return response()->json($create);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($club_ID) {
		try {
			$show = Club::find($club_ID);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			Log::error('Can not read clubs from DB.', ['message' => $e->getMessage()]);
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $club_ID) {
		try {
			$this->validate($request, array(
				'clubname' => 'required|string|max:70',
				'clubname2' => 'nullable|string|max:50',
				'clubabbr' => 'required|string|min:3|max:10',
				'clubabbr' => Rule::unique('club')->ignore($club_ID, 'club_ID'),
				'street' => 'string|max:30|nullable',
				'city' => 'string|max:30|nullable',
				'postalcode' => 'regex:/^\d{5}$/|nullable|max:13',
				'email' => 'email|nullable|max:100',
				'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
				'taxid' => 'regex:/^\d{8}$/|nullable|max:8',
				'vatid' => ['regex:/^(CZ|SK)\d{8}$/', 'nullable', 'max:10'],
				'country' => 'string|exists:country,country_code|max:2',
				'web' => 'url|nullable|max:50',
			));
			$edit = Club::find($club_ID)->update($request->all());
			Log::info('Club was updated to DB.', ['name' => $request->clubname, 'club_ID' => $club_ID]);
		} catch (\Exception $e) {
			alert()->error('Error!', $e->getMessage());
			$edit = $e->getMessage();
			Log::error('Club wasn`t updated to DB.', ['name' => $request->clubname, 'club_ID' => $club_ID]);
		}

		return response()->json($edit);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($club_ID) {
		Club::find($club_ID)->delete();
		//Runner::find($club_ID)->update(['deleted' => true]);
		return response()->json(['message' => 'Club deleted successfully', 'status' => 'success', 'done']);
	}

	public function searchclub(Request $request) {
		if ($request->get('query')) {
			$query = $request->get('query');
			$data = Club::where('clubname', 'LIKE', "%{$query}%")
				->orWhere('clubabbr', 'LIKE', "%{$query}%")
				->orWhere('club_ID', 'LIKE', "%{$query}%")
				->get();
			$output = '<ul class="dropdown-menu" style="display:block; position:relative">';
			foreach ($data as $row) {
				$output .= '
       <li><a href="#">' . $row->clubname . ' - ' . $row->clubabbr . ' - ' . $row->club_ID . '</a></li>
       ';
			}
			$output .= '</ul>';
			echo $output;
		}
	}

	/**
	 * ARES API.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getAresData() {
		$clubs = Club::all();
		$ares = new AresAPI();
		foreach ($clubs as $club) {
			$subject = array();
			if($club->taxid != null || $club->taxid != '') {
				try {
					$subject = $ares->findByIN($club->taxid);
					$name = explode(", ", $subject['name']);
					$club->clubname = trim($name[0]);
					$club->clubname2 = trim($name[1]);
					$club->vatid = ($subject['tin'] != null) ? $subject['tin'] : null;
					$club->city = $subject['city'];
					$club->street = $subject['street'];
					$club->postalcode = $subject['zip'];
				} catch (\Exception $e){
					$subject = null;
				}
			} else {
				try {
					$subject = $ares->findByName($club->clubname);
					$club->taxid = $subject['in'];
				} catch (\Exception $e){
					$subject = null;
				}
			}
			if ($subject != null) {
				$club->save();
			}
		}
		return response()->json(['message' => 'Successfull ARES update', 'status' => 'success', 'done']);
	}
}
