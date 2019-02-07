<?php

namespace App\Http\Controllers;

use App\Category;
use App\Country;
use App\DataTables\RegistrationDataTable;
use App\Http\Controllers\Controller;
use App\RegistrationSum;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JavaScript;

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
			$countofclub = DB::table('registration')->distinct()->select('club_ID')->where('edition_ID', $edition_ID)->groupBy('club_ID')->count();
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
		return view('races.registration.create', ['edition_ID' => $edition_ID, 'categories' => $categories, 'countries' => $countries], compact('registrationsum'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $edition_ID, $user) {
		try {
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
				'user' => 'numeric|exists:users,id',
			);
			$validator = Validator::make(Input::all(), $rules);

			// process the login
			if ($validator->fails()) {
				return Redirect::to('race/' . $edition_ID . '/registration/create')
					->withErrors($validator)
					->withInput();
			} else {
				// store
				$category = new Category;
				$category->categoryname = mb_convert_case($request->input('categoryname'), MB_CASE_UPPER, "UTF-8");
				$category->gender = Input::get('gender');
				$category->edition_ID = $edition_ID;
				if (Input::get('length')) {$category->length = $request->input('length');}
				if (Input::get('climb')) {$category->climb = $request->input('climb');}
				if (Input::get('entryfee')) {$category->entryfee = $request->input('entryfee');}
				//$category->currency = Input::get('currency');
				if (Input::get('starttime')) {$category->starttime = $request->input('starttime');}
				if (Input::get('sinterval')) {$category->sinterval = $request->input('sinterval');}
				if (Input::get('timelimit')) {$category->timelimit = $request->input('timelimit');}
				if (Input::get('capacity')) {$category->capacity = $request->input('capacity');}
				if (Input::get('checkage')) {$category->checkage = $request->input('checkage');}
				if (Input::get('birthfrom')) {$category->birthfrom = $request->input('birthfrom');}
				if (Input::get('birthto')) {$category->birthto = $request->input('birthto');}
				$category->save();
				// redirect
				Log::info('New category was added to DB.', ['name' => $category->categoryname]);
				alert()->success('Success!', 'Category ' . $category->categoryname . ' created successfully.');
				return Redirect::to('race/' . $edition_ID . '/category');
			}

		} catch (\Exception $e) {
			Log::error('Can not create category to DB.', ['category' => $request->input('categoryname'), 'message' => $e->getMessage()]);
			return redirect()->back()->alert()->error('Error!', $e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
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
