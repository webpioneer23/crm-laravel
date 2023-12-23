<form method="post" action="{{route('appraisal.update', $appraisal->id)}}">
    @csrf
    @method('PUT')
    <input type="hidden" name="step" value="property">


    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="bedroom">Bedrooms</label>
        <div class="col-sm-10">

            <select name="bedroom" class="select2 form-select" id="bedroom">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->bedroom == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>
    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="bathroom">Bathrooms</label>
        <div class="col-sm-10">

            <select name="bathroom" class="select2 form-select" id="bathroom">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->bathroom == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>

    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="ensuite">Ensuites</label>
        <div class="col-sm-10">

            <select name="ensuite" class="select2 form-select" id="ensuite">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->ensuite == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>

    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="toilet">Toilets</label>
        <div class="col-sm-10">

            <select name="toilet" class="select2 form-select" id="toilet">
                <option value="-1">-</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->toilet == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>
    </div>


    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="garage">Garage spaces</label>
        <div class="col-sm-10">

            <select name="garage" class="select2 form-select" id="garage">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->garage == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>
    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="carport">Carport spaces</label>
        <div class="col-sm-10">

            <select name="carport" class="select2 form-select" id="carport">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->carport == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>
    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="open_car">Open car spaces</label>
        <div class="col-sm-10">

            <select name="open_car" class="select2 form-select" id="open_car">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->open_car == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>
    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="living">Living areas</label>
        <div class="col-sm-10">

            <select name="living" class="select2 form-select" id="living">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}" {{$appraisal->property?->living == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>
    <?php
    $house_size_unit_options = ['Square metres', 'Squares', 'Square feet'];
    $land_size_unit_options = ['Square metres', 'Squares', 'Square feet', 'Hectarea', 'Acres'];

    ?>
    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="house_size">House size</label>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-md-6">
                    <input type="number" class="form-control" name="house_size" id="house_size" value="{{$appraisal->property?->house_size}}" step="0.01">
                </div>
                <div class="col-md-6">

                    <select class="form-select" name="house_size_unit" id="house_size_unit">
                        @foreach($house_size_unit_options as $house_size_option)
                        <option value="{{$house_size_option}}" {{$house_size_option == $appraisal->property?->house_size_unit ? 'selected' : ''}}>{{$house_size_option}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="land_size">Land size</label>
        <div class="col-sm-10">

            <div class="row">
                <div class="col-md-6">
                    <input type="number" class="form-control" name="land_size" id="land_size" value="{{$appraisal->property?->land_size}}" step="0.01">
                </div>
                <div class="col-md-6">
                    <select class="form-select" name="land_size_unit" id="land_size_unit">
                        @foreach($land_size_unit_options as $land_size_unit_option)
                        <option value="{{$land_size_unit_option}}" {{$land_size_unit_option == $appraisal->property?->land_size ? 'selected' : ''}}>{{$land_size_unit_option}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

    </div>
    <div class="row mb-3">
        <label class="col-sm-2 form-label" for="energy_efficiency_rating">Energy efficiency rating</label>
        <div class="col-sm-10">

            <select name="energy_efficiency_rating" class="select2 form-select" id="energy_efficiency_rating">
                <option value=" ">-</option>
                @for ($i = 0; $i <= 10; $i=$i + 0.5) <option value="{{$i}}" {{$appraisal->property?->energy_efficiency_rating == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
            </select>
        </div>

    </div>

    <div class="row justify-content-end">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>