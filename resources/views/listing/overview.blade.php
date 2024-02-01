@extends('layouts/layoutMaster')

@section('title', 'Listing Create')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>

<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sortablejs/sortable.js')}}"></script>
@endsection

@section('page-script')
@endsection


@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Listing /</span> Overview</h4>

<div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-end mb-4 text-center text-sm-start gap-2">
  <a href="{{route('listing.edit', $listing->id)}}" class="btn btn-primary btn-label-info">Edit Listing</a>
</div>

<!-- Tabs -->
<div class="row">


  <div class="col-xl-12">
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#listing-detail" aria-controls="listing-detail" aria-selected="true">Listing Details</button>
        </li>

        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#property-details" aria-controls="property-details" aria-selected="false">Property Details</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#image-copy" aria-controls="image-copy" aria-selected="false">Images and Copy</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#inspections" aria-controls="inspections" aria-selected="false">Inspections</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#portal" aria-controls="portal" aria-selected="false">Portal</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="listing-detail" role="tabpanel">
          <div class="card-body mt-3">
            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Status:</dt>
                <dd class="col-sm-8">{{$listing->status}}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Category:</dt>
                <dd class="col-sm-8">{{$listing->category_code}}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Property Type:</dt>
                <dd class="col-sm-8">{{$listing->property_type}}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Listing Expiry Date:</dt>
                <dd class="col-sm-8">{{$listing->expiry_date}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Price:</dt>
                <dd class="col-sm-8">
                  ${!! Helper::amountFormat($listing->price) !!}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Vendor :</dt>
                <dd class="col-sm-8">{{$listing->vendor?->first_name}} {{$listing->vendor?->last_name}}</dd>

                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Property Address :</dt>
                <dd class="col-sm-8">
                  {{$listing->address?->unit_number ? $listing->address->unit_number."/" : ""}}{{$listing->address->street}}, {{$listing->address->city}}
                </dd>

                @foreach($listing->portals() as $key => $portal)
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap"> {{$key ==0 ? 'Available Portals :' : ''}} </dt>
                <dd class="col-sm-8">{{$portal->name}}</dd>

                @endforeach
              </dl>
            </div>
          </div>

        </div>
        <div class="tab-pane fade" id="property-details" role="tabpanel">
          <div class="card-body mt-3">
            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Bedrooms :</dt>
                <dd class="col-sm-8">{{$listing->bedrooms}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Bathrooms :</dt>
                <dd class="col-sm-8">{{$listing->bathrooms}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Ensuites :</dt>
                <dd class="col-sm-8">{{$listing->ensuites}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Toilets :</dt>
                <dd class="col-sm-8">{{$listing->toilets}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Garage spaces :</dt>
                <dd class="col-sm-8">{{$listing->garage_spaces}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Carport spaces :</dt>
                <dd class="col-sm-8">{{$listing->carport_spaces}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Open car spaces :</dt>
                <dd class="col-sm-8">{{$listing->open_car_spaces}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Living areas :</dt>
                <dd class="col-sm-8">{{$listing->living_areas}}</dd>
              </dl>
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Year Built :</dt>
                <dd class="col-sm-8">{{$listing->year_built}}</dd>
              </dl>


              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">New Construction :</dt>
                <dd class="col-sm-8">{{$listing->is_new_construction ? 'Yes' : "No"}}</dd>
              </dl>


              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Coastal Waterfront :</dt>
                <dd class="col-sm-8">{{$listing->is_coastal_waterfront ? 'Yes' : "No"}}</dd>
              </dl>


              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Swimming Pool :</dt>
                <dd class="col-sm-8">{{$listing->has_swimming_pool ? 'Yes' : "No"}}</dd>
              </dl>

              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Tag :</dt>
                <dd class="col-sm-8">{{implode(", ", $listing->full_tag_names)}}</dd>
              </dl>

            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="image-copy" role="tabpanel">
          <div class="content-header mb-3">
            <h5 class="mb-0">UPLOAD IMAGES</h5>
          </div>
          <input type="hidden" name="img_order" class="img-order">
          <div class="d-flex flex-wrap gap-2" id="listing-photos">
            @foreach($listing->photos as $photo)
            <div class="">
              <img class="rounded-circle mb-3" src="{{asset('uploads/' . $photo->path)}}" alt="{{$photo->file_name}}" height="100" width="100">
            </div>
            @endforeach
          </div>

          <div class="content-header mb-3">
            <h5 class="mb-0">UPLOAD FLOORPLANS</h5>
          </div>
          <div class="d-flex flex-wrap gap-2" id="floorplan-photos">
            @foreach($listing->floorplans as $floorplan)
            <div class="" data-id="{{$floorplan->id}}">
              <img class="mb-3 rounded-circle" src="{{asset('uploads/' . $floorplan->path)}}" alt="{{$floorplan->file_name}}" height="150" width="150">
            </div>
            @endforeach
          </div>

          <div class="content-header mb-3">
            <h5 class="mb-0">UPLOAD DOCUMENTS</h5>
          </div>
          <div class="row">
            @foreach($listing->documents as $document)
            <div class="col-md-2">
              <a href="{{asset('uploads/' . $document->path)}}" class="btn btn-primary me-2 btn-sm" download>
                <img class="mb-3 img-fluid" src="{{asset('assets/img/icons/misc/doc.png')}}" width="70" height="70" alt="{{$document->file_name}}">
              </a>
            </div>
            @endforeach
          </div>

          <div class="content-header mt-3 mb-3">
            <h5 class="mb-0">Listing Copy</h5>
          </div>

          <div class="row g-3 mb-3">
            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Headline :</dt>
                <dd class="col-sm-8">{{$listing->headline}}</dd>
              </dl>
            </div>

            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Description :</dt>
                <dd class="col-sm-8">{{$listing->description}}</dd>
              </dl>
            </div>
          </div>

          <div class="content-header mb-3">
            <h5 class="mb-0">Links</h5>
          </div>
          <div class="row g-3 mb-3">
            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Video URL :</dt>
                <dd class="col-sm-8">
                  <a href="{{$listing->video_url}}" target="_blank">
                    {{$listing->video_url}}
                  </a>
                </dd>
              </dl>
            </div>

            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Online Tour 1 :</dt>
                <dd class="col-sm-8">{{$listing->online_tour1}}</dd>
              </dl>
            </div>
            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Online Tour 2 :</dt>
                <dd class="col-sm-8">{{$listing->online_tour2}}</dd>
              </dl>
            </div>
            <div class="row">
              <dl class="row mb-0">
                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Third party website link :</dt>
                <dd class="col-sm-8">{{$listing->third_party_link}}</dd>
              </dl>
            </div>

          </div>
        </div>
        <div class="tab-pane fade" id="inspections" role="tabpanel">

        </div>
        <div class="tab-pane fade" id="portal" role="tabpanel">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Pills -->

@endsection