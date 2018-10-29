<?php

namespace App\Http\Controllers;

use App\Category;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($edition_ID)
    {
        $categories = DB::table('category')
            ->where('edition_ID', $edition_ID)
            ->get();
        $totalcategories = DB::table('category')->where('edition_ID', $edition_ID)->count();
        $totalmencategories = DB::table('category')->where([['edition_ID', '=', $edition_ID], ['gender', '=', 'male']])->count();
        $totalwomencategories = DB::table('category')->where([['edition_ID', '=', $edition_ID], ['gender', '=', 'female']])->count();
        return view('races.category', ['edition_ID' => $edition_ID])->with('categories', $categories)->with('totalcategories', $totalcategories)->with('totalmencategories', $totalmencategories)->with('totalwomencategories', $totalwomencategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($edition_ID)
    {
        // load the create form (app/views/races/category/create.blade.php)
        return view('races.category.create', ['edition_ID' => $edition_ID]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $edition_ID)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'categoryname' => 'required|string',
            'gender' => 'required|max:6|string',
            'length' => 'numeric|nullable',
            'climb' => 'numeric|nullable',
            'entryfee' => 'numeric|nullable',
            'currency' => 'string|nullable|max:3|min:3',
            'starttime' => 'datetime|nullable',
            'sinterval' => 'numeric|nullable',
            'timelimit' => 'numeric|nullable',

        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('race/' . $edition_ID . 'category/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $category = new Category;
            $category->categoryname = Input::get('categoryname');
            $category->gender = Input::get('gender');
            $category->edition_ID = $edition_ID;
            $category->save();

            // redirect
            alert()->success('Success!', 'Category ' . $category->categoryname . ' successfully.');
            return Redirect::to('race/' . $edition_ID . '/category');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($edition_ID, $category_ID)
    {
        echo $category_ID;
        echo $edition_ID;
        die();
        // get the nerd
        $category = Category::find($category_ID);

        // show the edit form and pass the nerd
        return View::make('races.category.edit', ['edition_ID' => $edition_ID])
            ->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
