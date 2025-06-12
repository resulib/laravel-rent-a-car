<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand fw-bold text-primary me-4" href="{{ route('user.home') }}">
            <i class="fas fa-car-side me-2"></i> Rent A Car
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active fw-bold text-primary' : 'text-dark' }}"
                       href="{{ route('user.home') }}">
                        Ana Səhifə
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.cars.index') ? 'active fw-bold text-primary' : 'text-dark' }}"
                       href="{{ route('user.cars.index') }}">
                        Maşınlar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('haqqimizda') ? 'active fw-bold text-primary' : 'text-dark' }}"
                       href="{{ url('/haqqimizda') }}">
                        Haqqımızda
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
