<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\API\BaseController as BaseController;
use App\RaceEdition;
use App\Registration;
use Exception;
use Illuminate\Support\Facades\Log;

class CompetitionInfoController extends BaseController {
	/**
	 * Display a list of the entries.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchEntry($edition_ID) {
		try {
			$entry = Registration::leftJoin('club', 'registration.club_ID', '=', 'club.club_ID')->where('edition_ID', $edition_ID)->select('registration_ID', 'runner_ID', 'registration.club_ID', 'category_ID', 'tag', 'bib_nr', 'firstname', 'lastname', 'yearofbirth', 'clubname', 'clubabbr', 'gender', 'checktimems', 'starttimems', 'finishtimems', 'timems', 'is_running', 'NC', 'DNS', 'DNF', 'DSQ', 'note')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading entries from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		$entry->transform(function ($item) {
			return [
				'id' => $item->registration_ID,
				'runnerId' => $item->runner_ID,
				'firstName' => $item->firstname,
				'lastName' => $item->lastname,
				'yearOfBirth' => $item->yearofbirth,
				'clubId' => $item->club_ID,
				'club' => $item->clubname,
				'clubAbbr' => $item->clubabbr,
				'bibNr' => $item->bib_nr,
				'tag' => $item->tag,
				'gender' => $item->gender,
				'categoryId' => $item->category_ID,
				'isRunning' => $item->is_running,
				'notCompeting' => $item->NC,
				'DNS' => $item->DNS,
				'DNF' => $item->DNF,
				'DSQ' => $item->DSQ,
				'note' => $item->note,
				'checkTimeMs' => $item->checktimems,
				'startTimeMs' => $item->starttimems,
				'finishTimeMs' => $item->finishtimems,
				'timeMs' => $item->timems,
			];
		});
		return $this->sendResponse($entry->toArray(), 'Entries retrieved successfully.');

	}

	/**
	 * Display a list of the entries.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fullState($edition_ID) {
		try {
			$race = RaceEdition::find($edition_ID);
		} catch (\Exception $e) {
			Log::error('Can not find race in the database.', ['error' => $e->getMessage()]);
		}

		try {
			$classes = Category::where('edition_ID', $edition_ID)->select('category_ID', 'starttime')->get();
		} catch (\Exception $e) {
			Log::error('Can not find any category for the event in the database.', ['error' => $e->getMessage()]);
		}

		try {
			$startList = Registration::leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')->where('registration.edition_ID', $edition_ID)->select('registration_ID', 'registration.category_ID', 'stime', 'registration.bib_nr')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading start times from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}

		$startList->map(function ($item, $key) use ($race, $classes) {
			if ($item->stime === null) {
				$filtered = $classes->where('category_ID', $item->category_ID);
				if (isset($filtered[0]) && $filtered[0]->starttime != null) {
					$item->stime = $filtered[0]->starttime;
				} else {
					$item->stime = date('Y-m-d H:i:s', strtotime("$race->date $race->firststart"));
				}
			}
			$item['timeMs'] = strtotime($item->stime) - strtotime("$race->date $race->firststart");
		});
		$startList->transform(function ($item) {
			return [
				'entryId' => $item->registration_ID,
				'time' => $item->stime,
				'timeS' => $item->timeMs,
			];
		});

		try {
			$split = Registration::leftJoin('split', 'registration.registration_ID', '=', 'split.registration_ID')->where('edition_ID', $edition_ID)->whereNotNull('split_ID')->select('registration.registration_ID', 'gateway', 'splittimems', 'split_ID')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading split times from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}

		$groupedSplit = $split->groupBy(function ($item, $key) {
			return [$item->gateway];
		});

		$groupedSplit->map(function ($item, $key) {
			$item->transform(function ($item) {
				return [
					'id' => $item->split_ID,
					'entryId' => $item->registration_ID,
					'gateway' => $item->gateway,
					'timeS' => $item->splittimems,
				];
			});
		});

		try {
			$result = Registration::where('edition_ID', $edition_ID)->whereNotNull('timems')->orWhere('DNF', true)->select('registration_ID', 'timems', 'finishtimems', 'NC', 'DNS', 'DNF', 'DSQ')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading finish times from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}

		$result->transform(function ($item) {
			return [
				'entryId' => $item->registration_ID,
				'timeMs' => $item->timems,
				'finishTimeS' => $item->finishtimems,
				'notCompeting' => $item->NC,
				'DNS' => $item->DNS,
				'DNF' => $item->DNF,
				'DSQ' => $item->DSQ,
			];
		});

		$fullState = collect(['startList' => $startList, 'split' => $groupedSplit, 'result' => $result]);

		return $this->sendResponse($fullState->toArray(), 'Full state retrieved successfully.');

	}

	/**
	 * Display a start list.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchStartList($edition_ID) {
		try {
			$race = RaceEdition::find($edition_ID);
		} catch (\Exception $e) {
			Log::error('Can not find race in the database.', ['error' => $e->getMessage()]);
		}
		try {
			$classes = Category::where('edition_ID', $edition_ID)->select('category_ID', 'starttime')->get();
		} catch (\Exception $e) {
			Log::error('Can not find any category for the event in the database.', ['error' => $e->getMessage()]);
		}
		try {
			$startList = Registration::leftJoin('club', 'registration.club_ID', '=', 'club.club_ID')->leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')->where('registration.edition_ID', $edition_ID)->select('registration_ID', 'runner_ID', 'registration.club_ID', 'registration.category_ID', 'starttime.bib_nr', 'firstname', 'lastname', 'yearofbirth', 'clubname', 'clubabbr', 'gender', 'stime', 'NC', 'note')->get();
		} catch (\Exception $e) {
			Log::error('Problem with reading start list from databases.', ['error' => $e->getMessage()]);
			return $this->sendError('Problem with database.', $e->getMessage());
		}
		$startList->map(function ($item, $key) use ($race, $classes) {
			if ($item->stime === null) {
				$filtered = $classes->where('category_ID', $item->category_ID);
				if (isset($filtered[0]) && $filtered[0]->starttime != null) {
					$item->stime = $filtered[0]->starttime;
				} else {
					$item->stime = date('Y-m-d H:i:s', strtotime("$race->date $race->firststart"));
				}
			}
			$item['timeMs'] = strtotime($item->stime) - strtotime("$race->date $race->firststart");
		});
		$startList->transform(function ($item) {
			return [
				'id' => $item->registration_ID,
				'runnerId' => $item->runner_ID,
				'firstName' => $item->firstname,
				'lastName' => $item->lastname,
				'yearOfBirth' => $item->yearofbirth,
				'clubId' => $item->club_ID,
				'club' => $item->clubname,
				'clubAbbr' => $item->clubabbr,
				'bibNr' => $item->bib_nr,
				'gender' => $item->gender,
				'categoryId' => $item->category_ID,
				'notCompeting' => $item->NC,
				'time' => $item->stime,
				'timeS' => $item->timeMs,
				'note' => $item->note,
			];
		});
		return $this->sendResponse($startList->toArray(), 'Start list retrieved successfully.');

	}
}
