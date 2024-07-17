@extends('layouts.panel')

@section('content')

<section id="main" class="col-lg-10 p-4">
    <div class="table-list col-12">
        <h1 class="title-text mb-4">İstek Ve Talepler</h1>
        <div class="dropdown mb-4">
            <button class="btn btn-pink dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-funnel-fill"></i>
            </button>
            <div class="dropdown-menu p-4 col-3" aria-labelledby="filterDropdown">
                <form method="GET" action="{{ route('admin.demand-list') }}">
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
                        <label for="sender" class="form-label">Gönderen</label>
                        <select name="sender" id="sender" class="form-select">
                            <option value="">Hepsi</option>
                            @foreach ($senders as $sender)
                                <option value="{{ $sender->id }}" {{ request('sender') == $sender->id ? 'selected' : '' }}>
                                    {{ $sender->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-pink">Filtrele</button>
                </form>
            </div>
        </div>
        <table class="table table-striped table-borderless table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"><a
                            href="{{ route('admin.demand-list', ['sort_by' => 'created_at', 'sort_order' => $sort_order === 'asc' ? 'desc' : 'asc']) }}">Tarih</a>
                    </th>
                    <th scope="col">Gönderen</th>
                    <th scope="col"><a
                            href="{{ route('admin.demand-list', ['sort_by' => 'status', 'sort_order' => $sort_order === 'asc' ? 'desc' : 'asc']) }}">Durum</a>
                    </th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demands as $index => $demand)
                    <tr>
                        <th id="toggle-icon-{{ $index }}" data-bs-toggle="collapse" href="#{{ $index }}" role="button"
                            aria-expanded="false" aria-controls="{{ $index }}" scope="row">
                            <i id="icon-{{ $index }}" class="bi bi-eye-fill"></i>
                        </th>
                        <td>
                            @if ($demand->created_at->isToday())
                                {{ $demand->created_at->format('H:i') }}
                            @else
                                {{ $demand->created_at->format('d.m.Y') }}
                            @endif
                        </td>
                        <td> {{ $demand->anonymous ? 'Anonim' : $demand->name }}</td>
                        <td>
                            @if ($demand->status == 'pending')
                                <span class="badge bg-warning text-dark">Değerlendiriliyor</span>
                            @elseif ($demand->status == 'approved')
                                <span class="badge bg-success">Onaylandı</span>
                            @elseif ($demand->status == 'rejected')
                                <span class="badge bg-danger">Reddedildi</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            @if ($demand->status == 'pending')
                                <button class="btn btn-small-pink approve-btn" data-id="{{ $demand->id }}" title="Onayla">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <button class="btn btn-small-pink reject-btn" data-id="{{ $demand->id }}" title="Reddet">
                                    <i class="bi bi-ban"></i>
                                </button>
                            @endif
                            <form action="{{ route('admin.demand-delete', ['id' => $demand->id]) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-small-pink" title="Sil">
                                    <i class="bi bi-x-lg"></i>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <div id="{{ $index }}" class="col-12 collapse" data-bs-parent="#table">
                                <div class="col-12 d-flex flex-wrap">
                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>{{ $demand->title }}</p>
                                        <li>
                                            {{ $demand->content }}
                                        </li>
                                        @if ($demand->response)
                                            <li class="mt-3">
                                                <strong>Admin Yanıtı:</strong> {{ $demand->response }}
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="approveForm" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Onayla</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="response" placeholder="Yanıtınızı buraya girin..."
                        class="form-control mb-2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-pink">Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reddet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="response" placeholder="Yanıtınızı buraya girin..."
                        class="form-control mb-2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-pink">Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('[id^="toggle-icon-"]').forEach(item => {
            item.addEventListener('click', event => {
                const icon = event.currentTarget.querySelector('i');
                if (icon.classList.contains('bi-eye-fill')) {
                    icon.classList.remove('bi-eye-fill');
                    icon.classList.add('bi-eye-slash-fill');
                } else {
                    icon.classList.remove('bi-eye-slash-fill');
                    icon.classList.add('bi-eye-fill');
                }
            });
        });
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function () {
                const demandId = this.getAttribute('data-id');
                const formAction = `{{ url('/istek-listesi/onayla') }}/${demandId}`;
                document.getElementById('approveForm').setAttribute('action', formAction);
                new bootstrap.Modal(document.getElementById('approveModal')).show();
            });
        });

        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                const demandId = this.getAttribute('data-id');
                const formAction = `{{ url('/istek-listesi/reddet') }}/${demandId}`;
                document.getElementById('rejectForm').setAttribute('action', formAction);
                new bootstrap.Modal(document.getElementById('rejectModal')).show();
            });
        });
    });
</script>
@endsection