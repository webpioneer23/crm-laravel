@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="{{asset('assets/js/forms-extras.js')}}"></script>

<script>
  function loadAssociateList(addressId) {
    $.ajax({
      url: "{{route('associate.address')}}",
      type: 'get',
      data: {
        addressId
      },
      success: function(res) {

        let contactEle = '';
        let appraisalEle = '';
        let listingEle = '';

        const {
          contact_list,
          appraisal_list,
          listing_list
        } = res;
        console.log({
          contact_list,
          appraisal_list,
          listing_list
        });
        contactEle = contact_list.map(contact => `
          <option value="${contact.id}">${contact.first_name} ${contact.last_name}</option>
        `);
        appraisalEle = appraisal_list.map(appraisal => `
          <option value="${appraisal.id}">${appraisal.contact?.first_name} ${appraisal.contact?.last_name} ($${appraisal.price_min ? appraisal.price_min : ''}-$${appraisal.price_max ?appraisal.price_max:''})</option>
        `);
        listingEle = listing_list.map(listing => `
          <option value="${listing.id}">${listing?.vendor?.first_name} ${listing?.vendor?.last_name} ($${listing.price})</option>
        `);
        $("#contact").html(contactEle);
        $("#appraisal").html(appraisalEle);
        $("#listing").html(listingEle);

      },
      error: function(error) {
        console.log({
          error
        })
      }
    })
  }


  function handleAddress() {
    const addressId = $("#address").val();
    loadAssociateList(addressId)
  }

  function handleStatus() {
    const status = $("#status").val();
    $(".dynamic-ele").addClass("d-none");
    $(`.${status}-show`).removeClass("d-none");
  }
</script>

@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Lead/</span> Create</h4>

<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('lead.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Address</label>
          <div class="col-sm-10">
            <select id="address" placeholder="Select Address" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true" onchange="handleAddress()" required>
              <option value=""></option>
              @foreach($addresses as $address)
              <option value="{{$address->id}}"> {{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}} </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Contact</label>
          <div class="col-sm-10">
            <select id="contact" class="select2 form-select form-select-lg" name="contact[]" data-allow-clear="true" multiple>

            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="comment">Note</label>
          <div class="col-sm-10">
            <textarea name="note" class="form-control" placeholder=""></textarea>
          </div>
        </div>

        <?php
        $status_list = ["New", "Contacted", "Appointment Booked", "Appraised", "Won"];

        ?>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Status</label>
          <div class="col-sm-10">
            <select id="status" class="select2 form-select form-select-lg" name="status" data-allow-clear="true" onchange="handleStatus()">
              @foreach($status_list as $status)
              <option value="{{$status}}"> {{$status}} </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3 dynamic-ele Appraised-show d-none">
          <label class="form-check-label col-sm-2" for="purchasers">Appraisal</label>
          <div class="col-sm-10">
            <select id="appraisal" class="select2 form-select form-select-lg" name="appraisal[]" data-allow-clear="true" multiple>

            </select>
          </div>
        </div>

        <div class="row mb-3 dynamic-ele Won-show d-none">
          <label class="form-check-label col-sm-2" for="purchasers">Listing</label>
          <div class="col-sm-10">
            <select id="listing" class="select2 form-select form-select-lg" name="listing[]" data-allow-clear="true" multiple>

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

@endsection