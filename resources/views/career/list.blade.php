@extends('layouts.panel')

@section('content')
<section id="main" class="col-lg-10 p-4">
    <div class="career-list table-responsive">
        <h1 class="title-text mb-4">İş Başvuruları</h1>
        <table class="table table-hover table-list">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">İsim</th>
                    <th scope="col">Soyisim</th>
                    <th scope="col">Telefon No</th>
                    <th scope="col">Başvurulan Pozisyon</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody id="table">
                @foreach ($applications as $index => $application)
                    <tr>
                        <th id="toggle-icon-{{ $index }}" data-bs-toggle="collapse" href="#{{ $index }}" role="button"
                            aria-expanded="false" aria-controls="{{ $index }}" scope="row">
                            <i id="icon-{{ $index }}" class="bi bi-eye-fill"></i>
                        </th>
                        <td>{{ $application->ad }}</td>
                        <td>{{ $application->soyad }}</td>
                        <td>{{ $application->phone }}</td>
                        <td>
                            @if ($application->position == 'general_app')
                                Genel Başvuru
                            @elseif ($application->position == 'developer')
                                Yazılım Geliştirici
                            @elseif ($application->position == 'designer')
                                Grafik Tasarımcı
                            @elseif ($application->position == 'seoExpert')
                                SEO Uzmanı
                            @elseif ($application->position == 'socialMediaManager')
                                Sosyal Medya Yöneticisi
                            @elseif ($application->position == 'accounting')
                                Muhasebe
                            @elseif ($application->position == 'intern')
                                Stajyer
                            @endif
                        </td>
                        <td class="d-flex gap-2">
                            <button type="button" class="btn btn-small-pink" title="Personel Ata" data-bs-toggle="modal"
                                data-bs-target="#appointPersonalModal" data-career-id="{{ $application->id }}"><i
                                    class="bi bi-person-check"></i></button>
                            <a class="btn btn-small-pink" title="Mail Gönder" href="mailto:{{ $application->email }}?subject=Başvurunuz%20Hakkında&body=Başvurunuzu%20memnuniyetle%20aldık.%0ABaşvuru%20süreci%20halen%20devam%20etmektedir.%0AIlerleme%20hakkında%20en%20kısa%20sürede%20size%20bilgi%20vereceğiz.%0A%0ASaygılarımızla,%0ASEOPix"><i
                                    class="bi bi-envelope"></i></a>
                            <form action="{{ route('admin.career-delete', ['careerId' => $application->id]) }}"
                                method="POST" onsubmit="return confirm('Bu kaydı silmek istediğinizden emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-small-pink" title="Sil">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <div id="{{ $index }}" class="col-12 collapse" data-bs-parent="#table">
                                <div class="col-12 d-flex flex-wrap">
                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>Kişisel Bilgiler</p>
                                        <li>
                                            {{ $application->email }}
                                        </li>
                                        <li>
                                            @if ($application->gender == 'male')
                                                Erkek
                                            @else
                                                Kadın
                                            @endif
                                        </li>
                                        <li>
                                            Doğum T: {{ $application->dogum_yili }}
                                        </li>
                                        <li>
                                            Doğum Y: {{ $application->birth_place }}
                                        </li>
                                        <li>
                                            Medeni H: @if ($application->marital_status == 'single')
                                                Bekar
                                            @else
                                                Evli
                                            @endif
                                        </li>
                                        <li>
                                            Kan G: {{ $application->blood_type }}
                                        </li>
                                        <li>
                                            Adres: {{ $application->address }}
                                        </li>
                                        <li>
                                            Not: {{ $application->note }}
                                        </li>
                                        <li>
                                            Sosyal Medya: {{ $application->social_media }}
                                        </li>
                                    </ul>

                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>Eğitim Bilgileri</p>
                                        @foreach ($application->education_details as $education)
                                            <li class="mt-2">
                                                @if ($education['type'] == 'primary')
                                                    İlkokul
                                                @elseif ($education['type'] == 'secondary')
                                                    Ortaokul
                                                @elseif ($education['type'] == 'highschool')
                                                    Lise
                                                @elseif ($education['type'] == 'university')
                                                    Üniversite
                                                @elseif ($education['type'] == 'master')
                                                    Yüksek Lisans
                                                @elseif ($education['type'] == 'doctorate')
                                                    Doktora
                                                @endif
                                            </li>
                                            <li>Okul: {{ $education['school'] }}</li>
                                            <li>Bölüm: {{ $education['department'] }}</li>
                                            <li>Mezuniyet Yılı: {{ $education['graduation_year'] }}</li>
                                        @endforeach
                                    </ul>

                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>İş Bilgileri</p>
                                        @foreach ($application->work_details as $work)
                                            <li class="mt-2">
                                                Firma Adı: {{ $work['name'] }}
                                            </li>
                                            <li>
                                                Firma T: {{ $work['phone'] }}
                                            </li>
                                            <li>
                                                Departman: {{ $work['department'] }}
                                            </li>
                                            <li>
                                                Başlangıç T: {{ $work['start_date'] }}
                                            </li>
                                            <li>
                                                Bitiş T: {{ $work['finish_date'] }}
                                            </li>
                                        @endforeach
                                    </ul>

                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>Referans Bilgileri</p>
                                        @foreach ($application->reference_details as $reference)
                                            <li class="mt-2">
                                                Tür: @if ($reference['type'] == 'professional')
                                                    Profesyonel
                                                @else
                                                    Kişisel
                                                @endif
                                            </li>
                                            <li>
                                                Adı: {{ $reference['name'] }}
                                            </li>
                                            <li>
                                                Telefon: {{ $reference['phone'] }}
                                            </li>
                                        @endforeach
                                    </ul>

                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>Dil Bilgileri</p>
                                        @foreach ($application->language_details as $language)
                                            <li class="mt-2">
                                                @if ($language['type'] == 'english')
                                                    İngilizce
                                                @elseif ($language['type'] == 'france')
                                                    Fransızca
                                                @elseif ($language['type'] == 'arabic')
                                                    Arapça
                                                @elseif ($language['type'] == 'german')
                                                    Almanya
                                                @endif
                                            </li>
                                            <li>
                                                Seviye: @if ($language['level'] == 'beginning')
                                                    Başlangıç
                                                @elseif ($language['level'] == 'intermediate')
                                                    Orta
                                                @elseif ($language['level'] == 'good')
                                                    İyi
                                                @elseif ($language['level'] == 'very_good')
                                                    Çok İyi
                                                @endif
                                            </li>
                                            <li>
                                                Deneyim: @if ($language['experience'] == '1')
                                                    1-3 Yıl
                                                @elseif ($language['experience'] == '3')
                                                    3-5 Yıl
                                                @elseif ($language['experience'] == '5')
                                                    5-10 Yıl
                                                @elseif ($language['experience'] == '10')
                                                    +10 Yıl
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>

                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>Yetenekler</p>
                                        @foreach ($application->experience_details as $experience)
                                            <li class="mt-2">
                                                @if ($experience['type'] == 'office')
                                                    Ofis Programları
                                                @elseif ($experience['type'] == 'mail')
                                                    Mail Yazılımı
                                                @endif
                                            </li>
                                            <li>
                                                Seviye: @if ($experience['level'] == 'beginning')
                                                    Başlangıç
                                                @elseif ($experience['level'] == 'intermediate')
                                                    Orta
                                                @elseif ($experience['level'] == 'good')
                                                    İyi
                                                @elseif ($experience['level'] == 'very_good')
                                                    Çok İyi
                                                @endif
                                            </li>
                                            <li>
                                                Deneyim: @if ($experience['year'] == '1')
                                                    1-3 Yıl
                                                @elseif ($experience['year'] == '3')
                                                    3-5 Yıl
                                                @elseif ($experience['year'] == '5')
                                                    5-10 Yıl
                                                @elseif ($experience['year'] == '10')
                                                    +10 Yıl
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                    <ul class="col-12 col-md-6 col-lg-4">
                                        <p>Diğer Bilgiler</p>
                                            <li class="mt-2">
                                                Sabıka Kaydı Var mı: @if ($application['criminal_record'] == 'yes')
                                                    Evet
                                                @else
                                                    Hayır
                                                @endif
                                            </li>
                                            <li>
                                                Sigara Kullanıyor mu: @if ($application['smoking'] == 'yes')
                                                    Evet
                                                @else
                                                    Hayır
                                                @endif
                                            </li>
                                            <li>
                                                Seyahat Engeli Var mı: @if ($application['travel_ban'] == 'yes')
                                                    Evet
                                                @else
                                                    Hayır
                                                @endif
                                            </li>
                                            <li>
                                                Herhangi Bir Engel Durumu Var mı: @if ($application['disability_situation'] == 'yes')
                                                    Evet
                                                @else
                                                    Hayır
                                                @endif
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
<div class="modal fade" id="appointPersonalModal" tabindex="-1" aria-labelledby="appointPersonalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="appointPersonalForm" method="POST"
                action="{{ route('admin.appoint-personal', ['careerId' => 0]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="appointPersonalModalLabel">Personel Atama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="careerId" name="careerId">
                    <div class="mb-3">
                        <label for="position" class="form-label">Pozisyon Seçin</label>
                        <select class="form-select" id="position" name="position">
                            <option value="developer">Yazılım Geliştirici</option>
                            <option value="designer">Grafik Tasarımcı</option>
                            <option value="seoExpert">SEO Uzmanı</option>
                            <option value="socialMediaManager">Sosyal Medya Yöneticisi</option>
                            <option value="accounting">Muhasebe</option>
                            <option value="intern">Stajyer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button> -->
                    <button type="submit" class="btn btn-pink">Atama Yap</button>
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
    var appointPersonalModal = document.getElementById('appointPersonalModal');
    appointPersonalModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var careerId = button.getAttribute('data-career-id');
        var form = document.getElementById('appointPersonalForm');
        form.action = '{{ route("admin.appoint-personal", ":careerId") }}'.replace(':careerId', careerId);
    });
</script>
@stop