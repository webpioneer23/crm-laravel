@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Appraisal /</span> List
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-header right">
    <a href="{{route('appraisal.create')}}" class="btn btn-primary">New Appraisal</a>
  </div>
  <div class="card-body">

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <tr>
            <td>
            </td>

          </tr>
        </tbody>
      </table>
    </div>

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