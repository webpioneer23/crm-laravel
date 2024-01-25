@extends('layouts/layoutMaster')

@section('title', 'Kanban - Apps')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/jkanban/jkanban.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}" />

<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />

@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-kanban.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor//libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor//libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor//libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor//libs/jkanban/jkanban.js')}}"></script>
<script src="{{asset('assets/vendor//libs/quill/katex.js')}}"></script>
<script src="{{asset('assets/vendor//libs/quill/quill.js')}}"></script>

<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/app-kanban-task.js')}}"></script>
<script>
    function formSubmit() {
        console.log('form submit');
    }
</script>
@endsection

@section('content')
<div class="app-kanban">

    <!-- Add new board -->
    <div class="row">
        <div class="col-12">
            <form class="kanban-add-new-board">
                <label class="kanban-add-board-btn" for="kanban-add-board-input">
                    <i class="ti ti-plus ti-xs"></i>
                    <span class="align-middle">Add new</span>
                </label>
                <input type="text" class="form-control w-px-250 kanban-add-board-input mb-2 d-none" placeholder="Add Board Title" id="kanban-add-board-input" required />
                <div class="mb-3 kanban-add-board-input d-none">
                    <button class="btn btn-primary btn-sm me-2">Add</button>
                    <button type="button" class="btn btn-label-secondary btn-sm kanban-add-board-cancel-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kanban Wrapper -->
    <div class="kanban-wrapper"></div>

    <!-- Edit Task & Activities -->
    <div class="offcanvas offcanvas-end kanban-update-item-sidebar">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Edit Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-update">
                        <i class="ti ti-edit me-2"></i>
                        <span class="align-middle">Edit</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-activity">
                        <i class="ti ti-trending-up me-2"></i>
                        <span class="align-middle">Activity</span>
                    </button>
                </li>
            </ul>
            <div class="tab-content px-0 pb-0">
                <!-- Update item/tasks -->
                <div class="tab-pane fade show active" id="tab-update" role="tabpanel">
                    <form method="post" action="{{route('task.update', 1)}}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="task_id" id="task-id">
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" id="title" name="name" class="form-control" placeholder="Enter Title" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="users"> Users</label>
                            <select class="select2 select2-label form-select" id="users" name="users[]" multiple>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="listings"> Listing</label>
                            <select class="select2 select2-label form-select" id="listings" name="listings[]" multiple>
                                @foreach($listings as $listing)
                                <option value="{{$listing->id}}">
                                    {{$listing->address?->unit_number ? $listing->address->unit_number."/" : ""}}{{$listing->address->street}}, {{$listing->address->city}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="appraisals"> Appraisal</label>
                            <select class="select2 select2-label form-select" id="appraisals" name="appraisals[]" multiple>
                                @foreach($appraisals as $appraisal)
                                <option value="{{$appraisal->id}}">
                                    {{$appraisal->address?->unit_number ? $appraisal->address->unit_number."/" : ""}}{{$appraisal->address?->street}}, {{$appraisal->address?->city}} ({{$appraisal->appraisal_value}})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="contacts"> Contact</label>
                            <select class="select2 select2-label form-select" id="contacts" name="contacts[]" multiple>
                                @foreach($contacts as $contact)
                                <option value="{{$contact->id}}">
                                    {{$contact->first_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="contracts"> Contract</label>
                            <select class="select2 select2-label form-select" id="contracts" name="contracts[]" multiple>
                                @foreach($contracts as $contract)
                                <option value="{{$contract->id}}">
                                    {{$contract->listing?->address?->unit_number ? $contract->listing->address->unit_number."/" : ""}}{{$contract->listing?->address->street}}, {{$contract->listing?->address->city}}

                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- <div class="mb-4">
                            <label class="form-label">Comment</label>
                            <div class="comment-editor border-bottom-0"></div>
                            <div class="d-flex justify-content-end">
                                <div class="comment-toolbar">
                                    <span class="ql-formats me-0">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-link"></button>
                                        <button class="ql-image"></button>
                                    </span>
                                </div>
                            </div>
                        </div> -->
                        <div class="d-flex flex-wrap">
                            <button type="submit" class="btn btn-primary me-3" id="update-btn" data-bs-dismiss="offcanvas">
                                Update
                            </button>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">
                                Close
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Activities -->
                <div class="tab-pane fade" id="tab-activity" role="tabpanel">
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <span class="avatar-initial bg-label-success rounded-circle">HJ</span>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Jordan</span> Left the board.
                            </p>
                            <small class="text-muted">Today 11:00 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Dianna</span> mentioned
                                <span class="text-primary">@bruce</span> in
                                a comment.
                            </p>
                            <small class="text-muted">Today 10:20 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Martian</span> added moved
                                Charts & Maps task to the done board.
                            </p>
                            <small class="text-muted">Today 10:00 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Barry</span> Commented on App
                                review task.
                            </p>
                            <small class="text-muted">Today 8:32 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <span class="avatar-initial bg-label-secondary rounded-circle">BW</span>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Bruce</span> was assigned
                                task of code review.
                            </p>
                            <small class="text-muted">Today 8:30 PM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <span class="avatar-initial bg-label-danger rounded-circle">CK</span>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Clark</span> assigned task UX
                                Research to
                                <span class="text-primary">@martian</span>
                            </p>
                            <small class="text-muted">Today 8:00 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Ray</span> Added moved
                                <span class="fw-medium">Forms & Tables</span> task
                                from in progress to done.
                            </p>
                            <small class="text-muted">Today 7:45 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Barry</span> Complete all the
                                tasks assigned to him.
                            </p>
                            <small class="text-muted">Today 7:17 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <span class="avatar-initial bg-label-success rounded-circle">HJ</span>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Jordan</span> added task to
                                update new images.
                            </p>
                            <small class="text-muted">Today 7:00 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Dianna</span> moved task
                                <span class="fw-medium">FAQ UX</span> from in
                                progress to done board.
                            </p>
                            <small class="text-muted">Today 7:00 AM</small>
                        </div>
                    </div>
                    <div class="media mb-4 d-flex align-items-start">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <span class="avatar-initial bg-label-danger rounded-circle">CK</span>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Clark</span> added new board
                                with name <span class="fw-medium">Done</span>.
                            </p>
                            <small class="text-muted">Yesterday 3:00 PM</small>
                        </div>
                    </div>
                    <div class="media d-flex align-items-center">
                        <div class="avatar me-2 flex-shrink-0 mt-1">
                            <span class="avatar-initial bg-label-secondary rounded-circle">BW</span>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">
                                <span class="fw-medium">Bruce</span> added new task
                                in progress board.
                            </p>
                            <small class="text-muted">Yesterday 12:00 PM</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection