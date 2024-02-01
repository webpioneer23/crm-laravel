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
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Appraisal/</span> Overview</h4>

<div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-end mb-4 text-center text-sm-start gap-2">
  <a href="{{route('appraisal.edit', $appraisal->id)}}" class="btn btn-primary btn-label-info">Edit Appraisal</a>
</div>

<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <div class="content-header mb-3">
            <h5 class="mb-0">Appraisal Detail</h5>
          </div>
          <div class="row">
            <dl class="row mb-0">
              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Address:</dt>
              <dd class="col-sm-8">
                <?php $address = $appraisal->address; ?>
                {{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->unit_number ? $address->unit_number."/" : ""}}{{$address->street}}, {{$address->city}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Contact:</dt>
              <dd class="col-sm-8">
                {{$appraisal->contact->first_name}} {{$appraisal->contact->last_name}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Price Range:</dt>
              <dd class="col-sm-8">
                {{$appraisal->price_min}} {{$appraisal->price_max}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Appraisal Value:</dt>
              <dd class="col-sm-8">
                {{$appraisal->appraisal_value}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Due Date:</dt>
              <dd class="col-sm-8">
                {{$appraisal->due_date}}
              </dd>


              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Interest:</dt>
              <dd class="col-sm-8">
                {{$appraisal->interest}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Status:</dt>
              <dd class="col-sm-8">
                {{$appraisal->status}}
              </dd>

              @if($appraisal->status == 'Pending')
              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Delivered Date:</dt>
              <dd class="col-sm-8">
                {{$appraisal->delivered_date}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Delivery Type:</dt>
              <dd class="col-sm-8">
                {{$appraisal->delivery_type}}
              </dd>
              @elseif($appraisal->status == 'Lost')

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Reason Lost:</dt>
              <dd class="col-sm-8">
                {{$appraisal->reason_lost}}
              </dd>
              @endif

            </dl>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="content-header mb-3">
            <h5 class="mb-0">Appraisal Property</h5>
          </div>
          <div class="row">
            <?php
            $property = $appraisal->property;
            ?>
            @if($property)
            <dl class="row mb-0">
              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Bedrooms:</dt>
              <dd class="col-sm-8">
                {{$property->bedroom}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Bathrooms:</dt>
              <dd class="col-sm-8">
                {{$property->bathroom}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Ensuites:</dt>
              <dd class="col-sm-8">
                {{$property->ensuite}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Toilets:</dt>
              <dd class="col-sm-8">
                {{$property->toilet}}
              </dd>


              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Garage spaces:</dt>
              <dd class="col-sm-8">
                {{$property->garage}}
              </dd>


              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Carport spaces:</dt>
              <dd class="col-sm-8">
                {{$property->carport}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Open car spaces:</dt>
              <dd class="col-sm-8">
                {{$property->open_car}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Living areas:</dt>
              <dd class="col-sm-8">
                {{$property->living}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">House size:</dt>
              <dd class="col-sm-8">
                {{$property->house_size}} {{$property->house_size_unit}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Land size:</dt>
              <dd class="col-sm-8">
                {{$property->land_size}} {{$property->land_size_unit}}
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Energy efficiency rating:</dt>
              <dd class="col-sm-8">
                {{$property->energy_efficiency_rating}}
              </dd>

            </dl>
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@include('contact/new-address')

@endsection