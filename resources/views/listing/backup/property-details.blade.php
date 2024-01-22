<form method="post" action="{{route('listing.update', $listing->id)}}">
    @csrf
    @method('PUT')
    <input type="hidden" name="step" value="3">
    <div class="content-header mb-3">
        <h5 class="mb-0">About the property</h5>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label class="form-label" for="bedrooms">Bedrooms</label>
            <select name="bedrooms" class="select2 form-select" id="bedrooms" required>
                <option value="">Select</option>
                @for ($i = 1; $i < 51; $i++) <option value="{{$i}}" {{$listing->bedrooms == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="bathrooms">Bathrooms</label>
            <select name="bathrooms" class="select2 form-select" id="bathrooms" required>
                <option value="">Select</option>
                @for ($i = 1; $i < 51; $i++) <option value="{{$i}}" {{$listing->bathrooms == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="ensuites">Ensuites</label>
            <select name="ensuites" class="select2 form-select" id="ensuites">
                <option value="">Select</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$listing->ensuites == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="toilets">Toilets</label>
            <select name="toilets" class="select2 form-select" id="toilets">
                <option value="">Select</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$listing->toilets == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>



        <div class="col-sm-6">
            <label class="form-label" for="garage_spaces">Garage spaces</label>
            <select name="garage_spaces" class="select2 form-select" id="garage_spaces">
                <option value="">Select</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$listing->garage_spaces == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="carport_spaces">Carport spaces</label>
            <select name="carport_spaces" class="select2 form-select" id="carport_spaces">
                <option value="">Select</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$listing->carport_spaces == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="open_car_spaces">Open car spaces</label>
            <select name="open_car_spaces" class="select2 form-select" id="open_car_spaces">
                <option value="">Select</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$listing->open_car_spaces == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="living_areas">Living areas</label>
            <select name="living_areas" class="select2 form-select" id="living_areas">
                <option value="">Select</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$listing->living_areas == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="house_size">House size</label>
            <div class="row">
                <div class="col-md-6">
                    <input type="number" class="form-control" name="house_size" value="{{$listing->house_size}}">
                </div>
                <div class="col-md-6">
                    <select class="form-select" name="house_size_unit">
                        <option value="SQM">Square metres</option>
                        <option value="HA">Hectarea</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="land_size">Land size</label>
            <div class="row">
                <div class="col-md-6">
                    <input type="number" class="form-control" name="land_size" value="{{$listing->land_size}}">
                </div>
                <div class="col-md-6">
                    <select class="form-select" name="land_size_unit">
                        <option value="SQM">Square metres</option>
                        <option value="HA">Hectarea</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="energy_efficiency_rating">Energy efficiency rating</label>
            <select name="energy_efficiency_rating" class="select2 form-select" id="energy_efficiency_rating">
                <option value=" ">-</option>
                @for ($i = 0; $i <= 10; $i=$i + 0.5) <option value="{{$i}}" {{$listing->energy_efficiency_rating == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="agency_reference">Agency Reference</label>
            <input type="text" class="form-control" name="agency_reference" id="agency_reference" value="{{$listing->agency_reference}}">
        </div>
        <div class="col-sm-6">
            <?php
            $tag_list = $listing->full_tags;
            ?>
            <label class="form-label" for="tag_id">Tag</label>
            <select name="tag_id[]" class="select2 form-select" id="tag_id" multiple>
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" {{in_array($tag->id, $tag_list) ? 'selected' : ''}}>{{$tag->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="sms_code">SMS Code</label>
            <input type="text" class="form-control" name="sms_code" id="sms_code" value="{{$listing->sms_code}}">
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="document_delivery_cma">Document Delivery - CMA</label>
            <input type="date" class="form-control" name="document_delivery_cma" value="{{$listing->document_delivery_cma}}" id="document_delivery_cma">
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="document_delivery_method_cma">Document Delivery Method - CMA</label>
            <input type="text" class="form-control" name="document_delivery_method_cma" value="{{$listing->document_delivery_method_cma}}" id="document_delivery_method_cma">
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="inhouse_complaints_guide">Document Delivery - AA / REA Guides / Inhouse Complaints Guide</label>
            <input type="date" class="form-control" name="inhouse_complaints_guide" id="inhouse_complaints_guide" value="{{$listing->inhouse_complaints_guide}}">
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="deed_assignment_requested">Deed of Assignment Requested</label>
            <input type="text" class="form-control" name="deed_assignment_requested" id="deed_assignment_requested" value="{{$listing->deed_assignment_requested}}">
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="floor_area_verified">Floor Area Verified (Size & Documentation of Verification)</label>
            <input type="text" class="form-control" name="floor_area_verified" id="floor_area_verified" value="{{$listing->floor_area_verified}}">
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="ax_listing_check_admin">AX Listing Check (Admin)</label>
            <input type="date" class="form-control" name="ax_listing_check_admin" id="ax_listing_check_admin" value="{{$listing->ax_listing_check_admin}}">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="ax_listing_check_mitch">AX Listing Check (Mitch)</label>
            <input type="date" class="form-control" name="ax_listing_check_mitch" id="ax_listing_check_mitch" value="{{$listing->ax_listing_check_mitch}}">
        </div>

        <div class="content-header mt-3">
            <h5 class="mb-0">Property features</h5>
        </div>

        <?php
        $outdoorFeatures = [
            'Balcony',
            'Deck',
            'Outdoor Entertainment Area',
            'Remote Garage',
            'Shed',
            'Swimming Pool - In Ground',
            'Courtyard',
            'Fully Fenced',
            'Outside Spa',
            'Secure Parking',
            'Swimming Pool - Above Ground',
            'Tennis Court',
        ];


        $indoorFeatures = [
            'Alarm System',
            'Built-in Wardrobes',
            'Ducted Vacuum System',
            'Gym',
            'Intercom',
            'Rumpus Room',
            'Workshop',
            'Broadband Internet Available',
            'Dishwasher',
            'Floorboards',
            'Inside Spa',
            'Pay TV Access',
            'Study',
        ];

        $heatingCoolingFeatures = [
            'Air Conditioning',
            'Ducted Heating',
            'Gas Heating',
            'Open Fireplace',
            'Split-System Air Conditioning',
            'Ducted Cooling',
            'Evaporative Cooling',
            'Hydronic Heating',
            'Reverse Cycle Air Conditioning',
            'Split-System Heating',
        ];
        $ecoFriendlyFeatures = [
            'Grey Water System',
            'Solar Panels',
            'Solar Hot Water',
            'Water Tank',
        ];
        $listing_outdoor_features = $listing->outdoor_features ? json_decode($listing->outdoor_features) : [];
        $listing_indoor_features = $listing->indoor_features ? json_decode($listing->indoor_features) : [];
        $listing_heating_cooling = $listing->heating_cooling ? json_decode($listing->heating_cooling) : [];
        $listing_eco_friendly_features = $listing->eco_friendly_features ? json_decode($listing->eco_friendly_features)  : [];


        ?>


        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <label class="">OUTDOOR FEATURES</label>
                <div class="row mt-3">
                    @foreach($outdoorFeatures as $key => $outdoor)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$outdoor}}" id="{{$outdoor}}" name="outdoor_features[]" {{in_array($outdoor, $listing_outdoor_features) ? 'checked' : ''}} />
                            <label class="form-check-label" for="{{$outdoor}}">
                                {{$outdoor}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-6">
                <label class="">INDOOR FEATURES</label>
                <div class="row mt-3">
                    @foreach($indoorFeatures as $key => $indoor)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$indoor}}" id="{{$indoor}}" name="indoor_features[]" {{in_array($indoor, $listing_indoor_features) ? 'checked' : ''}} />
                            <label class="form-check-label" for="{{$indoor}}">
                                {{$indoor}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-6">
                <label class="">HEATING / COOLING</label>
                <div class="row mt-3">
                    @foreach($heatingCoolingFeatures as $key => $heatingCooling)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$heatingCooling}}" id="{{$heatingCooling}}" name="heating_cooling[]" {{in_array($heatingCooling, $listing_heating_cooling) ? 'checked' : ''}} />
                            <label class="form-check-label" for="{{$heatingCooling}}">
                                {{$heatingCooling}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-6">
                <label class="">ECO FRIENDLY FEATURES</label>
                <div class="row mt-3">
                    @foreach($ecoFriendlyFeatures as $key => $ecoFriendly)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$ecoFriendly}}" id="{{$ecoFriendly}}" name="eco_friendly_features[]" {{in_array($ecoFriendly, $listing_eco_friendly_features) ? 'checked' : ''}} />
                            <label class="form-check-label" for="{{$ecoFriendly}}">
                                {{$ecoFriendly}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="other_features">Other Features</label>
        <textarea class="form-control" name="other_features" id="other_features" rows="3">{{$listing->other_features}}</textarea>
    </div>
    <div class="col-12 text-end">
        <!-- <div class="col-12 d-flex justify-content-between text-end"> -->
        <!-- <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button> -->
        <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
    </div>
</form>