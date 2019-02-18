<?php

namespace App\Http\Controllers;

use App\Category;
use App\Country;
use App\DataTables\RegistrationDataTable;
use App\History;
use App\Http\Controllers\Controller;
use App\Mail\RegistrationCreated;
use App\Notification;
use App\RaceEdition;
use App\Registration;
use App\RegistrationSum;
use App\Runner;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use JavaScript;
use Validator;

class RegistrationController extends Controller {
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
	public function index(RegistrationDataTable $dataTable, $edition_ID) {
		try {
			$registration = DB::table('registration')
				->where('edition_ID', $edition_ID)
				->get();
			$totalregistrations = DB::table('registration')->where('edition_ID', $edition_ID)->count();
			$countofclub = DB::table('registration')->distinct('club_ID')->where('edition_ID', $edition_ID)->count('club_ID');
			$totalmenregistered = DB::table('registration')->select(['registration_ID', 'gender'])->where([['edition_ID', '=', $edition_ID], ['gender', '=', 'male']])->count();
			$totalwomenregistered = DB::table('registration')->select(['registration_ID', 'gender'])->where([['edition_ID', '=', $edition_ID], ['gender', '=', 'female']])->count();
			return $dataTable->forRaceEdition($edition_ID)->render('races.registration', ['edition_ID' => $edition_ID, 'totalregistrations' => $totalregistrations, 'countofclub' => $countofclub, 'totalmenregistered' => $totalmenregistered, 'totalwomenregistered' => $totalwomenregistered]);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($edition_ID) {
		// load the create form (app/views/races/category/create.blade.php)
		$categories = Category::where('edition_ID', $edition_ID)->orderBy('categoryname')->pluck('categoryname', 'category_ID');
		$countries = Country::pluck('name', 'country_code');
		$registrationsum = RegistrationSum::all('name', 'regsummary_ID', 'email');
		$user = Auth::user();
		Javascript::put(['userID' => $user->id]);
		return view('races.registration.create', ['edition_ID' => $edition_ID, 'user' => $user, 'categories' => $categories, 'countries' => $countries], compact('registrationsum'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$user = Auth::user();
		// validate
		// read more on validation at http://laravel.com/docs/validation

		$rules = array(
			'firstname' => 'required|string|max:50',
			'lastname' => 'required|string|max:255',
			'yearofbirth' => 'required|numeric|min:1900',
			'gender' => ['required', 'regex:/^(male|female)$/'],
			'club' => 'string|nullable|max:70',
			'entryfee' => 'numeric',
			'start_nr' => 'numeric|nullable',
			'note' => 'string|nullable',
			'paid' => 'boolean',
			'notcompeting' => 'boolean',
			'edition_ID' => 'numeric|exists:raceedition,edition_ID',
			'runner_ID' => 'numeric|exists:runner,runner_ID|nullable',
			'club_ID' => 'numeric|exists:club,club_ID|nullable',
			'category' => 'numeric|exists:category,category_ID',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		} else {
			try {
				// store
				$registration = new Registration;
				if ($request->runner_ID == "-1" || $request->runner_ID == "") {
					$runner = new Runner;
					$runner->firstname = $request->firstname;
					$runner->lastname = $request->lastname;
					$runner->yearofbirth = $request->yearofbirth;
					$runner->gender = $request->gender;
					$runner->email = $request->email;
					$runner->phone = $request->phone;
					$runner->country = $request->country;
					$runner->club_ID = $request->club_ID;
					$runner->save();
				} else {
					$runner = Runner::find($request->runner_ID);
				}

				// find or create registration sum
				if ($request->registrationsum == "-1" || $request->registrationsum == "") {
					$registrationsum = new RegistrationSum;
					$registrationsum->name = mb_convert_case($request->input('lastname'), MB_CASE_UPPER, "UTF-8") . ' ' . mb_convert_case($request->input('firstname'), MB_CASE_UPPER, "UTF-8");
					$registrationsum->email = $request->input('email');
					$registrationsum->price = $request->input('entryfee');
					$registrationsum->discount = '0.00';
					$registrationsum->totalprice = $request->input('entryfee');
					$registrationsum->status = 0;
					$registrationsum->creator_ID = $user->id;
					$registrationsum->edition_ID = $request->edition_ID;
					$registrationsum->payref = $this->generateNewPayRef();
					$registrationsum->save();
				} else {
					$registrationsum = RegistrationSum::find($request->registrationsum);
					$registrationsum->price = $registrationsum->price + $request->entryfee;
					$registrationsum->totalprice = $registrationsum->price - $registrationsum->discount;
					$registrationsum->save();
				}
				$registration->runner_ID = $runner->runner_ID;
				$registration->regsummary_ID = $registrationsum->regsummary_ID;
				$registration->category_ID = $request->input('category');
				if (Input::get('club_ID')) {$registration->club_ID = $request->input('club_ID');}
				$registration->firstname = $request->input('firstname');
				$registration->lastname = $request->input('lastname');
				$registration->yearofbirth = $request->input('yearofbirth');
				$registration->gender = $request->input('gender');
				$registration->entryfee = $request->input('entryfee');
				$registration->start_nr = $request->input('start_nr');
				$registration->NC = $request->notcompeting;
				$registration->note = $request->input('note');
				$registration->payref = $this->generateSpecificSymbol();
				$registration->paid = false;
				$registration->DNS = false;
				$registration->DNF = false;
				$registration->DSQ = false;
				$registration->creator_ID = $user->id;
				$registration->edition_ID = $request->edition_ID;
				$registration->save();

				if ($runner->email != '') {
					$raceedition = RaceEdition::find($request->edition_ID);
					$notification = new Notification;
					$notification->registration_ID = $registration->registration_ID;
					$notification->type = 'registration';
					$notification->kind = 'E';
					$notification->text = 'Registration with runner: ' . $registration->lastname . ' ' . $registration->firstname . ' created for race ' . $raceedition->editionname . '.';
					$notification->email = $runner->email;
					$notification->save();

					Mail::to($runner->email)->send(new RegistrationCreated($registration));
				}

				$history = new History;
				$history->registration_ID = $registration->registration_ID;
				$history->type = 'registration';
				$history->description = 'Registration (' . $registration->registration_ID . ') ' . $registration->lastname . ' ' . $registration->firstname . ' was created successfully';
				$history->creator_ID = $user->id;
				$history->save();
				// redirect
				Log::info('New registration was added to DB.', ['name' => $registration->lastname]);
				alert()->success('Success!', 'Registration ' . $registration->lastname . ' ' . $registration->firstname . ' created successfully.');
				return response()->json($registration);
			} catch (\Exception $e) {
				Log::error('Can not create registration to DB.', ['firstname' => $request->input('firstname'), 'lastname' => $request->input('lastname'), 'message' => $e->getMessage()]);
				return redirect()->back()->alert()->error('Error!', $e->getMessage());
			}
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($edition_ID, $registration_ID) {
		try {
			// get the nerd
			$registration = Registration::query()
				->leftJoin('category', 'registration.category_ID', '=', 'category.category_ID')
				->leftJoin('runner', 'registration.runner_ID', '=', 'runner.runner_ID')
				->leftJoin('club', 'registration.club_ID', '=', 'club.club_ID')
				->leftJoin('country', 'runner.country', '=', 'country.country_code')
				->leftJoin('registrationsum', 'registration.regsummary_ID', '=', 'registrationsum.regsummary_ID')
				->leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')
				->leftJoin('tag', 'starttime.tag_ID', '=', 'tag.tag_ID')
				->leftJoin('users', 'registration.creator_ID', '=', 'users.id')
				->where('registration_ID', $registration_ID)
				->where('registration.edition_ID', $edition_ID)
				->select('category.*', 'club.clubname', 'runner.email', 'runner.phone', 'country.name AS country', 'registrationsum.name AS registrationsum', 'registrationsum.email AS summaryemail', 'users.firstname AS userfirstname', 'users.lastname AS userlastname', 'tag.EPC', 'starttime.stime', 'registration.*')
				->first();

			// show the edit form and pass the nerd
			return view('races.registration.show', ['edition_ID' => $edition_ID])->with('registration', $registration);

		} catch (\Exception $e) {
			return redirect()->back()->alert()->error('Error!', $e->getMessage());
		}
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

	/**
	 * Try to find existing runner in the database by firstname, lastname and year of birth
	 * @param firstName runner's first name
	 * @param lastName runner's last name
	 * @param yearOfBirth runner's year of birth
	 * @return found runner_ID
	 */
	public function getSimilarRunnerWith(Request $request) {
		try {
			$runner = Runner::where('firstname', $request->firstname)->where('lastname', $request->lastname)->where('yearofbirth', $request->yearofbirth)->first();
			if ($runner != null) {
				return $runner;
			}
			return null;
		} catch (\Exception $e) {
			Log::error('Can not find any existing runner from DB.', ['runner' => $request->input('lastname'), 'message' => $e->getMessage()]);
			return redirect()->back()->alert()->error('Error!', $e->getMessage());
		}

	}

	/**
	 * Try to find existing registration in the database by firstname, lastname and year of birth
	 * @param firstName runner's first name
	 * @param lastName runner's last name
	 * @param yearOfBirth runner's year of birth
	 * @param race edition ID
	 * @param runner_ID
	 * @return found registration_ID
	 */
	public function isTooSimilarWith(Request $request) {
		try {
			$registration = Registration::where('edition_ID', $request->edition_ID)->where('firstname', $request->firstname)->where('lastname', $request->lastname)->where('yearofbirth', $request->yearofbirth)->orWhere('runner_ID', $request->runner_ID)->first();
			if ($registration != null) {
				return $registration;
			}
			return null;
		} catch (\Exception $e) {
			Log::error('Can not find any existing registration in DB.', ['registration' => $request->input('lastname'), 'message' => $e->getMessage()]);
			return redirect()->back()->alert()->error('Error!', $e->getMessage());
		}
	}

	/**
	 * Method for generation payment reference for registration summary.
	 * @return int payement reference
	 */
	private function generateNewPayRef() {
		$date = date('Ymd', time());
		$mark = 10 * (date('h', time()) + date('i', time())) + rand(1, 100);
		return $date . $mark;

	}

	/**
	 * Method for generation specific symbol for registration.
	 * @return int specific symbol
	 */
	private function generateSpecificSymbol() {
		$date = date('Y', time());
		$mark = (date('m', time()) + date('d', time())) + 1000 * (date('h', time()) + date('i', time()));
		return $date . $mark;
	}
}
