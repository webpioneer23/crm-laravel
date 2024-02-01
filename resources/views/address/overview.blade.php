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
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Address/</span> Overview</h4>

<div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-end mb-4 text-center text-sm-start gap-2">
    <a href="{{route('address.edit', $address->id)}}" class="btn btn-primary btn-label-info">Edit Address</a>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#address-detail" aria-controls="address-detail" aria-selected="true">
                        Address Details
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#property-details" aria-controls="property-details" aria-selected="false">
                        Property Details
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="address-detail" role="tabpanel">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0">Address Detail</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <dl class="row mb-0">
                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Property Type:</dt>
                                <dd class="col-sm-8">{{$address->property_type}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Google Address:</dt>
                                <dd class="col-sm-8">{{$address->google_address}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Unit Number:</dt>
                                <dd class="col-sm-8">{{$address->unit_number}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Street Address:</dt>
                                <dd class="col-sm-8">{{$address->street}}</dd>
                            </dl>
                            <dl class="row mb-0">
                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Building Name:</dt>
                                <dd class="col-sm-8">{{$address->building}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Suburb :</dt>
                                <dd class="col-sm-8">{{$address->suburb}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">City :</dt>
                                <dd class="col-sm-8">{{$address->city}}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="property-details" role="tabpanel">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0">Property Detail</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <?php
                            $property = $address->property;
                            ?>
                            @if($property)
                            <dl class="row mb-0">
                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Bedrooms:</dt>
                                <dd class="col-sm-8">{{$property->bedroom}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Bathrooms:</dt>
                                <dd class="col-sm-8">{{$property->bathroom}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Ensuites:</dt>
                                <dd class="col-sm-8">{{$property->ensuite}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Toilets:</dt>
                                <dd class="col-sm-8">{{$property->toilet}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Garage spaces:</dt>
                                <dd class="col-sm-8">{{$property->garage}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Carport spaces:</dt>
                                <dd class="col-sm-8">{{$property->carport}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Open car spaces:</dt>
                                <dd class="col-sm-8">{{$property->open_car}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Living areas:</dt>
                                <dd class="col-sm-8">{{$property->living}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">House size:</dt>
                                <dd class="col-sm-8">{{$property->house_size}} {{$property->house_size_unit}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Land size:</dt>
                                <dd class="col-sm-8">{{$property->land_size}} {{$property->land_size_unit}}</dd>

                                <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Energy efficiency rating:</dt>
                                <dd class="col-sm-8">{{$property->energy_efficiency_rating}}</dd>
                            </dl>
                            @else
                            You have not uploaded your property details yet.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection