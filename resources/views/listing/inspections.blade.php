<form method="post" action="{{route('listing.update', $listing->id)}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="step" value="5">
    <?php
    $inspection_type_list = ["Open", "Registration Required", "Private"];
    $inspection_setting_list = ["Use Account Defaults for Inspection Booking Settings", "Override Account Defaults for This Property"];

    ?>
    <div class="content-header mb-3">
        <h5 class="mb-0">NEW INSPECTION TIME</h5>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <label for="inspection_date" class="form-label">Date</label>
            <input class="form-control" type="date" id="inspection_date" name="inspection_date" value="{{$listing->inspection_date}}">
        </div>
        <div class="col-sm-6">
            <label for="start_time" class="form-label">Start Time</label>
            <input class="form-control" type="time" id="start_time" name="start_time" value="{{$listing->start_time}}">
        </div>
        <div class="col-sm-6">
            <label for="end_time" class="form-label">End Time</label>
            <input class="form-control" type="time" id="end_time" name="end_time" value="{{$listing->end_time}}">
        </div>
        <div class="col-sm-6">
            <label for="inspection_type" class="form-label">Inspection Type</label>
            <select class="form-select" name="inspection_type">
                @foreach($inspection_type_list as $type)
                <option value="{{$type}}" {{$type == $listing->inspection_type ? 'selected' : ''}}>{{$type}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="content-header mt-3">
        <h5 class="mb-0">INSPECTION BOOKING SETTINGS</h5>
    </div>
    <div class="col-md p-4">
        @foreach($inspection_setting_list as $inspection_set)
        <div class="form-check">
            <input name="inspection_booking_setting" class="form-check-input" type="radio" value="{{$inspection_set}}" id="{{$inspection_set}}" {{$inspection_set == $listing->inspection_booking_setting ? 'checked' : ''}} />
            <label class="form-check-label" for="{{$inspection_set}}">
                {{$inspection_set}}
            </label>
        </div>
        @endforeach
    </div>

    <div class="col-12 text-end">
        <!-- <div class="col-12 d-flex justify-content-between text-end"> -->
        <!-- <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button> -->
        <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
    </div>
</form>