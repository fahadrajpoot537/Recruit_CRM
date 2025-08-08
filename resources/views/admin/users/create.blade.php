@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h4 class="fw-bold text-primary">Create Recruit Companies Owner</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                    
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
</div>
</form>
</div>
@endsection