<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appraisal;
use App\Models\Contact;
use Illuminate\Http\Request;

class AppraisalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('appraisal/list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::all();
        $addresses = Address::all();
        return view('appraisal/create', compact('contacts', 'addresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Appraisal $appraisal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appraisal $appraisal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appraisal $appraisal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appraisal $appraisal)
    {
        //
    }
}
