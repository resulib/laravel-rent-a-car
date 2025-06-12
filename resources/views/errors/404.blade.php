@extends('user.layouts.app')

@section('title', 'Səhifə tapılmadı')

@section('meta')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-1 fw-bold">404</h1>
        <h3 class="mb-3">Səhifə tapılmadı</h3>
        <img src="{{ asset('storage/uploads/images/not-found.png') }}" alt="Səhifə tapılmadı şəkli"
             class="img-fluid my-3" style="max-width: 300px;" loading="lazy">
        <p class="mb-4">Axtardığınız səhifə mövcud deyil və ya silinmişdir.</p>
        <div>
            <a href="{{ url('/') }}" class="btn btn-primary me-2">Ana səhifəyə qayıt</a>
            <a href="{{ route('user.cars.index') }}" class="btn btn-outline-primary">Bütün maşınlar</a>
        </div>
    </div>
@endsection
