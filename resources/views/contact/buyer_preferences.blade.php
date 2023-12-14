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
            <a href="{{route('contact.edit', $contact->id)}}" class="nav-link "> Properties</a>
          </li>
          <li class="nav-item">
            <a href="{{route('contact.buyer_preferences', $contact->id)}}" class="nav-link active"> Preferences</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <form method="post" action="{{route('contact.update', $contact->id)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <input type="hidden" name="edit_type" value="buyer_preferences">

          <?php
          $listing_type_list = [
            "Any", "Residential sale", "Residential rental", "Land",
            "Commercial", "Rural", "Business"
          ];
          $unit_list = ["Square metres", "Squares", "Square feet", "Hectares", "Acres"];

          $listing_types = $contact->listing_types ? json_decode($contact->listing_types, true) : [];
          ?>
          <div class="row mb-3">
            <label class="form-check-label col-sm-2" for="listing_types">Listing Types</label>
            <div class="col-sm-10">
              <select id="listing_types" class="select2 form-select form-select-lg" name="listing_types[]" data-allow-clear="true" multiple>
                @foreach($listing_type_list as $listing_type)
                <option value="{{$listing_type}}" {{in_array($listing_type, $listing_types) ? 'selected' : ''}}>{{$listing_type}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-check-label col-sm-2" for="land_size_min">Land Size</label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-md-4">
                  <input type="number" placeholder="Min" class="form-control" name="land_size_min" value="{{$contact->land_size_min}}">
                </div>
                <div class="col-md-4">
                  <input type="number" placeholder="Max" class="form-control" name="land_size_max" value="{{$contact->land_size_max}}">
                </div>
                <div class="col-md-4">
                  <select class="form-select" name="land_size_unit">
                    @foreach($unit_list as $unit)
                    <option value="{{$unit}}" {{$contact->land_size_unit == $unit ? 'selected' : ''}}>{{$unit}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <label class="form-check-label col-sm-2" for="floor_sizse">Floor Size</label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-md-4">
                  <input type="number" placeholder="Min" class="form-control" name="floor_size_min" value="{{$contact->floor_size_min}}">
                </div>
                <div class="col-md-4">
                  <input type="number" placeholder="Max" class="form-control" name="floor_size_max" value="{{$contact->floor_size_max}}">
                </div>
                <div class="col-md-4">
                  <select class="form-select" name="floor_size_unit">
                    @foreach($unit_list as $unit)
                    <option value="{{$unit}}" {{$contact->floor_size_unit == $unit ? 'selected' : ''}}>{{$unit}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <label class="form-check-label col-sm-2" for="car_spaces">Car Spaces</label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-md-4">
                  <input type="number" placeholder="Min" class="form-control" name="car_spaces_min" value="{{$contact->car_spaces_min}}">
                </div>
                <div class="col-md-4">
                  <input type="number" placeholder="Max" class="form-control" name="car_spaces_max" value="{{$contact->car_spaces_max}}">
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <label class="form-check-label col-sm-2" for="suburbs">Suburbs</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="suburbs" id="suburbs" value="{{$contact->suburbs}}">
            </div>
          </div>

          <?php
          $property_tags = $contact->property_tags;
          ?>
          <div class="row mb-3">
            <label class="form-check-label col-sm-2" for="property_tags">Property Tags</label>
            <div class="col-sm-10">
              <select class="select2 form-select" name="property_tags[]" id="property_tags" multiple>
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" {{in_array($tag->id, $property_tags) ? 'selected' : ''}}>{{$tag->name}}</option>
                @endforeach
              </select>
            </div>
          </div>



          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="comments">Comments</label>
            <div class="col-sm-10">
              <textarea name="comments" id="comments" class="form-control" placeholder="">{{$contact->comments}}</textarea>
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