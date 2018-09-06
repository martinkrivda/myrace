<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Controller;
use App\Runner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RunnersController extends Controller
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
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function runners()
    {
        $countries = Country::all('country_code', 'name');
        return view('directory.runners', compact('countries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $runners = Runner::all();
        return response()->json(['data' => $runners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:255',
            'vintage' => 'required|numeric|min:1900',
            'gender' => ['required', 'regex:/^(male|female)$/', 'max:255'],
            'email' => 'email|nullable|max:255',
            'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
            'country' => 'string|exists:country,country_code|max:2',
        ]);
        $create = Runner::create($request->all());
        Log::info('New runner was added to DB.', ['firstname' => $create->firstname, 'lastname' => $create->lastname, 'runner_ID' => $create->runner_ID]);
        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($runner_ID)
    {
        $show = Runner::find($runner_ID);
        return response()->json($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $runner_ID
     * @return \Illuminate\Http\Response
     */
    public function edit($runner_ID)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $runner_ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $runner_ID)
    {
        $edit = Runner::find($runner_ID)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $runner_ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($runner_ID)
    {
        Runner::find($runner_ID)->delete();
        //Runner::find($runner_ID)->update(['deleted' => true]);
        return response()->json(['message' => 'Runner deleted successfully', 'status' => 'success', 'done']);
    }
}
