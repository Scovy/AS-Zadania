<div class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('candidate.dashboard') ? 'active' : '' }}" 
                   href="{{ route('candidate.dashboard') }}">
                    <i class="bi bi-house-door"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('candidate.profile') ? 'active' : '' }}" 
                   href="{{ route('candidate.profile') }}">
                    <i class="bi bi-person"></i>Mój profil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('candidate.applications') ? 'active' : '' }}" 
                   href="{{ route('candidate.applications') }}">
                    <i class="bi bi-file-earmark-text"></i>Moje aplikacje
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="bi bi-briefcase"></i>Przeglądaj oferty
                </a>
            </li>
        </ul>
    </div>
</div>
