@extends('admin.layouts.app')

@section('title', 'Səhifəni Redaktə Et')

@section('content')
    <div class="container py-4">
        <h3>Səhifəni Redaktə Et</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.pages.update', $page) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Başlıq</label>
                <input type="text" name="title" value="{{ old('title', $page->title) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" class="form-control" >
            </div>

            <div class="mb-3">
                <label class="form-label">Məzmun</label>
                <textarea name="content" class="form-control" rows="8">{{ old('content', $page->content) }}</textarea>
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active"
                       value="1" {{ $page->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Aktiv et</label>
            </div>

            <button type="submit" class="btn btn-success">Yadda saxla</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Geri</a>
        </form>
    </div>
@endsection
