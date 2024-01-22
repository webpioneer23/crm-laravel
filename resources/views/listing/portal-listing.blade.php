@extends('layouts/layoutMaster')

@section('title', 'Listing Create')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>

<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sortablejs/sortable.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="{{asset('assets/js/forms-extras.js')}}"></script>

<script>
</script>
@endsection


@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Listing /</span> Edit</h4>

<!-- Tabs -->
<div class="row">


    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist">
                @foreach($portals as $portal)
                <li class="nav-item">
                    <form method="get">
                        <input type="hidden" name="portal" value="{{$portal->id}}">
                        <button type="submit" class="nav-link {{$listing_portal->id == $portal->id ? 'active' : ''}}" role="tab" data-bs-toggle="tab" data-bs-target="#{{$portal->name}}" aria-controls="{{$portal->name}}" aria-selected="true">{{$portal->name}}</button>
                    </form>
                </li>
                @endforeach
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="{{$listing_portal->name}}" role="tabpanel">
                    @if($listing_portal->base_url == 'https://sandbox.realestate.co.nz')
                    <div>
                        <p>
                            Total Result: {{ $list->meta->{'total-results'} }}
                        </p>
                    </div>
                    <form class="dt_adv_search" method="get">
                        <?php
                        $status_list = ["all", "active", "sold", "withdrawn"];
                        ?>
                        <div class="row g-3">
                            <div class="col-12 col-sm-4 col-lg-4 capitalize">
                                <label class="form-label" for="status">Status:</label>
                                <select name="status" class="select2 form-select" id="status">
                                    @foreach($status_list as $status_item)
                                    <option value="{{$status_item}}" {{$status_item == Request::get('status') ? 'selected' : ''}}>{{$status_item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-4 col-lg-4">
                                <label class="form-label">Listing No:</label>
                                <input type="text" class="form-control" name="listingNo" value="{{Request::get('listingNo')}}" />
                            </div>
                            <input type="hidden" class="form-control" name="page" value="1" />
                            <div class="col-12 col-sm-4 col-lg-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-info">Filter</button>
                                <a href="" class="btn btn-danger ms-2">Reset</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive text-nowrap">
                        <?php
                        $limit = $list->meta->limit;
                        $page = Request::get('page') ? Request::get('page') : 1;
                        $page_count = ceil($list->meta->{'total-results'} / $limit);
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Header</th>
                                    <th>Address</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Last Change</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($list->data as $key => $item)
                                <?php
                                $attributes = $item->attributes;
                                ?>
                                <tr>
                                    <td>{{ ($page - 1) *  $limit +  $key + 1}}</td>
                                    <td>
                                        {{$attributes->header }}
                                    </td>
                                    <td>
                                        <?php
                                        $address = $attributes->address;
                                        ?>
                                        @if($address->{'street-name'})
                                        {{ $address->{'street-name'} }}
                                        @endif
                                        @if($address->{'street-number'})
                                        {{ $address->{'street-number'} }},
                                        @endif
                                        @if($address->{'suburb'})
                                        {{ $address->suburb }},
                                        @endif
                                        @if($address->district)
                                        {{ $address->district }},
                                        @endif
                                        @if($address->region)
                                        {{ $address->region }}
                                        @endif
                                    </td>
                                    <td>
                                        ${!! Helper::amountFormat($attributes->price) !!}
                                    </td>
                                    <td>
                                        {{$attributes->{'listing-status'} }}
                                    </td>
                                    <td>
                                        {{date('j M Y, H:i:s', strtotime($attributes->{'date-of-last-change'}))  }}
                                    </td>
                                    <td>
                                        @if(Helper::listIdFromPortal($listing_portal->id, $item->id))
                                        <a href="{{ route('listing.edit', Helper::listIdFromPortal($listing_portal->id, $item->id)) }}" class="btn btn-primary" target="_blank">
                                            View/Edit
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($page_count > 1)
                    <nav aria-label="Page navigation">
                        <ul class="pagination" style="float: right;">
                            <li class="page-item first">
                                @if($page == 1)
                                <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-left ti-xs"></i></a>
                                @else
                                <a class="page-link" href="{{route('portal.listing', ['page' => 1, 'status' => Request::get('status'), 'listingNo' => Request::get('listingNo') ])}}"><i class="ti ti-chevrons-left ti-xs"></i></a>
                                @endif
                            </li>
                            <li class="page-item prev">
                                @if($page == 1)
                                <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-left ti-xs"></i></a>
                                @else
                                <a class="page-link" href="{{route('portal.listing', ['page' => $page - 1, 'status' => Request::get('status'), 'listingNo' => Request::get('listingNo') ])}}"><i class="ti ti-chevron-left ti-xs"></i></a>
                                @endif
                            </li>
                            @for ($i = 0; $i < $page_count; $i++) <li class="page-item {{$i + 1 == $page ? 'active' : ''}} ">
                                @if($i + 1 == $page)
                                <a href="javascript:void(0);" class="page-link">{{$i + 1}}</a>
                                @else
                                <a href="{{route('portal.listing', ['page' => $i + 1, 'status' => Request::get('status'), 'listingNo' => Request::get('listingNo') ])}}" class="page-link">{{$i + 1}}</a>
                                @endif
                                </li>
                                @endfor
                                <li class="page-item next">
                                    @if($page == $page_count)
                                    <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-right ti-xs"></i></a>
                                    @else
                                    <a class="page-link" href="{{route('portal.listing', ['page' => $page + 1, 'status' => Request::get('status'), 'listingNo' => Request::get('listingNo') ])}}"><i class="ti ti-chevron-right ti-xs"></i></a>
                                    @endif
                                </li>
                                <li class="page-item last">
                                    @if($page == $page_count)
                                    <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-right ti-xs"></i></a>
                                    @else
                                    <a class="page-link" href="{{route('portal.listing', ['page' => $page_count, 'status' => Request::get('status'), 'listingNo' => Request::get('listingNo') ])}}"><i class="ti ti-chevrons-right ti-xs"></i></a>
                                    @endif
                                </li>
                        </ul>
                    </nav>
                    @endif
                    @else
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pills -->

@endsection