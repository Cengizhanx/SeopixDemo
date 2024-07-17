@extends('layouts.career')

@section('content')
<section class="d-flex flex-column flex-lg-row">
    @include('career.section-left')
    <div class="content-right col-12 col-lg-8 d-flex flex-column align-items-center justify-content-center gap-4">
        <div class="col-8 col-md-6 col-lg-4 m-auto step active-step" id="step-1">
            <form class="col-12 d-flex flex-column gap-3 py-5" id="tckimlik-form">
                @csrf
                <p class="mb-0">T.C. Kimlik Doğrulama</p>
                <input type="text" class="form-control" id="tckimlik_no" name="tckimlik_no" placeholder="T.C. Kimlik No"
                    required />

                <input type="text" id="ad" class="form-control" name="ad" placeholder="Ad" required />

                <input type="text" id="soyad" class="form-control" name="soyad" placeholder="Soyad" required />

                <input type="text" id="dogum_yili" class="form-control" name="dogum_yili" placeholder="Doğum Yılı"
                    required />
                <div class="text-end">
                    <button class="btn" type="submit">Doğrula</button>
                </div>
            </form>
        </div>

        <form class="d-none flex-column col-11 col-lg-10 gap-3 py-4 py-lg-5" id="education-info-form">
            <h5 class="fw-normal"><i class="bi bi-arrow-return-right"></i> İlgili alanları doldurarak formu tamamlayın.
            </h5>
            @csrf
            <div class="step" id="step-2">
                <div class="verified-info d-flex flex-wrap gap-2 mb-4">
                    <input class="form-control" type="text" id="tckimlik_no_2" name="tckimlik_no" readonly />
                    <input class="form-control" type="text" id="ad_2" name="ad" readonly />
                    <input class="form-control" type="text" id="soyad_2" name="soyad" readonly />
                    <input class="form-control" type="text" id="dogum_yili_2" name="dogum_yili" readonly />
                </div>
                <p data-bs-toggle="collapse" href="#personal-info" role="button" aria-expanded="false"
                    aria-controls="personal-info">
                    Kişisel Bilgiler <i class="bi bi-arrow-down-circle-fill"></i>
                </p>
                <div id="personal-info" data-bs-parent="#step-2" class="collapse personal-container">
                    <div class="d-flex flex-wrap gap-2">
                        <input class="form-control" type="email" id="email" name="email" placeholder="E-Posta"
                            required />
                        <input class="form-control" type="text" id="phone" name="phone" placeholder="Telefon"
                            required />
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Cinsiyet</option>
                            <option value="male">Erkek</option>
                            <option value="female">Kadın</option>
                        </select>
                        <input class="form-control" type="text" id="birth_place" name="birth_place"
                            placeholder="Doğum Yeri" required />
                        <select class="form-select" id="driving_license" name="driving_license" required>
                            <option value="">Ehliyet</option>
                            <option value="none">Yok</option>
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="B1">B1</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="K">K</option>
                        </select>
                        <select class="form-select" id="position" name="position" required>
                            <option value="">Pozisyon</option>
                            <option value="general_app">Genel Başvuru</option>
                            <option value="developer">Yazılım Geliştirici</option>
                            <option value="designer">Grafik Tasarımcı</option>
                            <option value="seoExpert">SEO Uzmanı</option>
                            <option value="socialMediaManager">
                                Sosyal Medya Yöneticisi
                            </option>
                            <option value="accounting">
                                Muhasebe
                            </option>
                            <option value="intern">Stajyer</option>
                        </select>
                        <select class="form-select" id="marital_status" name="marital_status" required>
                            <option value="">Medeni Hal</option>
                            <option value="single">Bekar</option>
                            <option value="married">Evli</option>
                        </select>
                        <select class="form-select" id="blood_type" name="blood_type" required>
                            <option value="">Kan Grubu</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="0+">0+</option>
                            <option value="0-">0-</option>
                        </select>
                        <textarea class="form-control" id="address" name="address" placeholder="Adres" rows="3"
                            required></textarea>
                        <textarea class="form-control" id="social_media" name="social_media" rows="3"
                            placeholder="Sosyal Medya Hesabı" required></textarea>
                    </div>
                </div>

                <div class="col-lg-11 d-flex align-items-center justify-content-between gap-3">
                    <p class="mt-3" data-bs-toggle="collapse" href="#education_fields" role="button"
                        aria-expanded="false" aria-controls="education_fields">
                        Eğitim Bilgileri <i class="bi bi-arrow-down-circle-fill"></i>
                    </p>
                    <button type="button" class="btn btn-middle" onclick="addEducationFields()">
                        Ekle
                    </button>
                </div>
                <div class="education-container">
                    <div id="education_fields" data-bs-parent="#step-2" class="collapse">
                        <div class="d-flex flex-wrap gap-2">
                            <select class="form-select" id="education_type" name="education[0][type]" required>
                                <option value="">Eğitim Türü</option>
                                <option value="primary">İlköğretim</option>
                                <option value="secondary">Ortaöğretim</option>
                                <option value="highschool">Lise</option>
                                <option value="university">Lisans</option>
                                <option value="master">Yüksek Lisans</option>
                                <option value="doctorate">Doktora</option>
                            </select>
                            <input class="form-control" type="text" id="school_name" name="education[0][school]"
                                placeholder="Okul Adı" required />
                            <input class="form-control" type="text" id="department" name="education[0][department]"
                                placeholder="Bölüm Adı" required />
                            <input class="form-control" type="text" id="graduation_year"
                                name="education[0][graduation_year]" placeholder="Mezuniyet Yılı" required />
                        </div>
                    </div>
                </div>

                <div class="col-lg-11 d-flex align-items-center justify-content-between gap-3">
                    <p class="mt-3" data-bs-toggle="collapse" href="#work_fields" role="button" aria-expanded="false"
                        aria-controls="work_fields">
                        İş Bilgileri <i class="bi bi-arrow-down-circle-fill"></i>
                    </p>
                    <button type="button" class="btn btn-middle" onclick="addWorkFields()">
                        Ekle
                    </button>
                </div>
                <div class="work-container d-flex flex-column gap-3">
                    <div id="work_fields" data-bs-parent="#step-2" class="collapse">
                        <div class="d-flex flex-wrap gap-2">
                            <input class="form-control" type="text" id="work_name" name="work[0][name]"
                                placeholder="Firma Adı" />
                            <input class="form-control" type="text" id="work_phone" name="work[0][phone]"
                                placeholder="Firma Telefonu" />
                            <input class="form-control" type="text" id="work_department" name="work[0][department]"
                                placeholder="Departman" />
                            <input class="form-control" type="text" id="work_position" name="work[0][position]"
                                placeholder="Pozisyon" />
                            <input placeholder="Başlangıç Tarihi" class="form-control" id="work_start_date"
                                name="work[0][start_date]" onfocus="(this.type='date')" onblur="(this.type='text')" />
                            <input placeholder="Bitiş Tarihi" class="form-control" onfocus="(this.type='date')"
                                onblur="(this.type='text')" id="work_finish_date" name="work[0][finish_date]" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-11 d-flex align-items-center justify-content-between gap-3">
                    <p class="mt-3" data-bs-toggle="collapse" href="#reference_fields" role="button"
                        aria-expanded="false" aria-controls="reference_fields">
                        Referans Bilgileri <i class="bi bi-arrow-down-circle-fill"></i>
                    </p>
                    <button type="button" class="btn btn-middle" onclick="addReferenceFields()">
                        Ekle
                    </button>
                </div>
                <div class="reference-container d-flex flex-column gap-3">
                    <div id="reference_fields" data-bs-parent="#step-2" class="collapse">
                        <div class="d-flex flex-wrap gap-2">
                            <select class="form-select" id="reference_type" name="reference[0][type]">
                                <option value="">Referans Türü</option>
                                <option value="professional">Profesyonel</option>
                                <option value="personal">Kişisel</option>
                            </select>
                            <input class="form-control" type="text" id="reference_name" name="reference[0][name]"
                                placeholder="Adı Soyadı" />
                            <input class="form-control" type="text" id="reference_phone" name="reference[0][phone]"
                                placeholder="Telefonu" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-11 d-flex align-items-center justify-content-between gap-3">
                    <p class="mt-3" data-bs-toggle="collapse" href="#language_field" role="button" aria-expanded="false"
                        aria-controls="language_field">
                        Bildiğiniz Diller <i class="bi bi-arrow-down-circle-fill"></i>
                    </p>
                    <button type="button" class="btn btn-middle" onclick="addLanguageFields()">
                        Ekle
                    </button>
                </div>
                <div class="language-container d-flex flex-column gap-3">
                    <div id="language_field" data-bs-parent="#step-2" class="collapse">
                        <div class="d-flex flex-wrap gap-2">
                            <select class="form-select" id="language_type" name="language[0][type]">
                                <option value="">Dil</option>
                                <option value="english">İngilizce</option>
                                <option value="france">Fransa</option>
                                <option value="arabic">Arapça</option>
                                <option value="german">Almanca</option>
                            </select>
                            <select class="form-select" id="language_level" name="language[0][level]">
                                <option value="">Seviye</option>
                                <option value="beginning">Başlangıç</option>
                                <option value="intermediate">Orta</option>
                                <option value="good">İyi</option>
                                <option value="very_good">Çok İyi</option>
                            </select>
                            <select class="form-select" id="language_experience" name="language[0][experience]">
                                <option value="">Deneyim</option>
                                <option value="1">1-3 Yıl</option>
                                <option value="3">3-5 Yıl</option>
                                <option value="5">5-10 Yıl</option>
                                <option value="10">+10 Yıl</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-11 d-flex align-items-center justify-content-between gap-3">
                    <p class="mt-3" data-bs-toggle="collapse" href="#experience_field" role="button"
                        aria-expanded="false" aria-controls="experience_field">
                        Bilgisayar Tecrübesi
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </p>
                    <button type="button" class="btn btn-middle" onclick="addExperienceFields()">
                        Ekle
                    </button>
                </div>
                <div class="experience-container d-flex flex-column gap-3">
                    <div id="experience_field" data-bs-parent="#step-2" class="collapse">
                        <div class="d-flex flex-wrap gap-2">
                            <select class="form-select" id="experience_type" name="experience[0][type]">
                                <option value="">Dil</option>
                                <option value="office">Office Programları</option>
                                <option value="mail">Mail Yazılımı</option>
                            </select>
                            <select class="form-select" id="experience_level" name="experience[0][level]">
                                <option value="">Seviye</option>
                                <option value="beginning">Başlangıç</option>
                                <option value="intermediate">Orta</option>
                                <option value="good">İyi</option>
                                <option value="very_good">Çok İyi</option>
                            </select>
                            <select class="form-select" id="experience_year" name="experience[0][year]">
                                <option value="">Deneyim</option>
                                <option value="1">1-3 Yıl</option>
                                <option value="3">3-5 Yıl</option>
                                <option value="5">5-10 Yıl</option>
                                <option value="10">+10 Yıl</option>
                            </select>
                        </div>
                    </div>
                </div>

                <p class="mt-3" data-bs-toggle="collapse" href="#other-info" role="button" aria-expanded="false"
                    aria-controls="other-info">
                    Diğer Bilgiler <i class="bi bi-arrow-down-circle-fill"></i>
                </p>
                <div id="other-info" data-bs-parent="#step-2" class="collapse other-info">
                    <div class="d-flex flex-wrap gap-2">
                        <select class="form-select" id="criminal_record" name="criminal_record" required>
                            <option value="">Sabıka kaydınız var mı?</option>
                            <option value="no">Hayır</option>
                            <option value="yes">Evet</option>
                        </select>

                        <select class="form-select" id="disability_situation" name="disability_situation" required>
                            <option value="">Herhangi bir engel durumunuz var mı?</option>
                            <option value="no">Hayır</option>
                            <option value="yes">Evet</option>
                        </select>
                        <select class="form-select" id="travel_ban" name="travel_ban" required>
                            <option value="">Seyahat engeliniz var mı?</option>
                            <option value="no">Hayır</option>
                            <option value="yes">Evet</option>
                        </select>
                        <select class="form-select" id="smoking" name="smoking" required>
                            <option value="">Sigara kullanıyor musunuz?</option>
                            <option value="no">Hayır</option>
                            <option value="yes">Evet</option>
                        </select>
                        <textarea class="form-control" placeholder="Eklemek istedikleriniz" id="note" name="note"
                            rows="3"></textarea>
                    </div>
                </div>

                <div class="col-11 d-flex justify-content-end">
                    <button class="btn mt-4" type="submit">Gönder</button>
                </div>
            </div>
        </form>
    </div>
</section>
@stop