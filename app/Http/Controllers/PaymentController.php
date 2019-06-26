<?php

namespace App\Http\Controllers;

use App\DataTables\RegistrationSumDataTable;
use App\Payment;
use App\RegistrationSum;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(RegistrationSum::class, 'registrations');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RegistrationSumDataTable $dataTable, $edition_ID)
    {
        $this->authorize('registrations.view', Registration::class);
        $totalRegistrationSum = RegistrationSum::where('edition_ID', $edition_ID)->count();
        $totalPrice = RegistrationSum::where('edition_ID', $edition_ID)->sum('totalprice');
        $totalPaid = Payment::where('ks', ltrim($edition_ID, '0'))->sum('amount');
        return $dataTable->forRaceEdition($edition_ID)->render('races.payment', ['edition_ID' => $edition_ID, 'totalRegistrationSum' => $totalRegistrationSum, 'totalPrice' => $totalPrice, 'totalPaid' => $totalPaid]);
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
