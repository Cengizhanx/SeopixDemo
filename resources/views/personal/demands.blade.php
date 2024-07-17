@extends('layouts.panel')

@section('content')
<section id="main" class="col-lg-10 p-4">
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
            <h1 class="title-text">İstek ve Talepler</h1>
            <button type="button" class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#demandModal">
                İstek Gönder
            </button>
        </div>
        <div class="col-md-12">
            <div class="table-list col-12 table-responsive">
                <table class="table table-striped table-borderless table-hover">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Konu Başlığı</th>
                            <th scope="col">Tarih</th>
                            <th scope="col">Durumu</th>
                            <th scope="col">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demands as $index => $demand)
                            <tr>
                                <th id="toggle-icon-{{ $index }}" data-bs-toggle="collapse" href="#{{ $index }}"
                                    role="button" aria-expanded="false" aria-controls="{{ $index }}" scope="row">
                                    <i id="icon-{{ $index }}" class="bi bi-eye-fill"></i>
                                </th>
                                <td>{{ $demand->title }}</td>
                                <td>
                                @if ($demand->created_at->isToday())
                                {{ $demand->created_at->format('H:i') }}
                                @else
                                {{ $demand->created_at->format('d.m.Y') }}
                                @endif
                        </td>
                                <td>
                                    @if ($demand->status == 'pending')
                                        <span class="badge bg-warning text-dark">Değerlendiriliyor</span>
                                    @elseif ($demand->status == 'approved')
                                        <span class="badge bg-success">Onaylandı</span>
                                    @elseif ($demand->status == 'rejected')
                                        <span class="badge bg-danger">Reddedildi</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($demand->status == 'pending')
                                        <button type="button" class="btn btn-small-pink" data-bs-toggle="modal" data-bs-target="#editDemandModal" data-demand="{{ $demand }}" data-demand-id="{{ $demand->id }}"><i
                                        class="bi bi-pencil-square"></i></button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12">
                                    <div id="{{ $index }}" class="col-12 collapse" data-bs-parent="#table">
                                        <div class="col-12 d-flex flex-wrap">
                                            <ul class="col-12 col-md-6 col-lg-4">
                                                <p>İçerik</p>
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
        </div>
    </div>
</section>

<!-- Yeni İstek Modal -->
<div class="modal fade" id="demandModal" tabindex="-1" aria-labelledby="demandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demandModalLabel">İstek ve Talep Gönder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('personal.demands') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Konu Başlığı</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">İçerik</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="anonymous" name="anonymous" value="1">
                        <label class="form-check-label" for="anonymous">Anonim olarak gönder</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-pink">Gönder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Düzenleme Modal -->
<div class="modal fade" id="editDemandModal" tabindex="-1" aria-labelledby="editDemandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDemandModalLabel">İstek ve Talep Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDemandForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editDemandId" name="demand_id">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Konu Başlığı</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editContent" class="form-label">İçerik</label>
                        <textarea class="form-control" id="editContent" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="editAnonymous" name="anonymous" value="1">
                        <label class="form-check-label" for="editAnonymous">Anonim olarak gönder</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-pink">Güncelle</button>
                    </div>
                </form>
            </div>
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

        var editDemandModal = document.getElementById('editDemandModal');
        editDemandModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var demand = button.getAttribute('data-demand');
            demand = JSON.parse(demand);

            document.getElementById('editDemandId').value = demand.id;
            document.getElementById('editTitle').value = demand.title;
            document.getElementById('editContent').value = demand.content;
            document.getElementById('editAnonymous').checked = demand.anonymous == 1;

            var form = document.getElementById('editDemandForm');
            form.action = '{{ route("personal.update-demand", ":demandId") }}'.replace(':demandId', demand.id);
        });
    });
</script>
@stop
