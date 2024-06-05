<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top"
        style="box-shadow:20px 19px 34px -15px rgba(0, 0, 0, 0.5)!important;border-right:1px solid rgba(0, 0, 0, 0.5);">
        <a class="sidebar-brand brand-logo" href="{{ route('dashboard') }}">
            <h5>Nine Livechat App</h5>
        </a>
        <a class="sidebar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <h5>Nine</h5>
        </a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="{{ asset('images/user.jpg') }}" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">
                            {{ strlen($admin->name) > 15 ? substr($admin->name, 0, 15) . '...' : $admin->name }}
                        </h5>
                        <span>{{ ucfirst($admin->type) }}</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                    aria-labelledby="profile-dropdown">
                    <a href="javascript:void(0)" class="dropdown-item preview-item" data-toggle="modal"
                        data-target="#myProfileModal">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-account-box text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">My Profile</p>
                        </div>
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Logout</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items {{ $url === '/' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li
            class="nav-item menu-items {{ $url === '/events' || $url === '/events/create-new' || $url === '/events/detail' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('events') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-calendar-month"></i>
                </span>
                <span class="menu-title">All Events</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ $url === '/all-administrators' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('all-administrators') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-account-group"></i>
                </span>
                <span class="menu-title">All Administrators</span>
            </a>
        </li>
    </ul>
</nav>
