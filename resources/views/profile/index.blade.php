@extends('layouts/layoutMaster')

@section('title', 'Account settings - Account')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
<script>
    const flatpickrDateList = document.querySelectorAll('.nz-date');
    if (flatpickrDateList) {
        flatpickrDateList.forEach(flatpickrDate => {
            flatpickrDate.flatpickr({
                dateFormat: 'd/m/Y'
            });
        });
    }
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Account Settings /</span> Profile
</h4>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-4">
            <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="ti-xs ti ti-users me-1"></i> Account</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('security')}}"><i class="ti-xs ti ti-lock me-1"></i> Security</a></li>
        </ul>
        <div class="card mb-4">
            <h5 class="card-header">Profile Details</h5>
            <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
                @csrf
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        @if($user->photo)
                        <img src="{{ asset('uploads/'.$user->photo) }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                        @else
                        <img src="{{ asset('assets/img/avatars/14.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                        @endif
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" name="photo" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                            </label>
                            <!-- <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button> -->

                            <div class="text-muted">Allowed JPG, GIF or PNG.</div>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Full Name *</label>
                            <input class="form-control" type="text" id="name" name="name" value="{{$user->name}}" autofocus required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail *</label>
                            <input class="form-control" type="text" id="email" name="email" value="{{$user->email}}" placeholder="" required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="licence_number" class="form-label">Licence Number</label>
                            <input type="text" class="form-control" id="licence_number" name="licence_number" value="{{$user->licence_number}}" placeholder="Licence Number" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <?php
                            $licence_classes = ["Licensed Salesperson", "Branch Manager", "Licensed Agent"];
                            ?>
                            <label for="licence_class" class="form-label">Licence Class</label>
                            <select id="licence_class" name="licence_class" class="select2 form-select">
                                <option value="">Select One</option>
                                @foreach($licence_classes as $licence_class)
                                <option value="{{$licence_class}}" {{$licence_class == $user->licence_class ? 'selected' : ''}}>{{$licence_class}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date-local" class="form-control nz-date" id="expiry_date" name="expiry_date" value="{{$user->expiry_date}}" placeholder="Expiry Date (DD/MM/YYYY)" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </form>
            <!-- /Account -->
        </div>
    </div>
</div>

@endsection