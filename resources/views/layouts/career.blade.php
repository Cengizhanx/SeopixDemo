<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SEOPix | Kariyer</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/career.css') }}">
    <link rel="icon" href="https://www.seopix.net/front/assets/images/seopix-favicon.ico" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
</head>

<body>
    @yield('content')
</body>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<script>
    $('#tckimlik-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/verify-tckimlik',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    // 2. adım formunu doldur ve göster
                    $('#tckimlik_no_2').val(response.data.tckimlikNo);
                    $('#ad_2').val(response.data.ad);
                    $('#soyad_2').val(response.data.soyad);
                    $('#dogum_yili_2').val(response.data.dogumYili);

                    $('#tckimlik-form').addClass('d-none');
                    $('#education-info-form').removeClass('d-none');
                    $('#education-info-form').addClass('d-flex');
                    $('#step-1').addClass('d-none');
                    $('#step-1').removeClass('active-step');
                    $('#step-2').addClass('active-step');
                    $('#step-2').removeClass('d-none');
                } else {
                    alert('TC Kimlik doğrulama başarısız. Lütfen bilgilerinizi kontrol edin.');
                }
            },
            error: function () {
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            }
        });
    });

    $('#education-info-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/submit-career-form',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('Başvurunuz başarıyla tamamlandı.');
                    window.location.href = '/kariyer';
                } else {
                    alert('Eğitim bilgiler gönderilirken bir hata oluştu.');
                }
            },
            error: function () {
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        var steps = document.querySelectorAll('.step');
        steps.forEach(function (step) {
            if (!step.classList.contains('active-step')) {
                step.classList.add('d-none');
            }
        });
    });
</script>
<script>
    let educationIndex = 1;

    function addEducationFields() {
        const container = document.getElementById('education_fields');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'flex-wrap', 'gap-2', 'mt-3');
        div.innerHTML = `
            <select class="form-select" id="education_type" name="education[${educationIndex}][type]">
                <option value="">Eğitim Türü</option>
                <option value="primary">İlköğretim</option>
                <option value="secondary">Ortaöğretim</option>
                <option value="highschool">Lise</option>
                <option value="university">Lisans</option>
                <option value="master">Yüksek Lisans</option>
                <option value="doctorate">Doktora</option>
            </select>
                <input class="form-control" type="text" id="school_name" name="education[${educationIndex}][school]" placeholder="Okul Adı">
                <input class="form-control" type="text" id="department" name="education[${educationIndex}][department]" placeholder="Bölüm Adı">
                <input class="form-control" type="text" id="graduation_year" name="education[${educationIndex}][graduation_year]" placeholder="Mezuniyet Yılı">
              <p class="remove-btn" onclick="removeEducationFields(this)">X</p>
            `;
        container.appendChild(div);
        educationIndex++;
    }

    function removeEducationFields(button) {
        button.parentElement.remove();
    }
</script>
<script>
    let workIndex = 1;

    function addWorkFields() {
        const container = document.getElementById('work_fields');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'flex-wrap', 'gap-2', 'mt-3');
        div.innerHTML = `
                    <input class="form-control" type="text" id="work_name" placeholder="Firma Adı" name="work[${workIndex}][name]">
                    <input class="form-control" type="text" id="work_phone" placeholder="Firma Telefonu" name="work[${workIndex}][phone]">
                    <input class="form-control" type="text" id="work_department" placeholder="Departman" name="work[${workIndex}][department]">
                    <input class="form-control" type="text" id="work_position" placeholder="Pozisyon" name="work[${workIndex}][position]">
                    <input placeholder="Başlangıç Tarihi" class="form-control" id="work_start_date"
                         onfocus="(this.type='date')" onblur="(this.type='text')" name="work[${workIndex}][start_date]">
                    <input placeholder="Bitiş Tarihi" class="form-control" onfocus="(this.type='date')"
                         onblur="(this.type='text')" id="work_finish_date" name="work[${workIndex}][finish_date]">
                    <p class="remove-btn" onclick="removeWorkFields(this)">X</p>
                `;
        container.appendChild(div);
        workIndex++;
    }

    function removeWorkFields(button) {
        button.parentElement.remove();
    }
</script>
<script>
    let referenceIndex = 1;

    function addReferenceFields() {
        const container = document.getElementById('reference_fields');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'flex-wrap', 'gap-2', 'mt-3');
        div.innerHTML = `
                <select class="form-select" id="reference_type" name="reference[${referenceIndex}][type]">
                    <option value="">Referans Türü</option>
                    <option value="professional">Profesyonel</option>
                    <option value="personal">Kişisel</option>
                </select>
                <input class="form-control" placeholder="Adı Soyadı" type="text" id="reference_name" name="reference[${referenceIndex}][name]">
                <input class="form-control" placeholder="Telefonu" type="text" id="reference_phone" name="reference[${referenceIndex}][phone]">
                <p class="remove-btn" onclick="removeReferenceFields(this)">X</p>
                `;
        container.appendChild(div);
        referenceIndex++;
    }

    function removeReferenceFields(button) {
        button.parentElement.remove();
    }
</script>
<script>
    let languageIndex = 1;

    function addLanguageFields() {
        const container = document.getElementById('language_field');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'flex-wrap', 'gap-2', 'mt-3');
        div.innerHTML = `
                <select class="form-select" id="languages_type" name="language[${languageIndex}][type]">
                    <option value="">Dil</option>
                    <option value="english">İngilizce</option>
                    <option value="france">Fransa</option>
                    <option value="arabic">Arapça</option>
                    <option value="german">Almanca</option>
                </select>
                <select class="form-select" id="languages_level" name="language[${languageIndex}][level]">
                    <option value="">Seviye</option>
                    <option value="beginning">Başlangıç</option>
                    <option value="intermediate">Orta</option>
                    <option value="good">İyi</option>
                    <option value="very_good">Çok İyi</option>
                </select>
                <select class="form-select" id="languages_experience" name="language[${languageIndex}][experience]">
                    <option value="">Deneyim</option>
                    <option value="1">1-3 Yıl</option>
                    <option value="3">3-5 Yıl</option>
                    <option value="5">5-10 Yıl</option>
                    <option value="10">+10 Yıl</option>
                </select>
                <p class="remove-btn" onclick="removeLanguageFields(this)">X</p>
                    `;
        container.appendChild(div);
        languageIndex++;
    }

    function removeLanguageFields(button) {
        button.parentElement.remove();
    }

    let experienceIndex = 1;

    function addExperienceFields() {
        const container = document.getElementById('experience_field');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'flex-wrap', 'gap-2', 'mt-3');
        div.innerHTML = `
                <select class="form-select" id="experience_type" name="experience[${experienceIndex}][type]">
                    <option value="">Dil</option>
                    <option value="office">Office Programları</option>
                    <option value="mail">Mail Yazılımı</option>
                </select>
                <select class="form-select" id="experience_level" name="experience[${experienceIndex}][level]">
                    <option value="">Seviye</option>
                    <option value="beginning">Başlangıç</option>
                    <option value="intermediate">Orta</option>
                    <option value="good">İyi</option>
                    <option value="very_good">Çok İyi</option>
                </select>
                <select class="form-select" id="experience_year" name="experience[${experienceIndex}][year]">
                    <option value="">Deneyim</option>
                    <option value="1">1-3 Yıl</option>
                    <option value="3">3-5 Yıl</option>
                    <option value="5">5-10 Yıl</option>
                    <option value="10">+10 Yıl</option>
                </select>
                <p class="remove-btn" onclick="removeExperienceFields(this)">X</p>
            `;
        container.appendChild(div);
        experienceIndex++;
    }

    function removeExperienceFields(button) {
        button.parentElement.remove();
    }
</script>

</html>