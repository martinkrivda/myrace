<?php

namespace App\Http\Controllers;
use App\RaceEdition;
use App\Registration;
use App\StartTime;
use App\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

class AssignTagController extends Controller {
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
		return view('races.assigntag', ['edition_ID' => $edition_ID]);
	}

	/**
	 * Return runnre with specific bib number.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchRunner($edition_ID, Request $request) {
		$rules = array(
			'edition_ID' => 'numeric|exists:raceedition,edition_ID',
			'bibNumber' => 'numeric|required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()], 422);
		}
		$runner = Registration::leftjoin('category', 'registration.category_ID', '=', 'category.category_ID')->leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')->where('registration.edition_ID', $edition_ID)->where('registration.bib_nr', $request->bibNumber)->select('registration_ID', 'firstname', 'lastname', 'registration.bib_nr', 'categoryname', 'registration.stime_ID', 'stime')->first();
		if (!$runner) {
			return response()->json(['bibNumber' => 'No runner with this bib number!'], 422);
		}

		return response()->json($runner);
	}
	/**
	 * Update runner with rfid tag.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateRunner($edition_ID, Request $request) {
		$rules = array(
			'epc' => 'required|string',
			'edition_ID' => 'numeric|exists:raceedition,edition_ID',
			'registrationId' => 'numeric|exists:registration,registration_ID',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()], 422);
		}
		try {
			$tagInUse = Registration::leftJoin('tag', 'registration.tag_ID', '=', 'tag.tag_ID')->leftJoin('starttime', 'starttime.stime_ID', '=', 'registration.stime_ID')->where('registration.edition_ID', $edition_ID)->where('tag.EPC', $request->epc)->select('registration_ID', 'registration.stime_ID', 'tag', 'registration.tag_ID', 'timems', 'tag.EPC', 'starttime.stime', 'is_running')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading from tag table.', ['tag' => $request->epc, 'error' => $e->getMessage()]);
			return response()->json(['error' => 'Problem with database'], 503);
		}
		if ($tagInUse) {
			foreach ($tagInUse as $key => $sameTag) {
				if ($sameTag->timems == null || $sameTag->stime > time() || $sameTag->is_running === false) {
					Log::warning('This tag cannot be assigned to another runner!', ['Registration ID' => $request->registrationId, 'tag' => $request->epc]);
					return response()->json(['message' => 'This tag cannot be assigned to another runner!'], 422);
				}
			}
		}
		try {
			$registration = Registration::find($request->registrationId);
			$tag = Tag::where('EPC', $request->epc)->first();
			$registration->tag = $tag->EPC;
			$registration->tag_ID = $tag->tag_ID;
			$registration->is_running = true;
			$registration->checktimems = time();
			$registration->save();
			Log::info('Rfid tag assigned to runner.', ['Registration ID' => $registration->registration_ID, 'tag' => $tag->EPC, 'tagId' => $tag->tag_ID]);
		} catch (\Exception $e) {
			Log::error('Can not assign tag to runner.', ['Registration ID' => $request->registrationId, 'tag' => $request->epc, 'error' => $e->getMessage()]);
		}
		if (!$registration) {
			return response()->json(['message' => 'No runner with this ID!'], 422);
		}

		return response()->json(['message' => 'Tag assigned successfully', 'tagId' => $tag->tag_ID]);
	}

	/**
	 * Set start time.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function setStartTime($edition_ID, Request $request) {
		$rules = array(
			'time' => 'required|date_format:H:i:s',
			'edition_ID' => 'numeric|exists:raceedition,edition_ID',
			'registrationId' => 'numeric|exists:registration,registration_ID',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()], 422);
		}

		try {
			$registration = Registration::find($request->registrationId);
		} catch (\Exception $e) {
			Log::error('Problem with reading the registration.', ['registration' => $request->registrationId, 'error' => $e->getMessage()]);
			return response()->json(['error' => 'Problem with database'], 503);
		}
		if (!$registration) {
			return response()->json(['message' => 'No runner with this ID!'], 422);
		}
		$event = RaceEdition::where('edition_ID', $edition_ID)->first();

		if ($registration->stime_ID == null) {
			try {
				$startTime = new StartTime;
				$startTime->edition_ID = $edition_ID;
				$startTime->category_ID = $registration->category_ID;
				$startTime->bib_nr = $registration->bib_nr;
				$startTime->stime = date('Y-m-d H:i:s', strtotime($event->date . $request->time));
				$startTime->save();
				$registration->stime_ID = $startTime->stime_ID;
				$registration->starttimems = strtotime($startTime->stime) - strtotime($event->date . $event->firststart);
				$registration->save();

			} catch (\Exception $e) {
				Log::error('Problem with writing startime to the registration.', ['registration' => $request->time, 'error' => $e->getMessage()]);
				return response()->json(['error' => 'Problem with database'], 503);
			}

		}
		return response()->json(['message' => 'Start time set successfully', 'time' => $startTime->stime]);
	}
}
