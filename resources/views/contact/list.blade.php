@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
@endsection

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Address /</span> List
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Contact List ({{count($list)}}) </h5>
      <a href="{{route('contact.create')}}" class="btn btn-primary">New Contact</a>
    </div>
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
              <a href="{{route('contact.index')}}" class="btn btn-danger ms-2">Reset</a>
            </div>
          </div>
        </div>
    </form>
  </div>
  <hr class="mt-3">
  <div class="card-datatable table-responsive">
    <table class="dt-advanced-search table">

      <thead>
        <tr>
          <th></th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Full Name</th>
          <th>Contact Info</th>
          <th>Residing Address</th>
          <th>Tags</th>
          <th>Owner / Tenant</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($list as $item)
        <tr>
          <td>
            @if($item->photo)
            <img src="{{ asset('uploads/' . $item->photo) }}" width="80" height="60" alt="{{$item->first_name}}" class="radius-10">
            @else
            <img src="{{ asset('assets/custom/img/default-house.png') }}" width="80" height="60" alt="{{$item->first_name}}" class="radius-10">
            @endif
          </td>
          <td>
            <span class="ms-4">
              {{$item->first_name}}
            </span>
          </td>
          <td> {{$item->last_name}}</td>
          <td> {{$item->full_name}}</td>
          <td>
            {{$item->email}} <br />
            {{$item->mobile}}
          </td>
          <td>
            @foreach($item->full_address as $address)
            <ul>
              <li>{{$address->street}}, {{$address->city}}</li>
            </ul>
            @endforeach
          </td>
          <td>
            @foreach($item->full_tags as $tag)
            <ul>
              <li>{{$tag->name}}</li>
            </ul>
            @endforeach
          </td>
          <td> {{$item->rent_type}}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('contact.edit', $item->id)}}"><i class="ti ti-pencil me-2"></i> Edit</a>
                <a class="dropdown-item" href="{{route('contact.show', $item->id)}}"><i class="ti ti-eye me-2"></i> Overview</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); deleteItem('delete-{{$item->id}}');"><i class="ti ti-trash me-2"></i> Delete</a>
              </div>
            </div>
            <form method="POST" action="{{ route('contact.destroy', $item->id) }}" class="d-none" id="delete-{{$item->id}}">
              @csrf
              @method('DELETE')
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>
<!--/ Basic Bootstrap Table -->
<script>
  function deleteItem(itemId) {
    const userConfirmed = confirm('Are you sure you want to delete this item?');
    if (userConfirmed) {
      document.getElementById(itemId).submit();
    }
  }
</script>
@endsection