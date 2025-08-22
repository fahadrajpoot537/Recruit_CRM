@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-gradient text-white"
                        style="background: linear-gradient(45deg, #007bff, #6610f2);">
                        <h4 class="mb-0 text-primary">
                            <i class="bi bi-building me-2"></i> Edit Company User
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ url('companies_users/' . $company_user->id) }}">

                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label>Company</label>
                                    <select class="form-select shadow-sm @error('company_id') is-invalid @enderror"
                                        name="company_id" id="company_id">
                                        @foreach ($companies as $company)
                                            <option value="{{ old('company_id', $company->id) }}"
                                                {{ $company_user->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ $company_user->user->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email"
                                        class="form-control shadow-sm @error('email') is-invalid @enderror" name="email"
                                        id="email" value="{{ $company_user->user->email }}" readonly>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select shadow-sm @error('role') is-invalid @enderror" name="role"
                                        id="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $company_user->role == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                    <i class="bi bi-plus-circle me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
