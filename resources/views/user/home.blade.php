@extends('user.layouts.app')

@section('title', 'Ana Səhifə')

@section('content')
    <style>
        .hero-section {
            position: relative;
            background: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)),
            url('{{ asset('storage/uploads/images/home-bg.jpg') }}') center center / cover no-repeat;
            height: 80vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .hero-content {
            z-index: 2;
            max-width: 800px;
            padding: 0 15px;
        }

        .hero-title {
            font-size: 3.2rem;
            font-weight: 700;
            line-height: 1.3;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-top: 1rem;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }

        .hero-btn {
            margin-top: 30px;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hero-btn:hover {
            background-color: #f8f9fa;
            color: #000;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .hero-btn {
                font-size: 1rem;
            }
        }
    </style>

    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Maşın icarəsi sisteminə xoş gəlmisiniz!</h1>
            <p class="hero-subtitle">Ən uyğun qiymətə, ən keyfiyyətli maşınlar sizi gözləyir</p>
            <a href="{{ route('user.cars.index') }}" class="btn btn-light btn-lg hero-btn">Maşınlara bax</a>
        </div>
    </div>

    <section class="mt-5">
        <h2 class="mb-5">Populyar Maşınlar</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            @foreach($popularCars as $car)
                <div class="col">
                    <x-car-card :car="$car"/>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('user.cars.index') }}" class="btn btn-light btn-lg hero-btn">Bütün maşınlar</a>
        </div>
    </section>
@endsection
