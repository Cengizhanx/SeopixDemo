@extends('layouts.panel')

@section('content')

    <section id="main" class="col-lg-10 p-4">
        <h1 class="title-text mb-4">Personel Kaydı</h1>
        <div class="d-flex flex-column align-items-center gap-2">
            <form class="d-flex flex-wrap align-items-center justify-content-center gap-2 gap-lg-4 px-lg-5 py-lg-2"
                method="POST" action="{{ route('register') }}">
                @csrf
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="name" class="form-label">Ad Soyad</label>
                    <input type="text" class="form-control" id="name" placeholder="Ad Soyad" name="name" required
                        autofocus autocomplete="name" />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="position" class="form-label">Pozisyon</label>
                    <select id="position" name="position" class="form-select" aria-label="Default select example">
                        <option value="developer">Yazılım Geliştirici</option>
                        <option value="designer">Grafik Tasarımcı</option>
                        <option value="seoExpert">SEO Uzmanı</option>
                        <option value="socialMediaManager">
                            Sosyal Medya Yöneticisi
                        </option>
                        <option value="accounting">Muhasebe</option>
                        <option value="intern">Stajyer</option>
                    </select>
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="phone" class="form-label">Telefon</label>
                    <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="05..."
                        name="phone" required autocomplete="username" />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@seopix.net"
                        name="email" required autocomplete="username" />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="*********"
                        name="password" required autocomplete="new-password" />
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-3">
                    <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="*********"
                        name="password_confirmation" required autocomplete="new-password" />
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
