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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contact/</span> Create</h4>

<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('contact.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="residing_address">Residing Address</label>
          <div class="col-sm-10">
            <select id="residing_address" class="select2 form-select form-select-lg" name="residing_address" data-allow-clear="true">
              @foreach($addresses as $address)
              <option value="{{$address->id}}">{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
              @endforeach
            </select>
          </div>
        </div>


        <div class="row mb-3">
          <label class="form-check-label col-sm-2" for="contact_address">Properties Owned (multiple)</label>
          <div class="col-sm-8">
            <select id="contact_address" class="select2 form-select form-select-lg" name="contact_address[]" data-allow-clear="true" multiple>
              @foreach($addresses as $address)
              <option value="{{$address->id}}">{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAddressModal">Add Property</button>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">First Name *</label>
          <div class="col-sm-10">
            <input type="text" name="first_name" class="form-control" placeholder="First Name" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Last Name</label>
          <div class="col-sm-10">
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Full Legal Name</label>
          <div class="col-sm-10">
            <input type="text" name="full_name" class="form-control" placeholder="Full Legal Name" />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Mobile</label>
          <div class="col-sm-10">
            <input type="text" name="mobile" class="form-control" placeholder="Mobile" />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
          <div class="col-sm-10">
            <input type="email" name="email" class="form-control" placeholder="Email" />
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-phone">Photo</label>
          <div class="col-sm-10">
            <input class="form-control" type="file" name="photo">
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-phone">Tags</label>
          <div class="col-sm-10">
            <input type="hidden" id="temp_tags">
            <select name="tags[]" class="select2 form-select" id="tags" multiple>
              @foreach($tags as $tag)
              <option value="{{$tag->id}}">{{$tag->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <label class="form-check-label col-sm-2">Owner / Tenant</label>
          <div class="col-sm-10 mt-2">
            <div class="form-check form-check-inline">
              <input name="rent_type" class="form-check-input" id="rental-owner" type="radio" value="Owner" checked />
              <label class="form-check-label" for="rental-owner">Owner</label>
            </div>
            <div class="form-check form-check-inline">
              <input name="rent_type" class="form-check-input" id="rental-tenant" type="radio" value="Tenant" />
              <label class="form-check-label" for="rental-tenant">Tenant</label>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="social_links">Social Links</label>
          <div class="col-sm-10">
            <textarea name="social_links" class="form-control" rows="5" placeholder=""></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-message">Notes</label>
          <div class="col-sm-10">
            <textarea name="notes" class="form-control" placeholder=""></textarea>
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