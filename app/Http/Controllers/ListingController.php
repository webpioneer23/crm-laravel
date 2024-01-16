<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AFile;
use App\Models\Contact;
use App\Models\Listing;
use App\Models\ListingInspection;
use App\Models\ListingPortal;
use App\Models\ListingPortalMap;
use App\Models\ListingSuburb;
use App\Models\ListingTag;
use App\Models\Tag;
use App\Services\HistoryService;
use App\Services\RealEstateService;
use Carbon\Carbon;
use Exception;
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
        $portals = ListingPortal::where('active', 1)->get();
        $contacts = Contact::all();
        $addresses = Address::all();
        return view('listing.create', compact('contacts', 'addresses', 'portals'));
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

        if ($request->portal) {
            foreach ($request->portal as $key => $portal) {
                ListingPortalMap::create([
                    'listing_id' => $listing->id,
                    'portal_id' => $portal,
                ]);
            }
        }

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

        $portals = ListingPortal::where('active', 1)->get();
        return view('listing.edit', compact('contacts', 'addresses', 'listing', 'tags', 'portals'));
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
            $data['step'] = max($listing->step, $data['step']);
            $listing->update($data);

            ListingPortalMap::where('listing_id', $listing->id)->delete();
            if ($request->portal) {
                foreach ($request->portal as $key => $portal) {
                    ListingPortalMap::create([
                        'listing_id' => $listing->id,
                        'portal_id' => $portal,
                    ]);
                }
            }
        } elseif ($data['step'] == 3) {
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
            $data['step'] = max($listing->step, $data['step']);


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
        } elseif ($data['step'] == 4) {
            $data['step'] = max($listing->step, $data['step']);

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
        } elseif ($data['step'] == 5) {
            $data = $request['group-a'];
            ListingInspection::where([
                'listing_id' => $listing->id
            ])->delete();
            foreach ($data as $item) {
                $item['listing_id'] = $listing->id;
                ListingInspection::create($item);
            }
            $listing->update([
                'step' => 5
            ]);
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
        ];

        HistoryService::addRecord($history);

        return back();
    }

    public function publish(Request $request)
    {
        try {
            $portal_id = $request->portal_id;
            $listing_id = $request->listing_id;
            $portal = ListingPortal::find($portal_id);
            $listing = Listing::find($listing_id);

            $base_url = $portal->base_url;

            $listing_portal_map = ListingPortalMap::where([
                'listing_id' => $listing_id,
                'portal_id' => $portal_id,
            ])->first();

            if (!$base_url) {
                return back()->with(["error" => "The base url for this portal has not been set."]);
            }

            if ($base_url == 'https://sandbox.realestate.co.nz') {

                $key = $portal->key;
                if (!$key) {
                    return back()->with(["error" => "The key for this portal has not been set."]);
                }
                $office_id = $portal->office_id;
                if (!$office_id) {
                    return back()->with(["error" => "The office_id for this portal has not been set."]);
                }

                $listing_request = RealEstateService::parsePostListing($listing, $office_id);

                $data = [
                    'key' => $key,
                    'request_data' => $listing_request,
                ];

                $listing_portal_map->update([
                    'status' => 'pending'
                ]);

                $history = [
                    'user_id' => auth()->user()->id,
                    'type' => 'pushed',
                    'source' => 'listingPortal',
                    'source_id' => $listing->id,
                    "note" => json_encode([
                        "listing_id" => $listing_id,
                        "portal_id" => $portal_id,
                        "status" => "Pending"
                    ]),
                    "note_json" => true
                ];

                HistoryService::addRecord($history);

                $publish_result = RealEstateService::postData("$base_url/feed/v1/listings", $data);

                $history_result = [];
                if (!$publish_result['status']) {
                    $listing_portal_map->update([
                        'status' => 'failed'
                    ]);

                    $history_result = [
                        'user_id' => auth()->user()->id,
                        'type' => 'pushed',
                        'source' => 'listingPortal',
                        'source_id' => $listing->id,
                        "note" => json_encode([
                            "listing_id" => $listing_id,
                            "portal_id" => $portal_id,
                            "status" => "Failed"
                        ]),
                        "note_json" => true
                    ];
                    return back()->with(["error" => "Something went wrong!"]);
                } else {
                    $push_data = json_decode($publish_result['data'], true);
                    $listing_portal_map->update([
                        'status' => 'published',
                        'push_id' => $push_data['data'][0]['id']
                    ]);

                    $history_result = [
                        'user_id' => auth()->user()->id,
                        'type' => 'pushed',
                        'source' => 'listingPortal',
                        'source_id' => $listing->id,
                        "note" => json_encode([
                            "listing_id" => $listing_id,
                            "portal_id" => $portal_id,
                            "status" => "Success",
                            'pushed_id' => $push_data['data'][0]['id'],
                        ]),
                        "note_json" => true
                    ];
                }

                HistoryService::addRecord($history_result);
            }
            return back()->with(['success' => "The listing has been successfully pushed!"]);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function re_publish(Request $request)
    {
        try {
            $portal_id = $request->portal_id;
            $listing_id = $request->listing_id;
            $portal = ListingPortal::find($portal_id);
            $listing = Listing::find($listing_id);

            $base_url = $portal->base_url;

            $listing_portal_map = ListingPortalMap::where([
                'listing_id' => $listing_id,
                'portal_id' => $portal_id,
            ])->first();

            if (!$base_url) {
                return back()->with(["error" => "The base url for this portal has not been set."]);
            }

            if ($base_url == 'https://sandbox.realestate.co.nz') {

                $key = $portal->key;
                if (!$key) {
                    return back()->with(["error" => "The key for this portal has not been set."]);
                }
                $office_id = $portal->office_id;
                if (!$office_id) {
                    return back()->with(["error" => "The office_id for this portal has not been set."]);
                }

                $listing_request = RealEstateService::parsePostListing($listing, $office_id, true, $listing_portal_map->push_id);

                $data = [
                    'key' => $key,
                    'request_data' => $listing_request,
                ];

                $listing_portal_map->update([
                    'status' => 'pending'
                ]);

                $history = [
                    'user_id' => auth()->user()->id,
                    'type' => 're-pushed',
                    'source' => 'listingPortal',
                    'source_id' => $listing->id,
                    "note" => json_encode([
                        "listing_id" => $listing_id,
                        "portal_id" => $portal_id,
                        "status" => "Pending"
                    ]),
                    "note_json" => true
                ];

                HistoryService::addRecord($history);

                $publish_result = RealEstateService::postData("$base_url/feed/v1/listings/$listing_portal_map->push_id", $data, false);
                $history_result = [];
                if (!$publish_result['status']) {
                    $listing_portal_map->update([
                        'status' => 'failed'
                    ]);

                    $history_result = [
                        'user_id' => auth()->user()->id,
                        'type' => 're-pushed',
                        'source' => 'listingPortal',
                        'source_id' => $listing->id,
                        "note" => json_encode([
                            "listing_id" => $listing_id,
                            "portal_id" => $portal_id,
                            "status" => "Failed"
                        ]),
                        "note_json" => true
                    ];
                    return back()->with(["error" => "Something went wrong!"]);
                } else {
                    $listing_portal_map->update([
                        'status' => 're-published',
                    ]);

                    $history_result = [
                        'user_id' => auth()->user()->id,
                        'type' => 're-pushed',
                        'source' => 'listingPortal',
                        'source_id' => $listing->id,
                        "note" => json_encode([
                            "listing_id" => $listing_id,
                            "portal_id" => $portal_id,
                            "status" => "Success",
                        ]),
                        "note_json" => true
                    ];
                }

                HistoryService::addRecord($history_result);
            }
            return back()->with(['success' => "The listing has been successfully repushed!"]);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function load_suburbs(Request $request)
    {
        $portal = ListingPortal::where('base_url', 'https://sandbox.realestate.co.nz')->first();

        $base_url = $portal->base_url;

        $publish_result = RealEstateService::getData("$base_url/feed/v1/suburbs");
        $listing_suburbs = $publish_result->data;
        foreach ($listing_suburbs as $suburb) {
            ListingSuburb::create([
                'suburb_id' => $suburb->id,
                'suburb_fq_slug' => $suburb->attributes->{'suburb-fq-slug'},
                'display_suburb_name' => $suburb->attributes->{'display-suburb-name'},
                'sdnid' => $suburb->attributes->sdnid,
                'dynamic_index' => $suburb->attributes->{'dynamic-index'},
                'suburb_name' => $suburb->attributes->{'suburb-name'},
                'district_name' => $suburb->attributes->{'district-name'},
                'region_name' => $suburb->attributes->{'region-name'},
            ]);
        }
        return 'success';
    }
}
