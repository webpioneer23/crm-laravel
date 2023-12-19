@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Contact/</span> Edit</h4>


<div class="row">
    <div class="card mb-4">
        <div class="nav-align-top mb-4">
            <div class="card-header">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <a href="{{route('contact.edit', $contact->id)}}" class="nav-link "> Properties</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('contact.buyer_preferences', $contact->id)}}" class="nav-link"> Preferences</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('contact.relationship', $contact->id)}}" class="nav-link active"> Relationship</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('contact.update', $contact->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="edit_type" value="relationship">
                    <?php
                    $relationship_list = [
                        "Wife", "Husband", "Spouse", "Solicitor", "Client", "Sibling", "Child", "Parent", "Business Partner", "Associate", "House Mate", "Ex Spouse", "Co Owner", "Other"
                    ];
                    ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" for="collapsible-fullname">Contact</label>
                            <select id="target_id" class="select2 form-select" name="target_id" data-allow-clear="true">
                                @foreach($contacts as $contact1)
                                <option value="{{$contact1->id}}">{{$contact1->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="collapsible-fullname">Select Relationship</label>
                            <select id="relationship" class="select2 form-select form-select-lg" name="relationship" data-allow-clear="true">
                                @foreach($relationship_list as $item)
                                <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="note">Note</label>
                            <textarea name="note" id="note" class="form-control" placeholder=""></textarea>

                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-4 text-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Related Contact</th>
                            <th>Relationship</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($list as $item)
                        <tr>
                            <td>
                                {{$item->target->first_name}}
                            </td>
                            <td> {{$item->relationship}}</td>
                            <td>
                                {{$item->note}}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); deleteItem('delete-{{$item->id}}');"><i class="ti ti-trash me-2"></i> Delete</a>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('contact.relationship.destroy', $item->id) }}" class="d-none" id="delete-{{$item->id}}">
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