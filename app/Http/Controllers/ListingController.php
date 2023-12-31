<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AFile;
use App\Models\Contact;
use App\Models\Listing;
use App\Models\ListingInspection;
use App\Models\ListingTag;
use App\Models\Tag;
use App\Services\HistoryService;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Listing::all();
        return view('listing.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::all();
        $addresses = Address::all();
        return view('listing.create', compact('contacts', 'addresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        if (isset($data['featured_property']) && $data['featured_property'] == 'on') {
            $data['featured_property'] = 1;
        } else {
            $data['featured_property'] = 0;
        }
        $listing = Listing::create($data);

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'created',
            'source' => 'listing',
            'source_id' => $listing->id,
            // 'note' => $contact->first_name . " " . $contact->last_name,
        ];

        HistoryService::addRecord($history);


        return redirect()->route('listing.edit', $listing->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        $contacts = Contact::all();
        $addresses = Address::all();
        $tags = Tag::all();
        return view('listing.edit', compact('contacts', 'addresses', 'listing', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $data = $request->except('_token');

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'edited',
            'source' => 'listing',
            'source_id' => $listing->id,
            'note' => "ID: $listing->id",
        ];

        HistoryService::addRecord($history);


        if ($data['step'] == 2) {
            if (isset($data['featured_property']) && $data['featured_property'] == 'on') {
                $data['featured_property'] = 1;
            } else {
                $data['featured_property'] = 0;
            }
            $listing->update($data);
        }


        if ($data['step'] == 3) {
            if (isset($data['outdoor_features'])) {
                $data['outdoor_features'] = json_encode($data['outdoor_features']);
            }
            if (isset($data['indoor_features'])) {
                $data['indoor_features'] = json_encode($data['indoor_features']);
            }
            if (isset($data['heating_cooling'])) {
                $data['heating_cooling'] = json_encode($data['heating_cooling']);
            }
            if (isset($data['eco_friendly_features'])) {
                $data['eco_friendly_features'] = json_encode($data['eco_friendly_features']);
            }

            $listing->update($data);
            ListingTag::where('listing_id', $listing->id)->delete();
            if (isset($data['tag_id'])) {
                foreach ($data['tag_id'] as $tag_id) {
                    ListingTag::create([
                        'listing_id' => $listing->id,
                        'tag_id' => $tag_id,
                    ]);
                }
            }
        }

        if ($data['step'] == 4) {
            $listing->update($data);

            $img_order_ids = explode(',', $data['img_order']);
            if (count($img_order_ids) > 0) {
                foreach ($img_order_ids as $key => $img_order_id) {
                    if ($img_order_id) {
                        $priority = count($img_order_ids) - $key;
                        AFile::find($img_order_id)->update([
                            'priority' => $priority
                        ]);
                    }
                }
            }

            $floorplan_photos_ids = explode(',', $data['floorplan_photos']);
            if (count($floorplan_photos_ids) > 0) {
                foreach ($floorplan_photos_ids as $key1 => $floorplan_photos_id) {
                    if ($floorplan_photos_id) {
                        $priority = count($floorplan_photos_ids) - $key1;
                        AFile::find($floorplan_photos_id)->update([
                            'priority' => $priority
                        ]);
                    }
                }
            }

            $photos = $request->file('photos');
            if ($photos) {
                foreach ($photos as $key1 => $file) {
                    $attached_path = $file->store('files', 'images');
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->extension();
                    AFile::create([
                        'path' => $attached_path,
                        'file_name' => $file_name,
                        'file_ext' => $file_ext,
                        'target_id' => $listing->id,
                        'type' => 'listing_photo',
                        'priority' => 0 - $key1
                    ]);
                }
            }


            $floorplans = $request->file('floorplans');
            if ($floorplans) {

                AFile::where(['type' => 'listing_floorplans', 'target_id' => $listing->id])->delete();

                foreach ($floorplans as $file) {
                    $attached_path = $file->store('files', 'images');
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->extension();
                    AFile::create([
                        'path' => $attached_path,
                        'file_name' => $file_name,
                        'file_ext' => $file_ext,
                        'target_id' => $listing->id,
                        'type' => 'listing_floorplans',
                    ]);
                }
            }

            $documents = $request->file('documents');
            if ($documents) {
                foreach ($documents as $file) {
                    $attached_path = $file->store('files', 'images');
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->extension();
                    AFile::create([
                        'path' => $attached_path,
                        'file_name' => $file_name,
                        'file_ext' => $file_ext,
                        'target_id' => $listing->id,
                        'type' => 'listing_document',
                    ]);
                }
            }
        }

        if ($data['step'] == 5) {
            $data = $request['group-a'];
            ListingInspection::where([
                'listing_id' => $listing->id
            ])->delete();
            foreach ($data as $item) {
                $item['listing_id'] = $listing->id;
                ListingInspection::create($item);
            }
            return redirect()->route('listing.index');
        }


        return redirect()->route('listing.edit', $listing->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'deleted',
            'source' => 'listing',
            'source_id' => $listing->id,
            // 'note' => $contact->first_name . " " . $contact->last_name,
        ];

        HistoryService::addRecord($history);

        return back();
    }
}
