<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Address::all();
        return view('address/list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('address/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_type' => 'required|string',
            'street' => 'required|string',
            'suburb' => 'required|string',
            'city' => 'required|string',
            'google_address' => 'required|string',
        ]);

        Address::create([
            'property_type' => $request->property_type,
            'unit_number' => $request->unit_number,
            'street' => $request->street,
            'building' => $request->building,
            'suburb' => $request->suburb,
            'city' => $request->city,
            'google_address' => $request->google_address,
        ]);
        return redirect()->route('address.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        return view('address/edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $request->validate([
            'property_type' => 'required|string',
            'street' => 'required|string',
            'suburb' => 'required|string',
            'city' => 'required|string',
            'google_address' => 'required|string',
        ]);

        $address->update([
            'property_type' => $request->property_type,
            'unit_number' => $request->unit_number,
            'street' => $request->street,
            'building' => $request->building,
            'suburb' => $request->suburb,
            'city' => $request->city,
            'google_address' => $request->google_address,
        ]);
        return redirect()->route('address.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('address.index');
    }
}
