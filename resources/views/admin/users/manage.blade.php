@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">Recruit Companies Owner</h4>
        @role('super-admin')
        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary mt-2">
            <i class="bi bi-plus-circle me-1"></i> Add Recruit Company User
        </a>
        @endrole
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($companies->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $index => $company)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>
                            <div class="form-group">
                                <select name="status" class="form-control status-dropdown" data-id="{{ $company->id }}">
                                    <option value="0" {{ $company->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    <option value="1" {{ $company->status == 1 ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No companies found.</p>
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.status-dropdown').change(function() {
            var status = $(this).val();
            var userId = $(this).data('id');

            $.ajax({
                url: '{{ route("update.user.status") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    status: status
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
</script>

@endsection

