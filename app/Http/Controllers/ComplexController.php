<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AddressContact;
use App\Models\AFile;
use App\Models\Complex;
use App\Models\ComplexAddress;
use App\Models\ComplexWishlist;
use App\Models\Contact;
use App\Models\Tag;
use App\Models\TagContact;
use App\Models\WishlistTag;
use Illuminate\Http\Request;

class ComplexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Complex::all();
        return view('complex/list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $address_list = Address::all();
        return view('complex/create', compact('address_list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'street_address' => 'required|string',
            'name' => 'required|string',
        ]);

        $complex = Complex::create([
            'street_address' => $request->street_address,
            'name' => $request->name,
            'year_built' => $request->year_built,
            'architect' => $request->architect,
            'constructor' => $request->constructor,
            'number_units' => $request->number_units,
            'number_floors' => $request->number_floors,
            'property_type' => $request->property_type,
            'body_manager' => $request->body_manager,
            'note' => $request->note,
        ]);

        if ($complex->id) {
            if ($request->file('attached')) {
                $files = $request->file('attached');
                foreach ($files as $file) {
                    $attached_path = $file->store('files', 'images');
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->extension();
                    AFile::create([
                        'path' => $attached_path,
                        'file_name' => $file_name,
                        'file_ext' => $file_ext,
                        'target_id' => $complex->id,
                        'type' => 'complex',
                    ]);
                }
            }

            if ($request->complex_address) {
                foreach ($request->complex_address as $key => $address_id) {
                    ComplexAddress::create([
                        'address_id' => $address_id,
                        'complex_id' => $complex->id,
                    ]);
                }
            }
        }

        return redirect()->route('complex.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complex $complex, Request $request)
    {
        $tags = Tag::all();
        $address_list = Address::all();

        $complex_address = ComplexAddress::where('complex_id', $complex->id)->pluck('address_id');
        $address_contacts = AddressContact::whereIn('address_id', $complex_address)->pluck('contact_id');
        $contacts = Contact::whereIn('id', $address_contacts);
        if ($request->get('include_tags')) {
            $include_tags = $request->get('include_tags');
            $include_list = TagContact::whereIn('tag_id', $include_tags)->pluck('contact_id');
            $contacts->whereIn('id', $include_list);
        }

        if ($request->get('exclude_tags')) {
            $exclude_tags = $request->get('exclude_tags');
            $exclude_list = TagContact::whereIn('tag_id', $exclude_tags)->pluck('contact_id');
            $contacts->whereNotIn('id', $exclude_list);
        }
        $contacts = $contacts->get();

        return view('complex/show', compact('address_list', 'complex', 'tags', 'contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complex $complex)
    {
        $address_list = Address::all();
        return view('complex/edit', compact('address_list', 'complex'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complex $complex)
    {
        $request->validate([
            'street_address' => 'required|string',
            'name' => 'required|string',
        ]);

        $complex->update([
            'street_address' => $request->street_address,
            'name' => $request->name,
            'year_built' => $request->year_built,
            'architect' => $request->architect,
            'constructor' => $request->constructor,
            'number_units' => $request->number_units,
            'number_floors' => $request->number_floors,
            'property_type' => $request->property_type,
            'body_manager' => $request->body_manager,
            'note' => $request->note,
        ]);

        if ($request->file('attached')) {
            AFile::where(['target_id' =>  $complex->id, 'type' => 'complex'])->delete();
            $files = $request->file('attached');
            foreach ($files as $file) {
                $attached_path = $file->store('files', 'images');
                $file_name = $file->getClientOriginalName();
                $file_ext = $file->extension();
                AFile::create([
                    'path' => $attached_path,
                    'file_name' => $file_name,
                    'file_ext' => $file_ext,
                    'target_id' => $complex->id,
                    'type' => 'complex',
                ]);
            }
        }

        ComplexAddress::where('complex_id', $complex->id)->delete();
        if ($request->complex_address) {
            foreach ($request->complex_address as $key => $address_id) {
                ComplexAddress::create([
                    'address_id' => $address_id,
                    'complex_id' => $complex->id,
                ]);
            }
        }

        return redirect()->route('complex.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complex $complex)
    {
        $complex->delete();
        return back();
    }

    public function wishlist($id)
    {
        $complex = Complex::findOrFail($id);
        $contacts = Contact::all();

        $wishlists = ComplexWishlist::where('complex_id', $id)->get();


        $tag_wishlist_map =  [];

        foreach ($wishlists as $key => $wishlist) {
            $tag_key = "$id-$wishlist->contact_id";
            $tags = WishlistTag::where("wishlist_id", $wishlist->id)->get();
            $tag_wishlist_map[$tag_key] = $tags;
        }

        return view('complex/wishlist', compact('complex', 'contacts', 'tag_wishlist_map', 'wishlists'));
    }

    public function wishlist_store(Request $request, $complex_id)
    {
        $request->validate([
            'contact' => 'required|string',
            'tags' => 'required|string',
        ]);
        $complex = Complex::findorfail($complex_id);
        if (!$complex) {
            return back();
        }

        $wishlist_id = "";

        $exist_wishlist = ComplexWishlist::where([
            'complex_id' => $complex_id,
            'contact_id' => $request->contact
        ])->first();
        if (!$exist_wishlist) {
            $complex_wishlist = ComplexWishlist::create([
                'complex_id' => $complex_id,
                'contact_id' => $request->contact
            ]);
            $wishlist_id = $complex_wishlist->id;
        } else {
            $wishlist_id = $exist_wishlist->id;
        }

        $tags = $request->tags;
        WishlistTag::where([
            'wishlist_id' => $wishlist_id,
        ])->delete();
        if ($tags) {
            $tags = json_decode($tags);
            foreach ($tags as $tag) {
                WishlistTag::create([
                    'wishlist_id' => $wishlist_id,
                    'tag' => $tag->value
                ]);
            }
        }

        return back();
    }

    public function wishlist_edit($id, $wishlist_id)
    {
        $taget_wishlist = ComplexWishlist::findorfail($wishlist_id);
        if (!$taget_wishlist) {
            return back();
        }

        $complex = Complex::findOrFail($id);
        $contacts = Contact::all();

        $wishlists = ComplexWishlist::where('complex_id', $id)->get();


        $tag_wishlist_map =  [];

        foreach ($wishlists as $key => $wishlist) {
            $tag_key = "$id-$wishlist->contact_id";
            $tags = WishlistTag::where("wishlist_id", $wishlist->id)->get();
            $tag_wishlist_map[$tag_key] = $tags;
        }

        return view('complex/wishlist', compact('complex', 'contacts', 'tag_wishlist_map', 'wishlists', 'taget_wishlist'));
    }

    public function wishlist_update($id, $wishlist_id, Request $request)
    {
        $tags = $request->tags;
        WishlistTag::where([
            'wishlist_id' => $wishlist_id,
        ])->delete();
        if ($tags) {
            $tags = json_decode($tags);
            foreach ($tags as $tag) {
                WishlistTag::create([
                    'wishlist_id' => $wishlist_id,
                    'tag' => $tag->value
                ]);
            }
        }
        // return $request->all();
        return redirect()->route('complex.wishlist', $id);
    }

    public function wishlist_delete($wishlist_id)
    {
        $wishlist = ComplexWishlist::findorfail($wishlist_id);
        if ($wishlist) {
            $wishlist->delete();
        }
        return back();
    }

    public function preview_files($complex_id)
    {
        $complex = Complex::findorfail($complex_id);
        if (!$complex) {
            return back();
        }
        return view('complex/files', compact('complex'));
    }
}
