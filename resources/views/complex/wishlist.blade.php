@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />

<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script>
  const whitelist = <?php echo $complex->tag_list; ?>;
  const tagListEl = document.querySelector('#tag_list');
  let tagList = new Tagify(tagListEl, {
    whitelist: whitelist,
    maxTags: 10,
    dropdown: {
      maxItems: 20,
      classname: 'tags-inline',
      enabled: 0,
      closeOnSelect: false
    }
  });
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{$complex->name}} /</span> WishList</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <!-- Basic Layout -->
  <div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">{{ isset($taget_wishlist) ? 'Edit Wishlist' : 'Create Wishlist'}}</h5>
      </div>
      <div class="card-body">
        <form action="{{isset($taget_wishlist) ? url('/complex-wishlist/'.$complex->id.'/update/'.$taget_wishlist->id) : route('complex.wishlist.store', $complex->id) }}" method="post">
          @csrf
          @if(isset($taget_wishlist))
          @method('PUT')
          @endif
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="contact">Contact</label>
              <select id="contact" name="contact" class="select2 form-select" data-allow-clear="true" {{isset($taget_wishlist) ? 'disabled' : 'required'}}>
                <option value="">Select</option>
                @foreach($contacts as $contact)
                <option value="{{$contact->id}}" {{isset($taget_wishlist) && $taget_wishlist->contact_id == $contact->id ? 'selected' : ''}}>{{$contact->first_name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <?php
              $target_tags = [];
              if (isset($taget_wishlist)) {
                foreach ($taget_wishlist->tags as $target_tag) {
                  array_push($target_tags, $target_tag->tag);
                }
              }
              $target_tag_value = implode(",", $target_tags);
              ?>
              <label class="form-label" for="multicol-last-name">Complex Tags</label>
              <input id="tag_list" name="tags" class="form-control" placeholder="select technologies" value="{{$target_tag_value}}" required>
            </div>
          </div>
          <div class="pt-4 float-end">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Basic with Icons -->
</div>

<div class="row">
  <!-- Basic Layout -->
  <div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">WishList</h5>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>First Name</th>
              <th>Contact Info</th>
              <th>Global Tags</th>
              <th>Complex Tags</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($wishlists as $item)
            <tr>
              <td>
                @if($item->contact->photo)
                <img src="{{ asset('uploads/' . $item->contact->photo) }}" width="80" height="60" alt="{{$item->contact->first_name}}" class="radius-10">
                @else
                <img src="{{ asset('assets/custom/img/default-house.png') }}" width="80" height="60" alt="{{$item->contact->first_name}}" class="radius-10">
                @endif
              </td>
              <td> {{$item->contact->first_name}}</td>
              <td>
                {{$item->contact->email}} <br />
                {{$item->contact->mobile}}
              </td>
              <td>
                @foreach($item->contact->full_tags as $tag)
                <ul>
                  <li>{{$tag->name}}</li>
                </ul>
                @endforeach
              </td>
              <td>
                @foreach($item->tags as $complex_tag)
                <ul>
                  <li>{{$complex_tag->tag}}</li>
                </ul>
                @endforeach
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{url('/complex-wishlist/'.$complex->id.'/edit/'.$item->id)}}"><i class="ti ti-pencil me-2"></i> Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); deleteItem('delete-{{$item->id}}');"><i class="ti ti-trash me-2"></i> Delete</a>
                  </div>
                </div>
                <form method="POST" action="{{ route('complex.wishlist.destroy', $item->id) }}" class="d-none" id="delete-{{$item->id}}">
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
  <!-- Basic with Icons -->
</div>

<script>
  function deleteItem(itemId) {
    const userConfirmed = confirm('Are you sure you want to delete this item?');
    if (userConfirmed) {
      document.getElementById(itemId).submit();
    }
  }
</script>
@endsection