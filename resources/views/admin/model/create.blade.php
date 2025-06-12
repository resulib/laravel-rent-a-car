@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h4>Model yarat</h4>

        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('admin.model.store')}}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="brand_id" class="form-label">Brend seçin</label>
                        <select name="brand_id" id="brand_id" class="form-control" required>
                            <option value="">-- Brend seçin --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <label for="name" class="form-label">Model adı</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                        <br>
                        <label for="name" class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktiv</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Deaktiv</option>
                        </select>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Yarat</button>
                    <a href="{{ route('admin.model.index') }}" class="btn btn-secondary">Geri</a>
                </form>
            </div>
        </div>
    </div>
@endsection
