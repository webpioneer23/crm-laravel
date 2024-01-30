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
      <li class="nav-item"><a class="nav-link  py-2" href="{{route('contract.show', $contract->id)}}">
          <i class="ti ti-user me-1"></i>
          Overview
        </a></li>
      <li class="nav-item"><a class="nav-link py-2 active" href="javascript::void();">
          <i class="ti ti-files me-1"></i>File List
        </a></li>
    </ul>
    <!--/ Customer Pills -->


    <div class="card mb-4">
      <h5 class="card-header">File List</h5>
      <div class="card-body">
        <div class="row">
          @foreach($contract->files as $file)
          <div class="col-md-3">
            <div class="bg-lighter p-3 rounded mb-3" style="height: 120px">
              <div class="d-flex justify-content-between flex-sm-row flex-column">
                <div class="card-information me-2">
                  @if($file->file_ext == 'pdf')
                  <img class="mb-3 img-fluid" src="{{asset('assets/img/icons/misc/pdf.png')}}" width="70" height="70" alt="{{$file->file_name}}">
                  @elseif($file->file_ext == 'xls')
                  <img class="mb-3 img-fluid" src="{{asset('assets/img/icons/misc/search-xls.png')}}" width="70" height="70" alt="{{$file->file_name}}">
                  @elseif($file->file_ext == 'doc')
                  <img class="mb-3 img-fluid" src="{{asset('assets/img/icons/misc/search-doc.png')}}" width="70" height="70" alt="{{$file->file_name}}">
                  @else
                  <img class="mb-3 img-fluid" src="{{asset('assets/img/icons/misc/doc.png')}}" width="70" height="70" alt="{{$file->file_name}}">
                  @endif
                </div>
                <div class="text-lg-end">
                  <div class="d-flex align-items-center mb-2 flex-wrap gap-2">
                    <p class="mb-0 me-2">{{$file->file_name}}</p>
                  </div>
                  <div class="d-flex float-end">
                    <a href="{{asset('uploads/' . $file->path)}}" class="btn btn-primary me-2 btn-sm" download><i class="ti ti-download"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>


    <!-- /Invoice table -->
  </div>
  <!--/ Customer Content -->
</div>

<!-- Modal -->
@include('_partials/_modals/modal-edit-user')
@include('_partials/_modals/modal-upgrade-plan')
<!-- /Modal -->
@endsection