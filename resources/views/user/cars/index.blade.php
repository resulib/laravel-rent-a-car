@extends('user.layouts.app')

@section('title', 'Maşınlar')

@section('content')
    <div class="mb-4">
        @include('components.car-filter', ['brands' => $brands])
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($cars as $car)
            <div class="col">
                <x-car-card :car="$car"/>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $cars->links('pagination::bootstrap-5') }}
    </div>
@endsection
