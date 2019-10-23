<?php

namespace App\Http\Controllers;

use App\Category;
use App\Mail\RunnerFinished;
use App\Notification;
use App\RaceEdition;
use App\Registration;
use App\RfidReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Jobs\ResultCalculation;
use App\Helpers;

class ResultListController extends Controller {

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
		$this->authorize('results.view', Registration::class);
		$race = RaceEdition::where('edition_ID', $edition_ID)->select('date AS eventdate', 'firststart')->first();
		$categories = Category::leftJoin('course', 'category.course_ID', '=', 'course.course_ID')
		->where('category.edition_ID', $edition_ID)
		->select('category.*', 'course.length', 'course.climb')
		->get();
		$runners = Registration::leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')->leftJoin('runner', 'registration.runner_ID', '=', 'runner.runner_ID')->leftJoin('club', 'registration.club_ID', '=', 'club.club_ID')->leftJoin('tag', 'starttime.tag_ID', '=', 'tag.tag_ID')->where('registration.edition_ID', $edition_ID)->whereNotNull('registration.stime_ID')->select('registration.*', 'starttime.*', 'tag.*', 'club.clubname', 'club.club_ID', 'runner.email')->get();
		if (Helpers::settings('resultsByService') === 'No'){
			$reader = RfidReader::where('edition_ID', $edition_ID)->where('gateway', 'F')->get();
			foreach ($runners as $key => $runner) {
				if ($runner->DNS == false) {
					$tag = $runner->EPC;
					$records = array();
					foreach ($reader as $key => $read) {
						if ($tag === $read->EPC) {
							$records[] = $read;
						}
					}

					$sort = usort($records, function ($a, $b) {return $a->time > $b->time;});
					foreach ($records as $key => $record) {
						if ($record->time >= $runner->stime) {
							$runner->timems = strtotime($record->time) - strtotime($runner->stime);
							// Save time to DB
							$runner->save();
								if ($runner->status < 8) {
									if ($runner->email != '') {
										$notification = new Notification;
										$notification->registration_ID = $runner->registration_ID;
										$notification->type = 'finish';
										$notification->kind = 'E';
										$notification->text = 'Runner: ' . $runner->lastname . ' ' . $runner->firstname . ' in finish ' . date('H:i:s', $runner->timems) . '.';
										$notification->email = $runner->email;
										$notification->save();

										Mail::to($runner->email)->send(new RunnerFinished($runner));
									}
									$runner->status = 8;
									$runner->save();
								}
							break;
						}
					}
				}
			}
		} else {
				ResultCalculation::dispatch();
			}

		foreach ($categories as $category) {
			$results = array();
			if ($category->starttime == null || strtotime($category->starttime) >= time()) {
				continue;
			}
			$filtered = $runners->filter(function ($value, $key) use ($category) {
				return $value->category_ID === $category->category_ID;
			});

			$sorted = $filtered->sortBy('timems');
			foreach ($sorted as $key => $runner) {
				if ($runner->timems != null && $runner->NC == false && $runner->DSQ == false && $runner->DNS == false && $runner->DNF == false) {
					$runner->status = 'OK';
					$results[] = $runner;
					$sorted->forget($key);
				}
			}
			foreach ($sorted as $key => $runner) {
				if ($runner->timems == null && $runner->NC == false && $runner->DSQ == false && $runner->DNS == false && $runner->DNF == false) {
					$runner->status = 'RUNNING';
					$results[] = $runner;
					$sorted->forget($key);
				}
			}
			foreach ($sorted as $key => $runner) {
				if ($runner->NC == false && $runner->DSQ == false && $runner->DNS == false && $runner->DNF == true) {
					$runner->status = 'DNF';
					$results[] = $runner;
					$sorted->forget($key);
				}
			}
			foreach ($sorted as $key => $runner) {
				if ($runner->NC == true && $runner->DSQ == false && $runner->DNS == false && $runner->DNF == false) {
					$runner->status = 'NC';
					$results[] = $runner;
					$sorted->forget($key);
				}
			}
			foreach ($sorted as $key => $runner) {
				if ($runner->DSQ == true && $runner->DNS == false && $runner->DNF == false) {
					$runner->status = 'DSQ';
					$results[] = $runner;
					$sorted->forget($key);
				}
			}
			foreach ($sorted as $key => $runner) {
				if ($runner->DSQ == false && $runner->DNS == true && $runner->DNF == false) {
					$runner->status = 'DNS';
					$results[] = $runner;
					$sorted->forget($key);
				}
			}

			$category->results = $results;
		}
		return view('races.results', ['edition_ID' => $edition_ID])->with('categories', $categories);
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
	 * @param  \App\Registration  $registration
	 * @return \Illuminate\Http\Response
	 */
	public function show(Registration $registration) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Registration  $registration
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Registration $registration) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Registration  $registration
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Registration $registration) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Registration  $registration
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Registration $registration) {
		//
	}
}
