<?php

namespace App\Http\Controllers;

use Alert;
use App\Course;
use App\RaceEdition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Validator;

class CourseController extends Controller
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
    public function index(RaceEdition $edition_ID)
    {
        $courses = Course::where('edition_ID', $edition_ID->edition_ID)->get();
        return view('races.course', ['edition_ID' => $edition_ID->edition_ID])->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RaceEdition $edition_ID)
    {
        // load the create form (app/views/races/course/create.blade.php)
        return view('races.course.create', ['edition_ID' => $edition_ID]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RaceEdition $edition_ID)
    {
        try {
            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'coursename' => 'required|string',
                'surface' => 'required|max:10|string',
                'length' => 'numeric|nullable',
                'climb' => 'numeric|nullable',
                'description' => 'string|nullable',
                'gpxfile' => 'file|nullable',

            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if ($validator->fails()) {
                return Redirect::to('race/' . $edition_ID . '/course/create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                // store
                $course = new Course;
                $course->coursename = mb_convert_case($request->input('coursename'), MB_CASE_UPPER, "UTF-8");
                $course->surface = Input::get('surface');
                $course->edition_ID = $edition_ID->edition_ID;
                if (Input::get('length')) {$course->length = $request->input('length');}
                if (Input::get('climb')) {$course->climb = $request->input('climb');}
                if (Input::get('description')) {$course->description = $request->description;}
                if (Input::file('gpxfile')) {$course->gpx = file_get_contents(Input::file('gpxfile')->getRealPath());}
                $course->save();
                // redirect
                Log::info('New course was added to DB.', ['name' => $course->coursename]);
                alert()->success('Success!', 'Course ' . $course->coursename . ' created successfully.');
                return Redirect::to('race/' . $edition_ID->edition_ID . '/course');
            }

        } catch (\Exception $e) {
            Log::error('Can not create course to DB.', ['course' => $request->input('coursename'), 'message' => $e->getMessage()]);
            return back()->withInput(['errors', $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RaceEdition $edition_ID, $course_ID)
    {
        try {
            // get the course
            $course = Course::find($course_ID);

            // show the edit form and pass the nerd
            return view('races.course.show', ['edition_ID' => $edition_ID->edition_ID])->with('course', $course);

        } catch (\Exception $e) {
            return redirect()->back($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
