@php use App\Constants\ImagePaths;use App\Helpers\ImageHelper; @endphp
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Maşınlar</h2>
            <a href="{{ route('admin.car.create') }}" class="btn btn-primary">+ Maşın əlavə et</a>
        </div>
        @include('components.car-filter', ['brands' => $brands])

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Ad (Brend, Model, il)</th>
                <th>Şəkillər</th>
                <th>Qiymət</th>
                <th>Yanacaq</th>
                <th>Suretler qutusu</th>
                <th>Status</th>
                <th>Əməliyyatlar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cars as $key => $car)
                <tr>
                    <td>{{ paginationIndex($key, $cars) }}</td>
                    <td>{{ $car->getFullName() ?? '-' }}</td>
                    <td>
                        @php
                            $images = ImageHelper::getCarImages($car);
                        @endphp

                        @if($images)
                            @foreach($images as $img)
                                <img src="{{ asset($img) }}" alt="{{$car->car_model_id}}" width="40">
                            @endforeach
                        @else
                            <img src="{{ asset(ImagePaths::NO_IMAGE) }}" alt="Car" width="40">
                        @endif
                    </td>
                    <td>{{ $car->price_per_day }}</td>
                    <td>{{ $car->fuel_type->label() }}</td>
                    <td>{{ $car->transmission->label() }}</td>
                    <td>{{ $car->status->label() }}</td>

                    <td>
                        <a href="{{ route('admin.car.edit', $car->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.car.destroy', $car) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Əminsiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-5">
            {{ $cars->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
