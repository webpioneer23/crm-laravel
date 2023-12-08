@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Complex /</span> List
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-header right">
    <a href="{{route('complex.create')}}" class="btn btn-primary">New Complex</a>
  </div>
  <div class="card-body">

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th width="15%">street_address</th>
            <th>name</th>
            <th>year built</th>
            <th>architect</th>
            <th>constructor</th>
            <th>number units</th>
            <th>number floors</th>
            <th>property type</th>
            <!-- <th>body manager</th> -->
            <!-- <th>note</th> -->
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($list as $item)
          <tr>
            <td class="text-ellipsis"> {{$item->street_address}}</td>
            <td> {{$item->name}}</td>
            <td> {{$item->year_built}}</td>
            <td> {{$item->architect}}</td>
            <td> {{$item->constructor}}</td>
            <td> {{$item->number_units}}</td>
            <td> {{$item->number_floors}}</td>
            <td> {{$item->property_type}}</td>
            <!-- <td> {{$item->body_manager}}</td> -->
            <!-- <td> {{$item->note}}</td> -->
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('complex.edit', $item->id)}}"><i class="ti ti-pencil me-2"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); deleteItem('delete-{{$item->id}}');"><i class="ti ti-trash me-2"></i> Delete</a>
                  <a class="dropdown-item" href="{{route('complex.show', $item->id)}}"><i class="ti ti-files me-2"></i> Contacts</a>
                  <a class="dropdown-item" href="{{route('complex.wishlist', $item->id)}}"><i class="ti ti-list me-2"></i> Wishlist</a>
                  <a class="dropdown-item" href="{{route('complex.files', $item->id)}}"><i class="ti ti-files me-2"></i> Files</a>
                </div>
              </div>
              <form method="POST" action="{{ route('complex.destroy', $item->id) }}" class="d-none" id="delete-{{$item->id}}">
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