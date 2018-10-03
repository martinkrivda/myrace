<?php

namespace App\Http\Controllers;

use App\Country;
use App\Organiser;
use App\Race;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use JavaScript;

class RacesController extends Controller
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
    public function races()
    {
        $countries = Country::all('country_code', 'name');
        $organisers = Organiser::all('organiser_ID', 'orgname');
        $races = Race::all('race_ID', 'racename');
        $user = Auth::user();
        Javascript::put(['userID' => $user->id]);
        return view('settings.races', compact('countries', 'organisers', 'races'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $races = DB::table('race')
            ->select('race_ID', 'racename', 'location', 'race.organiser_ID', 'race.web', 'race.email', 'race.phone', 'organiser_abbr', 'orgname')
            ->leftJoin('organiser', 'race.organiser_ID', '=', 'organiser.organiser_ID')
            ->get();
        return response()->json(['data' => $races]);
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
        $create = Race::create($request->all());
        Log::info('New race was added to DB.', ['racename' => $create->racename, 'location' => $create->location, 'race_ID' => $create->race_ID]);
        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($race_ID)
    {
        $show = Race::find($race_ID);
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request['action'] == 'edit') {
            try {
                $edit = Race::find($request['race_ID'])->update($request->all());
                alert()->success('Success!', 'Race was modified successfully.');
            } catch (\Exception $e) {
                alert()->error('Error!', 'Race was modified with errors.');
                return $e->getMessage();
            } finally {
                return response()->json($edit);
            }
        } elseif ($request['action'] == 'delete') {
            $delete = Race::find($request['race_ID'])->delete();
            alert()->success('Success!', 'Race was deleted successfully.');
        } elseif ($request['action'] == 'restore') {
            echo "restore";
        }
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
