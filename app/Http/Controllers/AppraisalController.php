<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appraisal;
use App\Models\Contact;
use App\Models\Property;
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

        $property = $request->only(
            "bedroom",
            "bathroom",
            "ensuite",
            "toilet",
            "garage",
            "carport",
            "open_car",
            "living",
            "house_size",
            "house_size_unit",
            "land_size",
            "land_size_unit",
            "energy_efficiency_rating",
        );
        $property = Property::create($property);

        $detail = $request->only(
            'address_id',
            'contact_id',
            'price_min',
            'price_max',
            'appraisal_value',
            'due_date',
            'status',
            'delivered_date',
            'delivery_type',
            'reason_lost',
            'interest',
        );
        $detail['property_id'] = $property->id;
        Appraisal::create($detail);
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

        $property = $request->only(
            "bedroom",
            "bathroom",
            "ensuite",
            "toilet",
            "garage",
            "carport",
            "open_car",
            "living",
            "house_size",
            "house_size_unit",
            "land_size",
            "land_size_unit",
            "energy_efficiency_rating",
        );
        Property::find($appraisal->property_id)->update($property);

        $detail = $request->only(
            'address_id',
            'contact_id',
            'price_min',
            'price_max',
            'appraisal_value',
            'due_date',
            'status',
            'delivered_date',
            'delivery_type',
            'reason_lost',
            'interest',
        );
        $appraisal->update($detail);
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

    public function loadAddressProperty(Request $request)
    {
        $address_id = $request->address_id;
        $address = Address::find($address_id);
        if ($address->property_id) {
            $property = Property::find($address->property_id);
            return response()->json(['property' => $property, 'status' => 1]);
        }

        return response()->json(['property' => null, 'status' => 0]);
    }
}
