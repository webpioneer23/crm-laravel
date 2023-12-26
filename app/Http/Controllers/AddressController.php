<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Property;
use App\Services\HistoryService;
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

        $address = Address::create([
            'property_type' => $request->property_type,
            'unit_number' => $request->unit_number,
            'street' => $request->street,
            'building' => $request->building,
            'suburb' => $request->suburb,
            'city' => $request->city,
            'google_address' => $request->google_address,
        ]);


        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'created',
            'source' => 'address',
            'source_id' => $address->id,
            'note' => ($address->unit_number ? $address->unit_number . "/" : "") . $address->street . $address->city,
        ];

        HistoryService::addRecord($history);


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
        if ($request->step == 1) {
            $request->validate([
                'property_type' => 'required|string',
                'street' => 'required|string',
                'suburb' => 'required|string',
                'city' => 'required|string',
                'google_address' => 'required|string',
            ]);

            $old_address = [
                'property_type' => $address->property_type,
                'unit_number' => $address->unit_number,
                'street' => $address->street,
                'building' => $address->building,
                'suburb' => $address->suburb,
                'city' => $address->city,
                'google_address' => $address->google_address,
                'step' => $request->step + 1,
            ];

            $updated = [
                'property_type' => $request->property_type,
                'unit_number' => $request->unit_number,
                'street' => $request->street,
                'building' => $request->building,
                'suburb' => $request->suburb,
                'city' => $request->city,
                'google_address' => $request->google_address,
                'step' => $request->step + 1,
            ];

            $address->update($updated);

            $diff = HistoryService::getObjectDifference($old_address, $updated);

            $history = [
                'user_id' => auth()->user()->id,
                'type' => 'edited',
                'source' => 'address',
                'source_id' => $address->id,
                'note' => json_encode($diff),
            ];

            HistoryService::addRecord($history);

            return back();
        }
        if ($request->step == 2) {
            $data = $request->except('_token');
            $old_address = [];
            if ($address->property_id) {
                $property = Property::find($address->property_id);
                $old_address = [
                    "bedroom" => $property["bedroom"],
                    "bathroom" => $property["bathroom"],
                    "ensuite" => $property["ensuite"],
                    "toilet" => $property["toilet"],
                    "garage" => $property["garage"],
                    "carport" => $property["carport"],
                    "open_car" => $property["open_car"],
                    "living" => $property["living"],
                    "house_size" => $property["house_size"],
                    "house_size_unit" => $property["house_size_unit"],
                    "land_size" => $property["land_size"],
                    "land_size_unit" => $property["land_size_unit"],
                    "energy_efficiency_rating" => $property["energy_efficiency_rating"],
                ];

                $property->update($data);
            } else {
                $property = Property::create($data);
                $address->property_id = $property->id;
                $address->save();
            }

            // $updated = [
            //     'property_type' => $request->property_type,
            //     'unit_number' => $request->unit_number,
            //     'street' => $request->street,
            //     'building' => $request->building,
            //     'suburb' => $request->suburb,
            //     'city' => $request->city,
            //     'google_address' => $request->google_address,
            //     'step' => $request->step + 1,
            // ];
            $updated = $request->except("_token", "_method", "extra");


            $diff = HistoryService::getObjectDifference($old_address, $updated);

            $history = [
                'user_id' => auth()->user()->id,
                'type' => 'edited',
                'source' => 'address',
                'source_id' => $address->id,
                'note' => json_encode($diff),
            ];

            HistoryService::addRecord($history);



            return redirect()->route('address.index');
        }
        return redirect()->route('address.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'deleted',
            'source' => 'address',
            'source_id' => $address->id,
            'note' => ($address->unit_number ? $address->unit_number . "/" : "") . $address->street . $address->city,
        ];

        $address->delete();
        HistoryService::addRecord($history);


        return redirect()->route('address.index');
    }

    public function contact_address(Request $request)
    {
        $request->validate([
            'property_type' => 'required|string',
            'street' => 'required|string',
            'suburb' => 'required|string',
            'city' => 'required|string',
            'google_address' => 'required|string',
        ]);

        $address = Address::create([
            'property_type' => $request->property_type,
            'unit_number' => $request->unit_number,
            'street' => $request->street,
            'building' => $request->building,
            'suburb' => $request->suburb,
            'city' => $request->city,
            'google_address' => $request->google_address,
        ]);

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'created',
            'source' => 'address',
            'source_id' => $address->id,
            'note' => ($address->unit_number ? $address->unit_number . "/" : "") . $address->street . $address->city,
        ];

        HistoryService::addRecord($history);
        return redirect()->back();
    }
}
