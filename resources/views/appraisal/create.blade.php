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
<script>
  function processStatus(status) {
    $(".pending-status").addClass("d-none");
    $(".lost-status").addClass("d-none");
    if (status == "Pending") {
      $(".pending-status").removeClass("d-none");
    }
    if (status == "Lost") {
      $(".lost-status").removeClass("d-none");
    }
  }

  $(document).on('change', '#status', function() {
    const status = $(this).val();
    processStatus(status);
  })

  function loadAddressProperty(addressId) {
    const selFields = [
      "bedroom",
      "bathroom",
      "ensuite",
      "toilet",
      "garage",
      "carport",
      "open_car",
      "living",
      "house_size_unit",
      "land_size_unit",
      "energy_efficiency_rating",
    ];
    const txtFields = [
      "house_size",
      "land_size",
    ];

    $.ajax({
      method: "get",
      url: "{{route('address.property')}}",
      data: {
        address_id: addressId
      },
      success: function(res) {
        console.log({
          res
        })
        if (res.status === 1) {
          const property = res.property;
          txtFields.map(item => {
            $(`#${item}`).val(property[item])
          })
          selFields.map(item => {
            $(`#${item}`).val(property[item]).select2()
          })
        } else {
          txtFields.map(item => {
            $(`#${item}`).val("")
          })
          selFields.map(item => {
            $(`#${item}`).val(0).select2()
          })
        }
      },
      error: function(err) {
        console.log({
          err
        })
      }
    })
  }

  $(document).on('change', '#address_id', function() {
    const addressId = $(this).val();
    loadAddressProperty(addressId)
  })
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Appraisal/</span> Create</h4>

<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('appraisal.store')}}">
        @csrf
        <div class="row">
          <div class="col-sm-6">
            <div class="content-header mb-3">
              <h5 class="mb-0">Appraisal Detail</h5>
            </div>
            <div class="row mb-3">
              <label class="form-check-label" for="address_id">Address</label>
              <div class="row">
                <div class="col-sm-9">
                  <select id="address_id" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true">
                    @foreach($addresses as $address)
                    <option value="{{$address->id}}">{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAddressModal">Add Property</button>
                </div>
              </div>
            </div>


            <div class="row mb-3">
              <label class="form-check-label" for="contact_id">Contact</label>
              <div class="row">
                <select id="contact_id" class="select2 form-select form-select-lg" name="contact_id" data-allow-clear="true">
                  @foreach($contacts as $contact)
                  <option value="{{$contact->id}}">{{$contact->first_name." ".$contact->last_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-form-label" for="price-range">Price Range</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="number" placeholder="Min" class="form-control" name="price_min">
                </div>
                <div class="col-md-6">
                  <input type="number" placeholder="Max" class="form-control" name="price_max">
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-form-label" for="appraisal_value">Appraisal Value</label>
              <div class="row">
                <input type="number" name="appraisal_value" class="form-control" placeholder="Appraisal Value" id="appraisal_value" />
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-form-label" for="basic-default-name">Due Date</label>
              <div class="row">
                <input type="date" name="due_date" id="due_date" class="form-control" placeholder="Due Date" />
              </div>
            </div>
            <?php
            $status_list = ["Preparing", "Pending", "Won", "Lost"];
            ?>
            <div class="row mb-3">
              <label class="col-form-label" for="status">Status</label>
              <div class="row">
                <select name="status" class="select2 form-select" id="status">
                  @foreach($status_list as $status)
                  <option value="{{$status}}">{{$status}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3 pending-status d-none">
              <label class="col-form-label" for="delivered_date">Delivered Date</label>
              <div class="row">
                <input type="datetime-local" name="delivered_date" id="delivered_date" class="form-control" placeholder="Delivered Date" />
              </div>
            </div>
            <?php
            $delivery_types = ["Electronic", "Physical"];
            ?>
            <div class="row mb-3 pending-status d-none">
              <label class="form-check-label">Delivery Type</label>
              @foreach($delivery_types as $key => $delivery_type)
              <div class="row">

                <div class="form-check form-check-inline">
                  <input name="delivery_type" class="form-check-input" id="{{$delivery_type}}" type="radio" value="{{$delivery_type}}" />
                  <label class="form-check-label" for="{{$delivery_type}}">{{$delivery_type}}</label>
                </div>
              </div>
              @endforeach
            </div>

            <div class="row mb-3 lost-status d-none">
              <label class="col-form-label" for="reason_lost">Reason Lost</label>
              <div class="row">
                <textarea name="reason_lost" id="reason_lost" class="form-control" rows="5" placeholder=""></textarea>
              </div>
            </div>

            <?php
            $interest_list = ["Cold", "Warm", "Hot"];
            ?>
            <div class="row mb-3">
              <label class="col-form-label" for="interest">Interest</label>
              <div class="row">


                <select name="interest" class="select2 form-select" id="interest">
                  @foreach($interest_list as $interest)
                  <option value="{{$interest}}">{{$interest}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="content-header mb-3">
              <h5 class="mb-0">Appraisal Property</h5>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="bedroom">Bedrooms</label>
              <select name="bedroom" class="select2 form-select" id="bedroom">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="bathroom">Bathrooms</label>
              <select name="bathroom" class="select2 form-select" id="bathroom">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>

            <div class="row mb-3">
              <label class="form-label" for="ensuite">Ensuites</label>
              <select name="ensuite" class="select2 form-select" id="ensuite">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>

            <div class="row mb-3">
              <label class="form-label" for="toilet">Toilets</label>
              <select name="toilet" class="select2 form-select" id="toilet">
                <option value="-1">-</option>
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>


            <div class="row mb-3">
              <label class="form-label" for="garage">Garage spaces</label>
              <select name="garage" class="select2 form-select" id="garage">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="carport">Carport spaces</label>
              <select name="carport" class="select2 form-select" id="carport">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="open_car">Open car spaces</label>
              <select name="open_car" class="select2 form-select" id="open_car">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="living">Living areas</label>
              <select name="living" class="select2 form-select" id="living">
                @for ($i = 0; $i < 51; $i++) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>
            <?php
            $house_size_unit_options = ['Square metres', 'Squares', 'Square feet'];
            $land_size_unit_options = ['Square metres', 'Squares', 'Square feet', 'Hectarea', 'Acres'];

            ?>
            <div class="row mb-3">
              <label class="form-label" for="house_size">House size</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="number" class="form-control" name="house_size" id="house_size" step="0.01">
                </div>
                <div class="col-md-6">

                  <select class="form-select" name="house_size_unit" id="house_size_unit">
                    @foreach($house_size_unit_options as $house_size_option)
                    <option value="{{$house_size_option}}">{{$house_size_option}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="land_size">Land size</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="number" class="form-control" name="land_size" id="land_size" step="0.01">
                </div>
                <div class="col-md-6">
                  <select class="form-select" name="land_size_unit" id="land_size_unit">
                    @foreach($land_size_unit_options as $land_size_unit_option)
                    <option value="{{$land_size_unit_option}}">{{$land_size_unit_option}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

            </div>
            <div class="row mb-3">
              <label class="form-label" for="energy_efficiency_rating">Energy efficiency rating</label>
              <select name="energy_efficiency_rating" class="select2 form-select" id="energy_efficiency_rating">
                <option value=" ">-</option>
                @for ($i = 0; $i <= 10; $i=$i + 0.5) <option value="{{$i}}">{{$i}}</option>
                  @endfor
              </select>
            </div>
          </div>
        </div>

        <div class="row justify-content-end">
          <div class="col-sm-4 text-end">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@include('contact/new-address')

@endsection