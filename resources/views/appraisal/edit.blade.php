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

  const initStatus = "<?php echo $appraisal->status; ?>";
  processStatus(initStatus);

  $(document).on('change', '#status', function() {
    const status = $(this).val();
    processStatus(status);
  })
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Appraisal/</span> Create</h4>

<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('appraisal.update', $appraisal->id)}}">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="address_id">Address</label>
          <div class="col-sm-8">
            <select id="address_id" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true">
              @foreach($addresses as $address)
              <option value="{{$address->id}}" {{$appraisal->address_id == $address->id ? 'selected' : ''}}>{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAddressModal">Add Property</button>
          </div>
        </div>


        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="contact_id">Contact</label>
          <div class="col-sm-10">
            <select id="contact_id" class="select2 form-select form-select-lg" name="contact_id" data-allow-clear="true">
              @foreach($contacts as $contact)
              <option value="{{$contact->id}}" {{$appraisal->contact_id == $contact->id ? 'selected' : ''}}>{{$contact->first_name." ".$contact->last_name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="price-range">Price Range</label>
          <div class="col-sm-10">
            <div class="row">
              <div class="col-md-6">
                <input type="number" placeholder="Min" class="form-control" name="price_min" value="{{$appraisal->price_min}}">
              </div>
              <div class="col-md-6">
                <input type="number" placeholder="Max" class="form-control" name="price_max" value="{{$appraisal->price_max}}">
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="appraisal_value">Appraisal Value</label>
          <div class="col-sm-10">
            <input type="number" name="appraisal_value" class="form-control" placeholder="Appraisal Value" id="appraisal_value" value="{{$appraisal->appraisal_value}}" />
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Due Date</label>
          <div class="col-sm-10">
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{$appraisal->due_date}}" placeholder="Due Date" />
          </div>
        </div>
        <?php
        $status_list = ["Preparing", "Pending", "Won", "Lost"];
        ?>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="status">Status</label>
          <div class="col-sm-10">
            <select name="status" class="select2 form-select" id="status">
              @foreach($status_list as $status)
              <option value="{{$status}}" {{$appraisal->status == $status ? 'selected' : ''}}>{{$status}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3 pending-status d-none">
          <label class="col-sm-2 col-form-label" for="delivered_date">Delivered Date</label>
          <div class="col-sm-10">
            <input type="datetime-local" name="delivered_date" id="delivered_date" value="{{$appraisal->delivered_date}}" class="form-control" placeholder="Delivered Date" />
          </div>
        </div>
        <?php
        $delivery_types = ["Electronic", "Physical"];
        ?>
        <div class="row mb-3 pending-status d-none">
          <label class="form-check-label col-sm-2">Delivery Type</label>
          <div class="col-sm-10 mt-2">
            @foreach($delivery_types as $key => $delivery_type)
            <div class="form-check form-check-inline">
              <input name="delivery_type" class="form-check-input" id="{{$delivery_type}}" type="radio" value="{{$delivery_type}}" {{$appraisal->delivery_type == $delivery_type ? 'checked' : ''}} />
              <label class="form-check-label" for="{{$delivery_type}}">{{$delivery_type}}</label>
            </div>
            @endforeach
          </div>
        </div>

        <div class="row mb-3 lost-status d-none">
          <label class="col-sm-2 col-form-label" for="reason_lost">Reason Lost</label>
          <div class="col-sm-10">
            <textarea name="reason_lost" id="reason_lost" class="form-control" rows="5" placeholder="">{{$appraisal->reason_lost}}</textarea>
          </div>
        </div>

        <?php
        $interest_list = ["Cold", "Warm", "Hot"];
        ?>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="interest">Interest</label>
          <div class="col-sm-10">
            <select name="interest" class="select2 form-select" id="interest">
              @foreach($interest_list as $interest)
              <option value="{{$interest}}" {{$appraisal->interest == $interest ? 'selected' : ''}}>{{$interest}}</option>
              @endforeach
            </select>
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