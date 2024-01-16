@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">History /</span> List
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-body">

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Date time</th>
            <th>Description</th>
            <th>Detail</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($list as $key => $item)
          <tr>
            <td>
              {{ ($list->currentPage() - 1) * $list->perPage() + $key+1}}
            </td>
            <td>
              {{date('d, M Y - H:i A', strtotime($item->created_at))}}
            </td>
            <td>
              {{$item->user->name." ".$item->type." ".$item->source}}
              @if($item->source_name)
              <br />
              ({{$item->source_name}})
              @endif
            </td>
            <td>
              @if($item->note_json == 1)
              @if($item->source == 'listingPortal')
              <ul>
                @foreach(json_decode($item->note) as $key => $note)
                <li>{!! Helper::convertToDisplayName($key) !!} : {{$note}}</li>
                @endforeach
              </ul>
              @else
              <ul>
                @foreach(json_decode($item->note) as $key => $note)
                <li>{!! Helper::convertToDisplayName($key) !!} : {{$note->old}} -> {{$note->new}}</li>
                @endforeach
              </ul>
              @endif
              @else
              {{$item->note}}
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
    {{$list->links()}}

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