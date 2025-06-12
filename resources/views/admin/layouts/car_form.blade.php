@php use App\Enums\FuelType;
use App\Enums\Status;
use App\Enums\Transmission;
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="brand_id">Brend:</label>
        <select name="brand_id" id="brand_id" class="form-control" required>
            <option value="">Seçin</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="car_model_id">Model:</label>
        <select name="car_model_id" id="car_model_id" class="form-control" required>
            <option value="{{ $car->model->id ?? '' }}">
                {{ $car->model->name ?? 'Əvvəl brend seçin' }}
            </option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="year">Buraxılış ili:</label>
        <select name="year" id="year" class="form-control" required>
            @for ($i = now()->year; $i >= 2000; $i--)
                <option value="{{ $i }}" {{ old('year', $car->year ?? '') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="seats">Oturacaq sayı:</label>
        <select name="seats" class="form-control" required>
            @for ($i = 2; $i <= 9; $i++)
                <option value="{{ $i }}" {{ old('seats', $car->seats ?? '') == $i ? 'selected' : '' }}>{{ $i }} nəfər</option>
            @endfor
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="price_per_day">Günlük qiymət (₼):</label>
        <input type="number" name="price_per_day" class="form-control" value="{{ old('price_per_day', $car->price_per_day ?? '') }}" required>
    </div>

    <div class="col-12 mb-3">
        <label for="description">Açıqlama:</label>
        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $car->description ?? '') }}</textarea>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label d-block">Yanacaq növü:</label>
        @foreach(FuelType::cases() as $fuel)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="fuel_type" id="fuel_{{ $fuel->value }}"
                       value="{{ $fuel->value }}"
                    {{ old('fuel_type', $car->fuel_type->value ?? '') == $fuel->value ? 'checked' : '' }}>
                <label class="form-check-label" for="fuel_{{ $fuel->value }}">{{ ucfirst($fuel->value) }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Sürətlər qutusu:</label>
        @foreach(Transmission::cases() as $type)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="transmission" id="transmission_{{ $type->value }}"
                       value="{{ $type->value }}"
                    {{ old('transmission', $car->transmission->value ?? '') == $type->value ? 'checked' : '' }}>
                <label class="form-check-label" for="transmission_{{ $type->value }}">{{ ucfirst($type->value) }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Status:</label>
        @foreach(Status::cases() as $status)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_{{ $status->value }}"
                       value="{{ $status->value }}"
                    {{ old('status', $car->status->value ?? '') == $status->value ? 'checked' : '' }}>
                <label class="form-check-label" for="status_{{ $status->value }}">{{ ucfirst($status->value) }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-6 mb-3">
        <label for="is_active">Aktivlik:</label>
        <select name="is_active" class="form-control">
            <option value="1" {{ old('is_active', $car->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktiv</option>
            <option value="0" {{ old('is_active', $car->is_active ?? 1) == 0 ? 'selected' : '' }}>Deaktiv</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="images">Yeni şəkil yüklə:</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>
</div>
