<?php

namespace App\Http\Controllers;

use App\Category;
use App\DataTables\StartTimeDataTable;
use App\RaceEdition;
use App\Registration;
use App\StartTime;
use App\Tag;
use Illuminate\Http\Request;

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
		$totalRegistrationSum = StartTime::where('edition_ID', $edition_ID)->count();
		//$totalPrice = StartTime::where('edition_ID', $edition_ID)->sum('totalprice');
		return $dataTable->forRaceEdition($edition_ID)->render('races.startlist', ['edition_ID' => $edition_ID, 'totalRegistrationSum' => $totalRegistrationSum]);
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
		//
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
			$startTimes = StartTime::where('edition_ID', $edition_ID)->whereNotNull('tag_ID')->where('category_ID', $category->category_ID)->get();
			$startTimes = $startTimes->shuffle();
			$startTimes->all();
			$registrations = Registration::where('edition_ID', $edition_ID)->where('category_ID', $category->category_ID)->get();
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
