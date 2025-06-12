@extends('admin.layouts.app')

@section('title', 'Yeni Səhifə')

@section('content')
    <div class="container py-4">
        <h3>Yeni Səhifə Yarat</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.pages.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Başlıq</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Məzmun</label>
                <textarea name="content" class="form-control" rows="8" required>{{ old('content') }}</textarea>
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label">Aktiv et</label>
            </div>

            <button type="submit" class="btn btn-success">Yarat</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Geri</a>
        </form>
    </div>
@endsection
