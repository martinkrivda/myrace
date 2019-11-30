<?php

namespace App\Http\Controllers;

use App\Category;
use App\Club;
use App\Registration;
use App\RegistrationSum;
use App\Runner;
use App\Payment;
use App\StartTime;
use App\RaceEdition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class McvvFetchDataController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Return runnre with specific bib number.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchClub($edition_ID) {
		$i = 0;
		$endpoint = "https://www.mcvv.org/data/api.php?f=oddily";
		$client = new \GuzzleHttp\Client();

		$response = $client->request('GET', $endpoint);

		$statusCode = $response->getStatusCode();
		$content = (object) json_decode($response->getBody(), true);
		if (empty($content->records)) {
			return response()->json(['Club data was not found in request.', 'Clubs need to be an object.']);
		}

		$allClubs = Club::all();
		//var_dump($content->records);

		foreach ($content->records as $key => $clubRequest) {
			try {
				$existing = $allClubs->where('importid', '=', $clubRequest['id'])->where('source', '=', 'mcvv')->first();
				if (is_null($existing)) {
					$club = new Club;
					$existing = Club::where('clubname', 'like', $clubRequest['jmeno'])->first();
					if (!is_null($existing)) {
						LOG::warn('Duplicita: ' . $clubRequest['jmeno']);
						#TODO:
						//check duplicity
					}
				} else {
					$club = $existing;
				}

				$club->clubname = $clubRequest['jmeno'];
				$club->clubname2 = isset($clubRequest['jmeno2']) ? trim($clubRequest['jmeno2']) : $club->clubname2;
				if (!isset($club->clubabbr)) {
					$s = strlen($clubRequest['jmeno']) . rand(0, 9);
					$club->clubabbr = preg_match('/\D/', $clubRequest['id']) ? trim($clubRequest['id']) : substr(str_replace(' ', '', strtoupper(iconv("utf-8", "us-ascii//TRANSLIT", trim($clubRequest['jmeno'])))), 0, 7) . $s;
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
				$club->source = isset($clubRequest->source) ? $clubRequest->source : 'mcvv';
				$club->importid = isset($clubRequest['id']) ? $clubRequest['id'] : $club->importid;
				$club->save();
				LOG::debug('Club ' . $clubRequest['jmeno'] . ' imported successfully');
				$i++;
			} catch (\Exception $e) {
				return response()->json(['Database Error.', $e->getMessage()]);
			}
		}

		return response()->json($content);
	}

	/**
	 * Return runnre with specific bib number.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchRunner($edition_ID) {
		$i = 0;
		$endpoint = "https://www.mcvv.org/data/api.php?f=bezci";
		$client = new \GuzzleHttp\Client();

		$response = $client->request('GET', $endpoint);

		$statusCode = $response->getStatusCode();
		$content = (object) json_decode($response->getBody(), true);
		if (empty($content->records)) {
			return response()->json(['Runner data was not found in request.', 'Runners need to be an object.']);
		}

		$allRunners = Runner::all();
		//var_dump($content->records);

		foreach ($content->records as $key => $runnerRequest) {
			try {
				$existing = $allRunners->where('importid', '=', $runnerRequest['id'])->where('source', '=', 'mcvv')->first();
				if (is_null($existing)) {
					$name = explode(' ', $runnerRequest['jmeno']);
					if (count($name) < 2) {
						continue;
					}
					$runner = new Runner;
					$existing = Runner::where('lastname', 'like', $name[0])->where('firstname', 'like', $name[1])->where('yearofbirth', '=', substr($runnerRequest['id'], 0, 4))->first();
					if (!is_null($existing)) {
						LOG::warn('Duplicita: ' . $runnerRequest['jmeno']);
						#TODO:
						//check duplicity
					}
				} else {
					continue;
					$runner = $existing;
				}
				$name = explode(' ', $runnerRequest['jmeno']);

				$runner->lastname = $name[0];
				$runner->firstname = $name[1];
				$runner->yearOfBirth = substr($runnerRequest['id'], 0, 4);
				$runner->gender = ((int) substr($runnerRequest['id'], -4) < 5000) ? 'male' : 'female';
				$runner->country = isset($runnerRequest['country']) ? trim($runnerRequest['country']) : 'CZ';
				$runner->source = isset($runnerRequest['source']) ? $runnerRequest['source'] : 'mcvv';
				$runner->importid = isset($runnerRequest['id']) ? $runnerRequest['id'] : $runner->importid;
				$runner->save();
				LOG::debug('Runner ' . $runnerRequest['jmeno'] . ' imported successfully');
				$i++;
			} catch (\Exception $e) {
				return response()->json(['Database Error.', $e->getMessage()]);
			}
		}

		return response()->json($content);
	}

	/**
	 * Return runnre with specific bib number.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchEntry($edition_ID) {
		$i = 0;
		$endpoint = "https://www.mcvv.org/data/api.php?f=prihlasky";
		$client = new \GuzzleHttp\Client();

		$response = $client->request('GET', $endpoint);

		$statusCode = $response->getStatusCode();
		$content = (object) json_decode($response->getBody(), true);
		if (empty($content->records)) {
			return response()->json(['Entry data was not found in request.', 'Entries need to be an object.']);
		}

		$allSummary = RegistrationSum::where('edition_ID', $edition_ID)->get();
		$allEntries = Registration::where('edition_ID', $edition_ID)->get();
		$classes = Category::where('edition_ID', $edition_ID)->get();
		$runners = Runner::where('deleted', false)->get();
		$clubs = CLub::where('deleted', false)->get();

		foreach ($content->records as $key => $entryRequest) {
			try {
				$existing = $allSummary->where('payref', '=', $entryRequest['id'])->first();
				if (is_null($existing)) {
					$summary = new RegistrationSum;
				} else {
					$summary = $existing;
				}

				$summary->edition_ID = $edition_ID;
				$summary->name = mb_convert_case($entryRequest['nazev'], MB_CASE_UPPER, "UTF-8");
				$summary->email = $entryRequest['email'];
				$summary->creator_ID = 1;
				if (!isset($summary->status)) {
					$summary->status = 0;
				}
				$price = array_sum(array_column($entryRequest['radky'],'startovne'));
				$summary->price = $price;
				$summary->discount = ($summary->discount == null) ? 0.00 : $summary->discount;
				$summary->totalprice = $price - $summary->discount;
				$summary->payref = $entryRequest['id'];
				$summary->save();
				foreach ($entryRequest['radky'] as $subKey => $radek) {
					$existing = $allEntries->where('importid', '=', $radek['bezec_id'])->first();
					if (is_null($existing)) {
						$entry = new Registration;
					} else {
						$entry = $existing;
					}

					$name = explode(' ', $radek['bezec_jmeno']);
					if (count($name) < 2) {
						continue;
					}

					$entry->regsummary_ID = $summary->regsummary_ID;
					$entry->edition_ID = $edition_ID;
					$runner = $runners->where('importid', '=', $radek['bezec_id'])->first();
					$entry->runner_ID = $runner->runner_ID;
					$entry->firstname = $name[1];
					$entry->lastname = $name[0];
					$club = $clubs->where('importid', '=', $radek['klub_id'])->first();
					if($club) $entry->club_ID = $club->club_ID;
					$entry->yearofbirth = $runner->yearofbirth;
					$entry->gender = $runner->gender;
					$entry->entryfee = $radek['startovne'];
					$entry->note = $radek['poznamka'];
					$entry->version = ($entry->version == null) ? 1 : $entry->version + 1;
					$entry->creator_ID = 1;
					$entry->importid = $radek['bezec_id'];
					$entry->bib_nr = $radek['cislo'];
					$entry->payref = $radek['bezec_id'];
					$entry->paid = (isset($entry->paid)) ? $entry->paid : false;
					$entry->NC = (isset($entry->NC)) ? $entry->NC : false;
					$entry->is_running = (isset($entry->is_running)) ? $entry->is_running : false;
					$entry->DNS = (isset($entry->DNS)) ? $entry->DNS : false;
					$entry->DNF = (isset($entry->DNF)) ? $entry->DNF : false;
					$entry->DSQ = (isset($entry->DSQ)) ? $entry->DSQ : false;
					$entry->source = 'mcvv';
					$entry->status = (isset($entry->status)) ? $entry->status : 0;
					$entry->club = $radek['klub_jmeno'];

					$category = $classes->where('importid', '=', $radek['kateg_id'])->first();
					$entry->category_ID = $category->category_ID;

					$entry->save();

				}
				LOG::debug('Entry ' . $entryRequest['nazev'] . ' imported successfully');
				$i++;
			} catch (\Exception $e) {
				return response()->json(['Database Error.', $e->getMessage()]);
			}
		}
		LOG::info('Entries ' . $i . ' imported successfully');
		return response()->json($content);
	}

	/**
	 * Return payment.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchPayment($edition_ID) {
		$i = 0;
		$endpoint = "https://www.mcvv.org/data/api.php?f=platby";
		$client = new \GuzzleHttp\Client();

		$response = $client->request('GET', $endpoint);

		$statusCode = $response->getStatusCode();
		$content = (object) json_decode($response->getBody(), true);
		if (empty($content->records)) {
			return response()->json(['Payment data was not found in request.', 'Payment need to be an object.']);
		}

		$allPayments = Payment::where('ks', $edition_ID)->get();
		//var_dump($content->records);

		foreach ($content->records as $key => $paymentRequest) {
			try {
				$existing = $allPayments->where('transactionId', '=', $paymentRequest['id'])->first();
				if (is_null($existing)) {
					$payment = new Payment;
				} else {
					continue;
				}
				$payment->transactionId = $paymentRequest['id'];
				$payment->currency = 'CZK';
				$payment->ks = $edition_ID;
				$payment->vs = $paymentRequest['prihlaska_id'];
				$payment->date = $paymentRequest['datum'];
				$payment->amount = $paymentRequest['castka'];
				$payment->save();
				LOG::debug('Payments ' . $paymentRequest['id'] . ' imported successfully');
				$i++;
			} catch (\Exception $e) {
				return response()->json(['Database Error.', $e->getMessage()]);
			}
		}
		LOG::info('Payments ' . $i . ' imported successfully');
		return response()->json($content);
	}

	/**
	 * Return payment.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function setPaid($edition_ID) {
		
		$allRegistrations = Registration::leftJoin('registrationsum', 'registration.regsummary_ID', '=', 'registrationsum.regsummary_ID')->where('registration.edition_ID', $edition_ID)->select('registrationsum.payref', 'totalprice', 'paid', 'registration_ID', 'registrationsum.regsummary_ID')->get();
		$allPayments = Payment::all();
		//var_dump($content->records);

		foreach ($allRegistrations as $key => $registration) {
			$paid = $allPayments->where('vs', $registration->payref)->sum('amount');
			$paid = number_format((float) $paid, 2, '.', '');

			if($registration->totalprice <= $paid){
				$registration->paid = true;
				$registration->save();
				$summary = RegistrationSum::find($registration->regsummary_ID);
				$summary->status = 3;
				$summary->save();
			}
		}
		return response()->json($allRegistrations);
	}

	/**
	 * Return startlist.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function fetchStartList($edition_ID) {
		$i = 0;
		$endpoint = "https://www.mcvv.org/data/api.php?f=startovka";
		$client = new \GuzzleHttp\Client();

		$response = $client->request('GET', $endpoint);

		$statusCode = $response->getStatusCode();
		$content = (object) json_decode($response->getBody(), true);
		if (empty($content->records)) {
			return response()->json(['Start list data was not found in request.', 'Start list need to be an object.']);
		}
		$allEntries = Registration::where('edition_ID', $edition_ID)->get();
		$classes = Category::where('edition_ID', $edition_ID)->get();
		$event = RaceEdition::where('edition_ID', $edition_ID)->first();

		foreach ($content->records as $key => $startlist) {
			try {
				$runner = $allEntries->where('importid', '=', $startlist['bezec_id'])->first();
				if (is_null($runner)) {
					continue;
				}

				if ($runner->stime_ID == null) {
					$startTime = new StartTime;
					$startTime->edition_ID = $edition_ID;
					$category = $classes->where('importid', '=', $startlist['kateg_id'])->first();
					$startTime->category_ID = $category->category_ID;
					$startTime->bib_nr = $runner->bib_nr;
					$startTime->stime = date('Y-m-d H:i:s', strtotime($event->date . $startlist['start_cas']));
					$startTime->save();
					$runner->stime_ID = $startTime->stime_ID;
					$runner->starttimems = strtotime($startTime->stime) - strtotime($event->date . $event->firststart);
					$runner->save();
				}
				LOG::debug('Start time ' . $startlist['bezec_id'] . ' imported successfully');
				$i++;
			} catch (\Exception $e) {
				return response()->json(['Database Error.', $e->getMessage()]);
			}
		}
		LOG::info('Start list ' . $i . ' imported successfully');
		return response()->json($content);
	}
}
