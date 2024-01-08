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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Lead/</span> Edit</h4>

<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('lead.update', $lead->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Address</label>
          <div class="col-sm-10">
            <select id="address" placeholder="Select Address" class="select2 form-select form-select-lg" name="address_id" data-allow-clear="true" onchange="handleAddress()" required>
              <option value=""></option>
              @foreach($addresses as $address)
              <option value="{{$address->id}}" {{$lead->address_id == $address->id ? 'selected' : ''}}> {{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}} </option>
              @endforeach
            </select>
          </div>
        </div>

        <?php
        $lead_contact_ids = [];
        foreach ($lead->contact() as $lead_contact) {
          array_push($lead_contact_ids, $lead_contact->id);
        }
        ?>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Contact</label>
          <div class="col-sm-10">
            <select id="contact" class="select2 form-select form-select-lg" name="contact[]" data-allow-clear="true" multiple>
              @foreach($contact_list as $contact)
              <option value="{{$contact->id}}" {{ in_array($contact->id, $lead_contact_ids)? 'selected' : ''}}>{{$contact->first_name}} {{$contact->last_name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="comment">Note</label>
          <div class="col-sm-10">
            <textarea name="note" class="form-control" placeholder="">{{$lead->note}}</textarea>
          </div>
        </div>

        <?php
        $status_list = ["New", "Contacted", "Appointment Booked", "Appraised", "Won"];

        $appraisal_ids = [];
        foreach ($lead->appraisals() as $lead_appraisals) {
          array_push($appraisal_ids, $lead_appraisals->id);
        }

        $listing_ids = [];
        foreach ($lead->listings() as $lead_listings) {
          array_push($listing_ids, $lead_listings->id);
        }

        ?>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="purchasers">Status</label>
          <div class="col-sm-10">
            <select id="status" class="select2 form-select form-select-lg" name="status" data-allow-clear="true" onchange="handleStatus()">
              @foreach($status_list as $status)
              <option value="{{$status}}" {{$lead->status == $status ? 'selected' : ''}}> {{$status}} </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3 dynamic-ele Appraised-show {{$lead->status == 'Appraised' ? '' : 'd-none'}}">
          <label class="form-check-label col-sm-2" for="purchasers">Appraisal</label>
          <div class="col-sm-10">
            <select id="appraisal" class="select2 form-select form-select-lg" name="appraisal[]" data-allow-clear="true" multiple>
              @foreach($appraisal_list as $appraisal)
              <option value="{{$appraisal->id}}" {{ in_array($appraisal->id, $appraisal_ids)? 'selected' : ''}}> {{$appraisal->contact?->last_name}} ${{$appraisal->price_min}} ~ ${{$appraisal->price_max}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3 dynamic-ele Won-show  {{$lead->status == 'Won' ? '' : 'd-none'}}">
          <label class="form-check-label col-sm-2" for="purchasers">Listing</label>
          <div class="col-sm-10">
            <select id="listing" class="select2 form-select form-select-lg" name="listing[]" data-allow-clear="true" multiple>
              @foreach($listing_list as $listing)
              <option value="{{$listing->id}}" {{ in_array($listing->id, $listing_ids)? 'selected' : ''}}>{{$listing->vendor?->first_name}} {{$listing->vendor?->last_name}} (${{$listing->price}})</option>
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

@endsection