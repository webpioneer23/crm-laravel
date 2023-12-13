@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB87UDyoVRfBpSKjUqto7YrwseLKlSY1Q4&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<script>
  let autocomplete;
  let address1Field;

  function initAutocomplete() {
    address1Field = document.querySelector("#street-address");
    // Create the autocomplete object, restricting the search predictions to
    // addresses in the US and Canada.
    autocomplete = new google.maps.places.Autocomplete(address1Field, {
      // componentRestrictions: {
      //   country: ["us", "ca"]
      // },
      fields: ["address_components", "geometry"],
      types: ["address"],
    });
    address1Field.focus();
    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    // autocomplete.addListener("place_changed", fillInAddress);
  }

  function fillInAddress() {

    // Get the place details from the autocomplete object.
    const place = autocomplete.getPlace();
    let address1 = "";

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    // place.address_components are google.maps.GeocoderAddressComponent objects
    // which are documented at http://goo.gle/3l5i5Mr
    for (const component of place.address_components) {
      // @ts-ignore remove once typings fixed
      const componentType = component.types[0];

      switch (componentType) {
        case "street_number": {
          address1 = `${component.long_name} ${address1}`;
          break;
        }

        case "route": {
          address1 += component.long_name;
          break;
        }
      }
    }

    document.querySelector("#street-address").value = address1;
  }
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Complex/</span> Edit</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Complex Detail</h5>
    </div>
    <div class="card-body">
      <form method="post" action="{{route('complex.update', $complex->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label" for="street-address">Street Address</label>
          <input type="text" class="form-control" id="street-address" name="street_address" value="{{$complex->street_address}}" placeholder="Street Address" required />
        </div>
        <div class="mb-3">
          <label class="form-label" for="complex_name">Complex Name</label>
          <input type="text" class="form-control" id="complex_name" name="name" value="{{$complex->name}}" placeholder="Complex Name" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="year-build">Year Built</label>
          <input type="text" class="form-control" id="year-build" name="year_built" value="{{$complex->year_built}}" placeholder="Year Built" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="Architect">Architect</label>
          <input type="text" class="form-control" id="Architect" name="architect" value="{{$complex->architect}}" placeholder="Architect" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="Constructor">Constructor</label>
          <input type="text" class="form-control" id="Constructor" name="constructor" value="{{$complex->constructor}}" placeholder="Constructor" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="number-units">Number of Units</label>
          <input type="number" class="form-control" id="number-units" name="number_units" value="{{$complex->number_units}}" placeholder="Number of Units" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="floors">Number of Floors</label>
          <input type="number" class="form-control" id="floors" name="number_floors" value="{{$complex->number_floors}}" placeholder="Number of Floors" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="property_type">Property Type</label>
          <select name="property_type" class="select2 form-select" id="property_type">
            <option value="Apartment" {{$complex->property_type == "Apartment" ? 'selected' : ''}}>Apartment</option>
            <option value="Townhouse" {{$complex->property_type == "Townhouse" ? 'selected' : ''}}>Townhouse</option>
            <option value="House" {{$complex->property_type == "House" ? 'selected' : ''}}>House</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="body_manager">Body Corporate Manager</label>
          <input type="text" class="form-control" name="body_manager" value="{{$complex->body_manager}}" id="body_manager" placeholder="Body Corporate Manager" />
        </div>

        <div class="mb-3">
          <label class="form-label" for="note">Notes</label>
          <textarea id="note" name="note" class="form-control" placeholder="Note">{{$complex->note}}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label" for="attached">Files</label>
          <input class="form-control" type="file" name="attached[]" accept=".pdf, .doc, .xls" multiple>
        </div>

        <div class="mb-3">
          <?php
          $address_ids = [];
          foreach ($complex->full_address as $key => $add) {
            array_push($address_ids, $add->id);
          }
          ?>
          <label class="form-label" for="complex_address">Addresses</label>
          <select id="complex_address" class="select2 form-select" name="complex_address[]" data-allow-clear="true" multiple>
            @foreach($address_list as $address)
            <option value="{{$address->id}}" {{in_array($address->id, $address_ids) ? 'selected' : ''}}>{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-primary float-end">Save</button>
      </form>
    </div>
  </div>
</div>

@endsection