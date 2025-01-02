@php
  $user = auth()->user();   
@endphp
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <div class="d-flex sidebar-profile">
          <div class="sidebar-profile-image">
            <img src="{{ $user->photo }}" alt="image">
            <span class="sidebar-status-indicator"></span>
          </div>
          <div class="sidebar-profile-name">
            <p class="sidebar-name">
              {{ $user->name }}
            </p>
            <p class="sidebar-designation">
              Welcome
            </p>
          </div>
        </div>        
        <p class="sidebar-menu-title">Dash menu</p>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <i class="typcn typcn-device-desktop menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteNamed('emission.index') ? 'active' : '' }}" href="{{ route('emission.index') }}">
          <i class="typcn typcn-th-list menu-icon"></i>
          <span class="menu-title">Emissions</span>
        </a>
      </li> 
      @if($user->user_role == \App\Lib\UserRole::ADMIN_ROLE)
        <li class="nav-item">
          <a class="nav-link {{ Route::currentRouteNamed('dashboard.contact.us') ? 'active' : '' }}" href="{{ route('dashboard.contact.us') }}">
            <i class="typcn typcn-mail menu-icon"></i>
            <span class="menu-title">Contact Us</span>
          </a>
        </li>
      @endif
    </ul>
  </nav>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">