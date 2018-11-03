<?php

namespace App\Http\Controllers;

use App\Category;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Validator;

class CategoryController extends Controller {
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
		try {
			$categories = DB::table('category')
				->where('edition_ID', $edition_ID)
				->get();
			$totalcategories = DB::table('category')->where('edition_ID', $edition_ID)->count();
			$totalmencategories = DB::table('category')->where([['edition_ID', '=', $edition_ID], ['gender', '=', 'male']])->count();
			$totalwomencategories = DB::table('category')->where([['edition_ID', '=', $edition_ID], ['gender', '=', 'female']])->count();
			return view('races.category', ['edition_ID' => $edition_ID])->with('categories', $categories)->with('totalcategories', $totalcategories)->with('totalmencategories', $totalmencategories)->with('totalwomencategories', $totalwomencategories);
		} catch (\Exception $e) {
			return new $e->getMessage();
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($edition_ID) {
		// load the create form (app/views/races/category/create.blade.php)
		return view('races.category.create', ['edition_ID' => $edition_ID]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $edition_ID) {
		try {
			// validate
			// read more on validation at http://laravel.com/docs/validation
			$rules = array(
				'categoryname' => 'required|string',
				'gender' => 'required|max:6|string',
				'length' => 'numeric|nullable',
				'climb' => 'numeric|nullable',
				'entryfee' => 'numeric|nullable',
				'currency' => 'string|nullable|max:3|min:3',
				'starttime' => 'date|nullable',
				'sinterval' => 'numeric|nullable',
				'timelimit' => 'numeric|nullable',
				'checkage' => 'boolean',
				'birthfrom' => 'date_format:Y|nullable',
				'birthto' => 'date_format:Y|nullable',

			);
			$validator = Validator::make(Input::all(), $rules);

			// process the login
			if ($validator->fails()) {
				return Redirect::to('race/' . $edition_ID . '/category/create')
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
	 * @param  int  $edition_ID [ID of specific race]
	 * @param int $category_ID [ID of specific category]
	 * @return \Illuminate\Http\Response
	 */
	public function show($edition_ID, $category_ID) {
		try {
			// get the nerd
			$category = Category::find($category_ID);

			// show the edit form and pass the nerd
			return view('races.category.show', ['edition_ID' => $edition_ID])->with('category', $category);

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
	public function edit($edition_ID, $category_ID) {
		// get the nerd
		$category = Category::find($category_ID);

		// show the edit form and pass the nerd
		return view('races.category.edit', ['edition_ID' => $edition_ID])
			->with('category', $category);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $edition_ID
	 * @param  int $category_ID [Category ID]
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $edition_ID, $category_ID) {
		try {
			// validate
			// read more on validation at http://laravel.com/docs/validation
			$rules = array(
				'categoryname' => 'required|string',
				'gender' => 'required|max:6|string',
				'length' => 'numeric|nullable',
				'climb' => 'numeric|nullable',
				'entryfee' => 'numeric|nullable',
				'currency' => 'string|nullable|max:3|min:3',
				'starttime' => 'date|nullable',
				'sinterval' => 'numeric|nullable',
				'timelimit' => 'numeric|nullable',
				'checkage' => 'boolean',
				'birthfrom' => 'date_format:Y|nullable',
				'birthto' => 'date_format:Y|nullable',

			);
			$validator = Validator::make(Input::all(), $rules);

			// process the login
			if ($validator->fails()) {
				return Redirect::to('race/' . $edition_ID . '/category/' . $category_ID . '/edit')
					->withErrors($validator)
					->withInput();
			} else {
				// store
				$category = Category::find($category_ID);
				$category->categoryname = mb_convert_case($request->input('categoryname'), MB_CASE_UPPER, "UTF-8");
				$category->gender = Input::get('gender');
				if (Input::get('length')) {$category->length = $request->input('length');}
				if (Input::get('climb')) {$category->climb = $request->input('climb');}
				if (Input::get('entryfee')) {$category->entryfee = $request->input('entryfee');}
				//$category->currency = Input::get('currency');
				if (Input::get('starttime')) {$category->starttime = $request->input('starttime');}
				if (Input::get('sinterval')) {$category->sinterval = $request->input('sinterval');}
				if (Input::get('timelimit')) {$category->timelimit = $request->input('timelimit');}
				if (Input::get('checkage')) {$category->checkage = $request->input('checkage');}
				if (Input::get('birthfrom')) {$category->birthfrom = $request->input('birthfrom');}
				if (Input::get('birthto')) {$category->birthto = $request->input('birthto');}
				$category->save();
				// redirect
				Log::info('Category was updated to DB.', ['name' => $category->categoryname]);
				alert()->success('Success!', 'Category ' . $category->categoryname . ' updated successfully.');
				return Redirect::to('race/' . $edition_ID . '/category');
			}
		} catch (\Exception $e) {
			Log::error('Can not update category to DB.', ['category' => $request->input('categoryname'), 'message' => $e->getMessage()]);
			return redirect()->back()->alert()->error('Error!', $e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($edition_ID, $category_ID) {
		// delete
		$category = Category::find($category_ID);
		$category->delete();

		// redirect
		return Redirect::to('race/' . $edition_ID . '/category');
	}
}
