<?php

namespace App\Http\Controllers;

use App\RaceEdition;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EditionController extends Controller
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
    public function index()
    {
        $raceeditions = DB::table('raceedition')
            ->leftJoin('race', 'raceedition.race_ID', '=', 'race.race_ID')
            ->leftJoin('organiser', 'race.organiser_ID', '=', 'organiser.organiser_ID')
            ->get();
        return response()->json(['data' => $raceeditions]);
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
        $create = RaceEdition::create($request->all());
        Log::info('New race edition was added to DB.', ['editionname' => $create->editionname, 'date' => $create->date, 'edition_ID' => $create->edition_ID]);
        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($edition_ID)
    {
        $show = RaceEdition::find($edition_ID);
        return response()->json($show);
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
    public function update(Request $request, $edition_ID)
    {

        $edit = RaceEdition::find($edition_ID)->update($request->all());
        Log::info('Edition was updated from DB.', ['edition_ID' => $edition_ID, 'user' => [$user->lastname, $user->lastname], 'user_ID' => $user->id]);
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($edition_ID)
    {
        $user = Auth::user();
        RaceEdition::find($edition_ID)->delete();
        //Runner::find($runner_ID)->update(['deleted' => true]);
        Log::info('Edition was deleted from DB.', ['edition_ID' => $edition_ID, 'user' => [$user->lastname, $user->lastname], 'user_ID' => $user->id]);
        return response()->json(['message' => 'Edition deleted successfully', 'status' => 'success', 'done']);
    }
}
