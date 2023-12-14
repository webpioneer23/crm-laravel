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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contact/</span> Edit</h4>


<div class="row">
  <div class="card mb-4">
    <div class="nav-align-top mb-4">
      <div class="card-header">
        <ul class="nav nav-pills mb-3" role="tablist">
          <li class="nav-item">
            <a href="{{route('contact.edit', $contact->id)}}" class="nav-link active"> Properties</a>
          </li>
          <li class="nav-item">
            <a href="{{route('contact.buyer_preferences', $contact->id)}}" class="nav-link"> Preferences</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <form method="post" action="{{route('contact.update', $contact->id)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row mb-3">
            <label class="form-check-label col-sm-2" for="contact_address">Residing Address (multiple)</label>
            <div class="col-sm-8">
              <?php
              $address_ids = [];
              foreach ($contact->full_address as $key => $add) {
                array_push($address_ids, $add->id);
              }
              ?>
              <select id="contact_address" class="select2 form-select form-select-lg" name="contact_address[]" data-allow-clear="true" multiple>
                @foreach($addresses as $address)
                <option value="{{$address->id}}" {{in_array($address->id, $address_ids) ? 'selected' : ''}}>{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}</option>
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
              <input type="text" value="{{$contact->first_name}}" name="first_name" class="form-control" placeholder="First Name" required />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">Last Name</label>
            <div class="col-sm-10">
              <input type="text" value="{{$contact->last_name}}" name="last_name" class="form-control" placeholder="Last Name" />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">Full Legal Name</label>
            <div class="col-sm-10">
              <input type="text" value="{{$contact->full_name}}" name="full_name" class="form-control" placeholder="Full Legal Name" />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">Mobile</label>
            <div class="col-sm-10">
              <input type="text" value="{{$contact->mobile}}" name="mobile" class="form-control" placeholder="Mobile" />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
            <div class="col-sm-10">
              <input type="email" value="{{$contact->email}}" name="email" class="form-control" placeholder="Email" />
            </div>
          </div>


          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-phone">Photo </label>
            <div class="col-sm-10">
              <input class="form-control" type="file" name="photo">
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-phone">Tags</label>
            <div class="col-sm-10">
              <input type="hidden" id="temp_tags" value="{{$contact->tags}}">
              <?php
              $tag_ids = [];
              foreach ($contact->full_tags as $key => $tag) {
                array_push($tag_ids, $tag->id);
              }
              ?>
              <select name="tags[]" class="select2 form-select" id="tags" multiple>
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" {{in_array($tag->id, $tag_ids) ? 'selected' : ''}}>{{$tag->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="form-check-label col-sm-2">Owner / Tenant</label>
            <div class="col-sm-10 mt-2">
              <div class="form-check form-check-inline">
                <input name="rent_type" class="form-check-input" id="rental-owner" type="radio" value="Owner" {{$contact->rent_type == 'Owner' ? 'checked' : ''}} />
                <label class="form-check-label" for="rental-owner">Owner</label>
              </div>
              <div class="form-check form-check-inline">
                <input name="rent_type" class="form-check-input" id="rental-tenant" type="radio" value="Tenant" {{$contact->rent_type == 'Tenant' ? 'checked' : ''}} />
                <label class="form-check-label" for="rental-tenant">Tenant</label>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-message">Notes</label>
            <div class="col-sm-10">
              <textarea name="notes" value="{{$contact->notes}}" class="form-control" placeholder=""></textarea>
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
</div>

@include('contact/new-address')

@endsection