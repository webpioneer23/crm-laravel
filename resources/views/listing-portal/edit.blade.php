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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Listing Portal/</span> Edit</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('listingPortal.update', $listingPortal->id)}}">
        @csrf
        @method('put')
        <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Portal Name</label>
          <input type="text" class="form-control" value="{{$listingPortal->name}}" name="name" placeholder="Tag Name" required />
        </div>
        <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Base Url</label>
          <input type="text" class="form-control" value="{{$listingPortal->base_url}}" name="base_url" placeholder="Tag Name" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">API Key</label>
          <input type="text" class="form-control" value="{{$listingPortal->key}}" name="key" placeholder="Tag Name" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Office Id</label>
          <input type="text" class="form-control" value="{{$listingPortal->office_id}}" name="office_id" placeholder="Tag Name" />
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>
@endsection