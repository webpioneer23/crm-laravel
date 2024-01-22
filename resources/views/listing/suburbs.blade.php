@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<!-- Flat Picker -->
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>

@endsection

@section('page-script')
<script>
  var datatable = $('.datatables');
  datatable.DataTable();
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Listing /</span> Suburbs
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="datatables table">
        <thead>
          <tr>
            <th></th>
            <th>Suburb Id</th>
            <th>Suburb</th>
            <th>District</th>
            <th>Region</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($list as $key => $item)
          <tr>
            <td>{{$key + 1}} </td>
            <td>{{$item->suburb_id}} </td>
            <td>{{$item->suburb_name}} </td>
            <td>{{$item->district_name}} </td>
            <td>{{$item->region_name}} </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection