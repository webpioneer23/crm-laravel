<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appraisal;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\LeadObject;
use App\Models\Listing;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Lead::all();
        return view('lead.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $addresses = Address::all();
        return view('lead.create', compact('addresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_lead = Lead::create([
            'address_id' => $request->address_id,
            'note' => $request->note,
            'status' => $request->status,
        ]);

        if ($request->contact && count($request->contact) > 0) {
            foreach ($request->contact as $contact) {
                LeadObject::create([
                    'lead_id' => $new_lead->id,
                    'target_name' => 'contact',
                    'target_id' => $contact,
                ]);
            }
        }
        if ($request->status == 'Appraised' && $request->appraisal && count($request->appraisal) > 0) {
            foreach ($request->appraisal as $appraisal) {
                LeadObject::create([
                    'lead_id' => $new_lead->id,
                    'target_name' => 'appraisal',
                    'target_id' => $appraisal,
                ]);
            }
        }
        if ($request->status == 'Won' && $request->contact && count($request->listing) > 0) {
            foreach ($request->contact as $listing) {
                LeadObject::create([
                    'lead_id' => $new_lead->id,
                    'target_name' => 'listing',
                    'target_id' => $listing,
                ]);
            }
        }

        return redirect()->route('lead.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        $addresses = Address::all();

        $addressId = $lead->address_id;
        $address = Address::find($addressId);
        $contact_list = $address->full_contacts;
        $appraisal_list = Appraisal::where('address_id', $addressId)->with('contact')->get();
        $listing_list = Listing::where('address_id', $addressId)->with('vendor')->get();

        return view('lead.edit', compact('lead', 'addresses', 'contact_list', 'appraisal_list', 'listing_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $lead->update([
            'address_id' => $request->address_id,
            'note' => $request->note,
            'status' => $request->status,
        ]);

        LeadObject::where('lead_id', $lead->id)->delete();

        if ($request->contact && count($request->contact) > 0) {
            foreach ($request->contact as $contact) {
                LeadObject::create([
                    'lead_id' => $lead->id,
                    'target_name' => 'contact',
                    'target_id' => $contact,
                ]);
            }
        }
        if ($request->status == 'Appraised' && $request->appraisal && count($request->appraisal) > 0) {
            foreach ($request->appraisal as $appraisal) {
                LeadObject::create([
                    'lead_id' => $lead->id,
                    'target_name' => 'appraisal',
                    'target_id' => $appraisal,
                ]);
            }
        }
        if ($request->status == 'Won' && $request->contact && count($request->listing) > 0) {
            foreach ($request->contact as $listing) {
                LeadObject::create([
                    'lead_id' => $lead->id,
                    'target_name' => 'listing',
                    'target_id' => $listing,
                ]);
            }
        }

        return redirect()->route('lead.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return back();
    }

    public function associate_address(Request $request)
    {
        $addressId = $request->addressId;
        $address = Address::find($addressId);
        $contact_list = $address->full_contacts;
        $appraisal_list = Appraisal::where('address_id', $addressId)->with('contact')->get();
        $listing_list = Listing::where('address_id', $addressId)->with('vendor')->get();


        return [
            'contact_list' => $contact_list,
            'appraisal_list' => $appraisal_list,
            'listing_list' => $listing_list,
        ];
    }
}
