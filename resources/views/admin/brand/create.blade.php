@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h4>Yeni Brand Yarat</h4>

        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('admin.brand.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Brand adı</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}"
                               required>
                        <div class="mb-3 mt-3">
                            <label for="is_active" class="form-label">Logo</label>
                            <input type="file" name="image" required>
                        </div>
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
                    <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary">Geri</a>
                </form>
            </div>
        </div>
    </div>
@endsection
