@php use App\Enums\FuelType; use App\Enums\Transmission; use App\Enums\Status;use App\Helpers\ImageHelper; @endphp
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Maşını Redaktə Et</h2>

        <form action="{{ route('admin.car.update', $car->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="brand_id">Brend:</label>
                    <select name="brand_id" id="brand_id" class="form-control" required>
                        <option value="">Brend seçin</option>
                        @foreach($brands as $brand)
                            <option
                                value="{{ $brand->id }}" {{ $car->model->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="car_model_id">Model:</label>
                    <select name="car_model_id" id="car_model_id" class="form-control" required>
                        @foreach($models as $model)
                            <option value="{{ $model->id }}" {{ $car->car_model_id == $model->id ? 'selected' : '' }}>
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="year">Buraxılış ili:</label>
                    <select name="year" class="form-control" required>
                        @for ($i = now()->year; $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ $car->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="seats">Oturacaq sayı:</label>
                    <select name="seats" class="form-control" required>
                        @for ($i = 2; $i <= 9; $i++)
                            <option value="{{ $i }}" {{ $car->seats == $i ? 'selected' : '' }}>{{ $i }} nəfər</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label d-block">Yanacaq Növü:</label>
                    @foreach(FuelType::cases() as $fuel)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                   name="fuel_type"
                                   id="fuel_{{ $fuel->value }}"
                                   value="{{ $fuel->value }}"
                                {{ old('fuel_type', $car->fuel_type->value) == $fuel->value ? 'checked' : '' }}>
                            <label class="form-check-label" for="fuel_{{ $fuel->value }}">
                                {{ ucfirst($fuel->label()) }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label d-block">Sürətlər qutusu:</label>
                    @foreach(Transmission::cases() as $type)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                   name="transmission"
                                   id="transmission_{{ $type->value }}"
                                   value="{{ $type->value }}"
                                {{ old('transmission', $car->transmission->value) == $type->value ? 'checked' : '' }}>
                            <label class="form-check-label" for="transmission_{{ $type->value }}">
                                {{ ucfirst($type->label()) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label d-block">Status:</label>
                    @foreach(Status::cases() as $status)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                   name="status"
                                   id="status_{{ $status->value }}"
                                   value="{{ $status->value }}"
                                {{ old('status', $car->status->value) == $status->value ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_{{ $status->value }}">
                                {{ ucfirst($status->label()) }}
                            </label>
                        </div>
                    @endforeach
                </div>

{{--                <div class="col-md-4 mb-3">--}}
{{--                    <label for="is_active">Aktivlik:</label>--}}
{{--                    <select name="is_active" class="form-control">--}}
{{--                        <option value="1" {{ $car->is_active ? 'selected' : '' }}>Aktiv</option>--}}
{{--                        <option value="0" {{ !$car->is_active ? 'selected' : '' }}>Deaktiv</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

                <div class="col-md-4 mb-3">
                    <label for="price_per_day">Günlük qiymət (₼):</label>
                    <input type="number" name="price_per_day" class="form-control" value="{{ $car->price_per_day }}"
                           required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description">Təsvir:</label>
                <textarea name="description" class="form-control" rows="3">{{ $car->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="images">Şəkillər:</label>

                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-success">Yadda saxla</button>
            <a href="{{ route('admin.car.index') }}" class="btn btn-secondary">Geri</a>
        </form>

        <div>
            <div class="mt-4">
                <h5>Mövcud şəkillər:</h5>
                @php
                    $images = ImageHelper::getCarImages($car);
                @endphp
                @foreach($images as $img)
                    <div class="d-inline-block position-relative mr-2 mb-2">
                        <img src="{{ asset($img) }}" width="80" height="60" style="object-fit: cover; border-radius: 5px;">

                        <form action="{{ route('admin.car.image.delete') }}" method="POST" style="position: absolute; top: 2px; right: 2px;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <input type="hidden" name="image_name" value="{{ basename($img) }}">

                            <button type="submit" class="btn btn-sm btn-danger p-1"
                                    onclick="return confirm('Bu şəkli silmək istədiyinizə əminsiniz?')">
                                &times;
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#brand_id').on('change', function () {
                const brandId = $(this).val();

                if (brandId) {
                    $.ajax({
                        url: '{{ route('admin.car.modelsByBrand') }}',
                        type: 'GET',
                        data: {brand_id: brandId},
                        success: function (data) {
                            let options = '<option value="">Model seçin</option>';
                            data.forEach(function (model) {
                                options += `<option value="${model.id}">${model.name}</option>`;
                            });
                            $('#car_model_id').html(options);
                        },
                        error: function (xhr) {
                            console.error('Xəta:', xhr.responseText);
                        }
                    });
                } else {
                    $('#car_model_id').html('<option value="">Əvvəl brend seçin</option>');
                }
            });
        });
    </script>
@endsection
