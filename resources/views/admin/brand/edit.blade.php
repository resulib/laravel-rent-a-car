@php use App\Constants\ImagePaths;use App\Helpers\ImageHelper; @endphp
@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h4>Brand Redaktə Et</h4>

        <div class="card mt-3">
            <div class="card-body">

                <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Adı:</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $brand->name) }}" required>

                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Logo</label>

                        @php
                            $imagePath = 'storage/' . ImagePaths::BRAND_LOGO_DIR . ImageHelper::generateBrandLogoName($brand);
                        @endphp

                        @if(file_exists(public_path($imagePath)))
                            <img src="{{ asset($imagePath) }}" width="100" alt="{{ $brand->name }}">
                        @else
                            <span class="text-muted">Şəkil yoxdur</span>
                        @endif

                        <input type="file" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status:</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $brand->is_active) == '1' ? 'selected' : '' }}>Aktiv
                            </option>
                            <option value="0" {{ old('is_active', $brand->is_active) == '0' ? 'selected' : '' }}>
                                Deaktiv
                            </option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-success">Yenilə</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
