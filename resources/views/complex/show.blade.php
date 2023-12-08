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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Complex/</span> Addresses & Contacts</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <!-- Basic Layout -->
  <div class="col-xl-4">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Addresses</h5>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th>Type</th>
              <th>Street</th>
              <th>City</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($complex->full_address as $addr)
            <tr>
              <td> {{$addr->property_type}}</td>
              <td> {{$addr->street}}</td>
              <td> {{$addr->city}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Basic with Icons -->
  <div class="col-xl-8">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Connected Contacts</h5>
      </div>
      <div class="card-body">
        <form class="dt_adv_search" method="get">
          <div class="row">
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12 col-sm-4 col-lg-4">
                  <label class="form-label" for="include_tags">Include Tags:</label>
                  <?php
                  $include_tags = Request::get('include_tags') ? Request::get('include_tags') : [];
                  $exclude_tags = Request::get('exclude_tags') ? Request::get('exclude_tags') : [];
                  ?>
                  <select name="include_tags[]" class="select2 form-select" id="include_tags" multiple>
                    @foreach($tags as $tag1)
                    <option value="{{$tag1->id}}" {{in_array($tag1->id, $include_tags) ? 'selected' : ''}}>{{$tag1->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-12 col-sm-4 col-lg-4">
                  <label class="form-label">Exclude Tags:</label>
                  <select name="exclude_tags[]" class="select2 form-select" id="exclude_tags" multiple>
                    @foreach($tags as $tag2)
                    <option value="{{$tag2->id}}" {{in_array($tag2->id, $exclude_tags) ? 'selected' : ''}}>{{$tag2->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-12 col-sm-4 col-lg-4 d-flex align-items-end">
                  <button type="submit" class="btn btn-info">Filter</button>
                  <a href="{{route('complex.show', $complex->id)}}" class="btn btn-danger ms-2">Reset</a>
                </div>
              </div>
            </div>
        </form>
      </div>
      <hr class="mt-3">
      <div class="card-datatable table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>FIRST NAME</th>
              <th>CONTACT INFO </th>
              <th>TAGS</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($contacts as $item)
            <tr>
              <td>
                @if($item->photo)
                <img src="{{ asset('uploads/' . $item->photo) }}" width="80" height="60" alt="{{$item->first_name}}" class="radius-10">
                @else
                <img src="{{ asset('assets/custom/img/default-house.png') }}" width="80" height="60" alt="{{$item->first_name}}" class="radius-10">
                @endif
              </td>
              <td> {{$item->first_name}}</td>
              <td>
                {{$item->email}} <br />
                {{$item->mobile}}
              </td>
              <td>
                @foreach($item->full_tags as $tag)
                <ul>
                  <li>{{$tag->name}}</li>
                </ul>
                @endforeach
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection