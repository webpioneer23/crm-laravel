@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Lead /</span> List
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-header right">
    <a href="{{route('lead.create')}}" class="btn btn-primary">New Lead</a>
  </div>
  <div class="card-body">

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Status</th>
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
              {{$item->address->unit_number ? $item->address->unit_number."/" : ""}}{{$item->address->street}}, {{$item->address->city}}
            </td>

            <td>
              <ul>
                @foreach($item->contact() as $contact)
                <li>{{$contact->first_name}} {{$contact->last_name}}</li>
                @endforeach
              </ul>
            </td>
            <td>
              {{$item->status}}
            </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('lead.edit', $item->id)}}"><i class="ti ti-pencil me-2"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); deleteItem('delete-{{$item->id}}');"><i class="ti ti-trash me-2"></i> Delete</a>
                </div>
              </div>
              <form method="POST" action="{{ route('lead.destroy', $item->id) }}" class="d-none" id="delete-{{$item->id}}">
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