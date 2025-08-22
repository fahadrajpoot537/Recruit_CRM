@extends('layouts.app')

@section('content')
<style>
.hover-zoom {
    display: inline-block;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.hover-zoom:hover {
    transform: scale(1.3);
}
</style>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">My Companies</h2>

        <a href="{{ route('companies.create') }}" class="btn btn-outline-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Company
        </a>

    </div>

    @if(session('success'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($companies->isEmpty())
    <div class="text-center py-5">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Data" width="100">
        <h5 class="mt-3">You haven't created any companies yet.</h5>
        <p class="text-muted">Start by adding your first company.</p>
    </div>
    @else
    <div class="row g-4">
        @foreach($companies as $company)
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('companies.show', $company->id) }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    <div class="card-body">
                        <h5 class="card-title text-dark hover-zoom text-uppercase">{{ $company->name }}</h5>
                        <p class="card-text text-muted mb-0">
                            <i class="bi bi-geo-alt-fill"></i> {{ $company->city ?? 'No City' }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <small class="text-primary fw-semibold hover-zoom">View Details <i
                                class="bi bi-arrow-right"></i></small>
                    </div>

                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
