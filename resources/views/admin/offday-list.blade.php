@extends('layouts.panel')

@section('content')

<section id="main" class="col-lg-10 p-4">
    <div class="table-list col-12">
        <h1 class="title-text mb-4">İzin Talepleri</h1>
        <div class="dropdown mb-4">
            <button class="btn btn-pink dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-funnel-fill"></i>
            </button>
            <div class="dropdown-menu p-4 col-3" aria-labelledby="filterDropdown">
                <form method="GET" action="{{ route('admin.offday-list') }}">
                    <div class="mb-3">
                        <label for="year" class="form-label">Yıl</label>
                        <select name="year" id="year" class="form-select">
                            <option value="">Hepsi</option>
                            @for ($i = 2020; $i <= now()->year; $i++)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Ay</label>
                        <select name="month" id="month" class="form-select">
                            <option value="">Hepsi</option>
                            @foreach (['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'] as $i => $month)
                                <option value="{{ $i + 1 }}" {{ request('month') == $i + 1 ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user" class="form-label">Gönderen</label>
                        <select name="user" id="user" class="form-select">
                            <option value="">Hepsi</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-pink">Filtrele</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-borderless table-hover">
                <thead>
                    <tr>
                        <th scope="col">İsim Soyisim</th>
                        <th scope="col">Başlangıç T.</th>
                        <th scope="col">Bitiş T.</th>
                        <th scope="col">Gün Sayısı</th>
                        <th scope="col">Durum</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dayRequest as $days)
                    <tr>
                        <td>
                            @foreach ($users as $index => $user)
                            @if ($user->id == $days->user_id)
                            {{ $user->name }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $days->start_date }}</td>
                        <td>{{ $days->end_date }}</td>
                        <td>{{ $days->daysRequested }}</td>
                        <td>
                            @if ($days->status == 'Pending')
                            <span class="badge text-bg-warning">Bekliyor</span>
                            @elseif ($days->status == 'approved')
                            <span class="badge text-bg-success">Onaylandı</span>
                            @elseif ($days->status == 'rejected')
                            <span class="badge text-bg-danger">Reddedildi</span>
                            @endif
                        </td>
                        <td class="gap-2">
                            @if ($days->status == 'Pending')
                                <form action="{{ route('auth.toggle-approved', ['id' => $days->id]) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-small-pink" title="Onayla">
                                        <i class="bi bi-check-lg"></i>
                                    </form>
                                </button>
                                <form action="{{ route('auth.toggle-rejected', ['id' => $days->id]) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-small-pink" title="Reddet">
                                    <i class="bi bi-ban"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop