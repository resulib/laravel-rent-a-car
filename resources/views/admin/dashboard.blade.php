@php use App\Models\Brand;use App\Models\Car;use App\Models\CarModel;use App\Models\User; @endphp
@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <p class="text-muted">Xoş gəldiniz, Admin!</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Maşınlar</h5>
                        <h2 class="text-primary">{{ Car::count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Brendlər</h5>
                        <h2 class="text-success">{{ Brand::count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Markalar</h5>
                        <h2 class="text-success">{{ CarModel::count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">İstifadəçilər</h5>
                        <h2 class="text-danger">{{ User::count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
