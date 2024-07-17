<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/css/login-style.css') }}" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <section id="login" class="d-flex align-items-center justify-content-center">
        <div class="main">
            <div class="logo">
                <img class="mb-4" src="{{ asset('assets/img/logo-white.webp') }}" alt="Logo" />
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3 text-white">
                    <label for="email">E-Mail</label>
                    <input type="email" id="email" name="email" required class="form-control text-white mt-2" />
                </div>
                <div class="mb-3 text-white">
                    <label for="password">Şifre</label>
                    <input type="password" id="password" class="form-control text-white mt-2" name="password"
                        required />
                </div>
                <div class="d-flex align-items-center justify-content-center mt-4">
                    <button type="submit" class="btn btn-outline-light">
                        Giriş Yap
                    </button>
                </div>
            </form>
        </div>
    </section>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
</body>

</html>
