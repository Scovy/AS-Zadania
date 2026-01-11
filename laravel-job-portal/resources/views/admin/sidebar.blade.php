<div class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                   href="{{ route('admin.users') }}">
                    <i class="bi bi-people"></i>Użytkownicy
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tags*') ? 'active' : '' }}" 
                   href="{{ route('admin.tags') }}">
                    <i class="bi bi-tags"></i>Tagi technologii
                </a>
            </li>
        </ul>
    </div>
</div>
