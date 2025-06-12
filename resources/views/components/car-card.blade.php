@php use App\Helpers\ImageHelper; @endphp
@props(['car'])
<style>
    .car-image-wrapper {
        height: 200px;
    }

    @media (min-width: 768px) {
        .car-image-wrapper {
            height: 250px;
        }
    }

    @media (min-width: 1200px) {
        .car-image-wrapper {
            height: 300px;
        }
    }
</style>
<div class="card h-100 shadow-sm border-0 rounded-4 hover-shadow">
    <a href="{{ route('user.cars.show', ['slug' => $car->slug]) }}">
        <div class="ratio ratio-16x9 overflow-hidden position-relative" style="height: 200px;">
            <img src="{{ ImageHelper::getFirstCarImage($car) }}"
                 alt="{{ $car->getFullName() }}"
                 class="card-img-top h-100 w-100"
                 style="object-fit: cover;">
            <div>
        <span class="position-absolute top-0 start-0 m-2 px-2 py-1 rounded fw-semibold"
              style="background-color: #1864a5; color: white; font-size: 0.9rem;">
            {{ number_format($car->price_per_day, 0) }} ₼ / gün
        </span>
            </div>
        </div>
    </a>

    <div class="card-body d-flex flex-column">
        <a href="{{ route('user.cars.show', ['slug' => $car->slug]) }}"
           class="text-decoration-none text-primary">
            <h5 class="card-title fw-semibold text-primary text-truncate">
                {{ $car->getFullName() }}
            </h5>
        </a>

        <ul class="list-unstyled small text-muted mb-1">
            <li class="mb-1">
                <i class="fas fa-info-circle me-1 text-secondary"></i>
                <strong>Status:</strong> {{ $car->status->label() }}
            </li>
            <li>
                <i class="fas fa-gas-pump me-1 text-secondary"></i>
                <strong>Yanacaq:</strong> {{ $car->fuel_type->label() }}
            </li>
        </ul>
    </div>
</div>
