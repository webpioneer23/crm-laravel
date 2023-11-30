@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Tag /</span> List
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-header right">
    <a href="{{route('tag.create')}}" class="btn btn-primary">New Tag</a>
  </div>
  <div class="card-body">

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th class="text-center" width="50%">Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($list as $item)
          <tr>
            <td class="text-center">
              <span class="fw-medium">{{$item->name}}</span>
            </td>
            <td class="d-flex">
              <a href="{{route('tag.edit', $item->id)}}" class="btn btn-primary">
                <span class="ti ti-pencil me-1"></span>Edit
              </a>
              <form method="POST" action="{{ route('tag.destroy', $item->id) }}" class="ms-4">
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
@endsection