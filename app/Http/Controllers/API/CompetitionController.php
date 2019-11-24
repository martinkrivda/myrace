<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Course;
use App\Http\Controllers\API\BaseController as BaseController;
use App\RaceEdition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompetitionController extends BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		try {
			$competition = RaceEdition::leftJoin('race', 'race.race_ID', '=', 'raceedition.race_ID')->leftJoin('organiser', 'organiser.organiser_ID', '=', 'race.organiser_ID')->where('cancelled', 0)->select('edition_ID', 'editionname', 'date', 'firststart', 'raceedition.location', 'gps', 'orgname')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading competition from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		$competition->transform(function ($item) {
			return [
				'id' => $item->edition_ID,
				'name' => $item->editionname,
				'date' => $item->date,
				'firststart' => $item->firststart,
				'location' => $item->location,
				'gps' => $item->gps,
				'organiser' => $item->orgname,
			];
		});
		return $this->sendResponse($competition->toArray(), 'Comepetitions retrieved successfully.');

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
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		try {
			$competition = RaceEdition::leftJoin('race', 'race.race_ID', '=', 'raceedition.race_ID')->leftJoin('organiser', 'organiser.organiser_ID', '=', 'race.organiser_ID')->where('edition_ID', $id)->where('cancelled', 0)->select('edition_ID', 'editionname', 'date', 'firststart', 'raceedition.location', 'gps', 'orgname', 'edition_nr')->first();
		} catch (\Exception $e) {
			Log::error('Problem with reading competition from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		$competition = collect([$competition]);
		$competition->transform(function ($item) {
			return [
				'id' => $item->edition_ID,
				'name' => $item->editionname,
				'editionNr' => $item->edition_nr,
				'date' => $item->date,
				'firstStart' => $item->firststart,
				'location' => $item->location,
				'gps' => $item->gps,
				'organiser' => $item->orgname,
			];
		});

		try {
			$course = Course::where('edition_ID', $id)->select('course_ID', 'coursename', 'surface', 'length', 'climb', 'description')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading course from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		$course->transform(function ($item) {
			return [
				'id' => $item->course_ID,
				'name' => $item->coursename,
				'surface' => $item->surface,
				'length' => $item->length,
				'climb' => $item->climb,
				'description' => $item->description,
			];
		});
		try {
			$category = Category::where('edition_ID', $id)->select('category_ID', 'course_ID', 'categoryname', 'gender', 'starttime', 'sinterval', 'timelimit', 'capacity')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading category from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		$category->transform(function ($item) {
			return [
				'id' => $item->category_ID,
				'name' => $item->categoryname,
				'gender' => $item->gender,
				'courseId' => $item->course_ID,
				'startTime' => $item->starttime,
				'sInterval' => $item->sinterval,
				'timeLimit' => $item->timelimit,
				'capacity' => $item->capacity,
			];
		});
		$competition = $competition->map(function ($item, $key) use ($course, $category) {
			$item['courses'] = $course;
			$item['classes'] = $category;
			return $item;
		});

		return $this->sendResponse($competition->toArray(), 'Comepetitions retrieved successfully.');
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
