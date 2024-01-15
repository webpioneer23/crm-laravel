@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Portal /</span> List
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-header right">
    <a href="{{route('listingPortal.create')}}" class="btn btn-primary">Add Portal</a>
  </div>
  <div class="card-body">

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Base Url</th>
            <th>Key</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($list as $item)
          <tr>
            <td>
              @if($item->active)
              <div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-0">
                <span class="badge badge-dot bg-success me-1"></span> {{$item->name}}
              </div>
              @else
              <div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-0">
                <span class="badge badge-dot bg-danger me-1"></span> {{$item->name}}
              </div>
              @endif
            </td>
            <td>{{$item->base_url}}</td>
            <td>{{$item->key}}</td>
            <td>

              <form action="{{route('portal-status')}}" method="post" id="status-form-{{$item->id}}">
                @csrf
                <label class="switch switch-lg">
                  <input type="checkbox" class="switch-input" name="checked" {{$item->active ? 'checked': ''}} onclick="changeActive('{{$item->id}}')" />
                  <input type="hidden" name="id" value="{{$item->id}}" />
                  <span class="switch-toggle-slider">
                    <span class="switch-on">
                      <i class="ti ti-check"></i>
                    </span>
                    <span class="switch-off">
                      <i class="ti ti-x"></i>
                    </span>
                  </span>
                  <span class="switch-label">{{$item->active ? 'Active': 'Inactive'}}</span>
                </label>

              </form>

            </td>
            <td class="d-flex">
              <a href="{{route('listingPortal.edit', $item->id)}}" class="btn btn-primary">
                <span class="ti ti-pencil me-1"></span>Edit
              </a>
              <form method="POST" action="{{ route('listingPortal.destroy', $item->id) }}" class="ms-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                  <span class="ti ti-trash me-1"></span>Delete
                </button>
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
  function changeActive(itemId) {
    console.log(`status-form-${itemId}`)
    console.log($(`status-form-${itemId}`))
    $(`#status-form-${itemId}`).submit();
  }
</script>
@endsection