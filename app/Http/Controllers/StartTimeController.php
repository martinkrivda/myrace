<?php

namespace App\Http\Controllers;

use App\Category;
use App\DataTables\StartTimeDataTable;
use App\RaceEdition;
use App\Registration;
use App\StartTime;
use App\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

class StartTimeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		//$this->authorizeResource(StartTime::class, 'starttime');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(StartTimeDataTable $dataTable, $edition_ID) {
		$this->authorize('starttime.view', StartTime::class);
		$categories = Category::where('edition_ID', $edition_ID)->orderBy('categoryname')->pluck('categoryname', 'category_ID');
		$totalRegistrationSum = StartTime::where('edition_ID', $edition_ID)->count();
		//$totalPrice = StartTime::where('edition_ID', $edition_ID)->sum('totalprice');
		return $dataTable->forRaceEdition($edition_ID)->render('races.startlist', ['edition_ID' => $edition_ID, 'totalRegistrationSum' => $totalRegistrationSum, 'categories' => $categories]);
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
	public function store(Request $request, $edition_ID) {

		$rules = array(
			'start_nr' => 'numeric|required|max:99999|min:1',
			'stime' => 'required|date_format:"Y-m-d H:i:s"',
			'category_ID' => 'numeric|exists:category,category_ID',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		} else {
			$existingNr = StartTime::where('edition_ID', $edition_ID)->where('start_nr', $request->start_nr)->first();
			if ($existingNr != null) {
				return response()->json('Start number already exist in the database.', 422);
			}
			try {
				$startTime = new StartTime;
				$startTime->edition_ID = $edition_ID;
				$startTime->category_ID = $request->category_ID;
				$startTime->start_nr = $request->start_nr;
				$startTime->stime = date('Y-m-d H:i:s', strtotime($request->stime));
				$startTime->save();
				Log::info('New start time was added to DB.', ['start_nr' => $startTime->start_nr, 'stime' => $startTime->stime, 'category_ID' => $startTime->category_ID]);
			} catch (\Exception $e) {
				$startTime = $e->getMessage();
				alert()->error('Error!', $e->getMessage());
				Log::error('New start time could not be added to DB.', ['start_nr' => $startTime->start_nr, 'stime' => $startTime->stime, 'category_ID' => $startTime->category_ID]);
			}
			return response()->json($startTime);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\StartTime  $startTime
	 * @return \Illuminate\Http\Response
	 */
	public function show(StartTime $startTime) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\StartTime  $startTime
	 * @return \Illuminate\Http\Response
	 */
	public function edit(StartTime $startTime) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\StartTime  $startTime
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, StartTime $startTime) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\StartTime  $startTime
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(StartTime $startTime) {
		//
	}

	/**
	 * Generate a start times.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function generateStartTime(Request $request, $edition_ID) {
		$this->authorize('starttime.generate', StartTime::class);
		$race = RaceEdition::where('edition_ID', $edition_ID)->first();
		$categories = Category::where('edition_ID', $edition_ID)->where('lock', false)->get();

		$start_nr = 1;
		$updates = 0;

		foreach ($categories as $key => $category) {
			$registrations = Registration::where('edition_ID', $edition_ID)->where('category_ID', $category->category_ID)->count();
			if ($category->starttime != null) {
				$startTime = $category->starttime;
			} else {
				$startTime = date('Y-m-d H:i:s', strtotime("$race->date $race->firststart"));
			}
			$interval = $category->sinterval;

			foreach ($request->request as $key => $value) {
				if ($key == $category->category_ID && $value != 0) {
					$registrations = $registrations + $value;
					break;
				}
			}

			for ($i = 0; $i < $registrations; $i++) {
				$time = new StartTime;
				$time->edition_ID = $edition_ID;
				$time->category_ID = $category->category_ID;
				$time->start_nr = $start_nr;
				$time->stime = date('Y-m-d H:i:s', strtotime($startTime));
				$time->save();
				$startTime = date('Y-m-d H:i:s', strtotime($startTime) + $interval);
				$start_nr++;
				$updates++;
			}
			$category->lock = true;
			$category->save();

		}

		return response()->json(['updates' => $updates]);
	}

	/**
	 * Assign a tags to start times.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function assignTags($edition_ID) {
		$this->authorize('starttime.generate', StartTime::class);
		$assignedTags = StartTime::where('edition_ID', $edition_ID)->whereNotNull('tag_ID')->select('tag_ID')->get();
		$usedTags = array();
		foreach ($assignedTags as $key => $assignedTag) {
			$usedTags[] = $assignedTag->tag_ID;
		}
		$tags = Tag::where('tag.active', true)->whereNotIn('tag_ID', $usedTags)->get();
		$startTimes = StartTime::where('edition_ID', $edition_ID)->where('tag_ID', null)->get();
		$i = 0;
		if (count($startTimes) > 0) {
			foreach ($tags as $key => $tag) {
				$startTime = $startTimes[$i];
				$startTime->tag_ID = $tag->tag_ID;
				$startTime->save();
				$i++;
			}
		} else {
			$i = "Start time doesn't exist yet!";
		}

		if ($i < count($startTimes)) {
			$i = 'Unsatisfactory number of free tags!';
		}

		return response()->json(['updates' => $i]);
	}

	/**
	 * Assign a tags to start times.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function drawStartList($edition_ID) {
		$this->authorize('starttime.generate', StartTime::class);
		$categories = Category::where('edition_ID', $edition_ID)->get();
		$updates = 0;

		foreach ($categories as $key => $category) {
			$regsWithStartTime = Registration::where('edition_ID', $edition_ID)->whereNotNull('stime_ID')->get();
			$drawExcept = array();
			foreach ($regsWithStartTime as $key => $regWithStartTime) {
				$drawExcept[] = $regWithStartTime->stime_ID;
			}
			$startTimes = StartTime::where('edition_ID', $edition_ID)->whereNotNull('tag_ID')->where('category_ID', $category->category_ID)->whereNotIn('stime_ID', $drawExcept)->get();
			$startTimes = $startTimes->shuffle();
			$startTimes->all();
			$registrations = Registration::where('edition_ID', $edition_ID)->where('category_ID', $category->category_ID)->where('stime_ID', null)->get();
			for ($i = 0; $i < count($startTimes); $i++) {
				$registration = $registrations[$i];
				$startTime = $startTimes[$i];
				$registration->stime_ID = $startTime->stime_ID;
				$registration->save();
				$updates++;
			}
		}

		return response()->json(['updates' => $updates]);
	}
}
