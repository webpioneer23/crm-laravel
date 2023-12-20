@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Contract /</span> Contract
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-header right">
    <a href="{{route('contract.create')}}" class="btn btn-primary">New Contract</a>
  </div>
  <div class="card-body">

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Listing</th>
            <th>Purchaser Name</th>
            <th>Vendor name</th>
            <th>Purchaser</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($list as $key => $item)
          <tr>
            <td>
              {{$key + 1}}
            </td>
            <td>
              @if($item->listing)
              {{$item->listing->address?->unit_number ? $item->listing->address->unit_number."/" : ""}}{{$item->listing->address->street}}, {{$item->listing->address->city}}
              @endif
            </td>
            <td>
              {{$item->purchaser_name}}
            </td>
            <td>
              {{$item->vendor_name}}
            </td>
            <td>
              <ul></ul>
              @foreach($item->contacts as $contact)
              <li>
                {{$contact->first_name}}
              </li>
              @endforeach
            </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('contract.edit', $item->id)}}"><i class="ti ti-pencil me-2"></i> Edit</a>
                  <a class="dropdown-item" href="{{route('contract.files', $item->id)}}"><i class="ti ti-files me-2"></i> Files</a>
                  <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); deleteItem('delete-{{$item->id}}');"><i class="ti ti-trash me-2"></i> Delete</a>
                </div>
              </div>
              <form method="POST" action="{{ route('contract.destroy', $item->id) }}" class="d-none" id="delete-{{$item->id}}">
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