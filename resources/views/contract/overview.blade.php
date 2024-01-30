@extends('layouts/layoutMaster')

@section('title', 'Contract - Overivew')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/modal-edit-user.js')}}"></script>
<script src="{{asset('assets/js/app-ecommerce-customer-detail.js')}}"></script>
<script src="{{asset('assets/js/app-ecommerce-customer-detail-overview.js')}}"></script>
@endsection

@section('content')
<h4 class="py-3 mb-2">
  <span class="text-muted fw-light">Contract /</span> Overview
</h4>

<div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
  <div class="mb-2 mb-sm-0">
    <h4 class="mb-1">
      {{$contract->listing->address?->unit_number ? $contract->listing->address->unit_number."/" : ""}}{{$contract->listing->address->street}}
    </h4>
    <p class="mb-0">
      {{$contract->listing->address->city}}
    </p>
  </div>
  <a href="{{route('contract.edit', $contract->id)}}" class="btn btn-primary btn-label-info">Edit Contract</a>
</div>


<div class="row">
  <!-- Customer Content -->
  <div class="col-xl-12 col-lg-12 col-md-12 ">
    <!-- Customer Pills -->
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
      <li class="nav-item"><a class="nav-link active py-2" href="javascript::void();">
          <i class="ti ti-user me-1"></i>
          Overview
        </a></li>
      <li class="nav-item"><a class="nav-link py-2" href="{{route('contract.files', $contract->id)}}">
          <i class="ti ti-lock me-1"></i>File List
        </a></li>
    </ul>
    <!--/ Customer Pills -->

    <!-- / Customer cards -->
    <div class="row text-nowrap">
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-icon mb-3">
              <div class="avatar">
                <div class="avatar-initial rounded bg-label-primary">
                  <i class='ti ti-currency-dollar ti-md'></i>
                </div>
              </div>
            </div>
            <div class="card-info">
              <h4 class="card-title mb-3">Sale Price</h4>
              <div class="d-flex align-items-baseline mb-1 gap-1">
                <h4 class="text-primary mb-0"> ${!! Helper::amountFormat($contract->price) !!}</h4>
                <p class="mb-0"> incl GST</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-icon mb-3">
              <div class="avatar">
                <div class="avatar-initial rounded bg-label-success">
                  <i class='ti ti-pig ti-md'></i>
                </div>
              </div>
            </div>
            <div class="card-info">
              <h4 class="card-title mb-3">Deposit</h4>
              <span class="badge bg-label-success mb-2">Received</span>
              <p class="text-muted mb-0"> {!! Helper::dateFormat($contract->deposit_received_date) !!} </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-icon mb-3">
              <div class="avatar">
                <div class="avatar-initial rounded bg-label-warning">
                  <i class='ti ti-list-check ti-md'></i>
                </div>
              </div>
            </div>
            <?php
            $specificDate = new DateTime($contract->unconditional_date); // Replace with your specific date
            $today = new DateTime();
            $interval = $today->diff($specificDate);
            $daysDifference = $interval->days;
            ?>
            <div class="card-info">
              <h4 class="card-title mb-3">Unconditional</h4>
              <div class="d-flex align-items-baseline mb-1 gap-1">
                <h4 class="text-warning mb-0"> {!! Helper::dateFormat($contract->unconditional_date) !!}</h4>
                <p class="mb-0">{{$daysDifference}} days</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-icon mb-3">
              <div class="avatar">
                <div class="avatar-initial rounded bg-label-info">
                  <i class='ti ti-circle-x ti-md'></i>
                </div>
              </div>
            </div>
            <div class="card-info">
              <h4 class="card-title mb-3">Commission</h4>
              <div class="d-flex align-items-baseline mb-1 gap-1">
                <h4 class="text-info mb-0">${!! Helper::amountFormat($contract->commission) !!}</h4>
                <p class="mb-0">(ex GST)</p>
              </div>

              <p class="text-muted mb-0 text-truncate">Total gross commission</p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Billing Address -->
    <div class="card card-action mb-4">
      <div class="card-header align-items-center">
        <h5 class="card-action-title mb-0">Contract Detail</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-xl-6 col-12">
            <dl class="row mb-0">
              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Address:</dt>
              <dd class="col-sm-8"> @if($contract->listing)
                {{$contract->listing->address?->unit_number ? $contract->listing->address->unit_number."/" : ""}}{{$contract->listing->address->street}}, {{$contract->listing->address->city}}
                @endif
              </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Purchaser:</dt>
              <dd class="col-sm-8">{{$contract->purchaser_name}}</dd>

              <?php
              $purchases = [];
              foreach ($contract->contacts as $contact) {
                array_push($purchases, $contact->first_name);
              }

              ?>
              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Purchasers:</dt>
              <dd class="col-sm-8">{{implode(", ", $purchases)}}</dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Vendor:</dt>
              <dd class="col-sm-8">{{$contract->vendor_name}}</dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Price:</dt>
              <dd class="col-sm-8">${!! Helper::amountFormat($contract->price) !!}</dd>


              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Contract Accepted Date:</dt>
              <dd class="col-sm-8"> {!! Helper::dateFormat($contract->contract_accepted_date) !!} </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Unconditional Date:</dt>
              <dd class="col-sm-8"> {!! Helper::dateFormat($contract->unconditional_date) !!} </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Settlement Date:</dt>
              <dd class="col-sm-8"> {!! Helper::dateFormat($contract->settlement_date) !!} </dd>



              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Deposit Due Date:</dt>
              <dd class="col-sm-8">{!! Helper::dateFormat($contract->deposit_due_date) !!} </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Deposit Received Date:</dt>
              <dd class="col-sm-8">{!! Helper::dateFormat($contract->deposit_received_date) !!} </dd>

              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">Commission (EX GST):</dt>
              <dd class="col-sm-8">${!! Helper::amountFormat($contract->commission) !!}</dd>
            </dl>
          </div>
          <div class="col-xl-6 col-12">
            <dl class="row mb-0">
              <dt class="col-sm-12 mb-2 fw-large text-nowrap">Conditions:</dt>

              @foreach ($contract->full_conditions as $condition)
              <dt class="col-sm-4 mb-2 fw-medium text-nowrap">{{$condition->tag_name}}:</dt>
              <dd class="col-sm-8">{{$condition->tag_date}}</dd>

              @endforeach


              <dt class="col-sm-4 mb-2 mt-3 fw-medium text-nowrap">Comments:</dt>
              <dd class="col-sm-8">
                @foreach($contract->full_comments as $comment)
                <p> {{$comment}}</p>
                @endforeach

              </dd>


            </dl>
          </div>
        </div>
      </div>
    </div>
    <!--/ Billing Address -->


    <!-- /Invoice table -->
  </div>
  <!--/ Customer Content -->
</div>

<!-- Modal -->
@include('_partials/_modals/modal-edit-user')
@include('_partials/_modals/modal-upgrade-plan')
<!-- /Modal -->
@endsection