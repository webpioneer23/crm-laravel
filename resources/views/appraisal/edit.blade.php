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
  const tags = $("#temp_tags").val();

  const tag_list = JSON.parse(tags);
  $("#tags").val(tag_list);
  console.log({
    tag_list
  })

  function selectAddressType(type) {
    console.log({
      type
    })
    if (type === 'new') {
      $(".exist-address").addClass('d-none');
      $(".new-address").removeClass('d-none')
    } else {
      var newTextarea = $(".new-address textarea");
      // Remove the 'required' attribute
      newTextarea[0].removeAttribute('required');

      $(".exist-address").removeClass('d-none')
      $(".new-address").addClass('d-none');
    }
  }
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contact/</span> Edit</h4>


<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="{{route('contact.update', $contact->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">First Name *</label>
          <div class="col-sm-10">
            <input type="text" value="{{$contact->first_name}}" name="first_name" class="form-control" placeholder="First Name" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Last Name *</label>
          <div class="col-sm-10">
            <input type="text" value="{{$contact->last_name}}" name="last_name" class="form-control" placeholder="Last Name" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Full Legal Name *</label>
          <div class="col-sm-10">
            <input type="text" value="{{$contact->full_name}}" name="full_name" class="form-control" placeholder="Full Legal Name" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Mobile *</label>
          <div class="col-sm-10">
            <input type="text" value="{{$contact->mobile}}" name="mobile" class="form-control" placeholder="Mobile" required />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-name">Email *</label>
          <div class="col-sm-10">
            <input type="email" value="{{$contact->email}}" name="email" class="form-control" placeholder="Email" required />
          </div>
        </div>


        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-phone">Photo </label>
          <div class="col-sm-10">
            <input class="form-control" type="file" name="photo">
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-phone">Tags *</label>
          <div class="col-sm-10">
            <input type="hidden" id="temp_tags" value="{{$contact->tags}}">
            <select name="tags[]" class="select2 form-select" id="tags" multiple>
              @foreach($tags as $tag)
              <option value="{{$tag->id}}">{{$tag->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-message">Notes</label>
          <div class="col-sm-10">
            <textarea name="notes" value="{{$contact->notes}}" class="form-control" placeholder=""></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <label class="form-check-label col-sm-2">Address *</label>
          <div class="col-sm-10 mt-2">
            <div class="form-check form-check-inline">
              <input name="address_type" class="form-check-input" id="new-address-type" type="radio" value="new" {{$contact->address_type == 'new' ? 'checked' : ''}} onclick="selectAddressType('new')" />
              <label class="form-check-label" for="new-address-type">New Address</label>
            </div>
            <div class="form-check form-check-inline">
              <input name="address_type" class="form-check-input" id="exist-address-type" type="radio" value="old" {{$contact->address_type == 'old' ? 'checked' : ''}} onclick="selectAddressType('exist')" />
              <label class="form-check-label" for="exist-address-type">Existing Address</label>
            </div>
          </div>
        </div>

        <div class="row mb-3 new-address {{$contact->address_type == 'new' ? '' : 'd-none'}}">
          <label class="form-check-label col-sm-2"></label>
          <div class="col-sm-10">
            <textarea id="new_address" name="address_new" class="form-control" placeholder="" required>{{$contact->address_type == 'new' ? $contact->address : ''}}
            </textarea>
          </div>
        </div>

        <div class="row mb-3 exist-address  {{$contact->address_type == 'old' ? '' : 'd-none'}}">
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

@endsection