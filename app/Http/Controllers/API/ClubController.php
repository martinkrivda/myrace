<?php

namespace App\Http\Controllers\API;

use App\Club;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class ClubController extends BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$this->authorize('clubs.view', Club::class);
		$clubs = Club::all();
		return $this->sendResponse($clubs->toArray(), 'Clubs retrieved successfully.');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$i = 0;
		$data = (object) $request->json()->all();
		Log::debug($request);
		$allClubs = Club::all();
		if (empty($data->clubs)) {
			return $this->sendError('Club data was not found in request.', 'Clubs need to be an object.');
		}
		foreach ($data->clubs as $key => $clubRequest) {
			# code...
			$validator = Validator::make($clubRequest, [
				'id' => 'required|numeric',
				'clubname' => 'required|string|max:70',
				'country' => 'required|string|exists:country,country_code|max:2',
				'source' => 'required|string|max:15',
				'clubname2' => 'nullable|string|max:50',
				'clubabbr' => 'nullable|string|min:3|max:10|unique:club',
				'street' => 'string|max:30|nullable',
				'city' => 'string|max:30|nullable',
				'zip' => 'regex:/^\d{5}$/|nullable|max:13',
				'email' => 'email|nullable|max:100',
				'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
				'taxid' => 'regex:/^\d{8}$/|nullable|max:8',
				'vatid' => ['regex:/^(CZ|SK)\d{8}$/', 'nullable', 'max:10'],
				'web' => 'url|nullable|max:50',
				'deleted' => 'boolean|nullable',

			]);

			if ($validator->fails()) {
				return $this->sendError('Validation Error.', $validator->errors());
			}
			$clubRequest = (object) $clubRequest;
			try {
				$existing = $allClubs->where('importid', '=', $clubRequest->id)->where('source', '=', $clubRequest->source)->first();
				if (is_null($existing)) {
					$club = new Club;
					$existing = Club::where('clubname', 'like', $clubRequest->clubname)->first();
					if (!is_null($existing)) {
						LOG::warn('Duplicita: ' . $clubRequest->clubname);
						#TODO:
						//check duplicity
					}
				} else {
					$club = $existing;
				}

				$club->clubname = $clubRequest->clubname;
				$club->clubname2 = isset($clubRequest->clubname2) ? trim($clubRequest->clubname2) : $club->clubname2;
				if (!isset($club->clubabbr)) {
					$club->clubabbr = isset($clubRequest->clubabbr) ? trim($clubRequest->clubabbr) : substr(str_replace(' ', '', strtoupper(iconv("utf-8", "us-ascii//TRANSLIT", trim($clubRequest->clubname)))), 0, 10);
				}
				$club->taxid = isset($clubRequest->taxid) ? $clubRequest->taxid : $club->taxid;
				$club->vatid = isset($clubRequest->vatid) ? $clubRequest->vatid : $club->vatid;
				$club->street = isset($clubRequest->street) ? $clubRequest->street : $club->street;
				$club->city = isset($clubRequest->city) ? $clubRequest->city : $club->city;
				$club->postalcode = isset($clubRequest->zip) ? $clubRequest->zip : $club->postalcode;
				$club->country = isset($clubRequest->country) ? trim($clubRequest->country) : 'CZ';
				$club->web = isset($clubRequest->web) ? $clubRequest->web : $club->web;
				$club->email = isset($clubRequest->email) ? $clubRequest->email : $club->email;
				$club->phone = isset($clubRequest->phone) ? $clubRequest->phone : $club->phone;
				$club->source = isset($clubRequest->source) ? $clubRequest->source : $club->source;
				$club->importid = isset($clubRequest->id) ? $clubRequest->id : $club->importid;
				$club->save();
				LOG::debug('Club ' . $clubRequest->clubname . ' imported successfully');
				$i++;
			} catch (\Exception $e) {
				return $this->sendError('Database Error.', $e->getMessage());
			}
		}
		LOG::info('Clubs (' . $i . ') imported successfully.');
		return $this->sendResponse($data->clubs, 'Clubs (' . $i . ') imported successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$this->authorize('clubs.view', Club::class);
		$club = Club::find($id);
		if (is_null($club)) {
			return $this->sendError('Club not found.');
		}
		return $this->sendResponse($club->toArray(), 'Club retrieved successfully.');
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
