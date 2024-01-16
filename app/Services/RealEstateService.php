<?php

namespace App\Services;

use App\Models\Address;
use App\Models\AFile;
use App\Models\History;
use App\Models\ListingSuburb;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\URL;

class RealEstateService
{
    public static function parsePostListing($listing, $office_id, $is_edit = false, $push_id = "")
    {
        $address = Address::find($listing->address_id);

        $floorplans = [];

        $floorplans_obs = AFile::where([
            'target_id' => $listing->id,
            'type' => 'listing_floorplans',
        ])->get();

        foreach ($floorplans_obs as $floorplans_ob) {
            if ($floorplans_ob->path) {
                array_push($floorplans, [
                    "url" => URL::asset('uploads/' . $floorplans_ob->path),
                    "order" => $floorplans_ob->priority == 0 ? 1 : $floorplans_ob->priority,
                ]);
            }
        }

        $address_suburb_fq_slug = $address->suburb;
        $address_suburb_fq_slug = str_replace(" City", "", $address_suburb_fq_slug);


        $suburb_fq_slug_ob = ListingSuburb::where('suburb_name', $address_suburb_fq_slug)->first();
        if (!$suburb_fq_slug_ob) {
            return back()->with(["error" => "No matching suburbs found in DB."]);
        }
        $suburb_fq_slug = $suburb_fq_slug_ob->suburb_fq_slug;

        $listing_attr = [
            // "listing-no" => "TG01217",
            "listing-no" => "AACRON$listing->id",
            "date-of-last-change" => Carbon::now('Pacific/Auckland')->format('Y-m-d\TH:i:sP'),
            "listing-status" => $listing->status,
            "listing-category-code" => "res_sale", // inject
            "listing-property-type-code" => "RESHOU", // inject
            "address" => [
                "suburb-fq-slug" => $suburb_fq_slug,
                // "suburb-fq-slug" => "canterbury_christchurch-city_christchurch-central_christchurch-central",
                // "building-name" => $address->building,
                // "unit-number" => $address->unit_number,
                "street-name" => $address->street,
                // "street-number" => '67', //
                "pub-address-web" => true,
            ],

            "bedroom-count" => max(intval($listing->bedrooms), 1),
            "bathroom-full-count" => max(intval($listing->bathrooms), 1),
            "sale-type-code" => "sole", //dev
            "pricing-type-code" => "auction",
            "price" => intval($listing->price),
            "is-gst-included" => true,
            "is-com-lease-by-sqm" => false,
            "header" => $listing->headline,
            "description" => $listing->description,
            "floorplans" => $floorplans,
        ];

        if ($listing->video_url) {
            $listing_attr['videos'] =  [
                [
                    "url" => $listing->video_url,
                    "order" => 1
                ]
            ];
        }

        if (intval($listing->ensuites) > 0) {
            $listing_attr['bathroom-ensuite-count'] = intval($listing->ensuites);
        }
        if (intval($listing->toilets) > 0) {
            $listing_attr['bathroom-wc-count'] = intval($listing->toilets);
        }
        if (intval($listing->garage_spaces) > 0) {
            $listing_attr['parking-garage-count'] = intval($listing->garage_spaces);
        }
        if (intval($listing->carport_spaces) > 0) {
            $listing_attr['parking-covered-count'] = intval($listing->carport_spaces);
        }
        if (intval($listing->open_car_spaces) > 0) {
            $listing_attr['parking-other-count'] = intval($listing->open_car_spaces);
        }


        if ($listing->house_size) {
            $listing_attr['floor-area'] = floatval($listing->house_size);
        }

        if ($listing->house_size) {
            $listing_attr['floor-area-unit'] = $listing->house_size_unit;
        }

        if ($listing->house_size) {
            $listing_attr['land-area'] = floatval($listing->land_size);
        }

        if ($listing->house_size) {
            $listing_attr['land-area-unit'] = $listing->land_size_unit;
        }

        if (!$is_edit) {
            $listing_request = [
                "data" => [
                    "type" => "listing",
                    "attributes" => $listing_attr,
                    "relationships" => [
                        "offices" => [
                            "data" => [
                                [
                                    "type" => "office",
                                    "id" => $office_id
                                ]
                            ]
                        ],
                        // "agents" => [
                        //     "data" => [
                        //         [
                        //             "type" => "agent",
                        //             "id" => 552994
                        //         ]
                        //     ]
                        // ]
                    ]
                ]
            ];
        } else {
            $listing_request = [
                "data" => [
                    "id" => $push_id,
                    "type" => "listing",
                    "attributes" => $listing_attr,
                    "relationships" => [
                        "offices" => [
                            "data" => [
                                [
                                    "type" => "office",
                                    "id" => $office_id
                                ]
                            ]
                        ],
                        // "agents" => [
                        //     "data" => [
                        //         [
                        //             "type" => "agent",
                        //             "id" => 552994
                        //         ]
                        //     ]
                        // ]
                    ]
                ]
            ];
        }



        return $listing_request;
    }

    public static function postData($url, $data, $is_post = true)
    {
        try {
            $client = new Client();
            $key = $data['key'];

            $requestParams = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $key",
                ],
                'json' => $data['request_data'],
            ];

            \Log::info($requestParams);

            if ($is_post) {
                \Log::info("post data---");
                $response = $client->post($url, $requestParams);
            } else {
                \Log::info("put data---");
                $response = $client->put($url, $requestParams);
            }

            \Log::info("success response");
            $responseBody = $response->getBody();
            return [
                'status' => true,
                'data' => $responseBody
            ];
        } catch (Exception $e) {
            \Log::info($e);
            return [
                'status' => false,
                'data' => null
            ];
        }
    }

    public static function getData($url)
    {
        $client = new Client();

        $key = config('services.realestate.key');

        $res = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => "Bearer $key",
            ]
        ]);
        $res_body = $res->getBody()->getContents();
        $res_body = json_decode($res_body);
        return $res_body;
    }
}
