<?php

namespace App\Http\Controllers;

use App\Models\ListingPortal;
use Illuminate\Http\Request;

class ListingPortalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = ListingPortal::all();
        return view('listing-portal.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('listing-portal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'base_url',
            'key',
            'office_id',
        ]);
        ListingPortal::create($data);
        return redirect()->route('listingPortal.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ListingPortal $listingPortal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListingPortal $listingPortal)
    {
        return view('listing-portal.edit', compact('listingPortal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListingPortal $listingPortal)
    {
        $update_data = $request->only([
            'name',
            'base_url',
            'key',
            'office_id',
        ]);
        $listingPortal->update($update_data);
        return redirect()->route('listingPortal.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListingPortal $listingPortal)
    {

        $listingPortal->delete();
        return redirect()->route('listingPortal.index');
    }

    public function update_status(Request $request)
    {
        $portal = ListingPortal::find($request->id);
        $isactive = !$portal->active;
        $portal->update([
            'active' => $isactive
        ]);
        return back();
    }
}
