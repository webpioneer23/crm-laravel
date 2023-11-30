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
          <label class="col-sm-2 col-form-label" for="basic-default-name">First Name *</label>
          <div class="col-sm-10">
            <input type="text" name="first_name" class="form-control" placeholder="First Name" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Last Name *</label>
          <div class="col-sm-10">
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Full Legal Name *</label>
          <div class="col-sm-10">
            <input type="text" name="full_name" class="form-control" placeholder="Full Legal Name" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Mobile *</label>
          <div class="col-sm-10">
            <input type="text" name="mobile" class="form-control" placeholder="Mobile" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Email *</label>
          <div class="col-sm-10">
            <input type="email" name="email" class="form-control" placeholder="Email" required />
          </div>
        </div>


        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-phone">Photo *</label>
          <div class="col-sm-10">
            <input class="form-control" type="file" name="photo" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-phone">Tags *</label>
          <div class="col-sm-10">
            <select name="tags[]" class="select2 form-select" multiple>
              @foreach($tags as $tag)
              <option value="{{$tag->id}}">{{$tag->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-message">Notes</label>
          <div class="col-sm-10">
            <textarea name="notes" class="form-control" placeholder=""></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2">Address *</label>
          <div class="col-sm-10 mt-2">
            <div class="form-check form-check-inline">
              <input name="address_type" class="form-check-input" value="new" id="new-address-type" type="radio" checked="" onclick="selectAddressType('new')" />
              <label class="form-check-label" for="new-address-type">New Address</label>
            </div>
            <div class="form-check form-check-inline">
              <input name="address_type" class="form-check-input" value="old" id="exist-address-type" type="radio" onclick="selectAddressType('exist')" />
              <label class="form-check-label" for="exist-address-type">Existing Address</label>
            </div>
          </div>
        </div>

        <div class="row mb-3 new-address">
          <label class="form-check-label col-sm-2"></label>
          <div class="col-sm-10">
            <textarea id="new_address" name="address" class="form-control" placeholder="" required></textarea>
          </div>
        </div>

        <div class="row mb-3 exist-address d-none">
          <label class="form-check-label col-sm-2"></label>
          <div class="col-sm-10">
            <select id="old_address" class="select2 form-select form-select-lg" name="address_old" data-allow-clear="true" required>
              @foreach($addresses as $address)
              <option value="{{$address->id}}">{{$address->street}}, {{$address->city}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function selectAddressType(type) {
    console.log({
      type
    })
    if (type === 'new') {
      $("#new_address").attr("name", 'address');
      $("#old_address").attr("name", 'old_address');
      $(".exist-address").addClass('d-none');
      $(".new-address").removeClass('d-none')
    } else {
      var newTextarea = $(".new-address textarea");
      // Remove the 'required' attribute
      newTextarea[0].removeAttribute('required');

      $("#new_address").attr("name", 'new_address');
      $("#old_address").attr("name", 'address');

      $(".exist-address").removeClass('d-none')
      $(".new-address").addClass('d-none');
    }
  }
</script>
@endsection