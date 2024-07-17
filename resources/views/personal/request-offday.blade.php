@extends('layouts.panel')

@section('content')
<section id="main" class="col-lg-10 p-4">
    <h1 class="title-text mb-4">İzin Talebi</h1>
    <p class="">
        İzin Gün Sayısı: <span class="badge text-bg-dark">{{ Auth::user()->offday }}</span>
    </p>
    @if ($errors->any())
        <div class="mt-2 col-lg-4 alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="mt-2 col-lg-4 alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex flex-column align-items-center gap-2">
        <form
            class="col-12 col-lg-3 d-flex flex-column align-items-center justify-content-center gap-2 pt-4 px-lg-5 py-lg-2"
            action="{{ route('personal.request-offday') }}" method="POST">
            @csrf
            <div class="col-12 d-flex flex-column flex-lg-row align-items-center justify-content-center gap-2 gap-lg-4">
                <div class="col-12 mb-3">
                    <label for="start_date" class="form-label">Başlangıç Tarihi</label>
                    <input type="date" class="form-control" name="start_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" />
                </div>
                <div class="col-12 mb-3">
                    <label for="end_date" class="form-label">Bitiş Tarihi</label>
                    <input type="date" class="form-control" name="end_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" />
                </div>
            </div>
            <div class="col-12 d-flex align-items-center justify-content-center">
                <button class="btn btn-pink">
                    <i class="bi bi-check-lg me-2"></i>Talep Oluştur
                </button>
            </div>
        </form>
    </div>
</section>
@stop

{{--
<!DOCTYPE html>
<html>

<head>
    <title>Leave Request</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Leave Request Form</h2>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form action="{{ route('auth.request-offday') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>
</body>

</html> --}}