@extends('layouts.panel')

@section('content')

<section id="main" class="col-lg-10 p-4">
    <div class="table-list col-12 table-responsive">
        <h1 class="title-text mb-4">Personel Listesi</h1>
        <table class="table table-striped table-borderless table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">İsim Soyisim</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Telefon No</th>
                    <th scope="col">Pozisyon</th>
                    <th scope="col">Rol</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                    <th id="toggle-icon-{{ $index }}" data-bs-toggle="collapse" href="#{{ $index }}" role="button"
                            aria-expanded="false" aria-controls="{{ $index }}" scope="row">
                            <i id="icon-{{ $index }}" class="bi bi-eye-fill"></i>
                        </th>
                        <td> {{ $user->name }}</td>
                        <td> {{ $user->email }}</td>
                        <td> {{ $user->phone }}</td>
                        <td>
                            @if ($user->position == 'developer')
                                Yazılım Geliştirici
                            @elseif ($user->position == 'CEO')
                                CEO
                            @elseif ($user->position == 'designer')
                                Grafik Tasarımcı
                            @elseif ($user->position == 'seoExpert')
                                SEO Uzmanı
                            @elseif ($user->position == 'socialMediaManager')
                                Sosyal Medya Yöneticisi
                            @elseif ($user->position == 'accounting')
                                Muhasebe
                            @elseif ($user->position == 'videoEditor')
                                Video Editörü
                            @elseif ($user->position == 'projectManager')
                                Proje Yöneticisi
                            @elseif ($user->position == 'intern')
                                Stajyer
                            @endif
                        </td>
                        <td>
                            @if ($user->role == 'admin')
                                Admin
                            @elseif ($user->role == 'personal')
                                Personel
                            @endif
                        </td>
                        <td class="d-flex gap-2">
                            <form action="{{ route('admin.toggle-role', ['id' => $user->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-small-pink" title="Admin Yap">
                                    <i class="bi bi-person-fill-gear"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirmDelete(this);">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-small-pink" title="Sil">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>

                            <a class="btn btn-small-pink" href="{{ route('admin.personel-edit', $user->id) }}"><i
                                    class="bi bi-pencil-square"></i></a>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <div id="{{ $index }}" class="col-12 collapse" data-bs-parent="#table">
                                <div class="col-12 d-flex flex-wrap">
                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>Kişisel Bilgiler</p>
                                        <li>
                                            İBAN: {{ $user->iban }}
                                        </li>
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
<script>
    function confirmDelete(form) {
        if (confirm("Kullanıcıyı silmek istediğinize emin misiniz")) {
            return true;
        }
        return false;
    }
</script>
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
@stop


{{-- <x-app-layout>
    <table class="w-3/4 mt-4 mx-auto text-base text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    İsim Soyisim
                </th>
                <th scope="col" class="px-6 py-3">
                    E-mail
                </th>
                <th scope="col" class="px-6 py-3">
                    Telefon No
                </th>
                <th scope="col" class="px-6 py-3">
                    Pozisyon
                </th>
                <th scope="col" class="px-6 py-3">
                    Rol
                </th>
                <th scope="col" class="px-6 py-3">
                    İşlemler
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $user->name }}
                </th>
                <td class="px-6 py-4 text-center">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4 text-center">
                    {{ $user->phone }}
                </td>
                <td class="px-6 py-4 text-center">
                    @if ($user->position == 'developer')
                    Yazılım Geliştirici
                    @elseif ($user->position == 'CEO')
                    CEO
                    @elseif ($user->position == 'designer')
                    Grafik Tasarımcı
                    @elseif ($user->position == 'seoExpert')
                    SEO Uzmanı
                    @elseif ($user->position == 'socialMediaManager')
                    Sosyal Medya Yöneticisi
                    @elseif ($user->position == 'intern')
                    Stajyer
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    @if ($user->role == 'admin')
                    Admin
                    @elseif ($user->role == 'personal')
                    Personel
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <form action="{{ route('admin.toggle-role', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            @if ($user->role == 'admin')
                            Personel Yap
                            @elseif ($user->role == 'personal')
                            Admin Yap
                            @endif
                        </button>
                    </form>
                    <form action="{{ route('admin.destroy', $user->id) }}" method="POST"
                        onsubmit="return confirmDelete(this);">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sil</button>
                    </form>
                    <a href="{{ route('admin.personel-edit', $user->id) }}">Düzenle</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(form) {
            if (confirm("Kullanıcıyı silmek istediğinize emin misiniz")) {
                return true;
            }
            return false;
        }
    </script>
</x-app-layout> --}}