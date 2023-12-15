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
<h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{$contract->name}} (Contract)/</span> Attached Files</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
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
</div>
@endsection