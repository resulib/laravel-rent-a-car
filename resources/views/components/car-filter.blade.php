@php
    use App\Enums\FuelType;
    use App\Enums\Transmission;
    use App\Enums\Status;
@endphp

<div class="mb-4">
    <form method="GET" action="{{ url()->current() }}">
        <div class="row g-2 align-items-center">
            <div class="col">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                       placeholder="Maşın adı, model, marka...">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Axtar</button>
            </div>

            <div class="col-auto">
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse"
                        data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                    Filtr et
                </button>
            </div>
        </div>
    </form>
</div>

<div class="collapse mb-3" id="filterCollapse">
    <form method="GET" action="{{ url()->current() }}" class="card card-body shadow-sm">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="brand" class="form-label">Brend</label>
                <select name="brand" id="brand" class="form-select">
                    <option value="">Hamısı</option>
                    @foreach($brands as $brand)
                        <option
                            value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="fuel_type" class="form-label">Yanacaq</label>
                <select name="fuel_type" id="fuel_type" class="form-select">
                    <option value="">Hamısı</option>
                    @foreach(FuelType::cases() as $type)
                        <option
                            value="{{ $type->label() }}" {{ request('fuel_type') == $type->label() ? 'selected' : '' }}>
                            {{ ucfirst($type->label()) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="transmission" class="form-label">Sürət qutusu</label>
                <select name="transmission" id="transmission" class="form-select">
                    <option value="">Hamısı</option>
                    @foreach(Transmission::cases() as $type)
                        <option
                            value="{{ $type->label() }}" {{ request('transmission') == $type->label() ? 'selected' : '' }}>
                            {{ ucfirst($type->label()) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Hamısı</option>
                    @foreach(Status::cases() as $type)
                        <option
                            value="{{ $type->label() }}" {{ request('status') == $type->label() ? 'selected' : '' }}>
                            {{ ucfirst($type->label()) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="min_price" class="form-label">Min Qiymət</label>
                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                       class="form-control" placeholder="₼" min="0">
            </div>

            <div class="col-md-3">
                <label for="max_price" class="form-label">Max Qiymət</label>
                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                       class="form-control" placeholder="₼" min="0">
            </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-success w-100">Axtar</button>
            </div>

            <div class="col-md-3 align-self-end">
                <a href="{{ url()->current() }}" class="btn btn-secondary w-100">Sıfırla</a>
            </div>
        </div>
    </form>
</div>
