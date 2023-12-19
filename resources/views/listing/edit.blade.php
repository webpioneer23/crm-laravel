@extends('layouts/layoutMaster')

@section('title', 'Listing Create')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>

<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="{{asset('assets/js/forms-extras.js')}}"></script>

<script>
  formRepeater = $('.form-repeater-inspection');
  var row = 2;
  var col = 1;
  formRepeater.repeater({
    show: function() {
      var fromControl = $(this).find('.form-control, .form-select, .form-check-input');
      var formLabel = $(this).find('.form-label, .form-check-label');

      fromControl.each(function(i) {
        var id = 'form-repeater-' + row + '-' + col;
        $(fromControl[i]).attr('id', id);
        $(formLabel[i]).attr('for', id);
        col++;
      });

      row++;

      $(this).slideDown();
    },
    hide: function(e) {
      confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
    },
  });

  const list = <?php echo $listing->inspections; ?>;

  const initList = list.map(item => ({
    "inspection_type": item.inspection_type,
    "inspection_booking_setting": item.inspection_booking_setting,
    "inspection_date": item.inspection_date,
    "start_time": item.start_time,
    "end_time": item.end_time,
  }));

  if (initList.length > 0) {
    formRepeater.setList(initList)
  }
</script>
@endsection


@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Create /</span> Edit</h4>

<!-- Tabs -->
<div class="row">
  <div class="col-xl-12">
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link {{$listing->step == 1 ? 'active' : ''}}" role="tab" data-bs-toggle="tab" data-bs-target="#listing-detail" aria-controls="listing-detail" aria-selected="true">Listing Details</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link {{$listing->step == 2 ? 'active' : ''}}" role="tab" data-bs-toggle="tab" data-bs-target="#property-details" aria-controls="property-details" aria-selected="false">Property Details</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link {{$listing->step == 3 ? 'active' : ''}}" role="tab" data-bs-toggle="tab" data-bs-target="#image-copy" aria-controls="image-copy" aria-selected="false">Images and Copy</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link {{$listing->step == 4 ? 'active' : ''}}" role="tab" data-bs-toggle="tab" data-bs-target="#inspections" aria-controls="inspections" aria-selected="false">Inspections</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade {{$listing->step == 1 ? 'show active' : '' }}" id="listing-detail" role="tabpanel">
          <form method="post" action="{{route('listing.update', $listing->id)}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="step" value="2">
            <div class="content-header mb-3">
              <h5 class="mb-0">Change Status</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="status">Status</label>
                <?php
                $status_list = ["Draft", "Active", "Off Market", "Withdrawn", "Sold", "Under Offer"];
                ?>
                <select name="status" class="select2 form-select" id="status">
                  @foreach($status_list as $status_item)
                  <option value="{{$status_item}}" {{$listing->status == $status_item ? 'selected' : ''}}>{{$status_item}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-6">
                <div class="small fw-medium mb-3">Featured Property</div>
                <label class="switch">
                  <input class="form-check-input" type="checkbox" id="featured_property" name="featured_property" {{$listing->featured_property ? 'checked' : ''}}>
                  <span class="switch-label">Tick this box to display this property in featured areas on your website</span>
                </label>
              </div>
            </div>
            <div class="content-header mb-3">
              <h5 class="mb-0">About the listing</h5>
            </div>
            <div class="row g-3">
              <div class="col-sm-6">
                <?php
                $typelist = [
                  "Apartment", "Boat Shed", "Carpark", "Home & Income", "House", "Lifestyle Property", "Lifestyle Section", "Multiple Properties", "Retirement Living - Apartment", "Retirement Living - Unit",
                  "Retirement Living - Villa", "Section", "Studio", "Townhouse", "Unit"
                ];
                ?>
                <label class="form-label" for="property_type">Property Type *</label>
                <select name="property_type" class="select2 form-select" id="property_type">
                  @foreach($typelist as $type_item)
                  <option value="{{$type_item}}" {{$listing->property_type == $type_item ? 'selected' : ''}}>{{$type_item}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="established_development">Established or Development</label>
                <select name="established_development" class="select2 form-select" id="established_development">
                  <option value="Established Building" {{$listing->established_development == 'Established Building' ? 'selected' : ''}}>Established Building</option>
                  <option value="Under Development" {{$listing->established_development == 'Under Development' ? 'selected' : ''}}>Under Development</option>
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="home_package">Is Home and Land Package</label>
                <select name="home_package" class="select2 form-select" id="home_package">
                  <option value="No" {{$listing->home_package == 'No' ? 'selected' : ''}}>No</option>
                  <option value="Yes" {{$listing->home_package == 'Yes' ? 'selected' : ''}}>Yes</option>
                </select>
              </div>

              <div class="col-sm-6">
                <?php
                $authority_list = ["Auction", "Exclusive", "Multi List", "Conjunctional", "Open", "Sale by Negotiation"];
                ?>
                <label class="form-label" for="authority">Authority</label>
                <select name="authority" class="select2 form-select" id="authority">
                  @foreach($authority_list as $authority_item)
                  <option value="{{$authority_item}}" {{$listing->authority == $authority_item ? 'selected' : ''}}>{{$authority_item}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="office">Office</label>
                <select name="office" class="select2 form-select" id="office">
                  <option value="Lab Realty" {{$listing->office == 'Lab Realty' ? 'selected' : ''}}>Lab Realty</option>
                  <option value="Vivacity" {{$listing->office == 'Vivacity' ? 'selected' : ''}}>Vivacity</option>
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="expiry_date">Listing Expiry Date</label>
                <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="expiry_date" id="expiry_date" value="{{$listing->expiry_date}}" />
              </div>

              <div class="col-sm-6">
                <?php
                $price_type_list = ["Asking Price", "Enquiries Over", "Price By Negotiation", "Deadline Treaty", "Tender"];
                ?>
                <label class="form-label" for="price_type">Price Type</label>
                <select name="price_type" class="select2 form-select" id="price_type">
                  @foreach($price_type_list as $price_type_item)
                  <option value="{{$price_type_item}}" {{$listing->price_type == $price_type_item ? 'selected' : ''}}>{{$price_type_item}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="tender_deadline_date">Tender/Deadline Date</label>
                <input type="date" class="form-control" name="tender_deadline_date" id="tender_deadline_date" placeholder="YYYY-MM-DD" value="{{$listing->tender_deadline_date}}" />
              </div>


              <div class="col-sm-6">
                <label class="form-label" for="price">Price *</label>
                <div class="input-group">
                  <input type="number" id="price" name="price" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" value="{{$listing->price}}">
                  <span class="input-group-text">$</span>
                </div>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="display_price">Display Price </label>
                <div class="form-check mt-3">
                  <input name="display_price" class="form-check-input" type="radio" value="actual_price" id="actual_price" {{$listing->display_price == 'actual_price' ? 'checked' :''}} />
                  <label class="form-check-label" for="actual_price">
                    Show actual price
                  </label>
                </div>
                <div class="form-check">
                  <input name="display_price" class="form-check-input" type="radio" value="text" id="text" {{$listing->display_price == 'text' ? 'checked' :''}} />
                  <label class="form-check-label" for="text">
                    Show text instead of price
                  </label>
                </div>
                <input type="text" name="display_price_text" id="display_price_text" class="form-control form-control-sm" value="{{$listing->display_price_text}}">
                <div class="form-check">
                  <input name="display_price" class="form-check-input" type="radio" value="contact_agent" id="contact_agent" {{$listing->display_price == 'contact_agent' ? 'checked' :''}} />
                  <label class="form-check-label" for="contact_agent">
                    Hide the price and display 'Contact Agent'
                  </label>
                </div>

              </div>
            </div>

            <div class="content-header mb-3">
              <h5 class="mb-0">Vendor details</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="contact_id">Vendor</label>
                <select name="contact_id" class="select2 form-select" id="contact_id">
                  @foreach($contacts as $contact)
                  <option value="{{$contact->id}}" {{$listing->contact_id == $contact->id ? 'selected' : ''}}>{{$contact->first_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Property Address</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="address_id">Address</label>
                <div class="row">
                  <div class="col-sm-9">
                    <select id="address_id" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true">
                      @foreach($addresses as $address)
                      <option value="{{$address->id}}" {{$listing->address_id == $address->id ? 'selected' : ''}}>{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAddressModal">Add Property</button>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="display">Display</label>
                <select name="display" class="select2 form-select" id="display">
                  <option value="Full Address" {{$listing->display == 'Full Address' ? 'selected' : ''}}>Full Address</option>
                  <option value="Suburb Only" {{$listing->display == 'Suburb Only' ? 'selected' : ''}}>Suburb Only</option>
                </select>
              </div>
            </div>


            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Internal Notes</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="key_number">Key Number</label>
                <input name="key_number" class="form-control" type="text" id="key_number" value="{{$listing->key_number}}" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="key_location">Key Location</label>
                <input name="key_location" class="form-control" type="text" id="key_location" value="{{$listing->key_location}}" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="alarm_code">Alarm Code</label>
                <input name="alarm_code" class="form-control" type="text" id="alarm_code" value="{{$listing->alarm_code}}" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="internal_notes">Internal Notes</label>
                <input name="internal_notes" class="form-control" type="text" id="internal_notes" value="{{$listing->internal_notes}}" />
              </div>
            </div>

            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Rent Appraisal</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="rent_appraisal">Rent Appraisal</label>
                <input name="rent_appraisal" class="form-control" type="text" id="rent_appraisal" value="{{$listing->rent_appraisal}}" />
              </div>
              <div class="col-12 text-end">
                <!-- <div class="col-12 d-flex justify-content-between text-end"> -->
                <!-- <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button> -->
                <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade  {{$listing->step == 2 ? 'show active' : '' }}" id="property-details" role="tabpanel">
          @include('listing.property-details')
        </div>
        <div class="tab-pane fade {{$listing->step == 3 ? 'show active' : '' }}" id="image-copy" role="tabpanel">
          @include('listing.images-copy')
        </div>
        <div class="tab-pane fade {{$listing->step == 4 ? 'show active' : '' }}" id="inspections" role="tabpanel">
          @include('listing.inspections')
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Pills -->

@endsection