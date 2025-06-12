@php use App\Enums\Status;use App\Enums\Transmission;use App\Enums\FuelType; @endphp
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Yeni Maşın Əlavə Et</h2>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="{{ route('admin.car.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mb-5">

                <div class="col-md-3">
                    <label for="brand_id" class="form-label">Brend:</label>
                    <select name="brand_id" id="brand_id" class="form-select" required>
                        <option value="">Brend seçin</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="car_model_id" class="form-label">Model:</label>
                    <select name="car_model_id" id="car_model_id" class="form-select" required>
                        <option value="">Əvvəl brend seçin</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="year" class="form-label">Buraxılış ili:</label>
                    <select name="year" id="year" class="form-select" required>
                        <option value="">İl seçin</option>
                        @for ($i = now()->year; $i >= 2000; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="seats" class="form-label">Oturacaq sayı:</label>
                    <select name="seats" id="seats" class="form-select" required>
                        <option value="">Seçin</option>
                        @for ($i = 2; $i <= 9; $i++)
                            <option value="{{ $i }}">{{ $i }} nəfər</option>
                        @endfor
                    </select>
                </div>

            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="p-3 border rounded shadow-sm h-100">
                        <label class="form-label d-block fw-bold">Yanacaq Növü:</label>
                        @foreach(FuelType::cases() as $fuel)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="fuel_type"
                                       id="fuel_{{ $fuel->value }}"
                                       value="{{ $fuel->value }}"
                                    {{ old('fuel_type', FuelType::cases()[0]->value) == $fuel->value ? 'checked' : '' }}>
                                <label class="form-check-label" for="fuel_{{ $fuel->value }}">
                                    {{ ucfirst($fuel->label()) }}
                                </label>
                            </div>
                        @endforeach
                        @error('fuel_type')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 border rounded shadow-sm h-100">
                        <label class="form-label d-block fw-bold">Sürətlər qutusu:</label>
                        @foreach(Transmission::cases() as $type)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="transmission"
                                       id="transmission_{{ $loop->index }}"
                                       value="{{ $type->value }}"
                                    {{ old('transmission', Transmission::cases()[0]->value) == $type->value ? 'checked' : '' }}>
                                <label class="form-check-label" for="transmission_{{ $loop->index }}">
                                    {{ ucfirst($type->label()) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 border rounded shadow-sm h-100">
                        <label class="form-label d-block fw-bold">Status:</label>
                        @foreach(Status::cases() as $type)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="status"
                                       id="status_{{ $loop->index }}"
                                       value="{{ $type->value }}"
                                    {{ old('status', Status::cases()[0]->value) == $type->value ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_{{ $loop->index }}">
                                    {{ ucfirst($type->label()) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{--                <div class="col-md-3">--}}
                {{--                    <div class="p-3 border rounded shadow-sm h-100">--}}
                {{--                        <label class="form-label d-block fw-bold">Aktivlik:</label>--}}
                {{--                        <div class="form-check">--}}
                {{--                            <input class="form-check-input" type="radio" name="is_active" id="active_1"--}}
                {{--                                   value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>--}}
                {{--                            <label class="form-check-label" for="active_1">Aktiv</label>--}}
                {{--                        </div>--}}
                {{--                        <div class="form-check">--}}
                {{--                            <input class="form-check-input" type="radio" name="is_active" id="active_0"--}}
                {{--                                   value="0" {{ old('is_active') == '0' ? 'checked' : '' }}>--}}
                {{--                            <label class="form-check-label" for="active_0">Deaktiv</label>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>


            <div class="row mb-4">
                <div class="col-md-8">
                    <label for="images" class="form-label fw-bold">Şəkillər:</label>
                    <div class="p-3 rounded bg-light">
                        <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    </div>

                    @error('images')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                    @if ($errors->has('images.*'))
                        @foreach ($errors->get('images.*') as $imageErrors)
                            @foreach ($imageErrors as $imageError)
                                <div class="text-danger mt-1">{{ $imageError }}</div>
                            @endforeach
                        @endforeach
                    @endif
                </div>

                <div class="col-md-4">
                    <label for="price_per_day" class="form-label fw-bold">Qiymət (₼):</label>
                    <input type="number" name="price_per_day" id="price_per_day" class="form-control" min="1"
                           max="100000" step="1" required placeholder="Məs: 15000" value="{{ old('price_per_day') }}">

                    @error('price')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-bold">Açıqlama:</label>
                <textarea name="description" id="description" class="form-control" rows="4"
                          placeholder="Maşın haqqında ətraflı məlumat daxil edin..."
                          required>{{ old('description') }}</textarea>

                @error('description')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Əlavə et</button>
            <a href="{{ route('admin.car.create') }}" class="btn btn-secondary">Geri</a>
        </form>
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
                            console.log('Xəta:', xhr.responseText);
                        }
                    });
                } else {
                    $('#car_model_id').html('<option value="">Əvvəl brend seçin</option>');
                }
            });
        });
    </script>

@endsection
