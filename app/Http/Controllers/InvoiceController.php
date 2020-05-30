<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    /**
     * Set an invoice as paid. 
     */

    public function setInvoiceAsPaid(Request $request)
    {

        $invoice = Invoice::find($request['invoice_id']);
        $invoice->date = strval(date('d/m/Y'));
        $invoice->isPaid = 1;
        $invoice->save();
        //return redirect()->route('profile.show', ["user" => $user]);

    }

    /**
     * Set an invoice as unpaid. 
     */

    public function setInvoiceAsUnpaid(Request $request)
    {

        $invoice = Invoice::find($request['invoice_id']);
        $invoice->date = null;
        $invoice->isPaid = 0;
        $invoice->save();
        //return redirect()->route('profile.show', ["user" => $user]);

    }
}
