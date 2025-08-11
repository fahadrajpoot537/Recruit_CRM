@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-uppercase text-white">
                            <i class="bi bi-building me-2"></i>
                            <b>{{ $company->name ?? 'Company Details' }}</b>
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="row row-cols-1 row-cols-md-2 gy-4">

                            <div><strong>📞 Contact:</strong> <span class="ms-2">{{ $company->contact ?? 'N/A' }}</span>
                            </div>
                            <div><strong>✉️ Email:</strong> <span class="ms-2">{{ $company->email ?? 'N/A' }}</span></div>

                            <div><strong>🏷️ Postal Code:</strong> <span
                                    class="ms-2">{{ $company->postal_code ?? 'N/A' }}</span></div>
                            <div><strong>📍 Address:</strong> <span class="ms-2">{{ $company->address ?? 'N/A' }}</span>
                            </div>

                            <div><strong>🏙️ City:</strong> <span class="ms-2">{{ $company->city ?? 'N/A' }}</span></div>
                            <div><strong>🌆 State:</strong> <span class="ms-2">{{ $company->state ?? 'N/A' }}</span></div>
                            <div><strong>🌍 Country:</strong> <span class="ms-2">{{ $company->country ?? 'N/A' }}</span>
                            </div>

                            <div><strong>👤 Contract Person:</strong> <span
                                    class="ms-2">{{ $company->contractpname ?? 'N/A' }}</span></div>
                            <div><strong>🏢 Head Office:</strong> <span
                                    class="ms-2">{{ $company->head_office ?? 'N/A' }}</span></div>
                            <div><strong>👥 No. of Employees:</strong> <span
                                    class="ms-2">{{ $company->no_of_employes ?? 'N/A' }}</span></div>
                            <div><strong>🏬 No. of Offices:</strong> <span
                                    class="ms-2">{{ $company->no_of_offices ?? 'N/A' }}</span></div>
                            <div><strong>🏭 Industry:</strong> <span
                                    class="ms-2">{{ $company->industry ?? 'N/A' }}</span>
                            </div>


                            @php
                                $socialLinks = [
                                    '🌐 Facebook' => $company->facebook,
                                    '🔗 LinkedIn' => $company->linkedln,
                                    '📸 Instagram' => $company->instagram,
                                    '🐦 Twitter' => $company->twitter,
                                ];
                            @endphp

                            @foreach ($socialLinks as $label => $url)
                                <div>
                                    <strong>{{ $label }}:</strong>
                                    @if (!empty($url))
                                        <a href="{{ $url }}" target="_blank"
                                            class="ms-2 text-decoration-none">{{ $url }}</a>
                                    @else
                                        <span class="ms-2">N/A</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 mt-4">
                            <strong>📝 Description:</strong>
                            <p class="ms-2 mt-1 mb-0">{{ $company->company_description ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        @if ($company->creators->contains(Auth::id()))
                            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary me-2">
                                ✏️ Edit
                            </a>
                        @endif
                        <a href="{{ route('companies.index') }}" class="btn btn-outline-primary">← Back to List</a>

                    </div>

                    <div class="card-footer text-end">




                    </div>
                </div>


            </div>
            <div class="col-md-12">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-uppercase text-white">
                            <i class="bi bi-building me-2"></i>
                            <b>{{ $company->name ?? 'Company Details' }} Users</b>
                        </h4>

                    </div>

                    <div class="card-body p-4">
                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                <a href="{{ route('companies.users.create', ['id' => $company->id]) }}"
                                    class="btn btn-primary me-2">
                                    Add Company User
                                </a>
                                {{-- <div class="collapse" id="collapseQuick">
                                    <div class="quick-access-form-wrap">
                                        <form class="quick-access-form border">
                                            <div class="row gx-3">
                                                <div class="col-xxl-10">
                                                    <div class="position-relative">
                                                        <div class="dropify-square">
                                                            <input type="file" class="dropify-1" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row gx-3">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="First name*" value=""
                                                                            type="text">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input class="form-control" placeholder="Last name*"
                                                                            value="" type="text">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input class="form-control" placeholder="Email Id*"
                                                                            value="" type="text">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input class="form-control" placeholder="Phone"
                                                                            value="" type="text">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input class="form-control" placeholder="Department"
                                                                            value="" type="text">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select id="input_tags" class="form-control"
                                                                            multiple="multiple">
                                                                            <option selected="selected">Collaborator
                                                                            </option>
                                                                            <option>Designer</option>
                                                                            <option selected="selected">Developer</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-2">
                                                    <div class="form-group">
                                                        <button data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                            aria-expanded="false" class="btn btn-block btn-primary ">Create
                                                            New
                                                        </button>
                                                    </div>
                                                    <div class="form-group">
                                                        <button data-bs-toggle="collapse" disabled
                                                            data-bs-target="#collapseExample" aria-expanded="false"
                                                            class="btn btn-block btn-secondary">Discard
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="contact-list-view">
                                    <table id="datable_1" class="table nowrap w-100 mb-5">
                                        <thead>
                                            <tr>
                                                {{-- <th><span class="form-check mb-0">
                                                        <input type="checkbox" class="form-check-input check-select-all"
                                                            id="customCheck1">
                                                        <label class="form-check-label" for="customCheck1"></label>
                                                    </span></th> --}}
                                                <th>Name</th>
                                                <th>Email Address</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Date Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($company_users as $company_user)
                                                <tr>
                                                    {{-- <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="contact-star marked"><span class="feather-icon"><i
                                                                        data-feather="star"></i></span></span>
                                                        </div>
                                                    </td> --}}

                                                    <td class="text-truncate">{{ $company_user->user->name }}</td>
                                                    <td class="text-truncate">{{ $company_user->user->email }}</td>

                                                    <td>
                                                        <span
                                                            class="badge badge-soft-violet my-1  me-2">{{ $company_user->user->role[0]['name'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-soft-violet my-1  me-2">{{ $company_user->user->status == 1 ? 'Active' : 'Inactive' }}</span>
                                                    </td>
                                                    <td>{{ $company_user->user->created_at->format('d M, Y') }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">

                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover dropdown-toggle no-caret"
                                                                    aria-expanded="false" data-bs-toggle="dropdown"><span
                                                                        class="icon"><span class="feather-icon"><i
                                                                                data-feather="more-vertical"></i></span></span></button>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="{{ route('companies.users.edit', ['id' => $company_user->id]) }}"><span
                                                                            class="feather-icon dropdown-icon"><i
                                                                                data-feather="edit"></i></span><span>Edit</span></a>
                                                                    <form
                                                                        action="{{ route('companies.users.destroy', $company_user->id) }}"
                                                                        method="POST" style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item"
                                                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                                                            <span class="feather-icon dropdown-icon"><i
                                                                                    data-feather="trash-2"></i></span>
                                                                            <span>Delete</span>
                                                                        </button>
                                                                    </form>
                                                                    <form
                                                                        action="{{ route('companies.users.update.status', $company_user->id) }}"
                                                                        method="POST" style="display: inline;">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="dropdown-item"
                                                                            onclick="return confirm('Are you sure you want to change the status of this user?')">
                                                                            <span class="feather-icon dropdown-icon">
                                                                                <i data-feather="refresh-ccw"></i>
                                                                                {{-- or another suitable icon --}}
                                                                            </span>
                                                                            <span>{{ $company_user->user->status == 1 ? 'Deactivate' : 'Activate' }}</span>
                                                                        </button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
@endsection
