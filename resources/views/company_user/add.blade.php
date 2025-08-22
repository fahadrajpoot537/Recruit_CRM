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
                            <i class="bi bi-building me-2"></i> Create New Company User
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('companies.users.store') }}">
                            @csrf

                            <div class="row g-3">

                                <input type="hidden" class="form-control shadow-sm" name="company_id" id="company_id"
                                    value="{{ $company->id }}">


                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email"
                                        class="form-control shadow-sm @error('email') is-invalid @enderror" name="email"
                                        id="email" value="{{ old('email') }}">
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
                                                {{ old('role') == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password"
                                        class="form-control shadow-sm @error('password') is-invalid @enderror"
                                        name="password" id="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password"
                                        class="form-control shadow-sm @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" id="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                    <i class="bi bi-plus-circle me-1"></i> Create User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
