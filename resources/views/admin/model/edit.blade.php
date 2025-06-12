@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h4>Modeli Redaktə Et</h4>

        <div class="card mt-3">
            <div class="card-body">

                <form action="{{ route('admin.model.update', $model->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="brand_id" class="form-label">Brend seçin</label>
                        <select name="brand_id" id="brand_id" class="form-control" required>
                            <option value="">{{$model->brand->name}}</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="mb-3">
                            <label for="name" class="form-label">Brand Adı:</label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $model->name) }}" required>

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status:</label>
                            <select name="is_active" id="is_active" class="form-select">
                                <option value="1" {{ old('is_active', $model->is_active) == '1' ? 'selected' : '' }}>
                                    Aktiv
                                </option>
                                <option value="0" {{ old('is_active', $model->is_active) == '0' ? 'selected' : '' }}>
                                    Deaktiv
                                </option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-start">
                            <button type="submit" class="btn btn-success">Yenilə</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
