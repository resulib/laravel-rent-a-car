@php use App\Constants\ImagePaths;use App\Helpers\ImageHelper; @endphp
@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Brand Siyahısı</h4>
            <a href="{{ route('admin.model.create') }}" class="btn btn-primary">+ Model əlavə et</a>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped m-0">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Logo</th>
                        <th>Brend</th>
                        <th>Model</th>
                        <th>Maşın sayı</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse($models as $key => $model)
                        <tr>
                            <td>{{ paginationIndex($key, $models) }}</td>
                            <td>
                                @php
                                    $imagePath = 'storage/' . ImagePaths::BRAND_LOGO_DIR . ImageHelper::generateBrandLogoName($model->brand);
                                @endphp

                                @if(file_exists(public_path($imagePath)))
                                    <img src="{{ asset($imagePath) }}" alt="{{ $model->brand->name }}" width="40">
                                @else
                                    <img src="{{ asset(ImagePaths::NO_IMAGE) }}" alt="No image" width="40">
                                @endif
                            </td>
                            <td>{{ $model->brand->name }}</td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->cars->count() }}</td>

                            <td>{{ $model->is_active ? 'Aktiv' : 'Deaktiv' }}</td>
                            <td>
                                <a href="{{ route('admin.model.edit', $model->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.model.destroy', $model->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Brand tapılmadı</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $models->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
