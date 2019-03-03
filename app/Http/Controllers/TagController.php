<?php

namespace App\Http\Controllers;

use App\DataTables\TagDataTable;
use App\Http\Controllers\Controller;
use App\Tag;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Toastr;
use Validator;

class TagController extends Controller {
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
	public function index(TagDataTable $dataTable) {
		try {
			$tags = Tag::all();
			$totaltags = DB::table('tag')->count();
			return $dataTable->render('settings.tags', ['totaltags' => $totaltags]);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		// load the create form (app/views/settings/tag/create.blade.php)
		return view('settings.tag.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		try {
			// validate
			// read more on validation at http://laravel.com/docs/validation
			$rules = array(
				'epc' => 'required',

			);
			$validator = Validator::make(Input::all(), $rules);

			// process the login
			if ($validator->fails()) {
				return Redirect::to('tags')
					->withErrors($validator)
					->withInput();
			} else {
				// store
				$tag = new Tag;
				$tag->EPC = $request->input('epc');
				$tag->active = true;
				$tag->save();
				// redirect
				Log::info('New tag was added to DB.', ['epc' => $tag->epc]);
				Toastr::success('Tag ' . $tag->EPC . ' added successfully.', 'Success!');
				return Redirect::to('tags');
			}

		} catch (\Exception $e) {
			Log::error('Can not add tag to DB.', ['tag' => $request->input('epc'), 'message' => $e->getMessage()]);
			return redirect()->back();
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
