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
        $list = Appraisal::all();
        return view('appraisal/list', compact('list'));
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
        $data = $request->except('_token');
        Appraisal::create($data);
        return redirect()->route('appraisal.index');
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
        $contacts = Contact::all();
        $addresses = Address::all();
        return view('appraisal/edit', compact('contacts', 'addresses', 'appraisal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appraisal $appraisal)
    {
        $data = $request->except('_token');
        $appraisal->update($data);
        return redirect()->route('appraisal.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appraisal $appraisal)
    {
        $appraisal->delete();
        return back();
    }
}
