<form method="post" action="{{route('listing.update', $listing->id)}}">
    @csrf
    @method('PUT')
    <input type="hidden" name="step" value="3">
    <div class="content-header mb-3">
        <h5 class="mb-0">About the property</h5>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label class="form-label" for="bedrooms">Bedrooms *</label>
            <select name="bedrooms" class="select2 form-select" id="bedrooms" required>
                <option value="">Select</option>
                @for ($i = 1; $i < 51; $i++) <option value="{{$i}}" {{$listing->bedrooms == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="bathrooms">Bathrooms *</label>
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
            <label class="form-label" for="year_built">Year Built</label>
            <input type="number" id="year_built" name="year_built" class="form-control" value="{{$listing->year_built}}">
        </div>

    </div>

    <?php
    $size_units = [
        ["value" => "SQM", "label" => "Square metres"],
        ["value" => "HA", "label" => "Hectarea"],
    ]

    ?>

    <div class="row mt-3">
        <div class="col-sm-6">
            <label class="form-label" for="house_size">House size</label>
            <div class="row">
                <div class="col-md-6">
                    <input type="number" class="form-control" name="house_size" value="{{$listing->house_size}}">
                </div>
                <div class="col-md-6">
                    <select class="form-select" name="house_size_unit">
                        @foreach($size_units as $size_unit)
                        <option value="{{$size_unit['value']}}" {{$listing->house_size_unit == $size_unit['value'] ? 'selected': ''}}>{{$size_unit['label']}}</option>
                        @endforeach
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
                        @foreach($size_units as $size_unit)
                        <option value="{{$size_unit['value']}}" {{$listing->land_size_unit == $size_unit['value'] ? 'selected': ''}}>{{$size_unit['label']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6">
            <label class="form-label" for="energy_efficiency_rating">New Construction</label>
            <div class="d-flex">
                <div class="form-check me-2">
                    <input type="radio" id="is_new_construction_no" name="is_new_construction" value="0" class="form-check-input" {{$listing->is_new_construction == 0 ? 'checked' : ''}} />
                    <label class="form-check-label" for="is_new_construction_no">No</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="is_new_construction_yes" name="is_new_construction" value="1" class="form-check-input" {{$listing->is_new_construction == 1 ? 'checked' : ''}} />
                    <label class="form-check-label" for="is_new_construction_yes">Yes</label>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="energy_efficiency_rating">Coastal Waterfront</label>
            <div class="d-flex">
                <div class="form-check me-2">
                    <input type="radio" id="is_coastal_waterfront_no" name="is_coastal_waterfront" value="0" class="form-check-input" {{$listing->is_coastal_waterfront == 0 ? 'checked' : ''}} />
                    <label class="form-check-label" for="is_coastal_waterfront_no">No</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="is_coastal_waterfront_yes" name="is_coastal_waterfront" value="1" class="form-check-input" {{$listing->is_coastal_waterfront == 1 ? 'checked' : ''}} />
                    <label class="form-check-label" for="is_coastal_waterfront_yes">Yes</label>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="energy_efficiency_rating">Swimming Pool</label>
            <div class="d-flex">
                <div class="form-check me-2">
                    <input type="radio" id="has_swimming_pool_no" name="has_swimming_pool" value="0" class="form-check-input" {{$listing->has_swimming_pool == 0 ? 'checked' : ''}} />
                    <label class="form-check-label" for="has_swimming_pool_no">No</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="has_swimming_pool_yes" name="has_swimming_pool" value="1" class="form-check-input" {{$listing->has_swimming_pool == 1 ? 'checked' : ''}} />
                    <label class="form-check-label" for="has_swimming_pool_yes">Yes</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
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
    </div>
    <div class="row mt-3">
        <div class="col-12 text-end">
            <!-- <div class="col-12 d-flex justify-content-between text-end"> -->
            <!-- <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button> -->
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
        </div>
    </div>
</form>