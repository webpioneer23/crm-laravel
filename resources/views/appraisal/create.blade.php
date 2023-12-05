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
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Appraisal/</span> Create</h4>

<div class="row">
  <div class="card mb-4">
    <form class="card-body">
      <div class="row mb-3">
        <label class="col-sm-2" for="contacts">Contact</label>
        <div class="col-sm-10">
          <select id="contacts" class="select2 form-select form-select-lg" name="contacts[]" data-allow-clear="true" multiple>
            @foreach($contacts as $contact)
            <option value="{{$contact->id}}">{{$contact->first_name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <hr class="my-4 mx-n4" />

      <h6>What property are you appraising?</h6>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="listing_type">Listing Type *</label>
          <div class="">
            <select id="listing_type" class="select2 form-select form-select-lg" name="listing_type" data-allow-clear="true" required>
              <option value="Residential Sale">Residential Sale</option>
              <option value="Residential Rental">Residential Rental</option>
              <option value="Land">Land</option>
              <option value="Commercial">Commercial</option>
              <option value="Rural">Rural</option>
              <option value="Business">Business</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="property_type_appraisal">Property Type *</label>
          <div class="">
            <select id="property_type_appraisal" name="property_type" class="select2 form-select form-select-lg" data-allow-clear="true" required>
              <option value="Apartment">Apartment</option>
              <option value="Townhouse">Townhouse</option>
              <option value="Unit">Unit</option>
              <option value="Land">Land</option>
              <option value="House">House</option>
              <option value="Lifestyle">Lifestyle</option>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <label class="form-label" for="multicol-password">Residing Address</label>
          <div class="row">
            <div class="col-sm-10">
              <select id="appraisal_address" class="select2 form-select form-select-lg" name="appraisal_address[]" data-allow-clear="true" multiple>
                @foreach($addresses as $address)
                <option value="{{$address->id}}">{{$address->street}}, {{$address->city}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2 text-end">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAddressModal">Add Property</button>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-4 mx-n4" />
      <h6>What are the appraisal details?</h6>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="appraisal_date">Appraisal Date</label>
          <input type="text" id="appraisal_date" name="appraisal_date" class="form-control dob-picker" placeholder="YYYY-MM-DD" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="multicol-last-name">Who can see this appraisal</label>
          <div class="form-check mt-3">
            <input name="see_permission" class="form-check-input" type="radio" value="everyone" id="defaultCheck1" checked />
            <label class="form-check-label" for="defaultCheck1">
              Everyone in my account
            </label>
          </div>
          <div class="form-check">
            <input name="see_permission" class="form-check-input" type="radio" value="just_me" id="defaultCheck2" />
            <label class="form-check-label" for="defaultCheck2">
              Just Me
            </label>
          </div>
          <div class="form-check">
            <input name="see_permission" class="form-check-input" type="radio" value="me_plus" id="defaultCheck3" />
            <label class="form-check-label" for="defaultCheck3">
              Me plus...
            </label>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="multicol-country">Authority</label>
          <select id="multicol-country" class="select2 form-select" data-allow-clear="true">
            <option value="">Select</option>
            <option value="Australia">Auction</option>
            <option value="Bangladesh">Exclusive</option>
            <option value="Belarus">Multi List</option>
            <option value="Brazil">Conjunctional</option>
            <option value="Canada">Open</option>
            <option value="China">Sale by Negotiation</option>
          </select>
        </div>
      </div>
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
      </div>
    </form>
  </div>

</div>

@include('contact/new-address')

@endsection