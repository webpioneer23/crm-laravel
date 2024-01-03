@extends('layouts/layoutMaster')

@section('title', 'Chat - Apps')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-chat.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/app-chat.js')}}"></script>
<script>
    // const whitelist = [
    //     'LIM',
    //     'Due Diligence',
    //     'Solicitor Approval',
    //     'Insurance',
    //     'Finance',
    //     'Sale of Property',
    // ];
    const tagListEl = document.querySelector('#numbers');
    const contactList = <?php echo json_encode($contacts); ?>;

    const optionList = contactList.map(item => `${item.first_name}(${item.mobile})`)

    let tagList = new Tagify(tagListEl, {
        whitelist: optionList,
        maxTags: 10,
        dropdown: {
            maxItems: 100,
            classname: '',
            enabled: 0,
            closeOnSelect: false
        }
    });
</script>
@endsection

@section('content')
<div class="app-chat card overflow-hidden">
    <div class="row g-0">
        <!-- Sidebar Left -->
        <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
            <div class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-4 pt-5">
                <div class="avatar avatar-xl avatar-online">
                    <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                </div>
                <h5 class="mt-2 mb-0">John Doe</h5>
                <span>Admin</span>
                <i class="ti ti-x ti-sm cursor-pointer close-sidebar" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left"></i>
            </div>
            <div class="sidebar-body px-4 pb-4">
                <div class="my-4">
                    <small class="text-muted text-uppercase">About</small>
                    <textarea id="chat-sidebar-left-user-about" class="form-control chat-sidebar-left-user-about mt-3" rows="4" maxlength="120">Dessert chocolate cake lemon drops jujubes. Biscuit cupcake ice cream bear claw brownie brownie marshmallow.</textarea>
                </div>
                <div class="my-4">
                    <small class="text-muted text-uppercase">Status</small>
                    <div class="d-grid gap-2 mt-3">
                        <div class="form-check form-check-success">
                            <input name="chat-user-status" class="form-check-input" type="radio" value="active" id="user-active" checked>
                            <label class="form-check-label" for="user-active">Active</label>
                        </div>
                        <div class="form-check form-check-danger">
                            <input name="chat-user-status" class="form-check-input" type="radio" value="busy" id="user-busy">
                            <label class="form-check-label" for="user-busy">Busy</label>
                        </div>
                        <div class="form-check form-check-warning">
                            <input name="chat-user-status" class="form-check-input" type="radio" value="away" id="user-away">
                            <label class="form-check-label" for="user-away">Away</label>
                        </div>
                        <div class="form-check form-check-secondary">
                            <input name="chat-user-status" class="form-check-input" type="radio" value="offline" id="user-offline">
                            <label class="form-check-label" for="user-offline">Offline</label>
                        </div>
                    </div>
                </div>
                <div class="my-4">
                    <small class="text-muted text-uppercase">Settings</small>
                    <ul class="list-unstyled d-grid gap-2 me-3 mt-3">
                        <li class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class='ti ti-message me-1 ti-sm'></i>
                                <span class="align-middle">Two-step Verification</span>
                            </div>
                            <label class="switch switch-primary me-4 switch-sm">
                                <input type="checkbox" class="switch-input" checked="" />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class='ti ti-bell me-1 ti-sm'></i>
                                <span class="align-middle">Notification</span>
                            </div>
                            <label class="switch switch-primary me-4 switch-sm">
                                <input type="checkbox" class="switch-input" />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </li>
                        <li>
                            <i class="ti ti-user-plus me-1 ti-sm"></i>
                            <span class="align-middle">Invite Friends</span>
                        </li>
                        <li>
                            <i class="ti ti-trash me-1 ti-sm"></i>
                            <span class="align-middle">Delete Account</span>
                        </li>
                    </ul>
                </div>
                <div class="d-flex mt-4">
                    <button class="btn btn-primary" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left">Logout</button>
                </div>
            </div>
        </div>
        <!-- /Sidebar Left-->

        <!-- Chat & Contacts -->
        <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
            <div class="sidebar-header">
                <div class="d-flex align-items-center me-3 me-lg-0">
                    <div class="flex-shrink-0 avatar avatar-online me-3" data-bs-toggle="sidebar" data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                        <img class="user-avatar rounded-circle cursor-pointer" src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar">
                    </div>
                    <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                    </div>
                </div>
                <i class="ti ti-x cursor-pointer d-lg-none d-block position-absolute mt-2 me-1 top-0 end-0" data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
            </div>
            <hr class="container-m-nx m-0">
            <div class="sidebar-body">

                <div class="btn-compost-wrapper d-grid p-3">
                    <button class="btn btn-primary btn-compose" data-bs-toggle="modal" data-bs-target="#smsSendModal" id="smsSendModalLabel">Compose</button>
                </div>

                <div class="chat-contact-list-item-title">
                    <h5 class="text-primary mb-0 px-4 pt-3 pb-2">Chats</h5>
                </div>
                <!-- Chats -->
                <ul class="list-unstyled chat-contact-list" id="chat-list">
                    <li class="chat-contact-list-item chat-list-item-0 d-none">
                        <h6 class="text-muted mb-0">No Chats Found</h6>
                    </li>
                    <li class="chat-contact-list-item">
                        <a class="d-flex align-items-center">
                            <div class="flex-shrink-0 avatar avatar-online">
                                <img src="{{asset('assets/img/avatars/13.png')}}" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="chat-contact-info flex-grow-1 ms-2">
                                <h6 class="chat-contact-name text-truncate m-0">Waldemar Mannering</h6>
                                <p class="chat-contact-status text-muted text-truncate mb-0">Refer friends. Get rewards.</p>
                            </div>
                            <small class="text-muted mb-auto">5 Minutes</small>
                        </a>
                    </li>
                    <li class="chat-contact-list-item active">
                        <a class="d-flex align-items-center">
                            <div class="flex-shrink-0 avatar avatar-offline">
                                <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="chat-contact-info flex-grow-1 ms-2">
                                <h6 class="chat-contact-name text-truncate m-0">Felecia Rower</h6>
                                <p class="chat-contact-status text-muted text-truncate mb-0">I will purchase it for sure. 👍</p>
                            </div>
                            <small class="text-muted mb-auto">30 Minutes</small>
                        </a>
                    </li>
                    <li class="chat-contact-list-item">
                        <a class="d-flex align-items-center">
                            <div class="flex-shrink-0 avatar avatar-busy">
                                <span class="avatar-initial rounded-circle bg-label-success">CM</span>
                            </div>
                            <div class="chat-contact-info flex-grow-1 ms-2">
                                <h6 class="chat-contact-name text-truncate m-0">Calvin Moore</h6>
                                <p class="chat-contact-status text-muted text-truncate mb-0">If it takes long you can mail inbox user</p>
                            </div>
                            <small class="text-muted mb-auto">1 Day</small>
                        </a>
                    </li>
                </ul>
                <!-- Contacts -->
                <ul class="list-unstyled chat-contact-list mb-0" id="contact-list">
                    <li class="chat-contact-list-item chat-contact-list-item-title">
                        <h5 class="text-primary mb-0">Contacts</h5>
                    </li>
                    @forelse($contacts as $key => $contact)
                    <li class="chat-contact-list-item">
                        <a class="d-flex align-items-center">
                            <div class="avatar d-block flex-shrink-0">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    {{strtoupper(substr($contact->first_name, 0, 1)).strtoupper(substr($contact->last_name, 0, 1))}}
                                </span>
                            </div>
                            <div class="chat-contact-info flex-grow-1 ms-2">
                                <h6 class="chat-contact-name text-truncate m-0">{{$contact->first_name." ".$contact->last_name}}</h6>
                                <p class="chat-contact-status text-muted text-truncate mb-0">{{$contact->mobile}}</p>
                            </div>
                        </a>
                    </li>
                    @empty
                    <li class="chat-contact-list-item contact-list-item-0 d-none">
                        <h6 class="text-muted mb-0">No Contacts Found</h6>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
        <!-- /Chat contacts -->

        <!-- Chat History -->
        <div class="col app-chat-history bg-body">
            <div class="chat-history-wrapper">
                <div class="chat-history-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex overflow-hidden align-items-center">
                            <i class="ti ti-menu-2 ti-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                            <div class="flex-shrink-0 avatar">
                                <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right">
                            </div>
                            <div class="chat-contact-info flex-grow-1 ms-2">
                                <h6 class="m-0">Felecia Rower</h6>
                                <small class="user-status text-muted">NextJS developer</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ti ti-phone-call cursor-pointer d-sm-block d-none me-3"></i>
                            <i class="ti ti-video cursor-pointer d-sm-block d-none me-3"></i>
                            <i class="ti ti-search cursor-pointer d-sm-block d-none me-3"></i>
                            <div class="dropdown d-flex align-self-center">
                                <button class="btn p-0" type="button" id="chat-header-actions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                                    <a class="dropdown-item" href="javascript:void(0);">View Contact</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mute Notifications</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Block Contact</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-history-body bg-body">
                    <ul class="list-unstyled chat-history">
                        <li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">How can we help? We're here for you! 😄</p>
                                    </div>
                                    <div class="text-end text-muted mt-1">
                                        <i class='ti ti-checks ti-xs me-1 text-success'></i>
                                        <small>10:00 AM</small>
                                    </div>
                                </div>
                                <div class="user-avatar flex-shrink-0 ms-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message">
                            <div class="d-flex overflow-hidden">
                                <div class="user-avatar flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">Hey John, I am looking for the best admin template.</p>
                                        <p class="mb-0">Could you please help me to find it out? 🤔</p>
                                    </div>
                                    <div class="chat-message-text mt-2">
                                        <p class="mb-0">It should be Bootstrap 5 compatible.</p>
                                    </div>
                                    <div class="text-muted mt-1">
                                        <small>10:02 AM</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">{{ config('variables.templateName') ? config('variables.templateName') : 'TemplateName' }} has all the components you'll ever need in a app.</p>
                                    </div>
                                    <div class="text-end text-muted mt-1">
                                        <i class='ti ti-checks ti-xs me-1 text-success'></i>
                                        <small>10:03 AM</small>
                                    </div>
                                </div>
                                <div class="user-avatar flex-shrink-0 ms-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message">
                            <div class="d-flex overflow-hidden">
                                <div class="user-avatar flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">Looks clean and fresh UI. 😃</p>
                                    </div>
                                    <div class="chat-message-text mt-2">
                                        <p class="mb-0">It's perfect for my next project.</p>
                                    </div>
                                    <div class="chat-message-text mt-2">
                                        <p class="mb-0">How can I purchase it?</p>
                                    </div>
                                    <div class="text-muted mt-1">
                                        <small>10:05 AM</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">Thanks, you can purchase it.</p>
                                    </div>
                                    <div class="text-end text-muted mt-1">
                                        <i class='ti ti-checks ti-xs me-1 text-success'></i>
                                        <small>10:06 AM</small>
                                    </div>
                                </div>
                                <div class="user-avatar flex-shrink-0 ms-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message">
                            <div class="d-flex overflow-hidden">
                                <div class="user-avatar flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">I will purchase it for sure. 👍</p>
                                    </div>
                                    <div class="chat-message-text mt-2">
                                        <p class="mb-0">Thanks.</p>
                                    </div>
                                    <div class="text-muted mt-1">
                                        <small>10:08 AM</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">Great, Feel free to get in touch.</p>
                                    </div>
                                    <div class="text-end text-muted mt-1">
                                        <i class='ti ti-checks ti-xs me-1 text-success'></i>
                                        <small>10:10 AM</small>
                                    </div>
                                </div>
                                <div class="user-avatar flex-shrink-0 ms-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message">
                            <div class="d-flex overflow-hidden">
                                <div class="user-avatar flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">Do you have design files for {{ config('variables.templateName') ? config('variables.templateName') : 'TemplateName' }}?</p>
                                    </div>
                                    <div class="text-muted mt-1">
                                        <small>10:15 AM</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1 w-50">
                                    <div class="chat-message-text">
                                        <p class="mb-0">Yes that's correct documentation file, Design files are included with the template.</p>
                                    </div>
                                    <div class="text-end text-muted mt-1">
                                        <i class='ti ti-checks ti-xs me-1'></i>
                                        <small>10:15 AM</small>
                                    </div>
                                </div>
                                <div class="user-avatar flex-shrink-0 ms-3">
                                    <div class="avatar avatar-sm">
                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Chat message form -->
                <div class="chat-history-footer shadow-sm">
                    <form class="form-send-message d-flex justify-content-between align-items-center ">
                        <input class="form-control message-input border-0 me-3 shadow-none" placeholder="Type your message here">
                        <div class="message-actions d-flex align-items-center">
                            <i class="speech-to-text ti ti-microphone ti-sm cursor-pointer"></i>
                            <label for="attach-doc" class="form-label mb-0">
                                <i class="ti ti-photo ti-sm cursor-pointer mx-3"></i>
                                <input type="file" id="attach-doc" hidden>
                            </label>
                            <button class="btn btn-primary d-flex send-msg-btn">
                                <i class="ti ti-send me-md-1 me-0"></i>
                                <span class="align-middle d-md-inline-block d-none">Send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Chat History -->

        <!-- Sidebar Right -->
        <div class="col app-chat-sidebar-right app-sidebar overflow-hidden" id="app-chat-sidebar-right">
            <div class="sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-4 pt-5">
                <div class="avatar avatar-xl avatar-online">
                    <img src="{{asset('assets/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle">
                </div>
                <h6 class="mt-2 mb-0">Felecia Rower</h6>
                <span>NextJS Developer</span>
                <i class="ti ti-x ti-sm cursor-pointer close-sidebar d-block" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right"></i>
            </div>
            <div class="sidebar-body px-4 pb-4">
                <div class="my-4">
                    <small class="text-muted text-uppercase">About</small>
                    <p class="mb-0 mt-3">A Next. js developer is a software developer who uses the Next. js framework alongside ReactJS to build web applications.</p>
                </div>
                <div class="my-4">
                    <small class="text-muted text-uppercase">Personal Information</small>
                    <ul class="list-unstyled d-grid gap-2 mt-3">
                        <li class="d-flex align-items-center">
                            <i class='ti ti-mail ti-sm'></i>
                            <span class="align-middle ms-2">josephGreen@email.com</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class='ti ti-phone-call ti-sm'></i>
                            <span class="align-middle ms-2">+1(123) 456 - 7890</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class='ti ti-clock ti-sm'></i>
                            <span class="align-middle ms-2">Mon - Fri 10AM - 8PM</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-4">
                    <small class="text-muted text-uppercase">Options</small>
                    <ul class="list-unstyled d-grid gap-2 mt-3">
                        <li class="cursor-pointer d-flex align-items-center">
                            <i class='ti ti-badge ti-sm'></i>
                            <span class="align-middle ms-2">Add Tag</span>
                        </li>
                        <li class="cursor-pointer d-flex align-items-center">
                            <i class='ti ti-star ti-sm'></i>
                            <span class="align-middle ms-2">Important Contact</span>
                        </li>
                        <li class="cursor-pointer d-flex align-items-center">
                            <i class='ti ti-photo ti-sm'></i>
                            <span class="align-middle ms-2">Shared Media</span>
                        </li>
                        <li class="cursor-pointer d-flex align-items-center">
                            <i class='ti ti-trash ti-sm'></i>
                            <span class="align-middle ms-2">Delete Contact</span>
                        </li>
                        <li class="cursor-pointer d-flex align-items-center">
                            <i class='ti ti-ban ti-sm'></i>
                            <span class="align-middle ms-2">Block Contact</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Sidebar Right -->

        <div class="app-overlay"></div>
    </div>

    <!-- Compose Email -->
    <div class="app-email-compose modal" id="smsSendModal" tabindex="-1" aria-labelledby="smsSendModalLabel" aria-hidden="true">
        <div class="modal-dialog m-0 me-md-4 mb-4 modal-lg  position-bottom-right">
            <div class="modal-content p-0">
                <div class="modal-header py-3 bg-body">
                    <h5 class="modal-title fs-5">Compose SMS Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 p-4 py-2">
                    <form class="email-compose-form" method="post" action="{{route('sms.store')}}">
                        @csrf
                        <div class="email-compose-to d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0" for="emailContacts">To:</label>
                            <div class="select2-primary border-0 shadow-none flex-grow-1 mx-2">
                                <input id="numbers" name="numbers" class="form-control" placeholder="Select Conditions" required>
                                <!-- <select class="select2 select-email-contacts form-select" id="emailContacts" name="emailContacts" multiple>
                                    <option data-avatar="1.png" value="Jane Foster">Jane Foster</option>
                                    <option data-avatar="3.png" value="Donna Frank">Donna Frank</option>
                                    <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                                    <option data-avatar="7.png" value="Lori Spears">Lori Spears</option>
                                    <option data-avatar="9.png" value="Sandy Vega">Sandy Vega</option>
                                    <option data-avatar="11.png" value="Cheryl May">Cheryl May</option>
                                </select> -->
                            </div>
                        </div>
                        <hr class="container-m-nx my-2">
                        <div class="email-compose-subject d-flex align-items-center mb-2">
                            <textarea class="form-control" id="content" name="content" placeholder="SMS Content" rows="7" required></textarea>
                        </div>
                        <hr class="container-m-nx mt-0 mb-2">
                        <div class="d-flex align-items-center mb-3">
                            <button type="submit" class="btn btn-primary"><i class="ti ti-send ti-xs me-1"></i>Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Compose Email -->
</div>
@endsection