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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contact/</span> Overview</h4>

<div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-end mb-4 text-center text-sm-start gap-2">
  <a href="{{route('contact.edit', $contact->id)}}" class="btn btn-primary btn-label-info">Edit Contact</a>
</div>



<div class="row">
  <div class="col-xl-12">
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#Properties" aria-controls="Properties" aria-selected="true">
            Properties
          </button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#Preferences" aria-controls="Preferences" aria-selected="false">
            Preferences
          </button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#Relationship" aria-controls="Relationship" aria-selected="false">
            Relationship
          </button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="Properties" role="tabpanel">
          <div class="card-header align-items-center">
            <h5 class="card-action-title mb-0">Properties</h5>
          </div>
          <div class="card-body mt-3">
            <div class="row">
              <div class="col-xl-6 col-12">
                <dl class="row mb-0">

                  <dt class="col-sm-12 mb-2 fw-medium text-nowrap">
                    @if($contact->photo)
                    <img src="{{ asset('uploads/' . $contact->photo) }}" width="150" alt="{{$contact->first_name}}" class="radius-10">
                    @else
                    <img src="{{ asset('assets/custom/img/default-house.png') }}" width="150" alt="{{$contact->first_name}}" class="radius-10">
                    @endif
                  </dt>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">First Name:</dt>
                  <dd class="col-sm-8">{{$contact->first_name}}</dd>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Last Name:</dt>
                  <dd class="col-sm-8">{{$contact->last_name}}</dd>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Full Legal Name:</dt>
                  <dd class="col-sm-8">{{$contact->full_name}}</dd>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Mobile :</dt>
                  <dd class="col-sm-8">{{$contact->mobile}}</dd>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Email :</dt>
                  <dd class="col-sm-8">{{$contact->email}}</dd>
                </dl>
              </div>
              <div class="col-xl-6 col-12">

                <dl class="row mb-0">
                  @if($contact->residingAddress)

                  <?php $residingAddress = $contact->residingAddress;  ?>
                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Residing Address:</dt>
                  <dd class="col-sm-8">{{$residingAddress->unit_number ? $residingAddress->unit_number."/" : ""}}{{$residingAddress->street}}, {{$residingAddress->city}}</dd>
                  @endif

                  @foreach($contact->full_address as $key => $own_address)
                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">{{$key == 0 ? "Properties Owned:" : ''}} </dt>
                  <dd class="col-sm-8">{{$own_address->unit_number ? $own_address->unit_number."/" : ""}}{{$own_address->street}}, {{$own_address->city}}</dd>
                  @endforeach
                </dl>
                <dl class="row mb-0">
                  <?php
                  $tag_list = [];
                  foreach ($contact->full_tags as $key => $tag) {
                    array_push($tag_list, $tag->name);
                  }
                  ?>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Tags :</dt>
                  <dd class="col-sm-8">{{implode(', ', $tag_list)}}</dd>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Owner / Tenant :</dt>
                  <dd class="col-sm-8">{{$contact->rent_type}}</dd>

                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Social Links :</dt>
                  <dd class="col-sm-8">{{$contact->social_links}}</dd>


                  <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Notes :</dt>
                  <dd class="col-sm-8">{{$contact->notes}}</dd>
                </dl>

              </div>

            </div>
          </div>
        </div>
        <div class="tab-pane fade " id="Preferences" role="tabpanel">
          <div class="card-header align-items-center">
            <h5 class="card-action-title mb-0">Preferences Detail</h5>
          </div>
          <div class="card-body mt-3">
            <div class="row">
              <?php
              $property = $contact->property;
              ?>
              <dl class="row mb-0">
                <?php
                $listing_type_list = [
                  "Any", "Residential sale", "Residential rental", "Land",
                  "Commercial", "Rural", "Business"
                ];
                $unit_list = ["Square metres", "Squares", "Square feet", "Hectares", "Acres"];

                $listing_types = $contact->listing_types ? json_decode($contact->listing_types, true) : [];
                ?>
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Listing Types:</dt>
                <dd class="col-sm-8">{{implode(', ', $listing_types)}}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Land Size:</dt>
                <dd class="col-sm-8">{{$contact->land_size_min}} ~ {{$contact->land_size_max}} {{$contact->land_size_unit }}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Floor Size:</dt>
                <dd class="col-sm-8">{{$contact->floor_size_min}} ~ {{$contact->floor_size_max}} {{$contact->floor_size_unit }}</dd>


                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Car Spaces:</dt>
                <dd class="col-sm-8">{{$contact->car_spaces_min}} ~ {{$contact->car_spaces_max}}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Suburbs:</dt>
                <dd class="col-sm-8">{{$contact->suburbs}}</dd>

                <?php
                $property_tags = [];
                $full_tags = $contact->full_tags;
                foreach ($full_tags as $key => $tag) {
                  array_push($property_tags, $tag->name);
                }
                ?>
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Property Tags:</dt>
                <dd class="col-sm-8">{{implode(", ", $property_tags)}}</dd>


                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Comments:</dt>
                <dd class="col-sm-8">{{$contact->comments}}</dd>
              </dl>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="Relationship" role="tabpanel">
          <div class="card-header align-items-center">
            <h5 class="card-action-title mb-0">Relationship</h5>
          </div>
          <div class="card-body mt-3">
            <table class="table">
              <thead>
                <tr>
                  <th>Related Contact</th>
                  <th>Relationship</th>
                  <th>Note</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($relation_list as $item)
                <tr>
                  <td>
                    {{$item->target->first_name}}
                  </td>
                  <td> {{$item->relationship}}</td>
                  <td>
                    {{$item->note}}
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); deleteItem('delete-{{$item->id}}');"><i class="ti ti-trash me-2"></i> Delete</a>
                      </div>
                    </div>
                    <form method="POST" action="{{ route('contact.relationship.destroy', $item->id) }}" class="d-none" id="delete-{{$item->id}}">
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


      </div>
    </div>
  </div>
</div>

<script>
  function deleteItem(itemId) {
    const userConfirmed = confirm('Are you sure you want to delete this item?');
    if (userConfirmed) {
      document.getElementById(itemId).submit();
    }
  }
</script>
@endsection