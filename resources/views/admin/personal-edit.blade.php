@extends ('layouts.panel')

@section('content')
    <section id="main" class="col-lg-10 p-4">
        <h1 class="title-text mb-4">Personel Düzenle</h1>
        <div class="d-flex flex-column align-items-center gap-2">
            <form class="d-flex flex-wrap align-items-center justify-content-center gap-2 gap-lg-4 px-lg-5 py-lg-2"
                method="POST" action="{{ route('admin.personel-update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="name" class="form-label">Ad Soyad</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                        required autofocus autocomplete="name" />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="position" class="form-label">Pozisyon</label>
                    <select id="position" name="position" class="form-select" aria-label="Default select example">
                        <option value="developer" {{ $user->position == 'developer' ? 'selected' : '' }}>Yazılım Geliştirici
                        </option>
                        <option value="designer" {{ $user->position == 'designer' ? 'selected' : '' }}>Grafik Tasarımcı
                        </option>
                        <option value="seoExpert" {{ $user->position == 'seoExpert' ? 'selected' : '' }}>SEO Uzmanı</option>
                        <option value="socialMediaManager" {{ $user->position == 'socialMediaManager' ? 'selected' : '' }}>
                            Sosyal Medya Yöneticisi</option>
                        <option value="accounting" {{ $user->position == 'accounting' ? 'selected' : '' }}>Muhasebe</option>
                        <option value="intern" {{ $user->position == 'intern' ? 'selected' : '' }}>Stajyer</option>
                    </select>
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="phone" class="form-label">Telefon</label>
                    <input type="phone" class="form-control" id="exampleFormControlInput1"name="phone"
                        value="{{ $user->phone }}" required />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
                        value="{{ $user->email }}" required />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="offday" class="form-label">İzin Günü</label>
                    <input type="number" class="form-control" id="exampleFormControlInput1" name="offday"
                        value="{{ $user->offday }}" min="0" max="50" required />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="iban" class="form-label">İBAN</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="iban"
                        value="{{ $user->iban }}"/>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-pink">
                        <i class="bi bi-check-lg me-2"></i>Kaydet
                    </button>
                </div>
            </form>
        </div>
    </section>
@stop
