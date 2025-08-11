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
    <div class="hk-pg-body py-0">
        <div class="contactapp-wrap">
            <div class="contactapp-content">
                <div class="contactapp-detail-wrap">

                    <div class="contact-body">
                        <div data-simplebar class="nicescroll-bar">

                            <div class="contact-card-view dt-container">
                                <div class="row">
                                    <div class="col-7 mb-3">
                                        <div class="contact-toolbar-left">

                                            <select class="d-flex align-items-center w-130p form-select form-select-sm">
                                                <option selected="">Export to CSV</option>
                                                <option value="2">Export to PDF</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <div class="contact-toolbar-right">
                                            <div class="dt-search"><input type="search"
                                                    class="form-control form-control-sm" id="dt-search-0"
                                                    placeholder="Search" aria-controls="datable_1"><label
                                                    for="dt-search-0"></label></div>

                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="row gx-3 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 mb-5">
                                    @foreach($companies as $index => $company)
                                    <div class="col">
                                        <div class="card card-border contact-card">
                                            <div class="card-body text-center">
                                                <div class="card-action-wrap">
                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                        href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="btn-icon-wrap">
                                                            <span class="feather-icon"><i
                                                                    data-feather="more-vertical"></i></span>
                                                        </span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end" role="menu">
                                                        <a class="dropdown-item change-status" href="javascript:void(0)"
                                                            data-id="{{ $company->id }}" data-status="1">
                                                            <i class="icon wb-check" aria-hidden="true"></i>Active
                                                        </a>
                                                        <a class="dropdown-item change-status" href="javascript:void(0)"
                                                            data-id="{{ $company->id }}" data-status="0">
                                                            <i class="icon wb-close" aria-hidden="true"></i>Inactive
                                                        </a>
                                                    </div>
                                                </div>
                                                @php
                                                $nameParts = explode(' ', $company->name);
                                                $firstInitial = substr($nameParts[0], 0, 1);
                                                $lastInitial = substr(end($nameParts), 0, 1);
                                                $initials = strtoupper($firstInitial . $lastInitial);
                                                @endphp

                                                <div class="avatar avatar-xl avatar-rounded">
                                                    <span class="initial-wrap avatar-img"
                                                        style="background-color: lightblue;">{{ $initials }}</span>
                                                </div>
                                                <div class="user-name"><span class="contact-star"><span
                                                            class="feather-icon"></span></span>{{ $company->name }}
                                                </div>
                                                <div class="user-email">{{ $company->email }}</div>
                                                <!-- <div class="user-contact">+145 52 5689</div>
                                                <div class="user-desg"><span
                                                        class="badge badge-primary badge-indicator badge-indicator-lg me-2"></span>
                                                    Design</div> -->
                                            </div>
                                            <div class="card-footer text-muted position-relative">

                                                <div class="v-separator-full m-0"></div>
                                                <a href="#" class="d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#contact_detail"
                                                    data-user-name="{{ $company->name }}"
                                                    data-user-email="{{ $company->email }}"
                                                    data-user-id="{{ $company->id }}"
                                                    data-user-status="{{ $company->status }}"
                                                    data-companies="{{ $company->companies ? $company->companies->toJson() : '[]' }}">
                                                    <span class="feather-icon me-2"><i
                                                            data-feather="user-check"></i></span>
                                                    <span class="fs-7 lh-1">Profile</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>

                                <div class="row">
                                    <div
                                        class="d-flex align-items-center col-sm-12 col-md-5 justify-content-center justify-content-md-start">
                                        <div class="dataTables_info">1 - 10 of 30</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <ul
                                            class="pagination custom-pagination pagination-simple mb-0 justify-content-center justify-content-md-end">
                                            <li class="dt-paging-button page-item previous disabled"><a href="#"
                                                    data-dt-idx="0" tabindex="0" class="page-link"><i
                                                        class="ri-arrow-left-s-line"></i></a></li>
                                            <li class="dt-paging-button page-item active"><a href="#" data-dt-idx="1"
                                                    tabindex="0" class="page-link">1</a></li>
                                            <li class="dt-paging-button page-item "><a href="#" data-dt-idx="2"
                                                    tabindex="0" class="page-link">2</a></li>
                                            <li class="dt-paging-button page-item next"><a href="#" data-dt-idx="4"
                                                    tabindex="0" class="page-link"><i
                                                        class="ri-arrow-right-s-line"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Details -->
                <div id="contact_detail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl contact-detail-modal" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <header class="contact-header">
                                    <div class="d-flex align-items-center p-3">
                                        @php
                                        $nameParts = explode(' ', $company->name);
                                        $firstInitial = substr($nameParts[0], 0, 1);
                                        $lastInitial = substr(end($nameParts), 0, 1);
                                        $initials = strtoupper($firstInitial . $lastInitial);
                                        @endphp
                                        <div class="avatar avatar-xl avatar-rounded me-3">
                                            <span class="initial-wrap avatar-img" style="background-color: lightblue;">
                                                {{ $initials }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="cp-name text-primary m-0" id="modal-user-name"></h4>
                                            <p id="modal-user-email" class="mb-0"></p>
                                            <span>Status: </span><span id="info-user-status"></span>
                                            <div class="rating rating-yellow my-rating-4" data-rating="3"></div>
                                        </div>
                                    </div>
                                </header>

                                <div class="contact-body contact-detail-body">
                                    <div data-simplebar class="nicescroll-bar">
                                        <div class="row p-3">
                                            @if($company->companies && $company->companies->count() > 0)
                                            @foreach($company->companies as $comp)
                                            <div class="col-md-6 mb-4">
                                                <div class="card h-100">
                                                    <div class="card-header">
                                                        <h4 class="text-primary mb-0">{{ $comp->name }}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="cp-info">
                                                            <li><span>Contact:</span>
                                                                <span>{{ $comp->contact ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Email:</span>
                                                                <span>{{ $comp->email ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Postal Code:</span>
                                                                <span>{{ $comp->postal_code ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Address:</span>
                                                                <span>{{ $comp->address ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>City:</span>
                                                                <span>{{ $comp->city ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>State:</span>
                                                                <span>{{ $comp->state ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Country:</span>
                                                                <span>{{ $comp->country ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Industry:</span>
                                                                <span>{{ $comp->industry ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Head Office:</span>
                                                                <span>{{ $comp->head_office ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>No. of Employees:</span>
                                                                <span>{{ $comp->no_of_employes ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>No. of Offices:</span>
                                                                <span>{{ $comp->no_of_offices ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Facebook:</span>
                                                                <span>{{ $comp->facebook ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>LinkedIn:</span>
                                                                <span>{{ $comp->linkedln ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Instagram:</span>
                                                                <span>{{ $comp->instagram ?? 'N/A' }}</span>
                                                            </li>
                                                            <li><span>Twitter:</span>
                                                                <span>{{ $comp->twitter ?? 'N/A' }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="text-primary mb-0">Company Information</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="text-muted">No companies associated with this user.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /Contact Details -->

            </div>

            @else
            <p>No companies found.</p>
            @endif
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // When the profile link is clicked
    $('a[data-bs-target="#contact_detail"]').on('click', function() {
        var userName = $(this).data('user-name');
        var userEmail = $(this).data('user-email');
        var userId = $(this).data('user-id');
        var userStatus = $(this).data('user-status');
        var companies = $(this).data('companies');

        // Set the modal content
        $('#modal-user-name').text(userName);
        $('#modal-user-email').text(userEmail);
        $('#info-user-name').text(userName);
        $('#info-user-email').text(userEmail);

        // Set status
        var statusText = userStatus == 1 ? 'Active' : 'Inactive';
        $('#info-user-status').text(statusText);

        // Handle companies data safely
        try {
            if (companies && companies !== '[]') {
                var companiesData = typeof companies === 'string' ? JSON.parse(companies) : companies;
                console.log('Companies data:', companiesData);
                // You can update company details in the modal here if needed
            } else {
                console.log('No companies data available');
            }
        } catch (e) {
            console.error('Error parsing companies data:', e);
        }

        // Make AJAX call to get fresh data
        $.ajax({
            url: '/admin/users/' + userId + '/details',
            type: 'GET',
            success: function(response) {
                // Update status with fresh data
                var statusText = response.status == 1 ? 'Active' : 'Inactive';
                $('#info-user-status').text(statusText);

                // Update company info if available
                if (response.companies && response.companies.length > 0) {
                    let html = '';
                    response.companies.forEach(function(comp) {
                        html += `
            <li><span>Company Name:</span> <span>${comp.name}</span></li>
            <li><span>Contact:</span> <span>${comp.contact}</span></li>
            <li><span>Email:</span> <span>${comp.email}</span></li>
            <li><span>Postal Code:</span> <span>${comp.postal_code}</span></li>
            <li><span>Address:</span> <span>${comp.address}</span></li>
            <li><span>City:</span> <span>${comp.city}</span></li>
            <li><span>State:</span> <span>${comp.state}</span></li>
            <li><span>Country:</span> <span>${comp.country}</span></li>
            <li><span>Contract Person Name:</span> <span>${comp.contractpname}</span></li>
            <li><span>Description:</span> <span>${comp.company_description}</span></li>
            <li><span>Head Office:</span> <span>${comp.head_office}</span></li>
            <li><span>No. of Employees:</span> <span>${comp.no_of_employes}</span></li>
            <li><span>No. of Offices:</span> <span>${comp.no_of_offices}</span></li>
            <li><span>Industry:</span> <span>${comp.industry}</span></li>
            <li><span>Facebook:</span> <span>${comp.facebook}</span></li>
            <li><span>LinkedIn:</span> <span>${comp.linkedln}</span></li>
            <li><span>Instagram:</span> <span>${comp.instagram}</span></li>
            <li><span>Twitter:</span> <span>${comp.twitter}</span></li>
            <div class="separator-full my-2"></div>
        `;
                    });

                    $('.company-info-list').html(html);
                } else {
                    $('.company-info-list').html(
                        `<p class="text-muted">No companies associated with this user.</p>`
                    );
                }

            },
            error: function(xhr, status, error) {
                console.error('Error fetching user details:', error);
            }
        });
    });

    // Status change functionality
    $(document).on('click', '.change-status', function(e) {
        e.preventDefault();

        var userId = $(this).data('id');
        var status = $(this).data('status');
        var statusText = status == 1 ? 'Active' : 'Inactive';

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change status to " + statusText + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
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
                        }).then(() => {
                            location
                                .reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message ||
                                'Something went wrong!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });
});
</script>

@endsection