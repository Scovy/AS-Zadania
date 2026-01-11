<div class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employer.dashboard') ? 'active' : '' }}" 
                   href="{{ route('employer.dashboard') }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employer.profile') ? 'active' : '' }}" 
                   href="{{ route('employer.profile') }}">
                    <i class="bi bi-building"></i> Profil firmy
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employer.offers*') ? 'active' : '' }}" 
                   href="{{ route('employer.offers') }}">
                    <i class="bi bi-briefcase"></i> Moje oferty
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employer.applications*') ? 'active' : '' }}" 
                   href="{{ route('employer.applications.all') }}">
                    <i class="bi bi-people"></i> Aplikacje
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('employer.offers.create') }}">
                    <i class="bi bi-plus-circle"></i> Dodaj ofertę
                </a>
            </li>
        </ul>
    </div>
</div>
