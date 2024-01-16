<div class="card-body">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th>Portal Name</th>
          <th>Publish Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($listing->portals() as $key => $portal)
        <tr>
          <td>{{$key + 1}}</td>
          <td>
            {{$portal->name}}
          </td>
          <td>
            @if(isset($listing->published_list["portal-$portal->id"]))
            {{$listing->published_list["portal-$portal->id"][0]}}
            @endif
          </td>
          <td class="d-flex">
            @if(isset($listing->published_list["portal-$portal->id"]) && !$listing->published_list["portal-$portal->id"][1])
            <form method="POST" action="{{route('listing.publish')}}" class="ms-4">
              @csrf
              <input type="hidden" name="listing_id" value="{{$listing->id}}">
              <input type="hidden" name="portal_id" value="{{$portal->id}}">

              <button type="submit" class="btn btn-primary">
                <span class="ti ti-logout me-1"></span>Push now
              </button>
            </form>
            @else
            <form method="POST" action="{{route('listing.update.publish')}}" class="ms-4">
              @csrf
              @method('put')
              <input type="hidden" name="listing_id" value="{{$listing->id}}">
              <input type="hidden" name="portal_id" value="{{$portal->id}}">

              <button type="submit" class="btn btn-info">
                <span class="ti ti-logout me-1"></span>Push Again
              </button>
            </form>
            <form method="POST" action="" class="ms-4">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                <span class="ti ti-trash me-1"></span>Remove from Portal
              </button>
            </form>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6">
            This listing is not connected to any portal. Please select portals on <span class="text-info">Listing Details</span> tab.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>