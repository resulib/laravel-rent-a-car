@php
    use App\Constants\ImagePaths;
    use App\Helpers\ImageHelper;
    $waText = urlencode($car->getFullName() . ' - ' . route('user.cars.show', ['slug' => $car->slug], true));
@endphp

@extends('user.layouts.app')
@section('title', $car->getFullName())

@section('content')
    <div class="row g-4 align-items-start">
        <div class="col-md-6">
            @php
                $images = ImageHelper::getCarImages($car);
            @endphp

            @if($images && count($images) > 0)
                <div id="carouselImages" class="carousel slide border rounded shadow-sm overflow-hidden"
                     data-bs-ride="carousel">
                    <div class="carousel-inner ratio ratio-16x9">
                        @foreach($images as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <img src="{{ asset($image) }}"
                                     class="d-block w-100 h-100 object-fit-cover"
                                     alt="Car image {{ $key + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    @if(count($images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark bg-opacity-50 rounded-circle p-2"
                                  aria-hidden="true"></span>
                            <span class="visually-hidden">Əvvəlki</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark bg-opacity-50 rounded-circle p-2"
                                  aria-hidden="true"></span>
                            <span class="visually-hidden">Növbəti</span>
                        </button>
                    @endif
                </div>
            @else
                <img src="{{ asset(ImagePaths::NO_IMAGE) }}" class="img-fluid border rounded shadow-sm"
                     alt="No image" style="max-height: 400px; object-fit: cover;">
            @endif
        </div>

        <div class="col-md-6">
            <div class="p-4 border rounded shadow-sm bg-light h-100">
                <h3 class="fw-bold mb-3">
                    <i class="fas fa-car-side me-2 text-primary"></i>{{ $car->getFullName() }}
                </h3>

                <ul class="list-unstyled mb-4 fs-6">
                    <li class="mb-2"><i class="fas fa-calendar-alt me-2 text-secondary"></i><strong>Buraxılış
                            ili:</strong> {{ $car->year }}</li>
                    <li class="mb-2"><i
                            class="fas fa-gas-pump me-2 text-secondary"></i><strong>Yanacaq:</strong> {{ $car->fuel_type->label() }}
                    </li>
                    <li class="mb-2"><i class="fas fa-chair me-2 text-secondary"></i><strong>Oturacaq
                            sayı:</strong> {{ $car->seats }}</li>
                    <li class="mb-2"><i class="fas fa-cogs me-2 text-secondary"></i><strong>Sürətlər
                            qutusu:</strong> {{ $car->transmission->label() }}</li>
                    <li class="mb-2"><i
                            class="fas fa-info-circle me-2 text-secondary"></i><strong>Status:</strong> {{ $car->status->label() }}
                    </li>
                    <li class="mb-2"><i class="fas fa-coins me-2 text-secondary"></i><strong>Gündəlik
                            qiymət:</strong> {{ number_format($car->price_per_day, 2) }} ₼
                    </li>
                </ul>

                @if($car->description)
                    <p class="text-muted"><i
                            class="fas fa-align-left me-2 text-secondary"></i><strong>Açıqlama:</strong> {{ $car->description }}
                    </p>
                @endif
                <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                    <a href="tel:+994775165916"
                       class="btn btn-outline-primary d-flex align-items-center justify-content-center px-4 py-2 shadow-sm rounded-pill w-100">
                        <i class="fas fa-phone-alt me-2"></i>
                        Zəng et
                    </a>

                    <a href="https://wa.me/994775165916?text={{ $waText }}"
                       target="_blank"
                       class="btn btn-success d-flex align-items-center justify-content-center px-4 py-2 shadow-sm rounded-pill w-100">
                        <i class="fab fa-whatsapp me-2"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-5 mb-4">Oxşar Maşınlar</h4>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($relatedCars as $related)
            <div class="col">
                <x-car-card :car="$related"/>
            </div>
        @endforeach
    </div>
@endsection
