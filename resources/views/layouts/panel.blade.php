<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEOPix</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" href="https://www.seopix.net/front/assets/images/seopix-favicon.ico" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>

<body>
    <div class="col-12 d-flex flex-column flex-lg-row">
        <section class="col-lg-2" id="sidebar">
            <div class="d-none d-lg-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
                <a href="/" class="d-flex align-items-center justify-content-center">
                    <img src="{{ asset('assets/img/logo-white.webp') }}" alt="SEOPix" width="128"
                        height="29" />
                </a>
                <hr />
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="mt-1 nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="page">
                            <i class="bi bi-house me-2"></i>
                            Ana Sayfa
                        </a>
                    </li>
                    @if (Auth::check() && Auth::user()->role === 'personal')
                        <li class="mt-1">
                            <a href="{{ route('personal.request-offday') }}" class="nav-link {{ request()->routeIs('personal.request-offday') ? 'active' : '' }}">
                                <i class="bi bi-calendar me-2"></i>
                                İzin Talebi
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="{{ route('personal.offday-status') }}" class="nav-link {{ request()->routeIs('personal.offday-status') ? 'active' : '' }}">
                                <i class="bi bi-calendar-check me-2"></i>
                                İzin Durumları
                            </a>
                        </li>
                        <li class="mt-1">
                        <a href="{{ route('personal.demands') }}" class="nav-link {{ request()->routeIs('personal.demands') ? 'active' : '' }}" aria-current="page">
                            <i class="bi bi-pencil-square me-2"></i>
                            İstek Ve Talepler
                        </a>
                    </li>
                    @endif

                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <li class="mt-1">
                            <a href="{{ route('admin.personal-list') }}" class="nav-link {{ request()->routeIs('admin.personal-list') ? 'active' : '' }}">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Personel Listesi
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">
                                <i class="bi bi-person-vcard me-2"></i>
                                Personel Kaydı
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="{{ route('admin.offday-list') }}" class="nav-link {{ request()->routeIs('admin.offday-list') ? 'active' : '' }}">
                                <i class="bi bi-calendar me-2"></i>
                                İzin Talepleri
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="{{ route('career.list') }}" class="nav-link {{ request()->routeIs('career.list') ? 'active' : '' }}">
                            <i class="bi bi-person-plus me-2"></i>
                                İş Başvuruları
                            </a>
                        </li>
                        <li class="mt-1">
                        <a href="{{ route('admin.demand-list') }}" class="nav-link {{ request()->routeIs('admin.demand-list') ? 'active' : '' }}" aria-current="page">
                            <i class="bi bi-pencil-square me-2"></i>
                            İstek Ve Talepler
                        </a>
                    </li>
                    @endif
                    <li class="mt-1">
                        <a href="{{ route('auth.events') }}" class="nav-link {{ request()->routeIs('auth.events') ? 'active' : '' }}" aria-current="page">
                            <i class="bi bi-calendar2-week me-2"></i>
                            Etkinlikler
                        </a>
                    </li>
                </ul>
                <hr />
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/img/user.webp') }}" alt="User Avatar" width="30" height="30"
                            class="rounded-circle me-2" />
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                        <!-- <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li> -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                    href="{{ route('logout') }}">Çıkış Yap</a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <nav class="mobile-navbar navbar navbar-expand-lg d-lg-none px-4">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/"><img src="assets/img/logo-white.webp" alt="CD Logo"
                            width="124" height="30" /></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav py-3">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                            aria-current="page" href="{{ route('dashboard') }}"><i
                                    class="bi bi-house me-2"></i>Ana Sayfa</a>
                            @if (Auth::check() && Auth::user()->role === 'personal')
                                <a class="nav-link {{ request()->routeIs('personal.request-offday') ? 'active' : '' }}" 
                                    href="{{ route('personal.request-offday') }}"><i
                                        class="bi bi-calendar me-2"></i> İzin
                                    Talebi</a>
                                <a class="nav-link {{ request()->routeIs('personal.offday-status') ? 'active' : '' }}"
                                     href="{{ route('personal.offday-status') }}"><i
                                        class="bi bi-calendar-check me-2"></i>İzin
                                    Durumları</a>
                            @endif
                            @if (Auth::check() && Auth::user()->role === 'admin')
                                <a class="nav-link {{ request()->routeIs('admin.personal-list') ? 'active' : '' }}"  
                                href="{{ route('admin.personal-list') }}"><i
                                        class="bi bi-person-lines-fill me-2"></i>Personel
                                    Listesi</a>
                                <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                                 href="{{ route('register') }}"><i
                                        class="bi bi-person-vcard me-2"></i>Personel Kaydı</a>
                                <a class="nav-link {{ request()->routeIs('admin.offday-list') ? 'active' : '' }}"
                                 href="{{ route('admin.offday-list') }}"><i
                                        class="bi bi-calendar me-2"></i>İzin
                                    Talepleri</a>
                                <a class="nav-link {{ request()->routeIs('career.list') ? 'active' : '' }}"
                                 href="{{ route('career.list') }}"><i
                                        class="bi bi-person-plus me-2"></i>İş
                                    Başvuruları</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="nav-link"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                    href="{{ route('logout') }}">
                                    <i class="bi bi-door-closed me-2"></i>Çıkış Yap</a>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </section>

        @yield('content')
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
