<form method="post" action="{{route('listing.update', $listing->id)}}" class="form-repeater-inspection">
    @csrf
    @method('PUT')
    <input type="hidden" name="step" value="5">
    <?php
    $inspection_type_list = ["Open", "Registration Required", "Private"];
    $inspection_setting_list = ["Use Account Defaults for Inspection Booking Settings", "Override Account Defaults for This Property"];
    ?>
    <div data-repeater-list="group-a">
        <div data-repeater-item>
            <div class="content-header mb-3">
                <h5 class="mb-0">NEW INSPECTION TIME</h5>
            </div>
            <div class="row g-3 ">
                <div class="col-sm-6">
                    <label class="form-label" for="form-repeater-1-1">Date</label>
                    <input class="form-control" type="date" name="inspection_date" id="form-repeater-1-1">
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="form-repeater-1-2">Start Time</label>
                    <input class="form-control" type="time" name="start_time" id="form-repeater-1-2">
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="form-repeater-1-3">End Time</label>
                    <input class="form-control" type="time" name="end_time" id="form-repeater-1-3">
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="form-repeater-1-4">Inspection Type</label>
                    <select class="form-select" name="inspection_type" id="form-repeater-1-4">
                        @foreach($inspection_type_list as $type)
                        <option value="{{$type}}" {{$type == $listing->inspection_type ? 'selected' : ''}}>{{$type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 p-4">
                    <button class="btn btn-label-danger mt-4" data-repeater-delete>
                        <i class="ti ti-x ti-xs me-1"></i>
                        <span class="align-middle">Delete</span>
                    </button>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <div class="mb-0">
        <button type="button" class="btn btn-primary" data-repeater-create>
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">Add</span>
        </button>
    </div>
    <div class="col-12 text-end">
        <!-- <div class="col-12 d-flex justify-content-between text-end"> -->
        <!-- <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button> -->
        <button type="submit" class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
    </div>
</form>