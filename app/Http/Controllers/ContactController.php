<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Contact::all();
        return view('contact/list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $addresses = Address::all();
        return view('contact/create', compact('tags', 'addresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = $request->file('photo');
        $path = $image->store('images', 'images'); // 'images' is the disk name
        $tags = json_encode($request->tags);
        Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => $request->full_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'photo' => $path,
            'tags' => $tags,
            'notes' => $request->notes,
            'address_type' => $request->address_type,
        ]);
        return redirect()->route('contact.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $tags = Tag::all();
        $addresses = Address::all();
        return view('contact/edit', compact('tags', 'addresses', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $address = $request->address_type == 'new' ? $request->address_new : $request->address_old;
        $tags = json_encode($request->tags);
        $updated = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => $request->full_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $address,
            'tags' => $tags,
            'notes' => $request->notes,
            'address_type' => $request->address_type,
        ];
        if ($request->file('photo')) {
            $image = $request->file('photo');
            $path = $image->store('images', 'images'); // 'images' is the disk name
            $updated['photo'] = $path;
        }
        $contact->update($updated);
        return redirect()->route('contact.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contact.index');
    }
}
