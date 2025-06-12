@extends('admin.layouts.app')

@section('title', 'Səhifələr')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Səhifələr</h3>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Yeni səhifə əlavə et</a>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Başlıq</th>
                <th>Slug</th>
                <th>Aktiv</th>
                <th>Əməliyyatlar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->slug }}</td>
                    <td>
                            <span class="badge bg-{{ $page->is_active ? 'success' : 'secondary' }}">
                                {{ $page->is_active ? 'Aktiv' : 'Passiv' }}
                            </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-warning">Redaktə</a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Silmək istədiyinizə əminsiniz?')">Sil
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection






