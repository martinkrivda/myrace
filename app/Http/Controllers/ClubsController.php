<?php

namespace App\Http\Controllers;

use App\Club;
use App\Country;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClubsController extends Controller
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
    public function clubs()
    {
        $countries = Country::all('country_code', 'name');
        return view('directory.clubs', compact('countries'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::all();
        return response()->json(['data' => $clubs]);
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
            'clubname' => 'required|string|max:70',
            'clubname2' => 'nullable|string|max:50',
            'clubabbr' => 'required|string|min:3|max:10',
            'street' => 'string|max:30|nullable',
            'city' => 'string|max:30|nullable',
            'postalcode' => 'regex:/^\d{5}$/|nullable|max:13',
            'email' => 'email|nullable|max:100',
            'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
            'taxid' => 'regex:/^\d{8}$/|numeric|nullable|max:8',
            'vatid' => 'regex:/^(CZ|SK)\d{8}$/|nullable|max:10',
            'country' => 'string|exists:country,country_code|max:2',
            'web' => 'url|nullable|max:50',
        ]);
        $create = Club::create($request->all());
        Log::info('New club was added to DB.', ['name' => $create->name, 'club_ID' => $create->club_ID]);
        return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($club_ID)
    {
        $show = Club::find($club_ID);
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
    public function update(Request $request, $club_ID)
    {
        $edit = Club::find($club_ID)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($club_ID)
    {
        Runner::find($club_ID)->delete();
        //Runner::find($club_ID)->update(['deleted' => true]);
        return response()->json(['message' => 'Club deleted successfully', 'status' => 'success', 'done']);
    }

    public function searchclub(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('club')
                ->where('clubname', 'LIKE', "%{$query}%")
                ->orWhere('clubabbr', 'LIKE', "%{$query}%")
                ->orWhere('club_ID', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
       <li><a href="#">' . $row->clubname . ' - ' . $row->clubabbr . ' - ' . $row->club_ID . '</a></li>
       ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
