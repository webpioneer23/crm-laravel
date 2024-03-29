<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AddressContact;
use App\Models\Contact;
use App\Models\ContactRelationship;
use App\Models\Tag;
use App\Models\TagContact;
use App\Models\TagObject;
use Illuminate\Http\Request;
use App\Services\HistoryService;

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
            'residing_address' => $request->residing_address,
            'social_links' => $request->social_links,
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

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'created',
            'source' => 'contact',
            'source_id' => $contact->id,
            'note' => $contact->first_name . " " . $contact->last_name,
        ];

        HistoryService::addRecord($history);

        return redirect()->route('contact.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $relation_list = ContactRelationship::where('source_id', $contact->id)->get();

        return view('contact.overview', compact('contact', 'relation_list'));
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
        $history_type = "edited";
        $history_source = "contact";
        if (isset($request->edit_type) && $request->edit_type == 'buyer_preferences') {
            $old_contact = [
                'listing_types' => $contact->listing_types,
                "land_size_min" => $contact->land_size_min,
                "land_size_max" => $contact->land_size_max,
                "land_size_unit" => $contact->land_size_unit,
                "floor_size_min" => $contact->floor_size_min,
                "floor_size_max" => $contact->floor_size_max,
                "floor_size_unit" => $contact->floor_size_unit,
                "car_spaces_min" => $contact->car_spaces_min,
                "car_spaces_max" => $contact->car_spaces_max,
                "suburbs" => $contact->suburbs,
                "property_tags" => json_encode($contact->property_tags),
                "comments" => $contact->comments,
            ];

            $updated = $request->except('_token', '_method', 'edit_type');
            $updated['listing_types'] = json_encode($request->listing_types);
            $contact->update($updated);

            TagObject::where([
                'target_id' => $contact->id,
                'type' => 'contact_buyer'
            ])->delete();
            if ($request->property_tags) {
                foreach ($request->property_tags as $value) {
                    TagObject::create([
                        'target_id' => $contact->id,
                        'tag_id' => $value,
                        'type' => 'contact_buyer',
                    ]);
                }
            }
        } elseif (isset($request->edit_type) && $request->edit_type == 'relationship') {
            $data = $request->except('_token', 'edit_type');
            $data['source_id'] = $contact->id;

            ContactRelationship::create($data);

            $history_type = "created";
            $history_source = "contact relationship";

            $target_contact = Contact::find($data['target_id']);

            $history = [
                'user_id' => auth()->user()->id,
                'type' => $history_type,
                'source' => $history_source,
                'source_id' => $contact->id,
                'note' => "The " . $data['relationship'] . " relationship was created between $contact->first_name and $target_contact->first_name.",
            ];
            HistoryService::addRecord($history);

            return back();
        } else {
            $request->validate([
                'first_name' => 'required|string',
            ]);

            $old_contact = [
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'full_name' => $contact->full_name,
                'mobile' => $contact->mobile,
                'email' => $contact->email,
                'notes' => $contact->notes,
                'rent_type' => $contact->rent_type,
                'residing_address' => $contact->residing_address,
                'social_links' => $contact->social_links,
            ];

            $updated = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'full_name' => $request->full_name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'notes' => $request->notes,
                'rent_type' => $request->rent_type,
                'residing_address' => $request->residing_address,
                'social_links' => $request->social_links,
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
        }


        $diff = HistoryService::getObjectDifference($old_contact, $updated);

        $history = [
            'user_id' => auth()->user()->id,
            'type' => $history_type,
            'source' => $history_source,
            'source_id' => $contact->id,
            'note' => json_encode($diff),
            "note_json" => true
        ];
        HistoryService::addRecord($history);

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

    public function buyer_preferences($contact_id)
    {
        $tags = Tag::all();
        $contact = Contact::findOrFail($contact_id);
        return view('contact.buyer_preferences', compact('contact', 'tags'));
    }

    public function relationship($contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $contacts = Contact::where('id', '!=', $contact_id)->get();

        $list = ContactRelationship::where('source_id', auth()->user()->id)->get();
        return view('contact.contact-related', compact('contacts', 'contact', 'list'));
    }

    public function relationship_destroy($contact_relationship_id)
    {
        $contact_relationship = ContactRelationship::findorFail($contact_relationship_id);
        $source = Contact::find($contact_relationship->source_id);
        $target = Contact::find($contact_relationship->target_id);

        $contact_relationship->delete();

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'deleted',
            'source' => 'contact relationship',
            'source_id' => $contact_relationship_id,
            'note' => "The " . $contact_relationship['relationship'] . " relationship was deleted between $source->first_name and $target->first_name.",
        ];

        HistoryService::addRecord($history);

        return back();
    }
}
