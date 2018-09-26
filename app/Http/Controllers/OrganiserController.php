<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Controller;
use App\Organiser;
use Illuminate\Http\Request;

class OrganiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function organiser()
    {
        $countries = Country::all('country_code', 'name');
        $organiser = Organiser::all();
        return view('settings.organiser', compact('organiser', 'countries'));
    }

    public function index()
    {
        //
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
        //
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
    public function update(Request $request, $organiser_ID)
    {
        $this->validate($request, array(
            'orgname' => 'string|required|max:70',
            'orgname2' => 'string|nullable|max:50',
            'organiser_abbr' => 'string|required|max:10|unique:organiser',
            'street' => 'string|max:30|nullable',
            'city' => 'string|max:30|nullable',
            'postalcode' => 'regex:/^\d{5}$/|nullable|max:13',
            'email' => 'email|nullable|max:100',
            'phone' => 'regex:/^[\+]?[()\/0-9\. \-]{9,}$/|nullable|max:13',
            'taxid' => 'regex:/^\d{8}$/|numeric|nullable|max:8',
            'vatid' => 'regex:/^(CZ|SK)\d{8}$/|nullable|max:10',
            'country' => 'string|exists:country,country_code|max:2',
            'bankaccount' => 'string|regex:/^[0-9\-]$/|nullable|max:50',
            'bankcode' => 'numeric|regex:/^[0-9]{4}$/|nullable|max:4',
            'web' => 'url|nullable|max:50',
        ));
        $organiser = Organiser::find($organiser_ID)->update($request->all());
        alert()->success('Success!', 'Club was modified successfully.');
        return redirect()->route('organiser.show');
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
