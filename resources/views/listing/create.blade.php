@extends('layouts/layoutMaster')

@section('title', 'Listing Create')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script>
  $("#price_type").change(function() {
    const prictType = $(this).val();
    if (["Tender", "Deadline Treaty"].includes(prictType)) {
      $("#tender_deadline_date_wrap").removeClass('d-none')
    } else {
      $("#tender_deadline_date_wrap").addClass('d-none')
    }
  })

  // category - property type
  function getPropertyTypeByCategory(categoryCode) {
    $.ajax({
      url: "{{route('listing.property')}}",
      data: {
        categoryCode,
        type: 'category-property-type'
      },
      success: function(res) {
        const propertyTypeList = res.map(pType =>
          `<option value="${pType.listing_property_type_code}">${pType.listing_property_type_code}</option>`);
        $('#property_type').html(propertyTypeList);
      },
      error: function(err) {
        console.log({
          err
        })
        alert("Something went wrong!");
      }
    })
  }
  $("#category_code").change(function(e) {
    const categoryCode = $(this).val();
    getPropertyTypeByCategory(categoryCode);
  })
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
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#listing-detail" aria-controls="listing-detail" aria-selected="true">Listing Details</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Property Details</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false">Images and Copy</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false">Inspections</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="listing-detail" role="tabpanel">
          <form method="post" action="{{route('listing.store')}}">
            @csrf
            <input type="hidden" name="step" value="2">
            <div class="row g-3 mb-3">
              <div class="col-sm-6 capitalize">
                <label class="form-label" for="status">Status *</label>
                <?php
                $status_list = ["draft", "active", "withdrawn", "sold", "under offer", "off market"];
                ?>
                <select name="status" class="select2 form-select" id="status" required>
                  @foreach($status_list as $status_item)
                  <option value="{{$status_item}}">{{$status_item}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label" for="status">Category *</label>
                <select name="category_code" class="select2 form-select" id="category_code" required>
                  <option value="">Select One</option>
                  @foreach($category_code_list as $category_code)
                  <option value="{{$category_code->listing_category_code}}">{{$category_code->listing_category_code}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="property_type">Property Type *</label>
                <select name="property_type" class="select2 form-select" id="property_type">
                </select>
              </div>


              <div class="col-sm-6">
                <label class="form-label" for="expiry_date">Listing Expiry Date</label>
                <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="expiry_date" id="expiry_date" value="" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="price">Price *</label>
                <div class="input-group">
                  <input type="number" id="price" name="price" class="form-control" value="" required>
                  <span class="input-group-text">$</span>
                </div>
              </div>

            </div>

            <div class="content-header mb-3 mt-3">
              <h5 class="mb-0">Vendor details</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="contact_id">Vendor</label>
                <select name="contact_id" class="select2 form-select" id="contact_id">
                  @foreach($contacts as $contact)
                  <option value="{{$contact->id}}">{{$contact->first_name}}</option>
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
                    <select id="address_id" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true" required>
                      @foreach($addresses as $address)
                      <option value="{{$address->id}}">{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAddressModal">Add Property</button>
                  </div>
                </div>
              </div>

            </div>

            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Portals</h5>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <div class="small fw-medium mb-3">Available Portals</div>
                @foreach($portals as $key => $portal)
                <div class="mb-2">
                  <label class="switch">
                    <input type="checkbox" class="switch-input" name="portal[]" value="{{$portal->id}}" />
                    <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                    </span>
                    <span class="switch-label">{{$portal->name}}</span>
                  </label>
                </div>
                @endforeach
              </div>


              <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Pills -->

@endsection