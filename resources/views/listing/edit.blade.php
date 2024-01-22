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
<script src="{{asset('assets/vendor/libs/sortablejs/sortable.js')}}"></script>
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
    "inspection_date": item.inspection_date,
    "start_time": item.start_time,
    "end_time": item.end_time,
  }));

  if (initList.length > 0) {
    formRepeater.setList(initList)
  }


  // image sort
  const listingPhotos = document.getElementById('listing-photos');
  var sort1 = Sortable.create(listingPhotos, {
    animation: 150,
    group: 'imgList',
    store: {
      get: function(sortable) {
        var order = localStorage.getItem(sortable.options.group);
        return order ? order.split('|') : [];
      },
      set: function(sortable) {
        var order = sortable.toArray();
        $('.img-order').attr('value', order);
      }
    }
  });

  // floorplan sort
  const floorplanPhotos = document.getElementById('floorplan-photos');
  console.log({
    floorplanPhotos
  })
  var sort1 = Sortable.create(floorplanPhotos, {
    animation: 150,
    group: 'imgFloorplan',
    store: {
      get: function(sortable) {
        var order = localStorage.getItem(sortable.options.group);
        return order ? order.split('|') : [];
      },
      set: function(sortable) {
        var order = sortable.toArray();
        $('.floorplan-photos').attr('value', order);
      }
    }
  });

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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Listing /</span> Edit</h4>

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
        <li class="nav-item">
          <button type="button" class="nav-link {{$listing->step == 5 ? 'active' : ''}}" role="tab" data-bs-toggle="tab" data-bs-target="#portal" aria-controls="portal" aria-selected="false">Portal</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade {{$listing->step == 1 ? 'show active' : '' }}" id="listing-detail" role="tabpanel">
          <form method="post" action="{{route('listing.update', $listing->id)}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="step" value="2">
            <div class="row g-3 mb-3">
              <div class="col-sm-6 capitalize">
                <label class="form-label" for="status">Status *</label>
                <?php
                $status_list = ["draft", "active", "withdrawn", "sold", "under offer", "off market"];
                ?>
                <select name="status" class="select2 form-select" id="status" required>
                  @foreach($status_list as $status_item)
                  <option value="{{$status_item}}" {{$listing->status == $status_item ? 'selected' : ''}}>{{$status_item}}</option>
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
                  <option value="{{$category_code->listing_category_code}}" {{$listing->category_code == $category_code->listing_category_code ? 'selected' : ''}}>{{$category_code->listing_category_code}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="property_type">Property Type *</label>
                <select name="property_type" class="select2 form-select" id="property_type">
                  <option value="">Select One</option>
                  @foreach($property_type_list as $property_type_item)
                  <option value="{{$property_type_item->listing_property_type_code}}" {{$listing->property_type == $property_type_item->listing_property_type_code ? 'selected' : ''}}>{{$property_type_item->listing_property_type_code}}</option>
                  @endforeach
                </select>
              </div>


              <div class="col-sm-6">
                <label class="form-label" for="expiry_date">Listing Expiry Date</label>
                <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="expiry_date" id="expiry_date" value="{{$listing->expiry_date}}" />
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="price">Price *</label>
                <div class="input-group">
                  <input type="number" id="price" name="price" class="form-control" value="{{$listing->price}}" required>
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
                    <select id="address_id" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true" required>
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

            </div>

            <div class="content-header mt-3 mb-3">
              <h5 class="mb-0">Portals</h5>
            </div>
            <div class="row g-3 mb-3">
              <?php
              $portal_ids = $listing->portal_ids();
              ?>

              <div class="col-sm-6">
                <div class="small fw-medium mb-3">Available Portals</div>
                @foreach($portals as $key => $portal)
                <div class="mb-2">
                  <label class="switch">
                    <input type="checkbox" class="switch-input" name="portal[]" value="{{$portal->id}}" {{in_array($portal->id, $portal_ids) ? 'checked' : ''}} />
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
        <div class="tab-pane fade  {{$listing->step == 2 ? 'show active' : '' }}" id="property-details" role="tabpanel">
          @include('listing.property-details')
        </div>
        <div class="tab-pane fade {{$listing->step == 3 ? 'show active' : '' }}" id="image-copy" role="tabpanel">
          @include('listing.images-copy')
        </div>
        <div class="tab-pane fade {{$listing->step == 4 ? 'show active' : '' }}" id="inspections" role="tabpanel">
          @include('listing.inspections')
        </div>
        <div class="tab-pane fade {{$listing->step == 5 ? 'show active' : '' }}" id="portal" role="tabpanel">
          @include('listing.portal')
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Pills -->

@endsection