@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/commonMaster' )

@php
/* Display elements */
$contentNavbar = ($contentNavbar ?? true);
$containerNav = ($containerNav ?? 'container-xxl');
$isNavbar = ($isNavbar ?? true);
$isMenu = ($isMenu ?? true);
$isFlex = ($isFlex ?? false);
$isFooter = ($isFooter ?? true);
$customizerHidden = ($customizerHidden ?? '');

/* HTML Classes */
$navbarDetached = 'navbar-detached';
$menuFixed = (isset($configData['menuFixed']) ? $configData['menuFixed'] : '');
if(isset($navbarType)) {
$configData['navbarType'] = $navbarType;
}
$navbarType = (isset($configData['navbarType']) ? $configData['navbarType'] : '');
$footerFixed = (isset($configData['footerFixed']) ? $configData['footerFixed'] : '');
$menuCollapsed = (isset($configData['menuCollapsed']) ? $configData['menuCollapsed'] : '');

/* Content classes */
$container = (isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';

@endphp

@section('layoutContent')
<div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
  <div class="layout-container">

    @if ($isMenu)
    @include('layouts/sections/menu/verticalMenu')
    @endif


    <!-- Layout page -->
    <div class="layout-page">

      @if(session('error'))
      <div class="container-xxl container-p-y pb-0 mb-0">
        <div class="row">
          <div class="col-md">
            <div class="alert alert-danger alert-dismissible" role="alert">
              {{session('error')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              </button>
            </div>
          </div>
        </div>
      </div>
      @endif

      @if(session('success'))
      <div class="container-xxl container-p-y pb-0 mb-0">
        <div class="row">
          <div class="col-md">
            <div class="alert alert-success alert-dismissible" role="alert">
              {{session('success')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              </button>
            </div>
          </div>
        </div>
      </div>
      @endif



      {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}
      {{-- <x-banner /> --}}

      <!-- BEGIN: Navbar-->
      @if ($isNavbar)
      @include('layouts/sections/navbar/navbar')
      @endif
      <!-- END: Navbar-->


      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        @if ($isFlex)
        <div class="{{$container}} d-flex align-items-stretch flex-grow-1 p-0">
          @else
          <div class="{{$container}} flex-grow-1 container-p-y">
            @endif

            @yield('content')

          </div>
          <!-- / Content -->

          <!-- Footer -->
          @if ($isFooter)
          @include('layouts/sections/footer/footer')
          @endif
          <!-- / Footer -->
          <div class="content-backdrop fade"></div>
        </div>
        <!--/ Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    @if ($isMenu)
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    @endif
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->
  @endsection