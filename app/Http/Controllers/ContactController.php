<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AddressContact;
use App\Models\Contact;
use App\Models\Tag;
use App\Models\TagContact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tags = Tag::all();
        $list = Contact::query();
        if ($request->get('include_tags')) {
            $include_tags = $request->get('include_tags');
            $include_list = TagContact::whereIn('tag_id', $include_tags)->pluck('contact_id');
            $list->whereIn('id', $include_list);
        }

        if ($request->get('exclude_tags')) {
            $exclude_tags = $request->get('exclude_tags');
            $exclude_list = TagContact::whereIn('tag_id', $exclude_tags)->pluck('contact_id');
            $list->whereNotIn('id', $exclude_list);
        }
        $list = $list->get();

        return view('contact/list', compact('list', 'tags'));
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
        $request->validate([
            'first_name' => 'required|string',
        ]);

        $photo_path = "";
        if ($request->file('photo')) {
            $image = $request->file('photo');
            $photo_path = $image->store('images', 'images');
        }

        $contact = Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => $request->full_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'photo' => $photo_path,
            'notes' => $request->notes,
            'rent_type' => $request->rent_type,
        ]);

        if ($contact->id) {
            if ($request->tags) {
                foreach ($request->tags as $tag_id) {
                    TagContact::create([
                        'tag_id' => $tag_id,
                        'contact_id' => $contact->id,
                    ]);
                }
            }

            if ($request->contact_address) {
                foreach ($request->contact_address as $key => $address_id) {
                    AddressContact::create([
                        'address_id' => $address_id,
                        'contact_id' => $contact->id,
                    ]);
                }
            }
        }

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
        $request->validate([
            'first_name' => 'required|string',
        ]);

        $updated = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => $request->full_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'notes' => $request->notes,
            'rent_type' => $request->rent_type,
        ];
        if ($request->file('photo')) {
            $image = $request->file('photo');
            $path = $image->store('images', 'images'); // 'images' is the disk name
            $updated['photo'] = $path;
        }
        $contact->update($updated);

        AddressContact::where('contact_id', $contact->id)->delete();
        if ($request->contact_address) {
            foreach ($request->contact_address as $key => $address_id) {
                AddressContact::create([
                    'address_id' => $address_id,
                    'contact_id' => $contact->id,
                ]);
            }
        }

        TagContact::where('contact_id', $contact->id)->delete();
        if ($request->tags) {
            foreach ($request->tags as $tag_id) {
                TagContact::create([
                    'tag_id' => $tag_id,
                    'contact_id' => $contact->id,
                ]);
            }
        }

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
