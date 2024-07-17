@extends('layouts.panel')

@section('content')

<section id="main" class="col-lg-10 p-4">
    @if (Auth::check() && Auth::user()->role === 'admin')
        <h1 class="title-text mb-4">Dashbord</h1>
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Kullanıcılar</p>
                                    <h4 class="card-title">{{ $totalUsers }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success">
                                    <i class="bi bi-calendar-event-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Aktif İzin Talepleri</p>
                                    <h4 class="card-title">{{ $activeRequestsCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-pink">
                                    <i class="bi bi-calendar-check-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Toplam İzin Talepleri</p>
                                    <h4 class="card-title">{{ $totalLeaveRequests }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-yellow">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">İş Başvuruları</p>
                                    <h4 class="card-title">{{ $totalApplications }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-red">
                                    <i class="bi bi-envelope-paper-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Toplam Talepler</p>
                                    <h4 class="card-title">{{ $totalDemands }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-orange">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Aktif Talepler</p>
                                    <h4 class="card-title">{{ $activeDemandCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-aqua">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Toplam Etkinlikler</p>
                                    <h4 class="card-title">{{ $totalEvents }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif (Auth::check() && Auth::user()->role === 'personal')
        <h1 class="title-text mb-4">Ana Sayfa</h1>
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                            <div class="icon-big text-center icon-orange">
                                    <i class="bi bi-calendar-event-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Beklenen İzin Taleplerim</p>
                                    <h4 class="card-title">{{ $userActiveLeaveRequestsCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-pink">
                                    <i class="bi bi-calendar-check-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Toplam İzin Taleplerim</p>
                                    <h4 class="card-title">{{ $userLeaveRequestsCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-yellow">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Beklenen Taleplerim</p>
                                    <h4 class="card-title">{{ $userActiveLeaveDemandsCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-red">
                                    <i class="bi bi-envelope-paper-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Toplam Taleplerim</p>
                                    <h4 class="card-title">{{ $userLeaveDemandsCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

@stop